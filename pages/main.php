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
        session_start();
        if(isset($_SESSION['logged_user']) == null){
            header("Location: ../index.php");
        }
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
                <h2><i class="fi fi-rr-comment-user trans"></i> Selamat Datang User</h2>
                <p class="user">Anda berhasil Log In kembali <strong><?php echo $_SESSION['logged_user']; ?></strong>, berikut rangkuman seluruh tiket yang dibuat oleh perusahaan anda, <strong><?php echo $_SESSION['logged_user_comp']; ?></strong>.</p>
                <p class="info blue inline"><i class="fi fi-rr-info"></i> Anda dapat membuat tiket baru dengan <strong>klik icon '+'</strong> pada kanan bawah halaman.</p>
            </div>
            <a>
                <h2><i class="fi fi-rr-document-signed"></i> Rangkuman Semua Tiket</h2>
                <span href="#"><i class="fi fi-rr-caret-right"></i></span>
            </a>
            <div class=sumbox v-if=listData.length>
                <div class=eachcontent>
                    <h1 class="pad">{{ (listData.filter(item => item.status != 'Created' || item.status != 'Closed')).length }} <span class="mini">Tiket</span></h1>
                    <div>
                        <h3 class=><i class="fi fi-rr-rotate-right colwarn"></i> Tiket On Progress</h3>
                        <p>Total tiket berlangsung / on-progress</p>
                        <button class=review>Lihat Tiket</button>
                    </div>
                </div>
                <div class=eachcontent>
                    <h1 class=" pad">{{ (listData.filter(item => item.status == 'Closed')).length }} <span class="mini">Tiket</span></h1>
                    <div>
                        <h3 class=><i class="fi fi-rr-checkbox colgreen"></i> Tiket Selesai</h3>
                        <p>Total tiket dengan status selesai.</p>
                        <button class=review>Lihat Tiket</button>
                    </div>
                </div>
                <div class=eachcontent>
                    <h1 class=" pad">{{ (listData.filter(item => item.status == 'Created')).length }} <span class="mini">Tiket</span></h1>
                    <div>
                        <h3 class=><i class="fi fi-rr-edit colblue"></i> Tiket Dibuat</h3>
                        <p>Total semua tiket yang dibuat.</p>
                        <button class=review>Lihat Tiket</button>
                    </div>
                </div>
            </div>
            <a>
                <h2><i class="fi fi-rr-ticket trans"></i> Tiket Terakhir Dibuat</h2>
                <span href="#"><i class="fi fi-rr-caret-right"></i></span>
            </a>
            <div class=lastticket>
                <div class=singleticket v-for="ticket in lastCreatedTicket" :key="ticket.id">
                    <h3>
                        <i class="fi fi-rr-ticket"></i>
                        <span class=rightinfo>
                            <span> Ticket Id. {{ticket.id}} - {{ticket.sn_unit}}</span>
                            <span>Dibuat pada {{(new Date(ticket.req_date)).toLocaleDateString('id-ID')}}</span>
                        </span>
                    </h3>
                    <div class=detrequestor>
                        <h4><i class="fi fi-rr-info"></i> Status : <span class="badgee" :class="ticket.status">{{ticket.status}}</span></h4>
                        <h4><i class="fi fi-rr-portrait"></i> {{ticket.requestor}} (Requestor) </h4>
                        <button>Detail Ticket</button>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <button @click="isAddData = true" title="Buat tiket baru" class=addbtn><i class="fi fi-rr-plus"></i></button>
        </div>
        <div class="addbox" v-if=isAddData>
            <div class=conbox>
                <h2>
                    <span><i class="fi fi-rr-envelope-plus"></i> Buat Tiket Baru</span>
                    <a href="#" @click="isAddData = false"><i class="fi fi-rr-cross-small"></i></a>
                </h2>
                <form id="formadd" class="form" @submit.prevent="submitNewRequest">
                    <div class=formsec>
                        <label for="sn">Serial Number Unit</label>
                        <input type="text" name="sn" required placeholder="Masukkan Serial Number Unit">
                    </div>
                    <div class=formsec>
                        <label for="desc">Deskripsi Pekerjaan</label>
                        <textarea name="desc"  rows="3" required placeholder="Masukkan Pekerjaan yang diinginkan"></textarea>
                    </div>
                    <div class=formsec>
                        <label for="email">Email Requestor</label>
                        <input type="email" name="email" placeholder="Masukkan Email Requestor" required>
                    </div>
                    <div class=formsec>
                        <label for="phone">Nomor Handphone Requestor</label>
                        <input type="tel" name="phone" required placeholder="Masukkan Nomor Telepon Requestor">
                    </div>
                    <div class="formsec btnfield">
                        <a href="#" @click="isAddData = false">Batal</a>
                        <button class="sbmt" type="submit" >Submit Request</button>
                    </div>
                </form>
            </div>
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
                    message: 'Hello Vue!',
                    listData: [],
                    isAddData: false,
                }
            },
            methods: {
                logOutUser(){
                    let confirm = window.confirm('Anda yakin ingin keluar?')
                    if(confirm){
                        window.location.href = "../index.php?status=logout"
                    }
                },
                loadData(data){
                    this.listData = JSON.parse(data)
                },
                submitNewRequest(){
                    $.ajax({
                        url: '../controllers/addNewRequest.php',
                        method: 'post',
                        data: $('#formadd').serialize(),
                        success: (data) => {
                            console.log(data)
                        }
                    })
                }
            },
            computed: {
                lastCreatedTicket(){
                    return this.listData.slice(0,5)
                }
            },
            mounted(){
                $.ajax({
                    url: '../controllers/getSummary.php',
                    method: 'get',
                    success: (data) => {
                        this.loadData(data)
                    }
                })
            }
        }).mount('#app')
    </script>
</body>
</html>