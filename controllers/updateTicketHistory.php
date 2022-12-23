<?php 
    include 'connection.php';
    $id = $_POST['id'];
    $date = $_POST['date'];
    $status = $_POST['status'];
    $note = $_POST['note'];
    if($status == 'Advice Only'){
        $query = "UPDATE history SET advice_date = '$date', advice_note = '$' VALUES('$id','$date')";
        mysqli_query($connection, $query);
    } else if($status == 'Waiting Quote'){

    }
    $quotenum = $_POST['quotenumber'];
    $teknisi = $_POST['teknisi'];
    $result = mysqli_query($connection, $query);
    return true;
?>