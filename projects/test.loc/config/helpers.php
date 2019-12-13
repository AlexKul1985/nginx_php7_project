<?php


 
 function debug($v){
    echo "<pre>";
    print_r($v);
    echo "</pre>";
}

function env($name){
    return $_ENV[$name];
}
?>