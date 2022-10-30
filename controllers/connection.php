<?php 
    $connection = mysqli_connect('localhost','root','','trakindo');
    if(!$connection){
        echo "Connection established failed, please check your database configuration";
    }
?>