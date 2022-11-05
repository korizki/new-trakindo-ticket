<?php 
    include 'connection.php';
    session_start();
    $user = $_SESSION['user'];
        $array_data = array();
        $query = "SELECT t.ticket_id, t.requestor, t.sn_unit, t.job_type, t.req_date, t.cp_email, t.cp_phone, t.status, u.company FROM tickets t LEFT JOIN user u ON t.requestor = u.user_name WHERE t.requestor = '$user' ORDER BY req_date DESC";
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
                "company" => $row['company'],
                "status" => $row['status'],
            );
        }
        echo json_encode($array_data);
    // } else {
    //     header("Location: ../index.php");
    // }

?>