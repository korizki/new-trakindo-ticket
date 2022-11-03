<?php
    include "connection.php";
    session_start();
    $username = $_SESSION['logged_user'];
    $company = $_SESSION['logged_user_comp'];
    $sn = $_POST['sn'];
    $desc = $_POST['desc'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    // query add data dan process insert data
    $queryAdd = "INSERT INTO tickets(requestor, sn_unit, job_type, cp_email, cp_phone, status) VALUES('$username','$sn','$desc','$email','$phone', 'Created')";
    $processAdd = mysqli_query($connection, $queryAdd);
    // return hasil proses apakah berhasil atau gagal
    if(!$processAdd){
        echo json_encode(["status" => "Failed"]);
    } else {
        echo json_encode(["status" => "Success"]);
    }

?>