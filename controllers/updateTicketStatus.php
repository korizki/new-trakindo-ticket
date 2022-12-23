<?php 
    include 'connection.php';
    $status = $_POST['status'];
    $ticketid = $_POST['id'];
    $query = "UPDATE tickets SET status = '$status' WHERE ticket_id = '$ticketid' ";
    $result = mysqli_query($connection, $query);
    return true;
?>