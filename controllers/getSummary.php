<?php 
    include 'connection.php';
    session_start();
    $user = $_SESSION['logged_user'];
        $array_data = array();
        $query = "SELECT * FROM tickets WHERE requestor = '$user' ORDER BY req_date DESC";
        $result = mysqli_query($connection, $query);
        while($row = mysqli_fetch_array($result)){
            $array_data[] = array(
                "id" => $row['ticket_id'],
                "requestor" => $row['requestor'],
                "sn_unit" => $row['sn_unit'],
                "job" => $row['job_type'],
                "req_date" => $row['req_date'],
                "email" => $row['cp_email'],
                "phone" => $row['cp_phone'],
                "status" => $row['status']
            );
        }
        echo json_encode($array_data);
    // } else {
    //     header("Location: ../index.php");
    // }

?>