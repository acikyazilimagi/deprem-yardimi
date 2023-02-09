<?php

namespace App\Classes;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class BadWordDetector
{

    private array $collection;

    public function __construct()
    {
        $fileNames = ['negative','political','religion','swear'];

        $dataStack = [];

        foreach ( $fileNames as $fileName){
            // find files
            $filePath = public_path("data/" .$fileName.".json");

            // read content
            $read = file_get_contents($filePath);

            // decode
            $data = json_decode($read, true);

            // merge all data
            $dataStack = array_merge($dataStack, $data);
        }

        $this->collection = $dataStack;
    }

    /**
     * @param ...$data
     * @return bool|array
     */
    public function validateBy(...$data): bool|array
    {
        foreach ($data as $key => $value)
        {
            $e = explode(" ", $value);
            foreach ($e as $v){
                return in_array($v, $this->collection) ?? false;
            }
        }

        return false;
    }
}
