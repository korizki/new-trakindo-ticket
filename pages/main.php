<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Tiket Trakindo</title>
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
        } else {
            $user = $_SESSION['logged_user'];
            $comp = $_SESSION['logged_user_comp'];
            echo "<script>
                localStorage.setItem('user', '$user')
                localStorage.setItem('company', '$comp')
            </script>";
        }

    ?>
    <div id="app">
        <nav>
            <a href="./main.php"><img src="../assets/icon/trakindo.png" alt="icon-trakindo" width=140></a>
            
            <a title="Log Out User" class="logoffbtn" @click="logOutUser"><i class="fi fi-rr-sign-out-alt"></i> <span class="remarklogout">Keluar</span></a>
        </nav>
        <p class=notifsuccess v-if="showNotifSuccess">
            <span><i class="fi fi-rr-badge-check"></i> <strong>Request Tiket berhasil</strong>, silahkan tunggu Feedback / Balasan tiket. Terima kasih.</span>
            <a @click="showNotifSuccess = false"><i class="fi fi-rr-cross-small"></i></a>
        </p>
        <div class=topnav>
            <a :class="{activetab: activeTab == 1}" @click="activeTab = 1"><i class="fi fi-rr-stats" v-if="activeTab == 1"></i> Summary</a>
            <a :class="{activetab: activeTab == 2}" @click="activeTab = 2"><i class="fi-rr-document-signed" v-if="activeTab == 2"></i> Report</a>
        </div>
        <div class=content-header v-if="activeTab == 1">
            <div class=welcom>
                <h2><i class="fi fi-rr-comment-user trans"></i> Selamat Datang User</h2>
                <p class="user">Anda berhasil Log In kembali <strong>{{ user }}</strong>, berikut rangkuman seluruh tiket yang dibuat oleh perusahaan anda, <strong>{{ company }}</strong>.</p>
                <p class="info blue inline"><i class="fi fi-rr-info"></i> Anda dapat membuat tiket baru dengan <strong>klik icon '+'</strong> pada kanan bawah halaman.</p>
            </div>
            <a>
                <h2><i class="fi fi-rr-document-signed"></i> Rangkuman Semua Tiket</h2>
                <span>Jumlah semua tiket {{ listData.length }} tiket.</span>
            </a>
            <div class=sumbox>
                <div class=eachcontent>
                    <h1 class=" pad">{{ (listData.filter(item => item.status == 'Created')).length }} <span class="mini">Tiket</span></h1>
                    <div>
                        <h3 class=><i class="fi fi-rr-edit colblue"></i> Tiket Baru Dibuat</h3>
                        <p>Total semua tiket yang dibuat.</p>
                        <button class=review>Lihat Tiket</button>
                    </div>
                </div>
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
            </div>
            <a>
                <h2><i class="fi fi-rr-ticket trans"></i> Tiket Terakhir Dibuat</h2>
                <span>Menampilkan 5 tiket yang terakhir dibuat.</span>
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
                        <button @click="showDetailTicket(ticket)">Detail Ticket</button>
                    </div>
                </div>
            </div>
        </div>
        <div class=content-header v-if="activeTab == 2">
            <a>
                <h2><i class="fi fi-rr-document-signed"></i> Monitoring Semua Tiket</h2>
                <span>Menampilkan total tiket <strong>{{ listData.length > 10 ? '10' : listData.length }}</strong> dari total <strong>{{ listData.length }}</strong> tiket.</span>
            </a>
            <div class=tableticket>
                <table>
                    <thead>
                        <th>No.</th>
                        <th>Ticket ID</th>
                        <th>Serial Number</th>
                        <th>Request Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <tr v-for="(row,index) in listData" :key="row.id" @click=showDetailTicket(row)>
                            <td>{{index + 1}}.</td>
                            <td>TIC-{{row.id}}</td>
                            <td style="text-align: left;">{{row.sn_unit}}</td>
                            <td>{{row.req_date}}</td>
                            <td>{{row.status}}
                                <span></
                            </td>
                            <td><a @click=showDetailTicket(row)><i class="fi fi-rr-search-alt"></i> Lihat Ticket </a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div>
            <button @click="isAddData = true" title="Buat tiket baru" class=addbtn><i class="fi fi-rr-plus"></i></button>
        </div>
        <div class="addbox" v-if=isAddData>
            <div class=conbox>
                <h2>
                    <span><i class="fi fi-rr-envelope-plus"></i> Buat Tiket Baru</span>
                    <a @click="isAddData = false"><i class="fi fi-rr-cross-small"></i></a>
                </h2>
                <form id="formadd" class="form" @submit.prevent="submitNewRequest">
                    <div class=formsec>
                        <label for="sn">Serial Number Unit</label>
                        <input type="text" name="sn" required placeholder="Contoh: EX-001">
                    </div>
                    <div class=formsec>
                        <label for="desc">Deskripsi Pekerjaan</label>
                        <textarea name="desc"  rows="3" required placeholder="Contoh: Penggantian Radiator "></textarea>
                    </div>
                    <div class=formsec>
                        <label for="email">Email Requestor</label>
                        <input type="email" name="email" placeholder="Contoh: admin@gmail.com" required>
                    </div>
                    <div class=formsec>
                        <label for="phone">Nomor Handphone Requestor</label>
                        <input type="tel" name="phone" required placeholder="Contoh: 08123456789">
                    </div>
                    <div class="formsec btnfield">
                        <a @click="isAddData = false">Batal</a>
                        <button class="sbmt" type="submit" >Submit Request</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="addbox detailout" v-if=showDetail @click.self="showDetail = false">
            <div class="conbox detail">
                <h2> 
                    <span><i class="fi fi-rr-ticket"></i> Detail Tiket</span>
                    <a @click="showDetail = false"><i class="fi fi-rr-cross-small"></i></a>
                </h2>
                <div class=detsect>
                    <h3>
                        <span><i class="fi fi-rr-info"></i> Informasi Tiket</span>
                        <span class=minif><i class="fi fi-rr-calendar-clock"></i> Dibuat pada {{ ticketDetail.req_date }}</span>
                    </h3>
                    <div class=contdet>
                        <div>
                            <p>Ticket ID</p>
                            <h4>TIC-{{ ticketDetail.id }}</h4>
                        </div>
                        <div>
                            <p>Serial Number Unit</p>
                            <h4>{{ ticketDetail.sn_unit }}</h4>
                        </div>
                        <div>
                            <p>Status Ticket</p>
                            <h4>{{ ticketDetail.status }}</h4>
                        </div>
                    </div>
                </div>
                <div class=detsect>
                    <h3><span><i class="fi fi-rr-portrait"></i> Informasi Requestor</span></h3>
                    <div class=contdet>
                        <div>
                            <p>Nomor Handphone</p>
                            <h4>{{ ticketDetail.phone }}</h4>
                        </div>
                        <div>
                            <p>Email</p>
                            <h4>{{ ticketDetail.email }}</h4>
                        </div>
                        <div>
                            <p>Username</p>
                            <h4>{{ ticketDetail.requestor }}</h4>
                        </div>
                    </div>
                </div>
                <div class=detsect>
                    <h3><span><i class="fi fi-rr-settings"></i> Informasi Pekerjaan</span></h3>
                    <div class=contdet>
                        <div class=pesan>
                            <p>Deskripsi / Detail</p>
                            <h4>{{ ticketDetail.job }}</h4>
                        </div>
                    </div>
                </div>
                <div class="detsect">
                    <button @click="showDetail = false" class=btntutup>Tutup</button>
                </div>
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
                    user: '',
                    company: '',
                    showNotifSuccess: false,
                    ticketDetail: '',
                    showDetail: false,
                    activeTab: 2,
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
                    console.log(this.ticketDetail)
                },
                getDataFromAPI(){
                    $.ajax({
                        url: '../controllers/getSummary.php',
                        method: 'get',
                        success: (data) => {
                            this.loadData(data)
                            this.user = localStorage.getItem('user')
                            this.company = localStorage.getItem('company')
                        }
                    })
                },
                showDetailTicket(ticket){
                    this.ticketDetail = ticket
                    this.showDetail = true
                },
                submitNewRequest(){
                    $.ajax({
                        url: '../controllers/addNewRequest.php',
                        method: 'post',
                        data: $('#formadd').serialize(),
                        success: (data) => {
                            // refresh data pada main page
                            this.getDataFromAPI()
                            let response = JSON.parse(data)
                            if(response.status == 'Success'){
                                this.isAddData = false
                                this.showNotifSuccess = true;
                                setTimeout(() => {
                                    this.showNotifSuccess = false;
                                },3000)
                            }
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
                this.getDataFromAPI()
            }
        }).mount('#app')
    </script>
</body>
</html>