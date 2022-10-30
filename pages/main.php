<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Tiket Trakindo - Main</title>
    <link rel="icon" href="../assets/icon/laptop.png">
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/responsive.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200;300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <!-- validasi sesi user yang log in -->
    <?php 
        // session_start();
        // if(isset($_SESSION['logged_user']) == null){
        //     header("Location: ../index.php");
        // }
    ?>
    <div id="app">
        <nav>
            <a href="./main.php"><img src="../assets/icon/trakindo.png" alt="icon-trakindo" width=140></a>
            <div>

            </div>
            <a title="Log Out User" class="logoffbtn" @click="logOutUser"><i class="fi fi-rr-sign-out-alt"></i> <span class="remarklogout">Keluar</span></a>
        </nav>
        <div class=content-header>
            <div class=welcom>
                <h2><i class="fi fi-rr-comment-user trans"></i> Selamat Datang kembali, Administrator</h2>
                <p style="opacity: 0.6">Berikut rangkuman seluruh tiket yang dibuat oleh PT. Madhani Talatah Nusantara</p>
                <p class="info blue inline"><i class="fi fi-rr-info"></i> Anda dapat membuat tiket baru dengan <strong>klik icon '+'</strong> pada kanan bawah halaman.</p>
            </div>
            <a>
                <h2><i class="fi fi-rr-document-signed"></i> Rangkuman Semua Tiket</h2>
                <span href="#"><i class="fi fi-rr-caret-right"></i></span>
            </a>
            <div class=sumbox>
                <div class=eachcontent>
                    <h1 class="progress pad">23 <span class="mini">Tiket</span></h1>
                    <div>
                        <h4><i class="fi fi-rr-rotate-right"></i> Tiket On Progress</h4>
                        <p>Total tiket berlangsung / on-progress</p>
                    </div>
                </div>
                <div class=eachcontent>
                    <h1 class="done pad">80 <span class="mini">Tiket</span></h1>
                    <div>
                        <h4><i class="fi fi-rr-checkbox"></i> Tiket Selesai</h4>
                        <p>Total tiket dengan status selesai.</p>
                    </div>
                </div>
                <div class=eachcontent>
                    <h1 class="blue pad">100 <span class="mini">Tiket</span></h1>
                    <div>
                        <h4><i class="fi fi-rr-edit"></i> Tiket Dibuat</h4>
                        <p>Total semua tiket yang dibuat.</p>
                    </div>
                </div>
            </div>
            <a>
                <h2><i class="fi fi-rr-ticket trans"></i> Tiket Terakhir Dibuat</h2>
                <span href="#"><i class="fi fi-rr-caret-right"></i></span>
            </a>
        </div>
        <div>
            <button title="Buat tiket baru" class=addbtn><i class="fi fi-rr-plus"></i></button>
        </div>
    </div>
    <!-- import CDN Vue.js dan jquery.js -->
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <!-- Block script vue  -->
    <script>
        const { createApp } = Vue

        createApp({
            data() {
                return {
                    message: 'Hello Vue!'
                }
            },
            methods: {
                logOutUser(){
                    let confirm = window.confirm('Anda yakin ingin keluar?')
                    window.location.href = confirm && "../index.php?status=logout"
                }
            }
        }).mount('#app')
    </script>
</body>
</html>