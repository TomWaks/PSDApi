<?php
# http://localhost/search.php?key_api=kkk&&dir=/var/www/private_space/&&word=pdf
header('Content-Type: application/json');
if(isset($_GET['key_api']) && isset($_GET['phrase'])){ 
    $key_api = $_GET['key_api'];
    $dir = __DIR__.'/..' . DIRECTORY_SEPARATOR . 'private_space/';
    $phrase = $_GET['phrase'];

    # echo $key_api." ".$dir." ".$word;

    $iter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST, RecursiveIteratorIterator::CATCH_GET_CHILD);

    $results = array();
    $paths = array($dir);
    foreach ($iter as $path => $dirr) {
        if ($dirr->isDir()) {
            $paths[] = $path."/";
            if($phrase == ""){
                $results[] = array("name_object" => end(explode("/", $path)), "type_object" => 1, "path_object" => str_replace($dir, "/", str_replace(end(explode("/", $path)), "", $path)));
            }else{
                if(strpos(strtolower(end(explode("/", $path))), strtolower($phrase)) !== false){
                    $results[] = array("name_object" => end(explode("/", $path)), "type_object" => 1, "path_object" => str_replace($dir, "/", str_replace(end(explode("/", $path)), "", $path)));
                }
            }
        }
    }      

    foreach ($paths as $folder) { 
        foreach (glob($folder."*.*") as &$filename) {
            $name = str_replace($folder, "", $filename); 
            if($phrase == ""){
                $results[] = array("name_object" => $name, "type_object" => 0,  "path_object" => str_replace($dir, "/", $folder));
            }else{
                if(strpos(strtolower($name), strtolower($phrase)) !== false){
                    $results[] = array("name_object" => $name, "type_object" => 0,  "path_object" => str_replace($dir, "/", $folder));
                }
            }
        } 
    } 
    echo json_encode(array('status' => 1, 'key_api' => $key_api, 'counter' => count($results), 'data' => $results), JSON_PRETTY_PRINT);

    // echo json_encode($results);
}

//     $key_api = $_GET['key_api'];
//     if(isset($_GET['path']) && isset($_GET['word'])){ 
//         $path = $_GET['path'];
//         $word = $_GET['word'];
//     }

//     $iter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS),
//     RecursiveIteratorIterator::SELF_FIRST, RecursiveIteratorIterator::CATCH_GET_CHILD);

//     echo $path." ".$word;
// }

// $root = '/var/www/private_space/';



// $paths = array($root);
// foreach ($iter as $path => $dir) {
//     if ($dir->isDir()) {
//         $paths[] = $path."/"; 
//     }
// } 

// $results = array();

// foreach ($paths as $qq) {
//     #echo "<b>".$qq. "</b></br>";
//     foreach (glob($qq."*.*") as &$filename) {
//         $results[] = array("name" => str_replace($qq, "", $filename), "path" => $qq);
//         #echo "$filename size " . filesize($filename) . "</br>";
//     }


//     // $filelist = glob($qq."/");
//     // foreach ($filelist as $key => $link) {
//     //     if(is_dir($dir.$link)){
//     //         unset($filelist[$key]);
//     //     }
//     // }
    
//     // echo json_encode($filelist);
//     #echo "</br>";
// }

// if(strpos("123456", "2")){
//     echo "1";
// }else{
//     echo "0";
// }
// # echo "|".strpos("13456", "2")."|";
// // echo json_encode(array('status' => 1, 'counter' => count($results), 'data' => $results), JSON_PRETTY_PRINT);
// ?>