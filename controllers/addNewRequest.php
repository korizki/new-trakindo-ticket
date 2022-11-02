<?php
    include "connection.php";
    session_start();
    $username = $_SESSION['logged_user'];
    $company = $_SESSION['logged_user_comp'];
    $sn = $_POST['sn'];
    $desc = $_POST['desc'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    echo $username;
    echo $company;

?>