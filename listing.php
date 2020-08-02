<?php
// # $key_api = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));
# localhost/get_listing.php?key_api=asdad&&path=/var/www/private_space/

function human_filesize($size, $precision = 2) {
    $units = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
    $step = 1024;
    $i = 0;
    while (($size / $step) > 0.9) {
        $size = $size / $step;
        $i++;
    }
    return round($size, $precision).$units[$i];
}

header('Content-Type: application/json');
if(isset($_GET['key_api'])){
    $key_api = $_GET['key_api'];
    if(isset($_GET['path'])){ 
        $path = __DIR__.'/..' . DIRECTORY_SEPARATOR . 'private_space'.$_GET['path'];
        $objects = array_diff(scandir($path), array('.', '..'));
    
        $result_objects = array();
        foreach ($objects as &$value) {
            $date = filemtime($path."/".$value);
            if(is_dir($path."/".$value)){
                $type = 1;
                $size = -1;
                $numb_of_objects = count(array_diff(scandir($path."/".$value), array('.', '..')));
            }else{
                $type = 0;
                $size = human_filesize(filesize($path."/".$value));
                $numb_of_objects = -1; 
            }
            $result_objects[] = array("name_object" => $value, "type_object" => $type, "size_object" => $size, "date_object" => date("H:i d/m/Y", $date), "numb_of_objects" => $numb_of_objects);
                
        }    
        echo json_encode(array('status' => 1, 'key_api' => $key_api, 'counter' => count($result_objects), 'data' => $result_objects), JSON_PRETTY_PRINT);
    }else{
        echo json_encode(array('status' => 0, 'key_api' => $key_api, 'counter' => count($result_objects), 'data' => $result_objects), JSON_PRETTY_PRINT);
    }
}else{
    echo "Invalid key api";
}

?>