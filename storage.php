<?php
function GetDirectorySize($path){
    $bytestotal = 0;
    $path = realpath($path);
    if($path!==false && $path!='' && file_exists($path)){
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
            $bytestotal += $object->getSize();
        }
    }
    return $bytestotal;
}

function human_filesize($bytes, $dec = 2) 
{
    $size   = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $factor = floor((strlen($bytes) - 1) / 3);

    return sprintf("%.{$dec}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}


if(isset($_GET["key_api"])){
    $path = __DIR__.'/..' . DIRECTORY_SEPARATOR . 'private_space/';
    echo json_encode(array('status' => 1, 'key_api' => $_GET["key_api"], 'storage_used' => GetDirectorySize($path), 'storage_free' => disk_free_space($path)), JSON_PRETTY_PRINT);
}