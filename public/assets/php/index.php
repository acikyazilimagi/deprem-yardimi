<?php

// Comment if you don't want to allow posts from other domains
header('Access-Control-Allow-Origin: *');

// Allow the following methods to access this file
header('Access-Control-Allow-Methods: OPTIONS, GET, DELETE, POST, HEAD, PATCH');

// Allow the following headers in preflight
header('Access-Control-Allow-Headers: content-type, upload-length, upload-offset, upload-name');

// Allow the following headers in response
header('Access-Control-Expose-Headers: upload-offset');

// Load the FilePond class
require_once('FilePond.class.php');

// Load our configuration for this server
require_once('config.php');

// catch server exceptions and auto jump to 500 response code if caught
FilePond\catch_server_exceptions();

// Route request to handler method
FilePond\route_api_request(ENTRY_FIELD, [
    'FILE_TRANSFER' => 'handle_file_transfer',
    'PATCH_FILE_TRANSFER' => 'handle_patch_file_transfer',
    'REVERT_FILE_TRANSFER' => 'handle_revert_file_transfer',
    'RESTORE_FILE_TRANSFER' => 'handle_restore_file_transfer',
    'LOAD_LOCAL_FILE' => 'handle_load_local_file',
    'FETCH_REMOTE_FILE' => 'handle_fetch_remote_file'
]);

function handle_file_transfer($transfer) {

    $metadata = $transfer->getMetadata();
    $files = $transfer->getFiles();

    // something went wrong, most likely a field name mismatch
    if ($files !== null && count($files) === 0) return http_response_code(400);

    // store data
    FilePond\store_transfer(TRANSFER_DIR, $transfer);

    // created the temp entry
    http_response_code(201);
    
    // returns plain text content
    header('Content-Type: text/plain');

    // remove item from array Response contains uploaded file server id
    echo $transfer->getId();
}

function handle_patch_file_transfer($id) {

    // location of patch files
    $dir = TRANSFER_DIR . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR;
    
    // exit if is get
    if ($_SERVER['REQUEST_METHOD'] === 'HEAD') {
        $patch = glob($dir . '.patch.*');
        $offsets = array();
        $size = '';
        $last_offset = 0;
        foreach ($patch as $filename) {

            // get size of chunk
            $size = filesize($filename);

            // get offset of chunk
            list($dir, $offset) = explode('.patch.', $filename, 2);

            // offsets
            array_push($offsets, $offset);

            // test if is missing previous chunk
            // don't test first chunk (previous chunk is non existent)
            if ($offset > 0 && !in_array($offset - $size, $offsets)) {
                $last_offset = $offset - $size;
                break;
            }

            // last offset is at least next offset
            $last_offset = $offset + $size;
        }

        // return offset
        http_response_code(200);
        header('Upload-Offset: ' . $last_offset);
        return;
    }

    // get patch data
    $offset = $_SERVER['HTTP_UPLOAD_OFFSET'];
    $length = $_SERVER['HTTP_UPLOAD_LENGTH'];

    // should be numeric values, else exit
    if (!is_numeric($offset) || !is_numeric($length)) {
        return http_response_code(400);
    }

    // get sanitized name
    $name = FilePond\sanitize_filename($_SERVER['HTTP_UPLOAD_NAME']);

    // write patch file for this request
    file_put_contents($dir . '.patch.' . $offset, fopen('php://input', 'r'));

    // calculate total size of patches
    $size = 0;
    $patch = glob($dir . '.patch.*');
    foreach ($patch as $filename) {
        $size += filesize($filename);
    }

    // if total size equals length of file we have gathered all patch files
    if ($size == $length) {

        // create output file
        $file_handle = fopen($dir . $name, 'w');

        // write patches to file
        foreach ($patch as $filename) {

            // get offset from filename
            list($dir, $offset) = explode('.patch.', $filename, 2);

            // read patch and close
            $patch_handle = fopen($filename, 'r');
            $patch_contents = fread($patch_handle, filesize($filename));
            fclose($patch_handle); 
            
            // apply patch
            fseek($file_handle, $offset);
            fwrite($file_handle, $patch_contents);
        }

        // remove patches
        foreach ($patch as $filename) {
            unlink($filename);
        }

        // done with file
        fclose($file_handle);
    }

    http_response_code(204);
}

function handle_revert_file_transfer($id) {

    // test if id was supplied
    if (!isset($id) || !FilePond\is_valid_transfer_id($id)) return http_response_code(400);

    // remove transfer directory
    FilePond\remove_transfer_directory(TRANSFER_DIR, $id);

    // no content to return
    http_response_code(204);
}

function handle_restore_file_transfer($id) {

    // Stop here if no id supplied
    if (empty($id) || !FilePond\is_valid_transfer_id($id)) return http_response_code(400);

    // create transfer wrapper around upload
    $transfer = FilePond\get_transfer(TRANSFER_DIR, $id);

    // Let's get the temp file content
    $files = $transfer->getFiles();

    // No file returned, file not found
    if (count($files) === 0) return http_response_code(404);

    // Return file
    FilePond\echo_file($files[0]);
}

function handle_load_local_file($ref) {

    // Stop here if no id supplied
    if (empty($ref)) return http_response_code(400);

    // In this example implementation the file id is simply the filename and 
    // we request the file from the uploads folder, it could very well be 
    // that the file should be fetched from a database or a totally different system.
    
    // path to file
    $path = UPLOAD_DIR . DIRECTORY_SEPARATOR . FilePond\sanitize_filename($ref);

    // Return file
    FilePond\echo_file($path);
}

function handle_fetch_remote_file($url) {

    // Stop here if no data supplied
    if (empty($url)) return http_response_code(400);

    // Is this a valid url
    if (!FilePond\is_url($url)) return http_response_code(400);

    // Let's try to get the remote file content
    $file = FilePond\fetch($url);

    // Something went wrong
    if (!$file) return http_response_code(500);

    // remote server returned invalid response
    if ($file['error'] !== 0) return http_response_code($file['error']);
    
    // if we only return headers we store the file in the transfer folder
    if ($_SERVER['REQUEST_METHOD'] === 'HEAD') {
        
        // deal with this file as if it's a file transfer, will return unique id to client
        $transfer = new FilePond\Transfer();
        $transfer->restore($file);
        FilePond\store_transfer(TRANSFER_DIR, $transfer);

        // send transfer id back to client
        header('X-Content-Transfer-Id: ' . $transfer->getId());
    }

    // time to return the file to the client
    FilePond\echo_file($file);
}