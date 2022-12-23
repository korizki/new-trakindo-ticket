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
            $access = $_SESSION['logged_user_type'];
            echo "<script>
                localStorage.setItem('user', '$user')
                localStorage.setItem('company', '$comp')
                localStorage.setItem('temp', btoa('$access'))
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
        <div class=topnav v-if="ticketWillUpdate == ''">
            <a :class="{activetab: activeTab == 1}" @click="activeTab = 1"><i class="fi fi-rr-stats" v-if="activeTab == 1"></i> Summary</a>
            <a :class="{activetab: activeTab == 2}" @click="activeTab = 2"><i class="fi-rr-document-signed" v-if="activeTab == 2"></i> Report</a>
        </div>
        <div class=content-header v-if="activeTab == 1">
            <div class=welcom>
                <h2><i class="fi fi-rr-comment-user trans"></i> Selamat Datang User  {{userAccess}}</h2>
                <p class="user">Anda berhasil Log In kembali <strong>{{ user }}</strong>, berikut rangkuman seluruh tiket yang dibuat oleh perusahaan <span v-if="userAccess == 'Administrator'">rekanan</span><span v-else>anda, <strong>{{ company }}</strong></span>.</p>
                <p v-if="userAccess != 'Administrator'" class="info blue inline"><i class="fi fi-rr-info"></i> Anda dapat membuat tiket baru dengan <strong>klik icon '+'</strong> pada kanan bawah halaman.</p>
                <p v-else class="info blue inline"><i class="fi fi-rr-info"></i> Anda dapat mengupdate tiket pada tab <strong>Report</strong> atau pada form <strong>Detail Ticket</strong>.</p>

            </div>
            <a>
                <h2><i class="fi fi-rr-document-signed"></i> Rangkuman Semua Tiket</h2>
                <span>Jumlah semua tiket {{ listData.length }} tiket.</span>
            </a>
            <div class=sumbox>
                <div class=eachcontent>
                    <h1 class=" pad">{{ (listData.filter(item => item.status == 'Created')).length }} <span class="mini">Tiket</span></h1>
                    <div>
                        <h3 class=><i class="fi fi-rr-edit colblue"></i> Tiket Baru <span v-if="userAccess != 'Administrator'">Dibuat</span></h3>
                        <p>Total semua tiket yang dibuat.</p>
                        <button class=review @click="ticketSummary('Created')">Lihat Tiket</button>
                    </div>
                </div>
                <div class=eachcontent>
                    <h1 class="pad">{{ (listData.filter(item => item.status != 'Created' && item.status != 'Closed')).length }} <span class="mini">Tiket</span></h1>
                    <div>
                        <h3 class=><i class="fi fi-rr-rotate-right colwarn"></i> Tiket On Progress</h3>
                        <p>Total tiket berlangsung / on-progress</p>
                        <button class=review @click="ticketSummary('Process')">Lihat Tiket</button>
                    </div>
                </div>
                <div class=eachcontent>
                    <h1 class=" pad">{{ (listData.filter(item => item.status == 'Closed')).length }} <span class="mini">Tiket</span></h1>
                    <div>
                        <h3 class=><i class="fi fi-rr-checkbox colgreen"></i> Tiket Selesai</h3>
                        <p>Total tiket dengan status selesai.</p>
                        <button class=review @click="ticketSummary('Completed')">Lihat Tiket</button>
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
                            <span> ID {{ticket.id}} - {{ticket.sn_unit}}</span>
                            <span>Dibuat pada {{(new Date(ticket.req_date)).toLocaleDateString('id-ID')}}</span>
                        </span>
                        <a @click="updateTicket(ticket)" title="Update Status Tiket" v-if="userAccess == 'Administrator'" class=updatebtns><i class="fi fi-rr-refresh"></i></a>
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
                <span>Menampilkan total tiket <strong>{{ filteredTickets.length > 10 ? '10' : filteredTickets.length }}</strong> dari total <strong>{{ listData.length }}</strong> tiket.</span>
            </a>
            <p class="info blue inline"><i class="fi fi-rr-info"></i> Anda dapat melihat detail tiket dengan klik pada baris tiket atau <strong>Lihat Tiket</strong> pada kolom Action.</p>
            <div class=searchbox>
                <form style="position: relative">
                    <select v-model="criteriaSearch" @change=handleChangeSelect>
                        <option value="">Kategori Pencarian</option>
                        <option value="sn_unit">Serial Number Unit</option>
                        <option value="company">Perusahaan</option>
                        <option value="requestor">Requestor</option>
                        <option value="status">Status</option>
                    </select>
                    <input type="text" v-model="keyword" ref=inputkeyword>
                    <a v-if="keyword.length" class=cleartext @click="keyword = ''"><i class="fi fi-rr-cross-small"></i></a>
                    <button><i class="fi fi-rr-search"></i></button>
                </form>
            </div>
            <div class=tableticket>
                <table>
                    <thead>
                        <th>No.</th>
                        <th class=mobile>Ticket ID</th>
                        <th>Serial Number</th>
                        <th>Request Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <tr v-for="(row,index) in filteredTickets" :key="row.id" @click=showDetailTicket(row)>
                            <td>{{(activePage-1)* 10 + index + 1}}.</td>
                            <td class=mobile>TIC-{{row.id}}</td>
                            <td style="text-align: left;">{{row.sn_unit}}</td>
                            <td>{{row.req_date}}</td>
                            <td>{{row.status}}
                                <span></
                            </td>
                            <td><a @click=showDetailTicket(row)><i class="fi fi-rr-search-alt"></i> <span class=mobile>Lihat Ticket<span> </a></td>
                        </tr>
                        <tr v-if=!filteredTickets.length>
                            <td colspan=6>Sorry, no data found.</td>
                        </tr>
                    </tbody>
                </table>
                <div class="bottomnav">
                    <a @click="tableNavClick('prev')"><i class="fi fi-rr-caret-left"></i></a>
                    <a @click="tableNavClick('next')"><i class="fi fi-rr-caret-right"></i></a>
                </div>
            </div>
        </div>
        <div class="content-header updateform" v-if="activeTab == 3">
            <h2><i class="fi fi-rr-edit"></i> Update Status Ticket</h2>
            <p class="info blue inlines"><i class="fi fi-rr-info"></i> Anda akan memperbaharui status ticket dengan detail berikut.</p>
            <div class="carddetailtick">
                <div class="cardfl">
                    <div class="cardsec">
                        <p><i class="fi fi-rr-ticket"></i> Ticket ID</p>
                        <h4>{{ticketWillUpdate.id}}</h4>
                    </div>
                    <div class="cardsec">
                        <p><i class="fi fi-rr-id-badge"></i> SN Unit</p>
                        <h4>{{ticketWillUpdate.sn_unit}}</h4>
                    </div>
                    <div class="cardsec">
                        <p><i class="fi fi-rr-building"></i> Perusahaan</p>
                        <h4>{{ticketWillUpdate.company}}</h4>
                    </div>
                    <div class="cardsec">
                        <p><i class="fi fi-rr-mobile-notch"></i> Kontak Person (HP)</p>
                        <h4>{{ticketWillUpdate.phone}}</h4>
                    </div>
                </div>
                <div class="cardfl">
                    <div class="cardsec">
                        <p><i class="fi fi-rr-document-signed"></i> Request Detail</p>
                        <h4>{{ticketWillUpdate.job}}</h4>
                    </div>
                </div>
                <div class="cardfl">
                    <div class="cardsec">
                        <p><i class="fi fi-rr-exclamation"></i> Status Tiket Terakhir</p>
                        <h4 class="info blue stat">{{ticketWillUpdate.status}}</h4>
                    </div>
                </div>
            </div>
            <div class="boxupdate">
                <form @submit.prevent="submitUpdate" id="formUpdate">
                    <div class="formsec nopad">
                        <label>Update Status</label>
                        <!-- <input type="text" name="status"> -->
                        <select name="status" v-model="updateStatus">
                            <option value="">Pilih Status</option>
                            <option value="Advice Only">Advice Only</option>
                            <option value="Waiting Quote">Waiting Quote</option>
                            <option value="Waiting Quote Approval / PO">Waiting Quote Approval / PO</option>
                            <option value="Waiting Schedule Perform">Waiting Schedule Perform</option>
                            <option value="Waiting Technician">Waiting Technician</option>
                            <option value="In Progress Perform">In Progress Perform</option>
                            <option value="Closed">Closed</option>
                        </select>
                    </div>
                    <div class="formsec nopad" v-if="updateStatus != 'Advice Only'" v-if="updateStatus != 'Waiting Quote'" v-if="updateStatus != 'Closed'">
                        <label>No Quote/ SO</label>
                        <input type="text" name="quotenumber">
                    </div>
                    <div class="formsec nopad" v-if="updateStatus == 'Waiting Quote Approval / PO' || updateStatus == 'In Progress Perform'">
                        <label>Nama Teknisi</label>
                        <input type="text" name="teknisi">
                    </div>
                    <div class="formsec nopad">
                        <label>Catatan Tambahan</label>
                        <input type="text" name="note">
                    </div>
                    <div class="upform nopad nopad-btn">
                        <a @click="cancelUpdate">Batal</a>
                        <button type="submit"><i class="fi fi-rr-disk"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <div v-if="userAccess != 'Administrator'">
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
                    <button v-if="userAccess == 'Administrator'" @click="updateTicket(ticketDetail)" class=btntutup>Update Ticket</button>
                    <button @click="showDetail = false" class=btntutup :class="{line: userAccess == 'Administrator'}">Tutup</button>
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
                    activeTab: 1,
                    criteriaSearch: '',
                    keyword: '',
                    activePage: 1,
                    totalPage: 0,
                    userAccess: '',
                    ticketWillUpdate: '',
                    updateStatus: ''
                }
            },
            methods: {
                ticketSummary(status){
                    this.criteriaSearch = 'status'
                    this.keyword = status 
                    this.activeTab = 2
                },
                logOutUser(){
                    let confirm = window.confirm('Anda yakin ingin keluar?')
                    if(confirm){
                        window.location.href = "../index.php?status=logout"
                    }
                },
                loadData(data){
                    this.listData = JSON.parse(data)
                    this.totalPage = Math.ceil(this.listData.length/10)
                },
                handleChangeSelect(){
                    this.$refs.inputkeyword.focus()
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
                cancelUpdate(){
                    this.activeTab = 1
                    this.ticketWillUpdate = ''
                    this.updateStatus = ''
                },
                showDetailTicket(ticket){
                    this.ticketDetail = ticket
                    this.showDetail = true
                },
                tableNavClick(nav){
                    if(nav == 'prev'){
                        this.activePage--
                        this.activePage = this.activePage == 0 ? 1 : this.activePage
                    } else {
                        this.activePage++
                        this.activePage = this.activePage > this.totalPage ? this.totalPage : this.activePage
                    }
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
                },
                updateTicket(ticket){
                    window.scrollTo(0,0)
                    this.ticketWillUpdate = ticket
                    this.showDetail = false
                    this.activeTab = 3
                },
                submitUpdate(){
                    // update status ticket
                    let form = new FormData(document.querySelector('#formUpdate'))
                    let obj = Object.fromEntries(form.entries())
                    // update status ticket 
                    $.ajax({
                        url: '../controllers/updateTicketStatus.php',
                        data: {id: this.ticketWillUpdate.id, status: obj.status},
                        method: 'POST',
                        error: () => {
                            alert('Gagal update tiket.')
                        }
                    })
                    // add to history
                    $.ajax({
                        url: '../controllers/addTicketHistory.php',
                        data: {id: this.ticketWillUpdate.id, date: this.ticketWillUpdate.req_date.slice(0,10)},
                        method: 'POST',
                        success: () => {
                            // update data dengan id dan tanggal
                            obj.date = (new Date()).toLocaleDateString('fr-CA')
                            obj.id = this.ticketWillUpdate.id
                            // update history
                            $.ajax({
                                url: '../controllers/updateTicketHistory.php',
                                data: obj,
                                method: 'POST',
                                success: () => {
                                    alert('Berhasil update ticket.')
                                    setTimeout(() => {
                                        this.activeTab = 1
                                        this.getDataFromAPI()
                                    },500)
                                }
                            })
                            console.log(obj)
                        }
                    })
                }
            },
            computed: {
                lastCreatedTicket(){
                    return this.listData.slice(0,5)
                },
                filteredTickets(){
                    return (this.listData.filter(item => item[this.criteriaSearch || 'requestor'].toLowerCase().includes((this.keyword).toLowerCase()))).slice((this.activePage - 1)*10, (this.activePage*10))
                }
            },
            mounted(){
                this.getDataFromAPI()
                let user = localStorage.getItem('temp')
                this.userAccess = atob(user)
            }
        }).mount('#app')
    </script>
</body>
</html>