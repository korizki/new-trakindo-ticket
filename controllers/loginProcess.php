<?php
    // memuat file koneksi database
    include "connection.php";
    // eksekusi saat tombol login ditekan
    if(isset($_POST['buttonlogin'])){
        // dapatkan nilai input form login
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        // query search user
        $query = "SELECT * FROM user WHERE user_name = '$username' AND password = '$password' ";
        $checking = mysqli_query($connection, $query);
        // jika ada user maka arahkan ke main page 
        if(mysqli_num_rows($checking)){
            // memuat sesi dan menyimpan informasi sesi
            session_start();
            $row = mysqli_fetch_array($checking, MYSQLI_ASSOC);
            $_SESSION['logged_user'] = $row['nama_user'];
            $_SESSION['user'] = $username;
            $_SESSION['logged_user_comp'] = $row['company'];
            $_SESSION['logged_user_type'] = $row['type'];
            // arahkan ke main page
            header("Location: ../pages/main.php");
        } else {
            // arahkan ke user tidak ditemukan / salah password
            header("Location: ../index.php?status=failed");
        }
    } else {
        // arahkan ke page login
        header("Location: ../index.php");
    }
?>