<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Advanced Contact Form with File Uploader">
	<meta name="author" content="UWS">
	<title>Sendy | Advanced Contact Form</title>

	<!-- Favicon -->
	<link href="../img/favicon.png" rel="shortcut icon">

	<!-- Google Fonts - Poppins, Karla -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Karla:300,400,500,600,700" rel="stylesheet">

	<!-- Font Awesome CSS -->
	<link href="../vendor/fontawesome/css/all.min.css" rel="stylesheet">

	<!-- Custom Font Icons -->
	<link href="../vendor/icomoon/css/iconfont.min.css" rel="stylesheet">

	<!-- Vendor CSS -->
	<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="../vendor/dmenu/css/menu.css" rel="stylesheet">
	<link href="../vendor/hamburgers/css/hamburgers.min.css" rel="stylesheet">
	<link href="../vendor/mmenu/css/mmenu.min.css" rel="stylesheet">
	<link href="../vendor/filepond/css/filepond.css" rel="stylesheet">

	<!-- Main CSS -->
	<link href="../css/style.css" rel="stylesheet">

</head>

<body onLoad="setTimeout('delayedRedirect()', 5000)">

<?php

/* Setup PHPMailer
==================================== */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php'; 

$mail = new PHPMailer(true);

/* Validate User Inputs
==================================== */

// Name 
if ($_POST['username'] != '') {
	
	// Sanitizing
	$_POST['username'] = filter_var($_POST['username'], FILTER_SANITIZE_STRING);

	if ($_POST['username'] == '') {
		$errors .= 'Please enter a valid name.<br/>';
	}
}
else { 
	// Required to fill
	$errors .= 'Please enter your name.<br/>';
}

// Email 
if ($_POST['email'] != '') {

	// Sanitizing 
	$_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

	// After sanitization validation is performed
	$_POST['email'] = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
	
	if($_POST['email'] == '') {
		$errors .= 'Please enter a valid email address.<br/>';
	}
}
else {
	// Required to fill
	$errors .= 'Please enter your email address.<br/>';
}

// Phone 
if ($_POST['phone'] != '') {

	// Sanitizing
	$_POST['phone'] = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);

	// After sanitization validation is performed
	$pattern_phone = array('options'=>array('regexp'=>'/^\+{1}[0-9]+$/'));
	$_POST['phone'] = filter_var($_POST['phone'], FILTER_VALIDATE_REGEXP, $pattern_phone);
	
	if($_POST['phone'] == '') {
		$errors .= 'Please enter a valid phone number like: +363012345<br/>';
	}
}

/* Validate Hidden Inputs
==================================== */

function sanitizePostTitle($postName, $invalidMessage) {
	
	if ($_POST[$postName] != '') {
		
		// Sanitizing
	  	$_POST[$postName] = filter_var($_POST[$postName], FILTER_SANITIZE_STRING);
		  
		if ($_POST[$postName] == '') {
			return $invalidMessage . '<br/>';
	  	}

	}
	return '';
}

$errors .= sanitizePostTitle('subject', 'Please set a valid Subject.');

// Continue if NO errors found after validation
if (!$errors) {	

	// Customer Details
	$customer_name = $_POST['username'];
	$customer_mail = $_POST['email'];
	$customer_phone = $_POST['phone'];	
	$customer_subject = $_POST['subject'];
	$customer_message = $_POST['message'];

	/* Mail Sending
	==================================== */

	try {

    	// Recipients
    	$mail->setFrom('noreply@yourdomain.com', 'Sendy');                				// Set Sender    	
		$mail->addAddress('websolutions.ultimate@gmail.com', 'Ultimate Websolutions'); 	// Set Recipients		
    	$mail->addReplyTo('replyto@yourdomain.com', 'Sendy');          					// Set Reply-to Address
    	$mail->isHTML(true);                                                       
    	$mail->Subject = 'Message';                                     				// Email Subject

		// Explore the uploaded file if exists
		$tmp_dirs = [];
		$attachment_ids = $_POST['filepond'];
		foreach($attachment_ids as $attachment_id) {

			$dir = 'tmp/'.$attachment_id;
			$tmp_dirs[] = $dir;
			$file = glob('tmp/'.$attachment_id.'/*.*')[0];
			$mail->addAttachment($file);

		}

		// Handle if user provided a file or not
		if (file_exists($file)) {			
			$file_attachment = 'Can be found attached';
		} else {
			$file_attachment = 'Was NOT uploaded';			
		}

		// Get the email's html content
		$email_html = file_get_contents('phpmailer/email-file-attachment.html');

		// Set HTML content	
		$body = str_replace(
			array('customerName', 'customerEmail', 'customerPhone', 'customerSubject', 'fileAttachment', 'customerMessage'), 
			array($customer_name, $customer_mail, $customer_phone, $customer_subject, $file_attachment, $customer_message), $email_html);

		$mail->msgHTML($body);    	
		
		// Send to site owner
		$mail->send();

		// Send the confirmation to the user who filled the form
		$mail->clearAddresses();
		$mail->clearAttachments();
    	$mail->addAddress($_POST['email']); // Email address entered on form
    	$mail->isHTML(true);
		$mail->Subject    = 'Confirmation';
		
		// Get the confirmation email's html content
		$email_confirmation_html = file_get_contents('phpmailer/email-confirmation.html');

		// Set HTML content
		$body = str_replace(array('customerName'), array($customer_name), $email_confirmation_html);
		$mail->MsgHTML($body);

		// Send to who filled the form
		$mail->send();


	} catch (Exception $e) {

		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

	} 

	// Success Page
	echo '<div id="success">';
	echo '<div class="icon icon-order-success svg">';
	echo '<svg width="72px" height="72px">';
	echo '<g fill="none" stroke="#53c4da" stroke-width="2">';
	echo '<circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>';
	echo '<path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>';
	echo '</g>';
	echo '</svg>';
	echo '</div>';    
	echo '<h4>Thank you for contacting us.</h4>';
	echo '<small>Check your mailbox.</small>';
	echo '</div>';
	echo '<script src="../js/redirect.js"></script>';

} else {

	// Error Page
	echo '<div style="color: #e9431c">' . $errors . '</div>';
	echo '<div id="success">';    
	echo '<h4>Something went wrong.</h4>';
	echo '<a class="animated-link" href="../index.html">Go Back</small>';
	echo '</div>';	
}

?>
<!-- END PHP -->

</body>
</html>