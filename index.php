<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/icon/laptop.png">
    <title>Sistem Tiket Trakindo - Sign In</title>
    <link rel="stylesheet" href="./assets/style.css">
    <link rel="stylesheet" href="./assets/responsive.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200;300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="outer">
        <img src="./assets/icon/trakindo.png" alt="logo trakindo" width=140>
        <div class="box">
            <h1 class="head"><span class=icon><i class="fi fi-rr-ticket"></i></span> Sistem Tiket Trakindo</h1>
            <form action="./controllers/loginProcess.php" class="formlogin" method="post" autocomplete="off">
                <div class="formsec">
                    <p class="info blue"><i class="fi fi-rr-info"></i> Silahkan <strong>Log In</strong> menggunakan user terdaftar.</p>
                </div>
                <div class="formsec">
                    <label>Username</label>
                    <input type="text" id="username" name="username" autoComplete="off" required  placeholder="Masukkan username">
                </div>
                <div class="formsec">
                    <label>Password</label>
                    <input type="password" name="password" required autoComplete="off" placeholder="Masukkan password">
                </div>
                <div class="formsec">
                    <button class="sbmt" type="submit" name="buttonlogin"><i class="fi fi-rr-enter"></i> Log In</button>
                </div>
                <?php 
                    if(isset($_GET['status'])){
                        if($_GET['status'] == 'failed'){
                            echo '<p class="info red mt"><i class="fi fi-rr-ban"></i> Username <strong>tidak terdaftar</strong> atau <strong>password salah</strong>, mohon periksa kembali!</p>';
                        } else {
                            session_start();
                            session_destroy();
                            echo '<p class="info blue mt"><i class="fi fi-rr-info"></i> Anda berhasil <strong>Log Out</strong>, Terima kasih. </p>';
                        }
                    }
                ?>
                <p>Silahkan menghubungi Administrator jika ada <strong>belum memiliki akun</strong> atau <strong>lupa password</strong>!</p>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('username').focus()
    </script>
</body>
</html>