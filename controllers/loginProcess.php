<?php
    include "connection.php";
    
    echo $_POST['username'];
    echo md5($_POST['password']);
?>