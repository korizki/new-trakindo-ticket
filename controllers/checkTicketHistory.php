<?php
    include "connection.php";
    $id = $_POST['id'];
    $query = "SELECT * FROM history WHERE request_id = '$id' ";
    $array_data = array();
    $result = mysqli_query($connection, $query);
    while($row = mysqli_fetch_array($result)){
        $array_data[] = array(
            "advice_date" => $row['advice_date'],
            "advice_note" => $row['advice_note'],
            "quote_date" => $row['quote_date'],
            "quote_note" => $row['quote_note'],
            "quoteapp_date" => $row['quoteapp_date'],
            "quoteapp_note" => $row['quoteapp_note'],
            "quoteapp_num" => $row['quoteapp_note'],
            "quoteapp_tech" => $row['quoteapp_tech'],
            "schedule_date" => $row['schedule_date'],
            "schedule_note" => $row['schedule_note'],
            "schedule_so" => $row['schedule_so'],
            "waittech_date" => $row['waittech_date'],
            "waittech_so" => $row['waittech_so'],
            "waittech_note" => $row['waittech_note'],
            "progress_so" => $row['progress_so'],
            "progress_date" => $row['progress_date'],
            "progress_tech" => $row['progress_tech'],
            "progress_note" => $row['progress_note'],
            "close_date" => $row['close_date'],
            "close_note" => $row['close_note']
        );
    }
    echo json_encode($array_data);
?>