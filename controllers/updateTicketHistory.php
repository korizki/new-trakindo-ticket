<?php 
    include 'connection.php';
    $id = $_POST['id'];
    $date = $_POST['date'];
    $status = $_POST['status'];
    $note = $_POST['note'];
    $query = '';
    if($status == 'Advice Only'){
        $query = "UPDATE history SET advice_date = '$date', advice_note = '$note' WHERE request_id = '$id'";
    } else if($status == 'Waiting Quote'){
        $query = "UPDATE history SET quote_date = '$date', quote_note = '$note' WHERE request_id = '$id'";
    } else if($status == 'Waiting Quote Approval / PO'){
        $quotenum = $_POST['quotenumber'];
        $teknisi = $_POST['teknisi'];
        $query = "UPDATE history SET quoteapp_date = '$date', quoteapp_note = '$note', quoteapp_tech = '$teknisi', quoteapp_num = '$quotenum' WHERE request_id = '$id'";
    } else if($status == 'Waiting Schedule Perform'){
        $quotenum = $_POST['quotenumber'];
        $query = "UPDATE history SET schedule_date = '$date', schedule_note = '$note', schedule_so = '$quotenum' WHERE request_id = '$id'";
    } else if($status == 'Waiting Technician'){
        $quotenum = $_POST['quotenumber'];
        $query = "UPDATE history SET waittech_date = '$date', waittech_note = '$note', waittech_so = '$quotenum' WHERE request_id = '$id'";
    } else if($status == 'In Progress Perform'){
        $quotenum = $_POST['quotenumber'];
        $teknisi = $_POST['teknisi'];
        $query = "UPDATE history SET progress_date = '$date', progress_note = '$note', progress_so = '$quotenum', progress_tech = '$teknisi' WHERE request_id = '$id'";
    } else if($status == 'Closed'){
        $query = "UPDATE history SET close_date = '$date', close_note = '$note' WHERE request_id = '$id'";
    }
    mysqli_query($connection, $query);
    mysqli_query($connection, "INSERT INTO file(ticket_id, url_trakindo, url_customer) VALUES ('$id','','')");
    return true;
?>