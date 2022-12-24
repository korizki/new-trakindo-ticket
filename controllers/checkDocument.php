<?php 
    include 'connection.php';
    $id = $_POST['id'];
    $array_data = array();
    $query = "SELECT * FROM file WHERE ticket_id = '$id' ";
    $result = mysqli_query($connection, $query);
    while($row = mysqli_fetch_array($result)){
        $array_data[] = array(
            "ticket_id" => $row['ticket_id'],
            "url_trakindo" => $row['url_trakindo'],
            "url_customer" => $row['url_customer'],
        );
    }
    echo json_encode($array_data);
?>