<?php

if(isset($_GET['key_api'])){

    if(true){
        echo json_encode(array('status' => 1), JSON_PRETTY_PRINT);
    }else{
        echo json_encode(array('status' => 0), JSON_PRETTY_PRINT);
    } 
}else{
    echo json_encode(array('status' => -1), JSON_PRETTY_PRINT);
}

?>