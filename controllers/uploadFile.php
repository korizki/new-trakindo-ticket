<?php 
    include 'connection.php';
    // upload dokumen
    $upload_dir = '../assets/file_admin/';
    $uploadfile = $upload_dir . basename($_FILES['files']['name']);
    $id = $_POST['ticket_id'];
    move_uploaded_file($_FILES["files"]["tmp_name"], $uploadfile);
    // menambahkan record pada tabel
    $name = basename($_FILES['files']['name']);
    mysqli_query($connection, "UPDATE file SET url_trakindo = '$name' WHERE ticket_id='$id'");
    return true;
?>