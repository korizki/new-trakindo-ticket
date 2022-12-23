<?php 
    include 'connection.php';
    $id = $_POST['id'];
    $date = $_POST['date'];
    $query = "INSERT INTO history(request_id, date_request) VALUES('$id','$date')";
    $result = mysqli_query($connection, $query);
    return true;
?>