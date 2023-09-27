 <!-- /.container-fluid -->

 </div>
 <!-- End of Main Content -->

 <!-- Footer -->
 <footer class="sticky-footer bg-white">
     <div class="container my-auto">
         <div class="copyright text-center my-auto">
             <span>Copyright &copy; Your Website 2021</span>
         </div>
     </div>
 </footer>
 <!-- End of Footer -->

 </div>
 <!-- End of Content Wrapper -->

 </div>
 <!-- End of Page Wrapper -->

 <!-- Scroll to Top Button-->
 <a class="scroll-to-top rounded" href="#page-top">
     <i class="fas fa-angle-up"></i>
 </a>

 <!-- Logout Modal-->
 <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                 <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                 </button>
             </div>
             <div class="modal-body">Cek kembali data anda, jika anda yakin ingin logout klik tombol logout</div>
             <div class="modal-footer">
                 <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                 <a class="btn btn-primary" href="../logout.php">Logout</a>
             </div>
         </div>
     </div>
 </div>

 <!-- Bootstrap core JavaScript-->
 <script src="../template/vendor/jquery/jquery.js"></script>
 <script src="../template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

 <!-- Core plugin JavaScript-->
 <script src="../template/vendor/jquery-easing/jquery.easing.min.js"></script>

 <!-- Custom scripts for all pages-->
 <script src="../template/js/sb-admin-2.min.js"></script>

 <!-- Page level plugins -->
 <script src="../template/vendor/chart.js/Chart.min.js"></script>
 <script src="../assets/bootstrap-select/dist/js/bootstrap-select.js"></script>

 <!-- Page level custom scripts -->
 <!-- <script src="../template/js/demo/chart-bar-demo.js"></script> -->
 <!-- <script src="../template/js/demo/chart-pie-demo.js"></script> -->
 <!-- Page level plugins -->
 <!-- <script src="../template/vendor/datatables/jquery.dataTables.min.js"></script>
 <script src="../template/vendor/datatables/dataTables.bootstrap4.min.js"></script> -->
 <script src="../assets/DataTables/datatables/jquery.dataTables.min.js"></script>
 <script src="../assets/DataTables/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
 <script src="../assets/DataTables/datatables-responsive/js/dataTables.responsive.min.js"></script>
 <script src="../assets/DataTables/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
 <script src="../assets/DataTables/datatables-buttons/js/dataTables.buttons.min.js"></script>
 <script src="../assets/DataTables/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

 <?php
    require_once "../db/koneksi.php";
    if (isset($_GET["cari"])) {
        $dari_tgl = $_GET["dari"];
        $sampai_tgl = $_GET["sampai"];
    } else {
        $tgl_pendTerakhir = mysqli_fetch_array(mysqli_query($conn, "SELECT tgl_pemasukan FROM pemasukan 
        GROUP BY tgl_pemasukan ORDER BY tgl_pemasukan DESC"));
        if ($tgl_pendTerakhir != NULL) {
            $dari_tgl = $tgl_pendTerakhir["tgl_pemasukan"];
            $sampai_tgl = $tgl_pendTerakhir["tgl_pemasukan"];
        } else {
            $dari_tgl = date("Y-m-01");
            $sampai_tgl = date("Y-m-01", strtotime("+ 30 day"));
        }
    }

    $query = "SELECT sum(pendapatan) FROM pemasukan WHERE tgl_pemasukan BETWEEN '$dari_tgl%' AND '$sampai_tgl%'";
    $result = mysqli_fetch_row(mysqli_query($conn, $query));
    // var_dump($result);

    $query_pemasukan = "SELECT bulan, total_pendapatan, total_hutang FROM total_pemasukan";
    $get_pemasukan = mysqli_query($conn, $query_pemasukan);

    $incomeData = [];
    $debtData = [];
    $months = [];
    $total_pemasukan = [];
    if (mysqli_num_rows($get_pemasukan) > 0) {
        while ($row = mysqli_fetch_array($get_pemasukan)) {
            $months[] = $row['bulan'];
            $incomeData[] = $row['total_pendapatan'];
            $debtData[] = $row['total_hutang'];
            $total_pemasukan[] = $row["total_pendapatan"] + $row["total_hutang"];
        }
    }

    // -----------------------------------------------------
    //Total pemasukan pendapatan
    // -----------------------------------------------------
    $query_bbm = mysqli_query($conn, "SELECT * FROM bbm");
    $data_bbm = array();
    while ($row = mysqli_fetch_array($query_bbm)) {

        $id_bbm = $row["id_bbm"];
        $total_pendapatan = mysqli_fetch_row(mysqli_query($conn, "SELECT sum(pendapatan) FROM pemasukan WHERE id_bbm='$id_bbm' AND tgl_pemasukan BETWEEN '$dari_tgl%' AND '$sampai_tgl%'"));
        $bbm = [
            "nama_bbm" => $row["nama_bbm"],
            "pendapatan" => $total_pendapatan
        ];
        $data_bbm[] = $bbm;
    }
    // header('Content-Type: application/json');
    $total_dapat =  json_encode($data_bbm);

    // -----------------------------------------------------
    //Total penjualan liter
    // -----------------------------------------------------
    $query_bbm = mysqli_query($conn, "SELECT * FROM bbm");

    $data_bbm = array();
    $no = 1;
    while ($row = mysqli_fetch_array($query_bbm)) {
        $id_bbm = $row["id_bbm"];
        $liter_terjual = mysqli_fetch_row(mysqli_query($conn, "SELECT sum(liter_terjual) FROM pemasukan WHERE id_bbm='$id_bbm' AND tgl_pemasukan BETWEEN '$dari_tgl%' AND '$sampai_tgl%'"));
        $bbm = [
            "nama_bbm" => $row["nama_bbm"],
            "liter_terjual" => $liter_terjual[0],
            "bg" => "#" . $no++ . "e73df"
        ];
        $data_bbm[] = $bbm;
    }

    // header('Content-Type: application/json');
    $total_liter =  json_encode($data_bbm);
    ?>

 <!-- Page level custom scripts -->
 <!-- <script src="../template/js/demo/datatables-demo.js"></script> -->
 <!-- <script src="../assets/jquery.js"></script> -->

 <script>
     // Set new default font family and font color to mimic Bootstrap's default styling
     Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
     Chart.defaults.global.defaultFontColor = '#858796';

     function number_format(number, decimals, dec_point, thousands_sep) {
         // *     example: number_format(1234.56, 2, ',', ' ');
         // *     return: '1 234,56'
         number = (number + '').replace(',', '').replace(' ', '');
         var n = !isFinite(+number) ? 0 : +number,
             prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
             sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
             dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
             s = '',
             toFixedFix = function(n, prec) {
                 var k = Math.pow(10, prec);
                 return '' + Math.round(n * k) / k;
             };
         // Fix for IE parseFloat(0.55).toFixed(0) = 0;
         s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
         if (s[0].length > 3) {
             s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
         }
         if ((s[1] || '').length < prec) {
             s[1] = s[1] || '';
             s[1] += new Array(prec - s[1].length + 1).join('0');
         }
         return s.join(dec);
     }

     var receivedData = <?= $total_dapat; ?>;
     var nama_bbm = [];
     var total_pendapatan = [];

     for (var i = 0; i < receivedData.length; i++) {
         //  var bbm = {
         //      "nama_bbm": receivedData[i],
         //  }
         namaBbm = receivedData[i]["nama_bbm"];
         total = receivedData[i]["pendapatan"][0];

         nama_bbm.push(namaBbm);
         total_pendapatan.push(total);
     }
     var ctx = document.getElementById("myBarChart");
     var myBarChart = new Chart(ctx, {
         type: 'bar',
         data: {
             labels: nama_bbm,
             datasets: [{
                 label: "Pendapatan",
                 backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                     '#858796', '#5a5c69', '#f8f9fc', '#d1d3e2', '#f8f9fc'
                 ],
                 hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#dda20a', '#c53727',
                     '#6b6d7d', '#45474d', '#d1d3e2', '#b7b9cc', '#d1d3e2'
                 ],
                 borderColor: "#4e73df",
                 data: total_pendapatan,
             }],
         },
         options: {
             maintainAspectRatio: false,
             layout: {
                 padding: {
                     left: 10,
                     right: 25,
                     top: 25,
                     bottom: 0
                 }
             },
             scales: {
                 xAxes: [{
                     time: {
                         unit: 'month'
                     },
                     gridLines: {
                         display: true,
                         drawBorder: false
                     },
                     ticks: {
                         maxTicksLimit: 6
                     },
                     maxBarThickness: 25,
                 }],
                 yAxes: [{
                     ticks: {
                         min: 0,
                         max: <?= $result[0]; ?>,
                         maxTicksLimit: 5,
                         padding: 10,
                         // Include a dollar sign in the ticks
                         callback: function(value, index, values) {
                             return 'Rp. ' + number_format(value);
                         }
                     },
                     gridLines: {
                         color: "rgb(234, 236, 244)",
                         zeroLineColor: "rgb(234, 236, 244)",
                         drawBorder: false,
                         borderDash: [2],
                         zeroLineBorderDash: [2]
                     }
                 }],
             },
             legend: {
                 display: false
             },
             tooltips: {
                 titleMarginBottom: 10,
                 titleFontColor: '#6e707e',
                 titleFontSize: 14,
                 backgroundColor: "rgb(255,255,255)",
                 bodyFontColor: "#858796",
                 borderColor: '#dddfeb',
                 borderWidth: 1,
                 xPadding: 15,
                 yPadding: 15,
                 displayColors: false,
                 caretPadding: 10,
                 callbacks: {
                     label: function(tooltipItem, chart) {
                         var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                         return datasetLabel + ': Rp. ' + number_format(tooltipItem.yLabel);
                     }
                 }
             },
         }
     });


     //pie chart
     // Lakukan sesuatu dengan data yang diterima
     var penjualan_liter = <?= $total_liter; ?>;
     var nama_bbm = [];
     var liter_bbm = [];
     var background = [];
     for (var i = 0; i < penjualan_liter.length; i++) {
         var namaBbm = penjualan_liter[i]["nama_bbm"];
         var literBbm = penjualan_liter[i]["liter_terjual"];
         var bg = penjualan_liter[i]["bg"];
         nama_bbm.push(namaBbm);
         liter_bbm.push(literBbm);
         background.push(bg);

     }

     var ctx = document.getElementById("myPieChart");
     var myPieChart = new Chart(ctx, {
         type: 'doughnut',
         data: {
             labels: nama_bbm,
             datasets: [{
                 data: liter_bbm,
                 backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                     '#858796', '#5a5c69', '#f8f9fc', '#d1d3e2', '#f8f9fc'
                 ],
                 hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#dda20a', '#c53727',
                     '#6b6d7d', '#45474d', '#d1d3e2', '#b7b9cc', '#d1d3e2'
                 ],
                 hoverBorderColor: "rgba(234, 236, 244, 1)",
             }],
         },
         options: {
             maintainAspectRatio: false,
             tooltips: {
                 backgroundColor: "rgb(255,255,255)",
                 bodyFontColor: "#858796",
                 borderColor: '#dddfeb',
                 borderWidth: 1,
                 xPadding: 15,
                 yPadding: 15,
                 displayColors: false,
                 caretPadding: 10,
             },
             legend: {
                 display: false
             },
             cutoutPercentage: 80,
         },
     });

     // Data dari PHP, gantilah dengan data yang sesuai
     function formatNumberWithCommas(number) {
         return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
     }
     var incomeData = <?php echo json_encode($incomeData); ?>;
     var debtData = <?php echo json_encode($debtData); ?>;
     var months = <?php echo json_encode($months); ?>;
     var total_pemasukan = <?php echo json_encode($total_pemasukan); ?>;

     // Area Chart Example
     var ctx = document.getElementById("myAreaChart");
     var myLineChart = new Chart(ctx, {
         type: 'line',
         data: {
             labels: months,
             datasets: [{
                     label: "Total Pemasukan Seharusnya",
                     lineTension: 0.3,
                     backgroundColor: "rgba(75, 192, 192, 0.05)",
                     borderColor: "rgba(75, 192, 192, 1)",
                     pointRadius: 3,
                     pointBackgroundColor: "rgba(75, 192, 192, 1)",
                     pointBorderColor: "rgba(75, 192, 192, 1)",
                     pointHoverRadius: 3,
                     pointHoverBackgroundColor: "rgba(75, 192, 192, 1)",
                     pointHoverBorderColor: "rgba(75, 192, 192, 1)",
                     pointHitRadius: 10,
                     pointBorderWidth: 2,
                     data: total_pemasukan,
                 },
                 {
                     label: "Pendapatan",
                     lineTension: 0.3,
                     backgroundColor: "rgba(78, 115, 223, 0.05)",
                     borderColor: "rgba(78, 115, 223, 1)",
                     pointRadius: 3,
                     pointBackgroundColor: "rgba(78, 115, 223, 1)",
                     pointBorderColor: "rgba(78, 115, 223, 1)",
                     pointHoverRadius: 3,
                     pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                     pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                     pointHitRadius: 10,
                     pointBorderWidth: 2,
                     data: incomeData,
                 },
                 {
                     label: "Hutang Customer",
                     lineTension: 0.3,
                     backgroundColor: "rgba(255, 99, 132, 0.05)",
                     borderColor: "rgba(255, 99, 132, 1)",
                     pointRadius: 3,
                     pointBackgroundColor: "rgba(255, 99, 132, 1)",
                     pointBorderColor: "rgba(255, 99, 132, 1)",
                     pointHoverRadius: 3,
                     pointHoverBackgroundColor: "rgba(255, 99, 132, 1)",
                     pointHoverBorderColor: "rgba(255, 99, 132, 1)",
                     pointHitRadius: 10,
                     pointBorderWidth: 2,
                     data: debtData,
                 },
             ],
         },
         options: {
             maintainAspectRatio: false,
             layout: {
                 padding: {
                     left: 10,
                     right: 25,
                     top: 25,
                     bottom: 0
                 }
             },
             scales: {
                 xAxes: [{
                     time: {
                         unit: 'date'
                     },
                     gridLines: {
                         display: false,
                         drawBorder: false
                     },
                     ticks: {
                         maxTicksLimit: 7
                     }
                 }],
                 yAxes: [{
                     ticks: {
                         maxTicksLimit: 5,
                         padding: 10,
                         // Include a dollar sign in the ticks
                         callback: function(value, index, values) {
                             return 'Rp. ' + number_format(value);
                         }
                     },
                     gridLines: {
                         color: "rgb(234, 236, 244)",
                         zeroLineColor: "rgb(234, 236, 244)",
                         drawBorder: false,
                         borderDash: [2],
                         zeroLineBorderDash: [2]
                     }
                 }],
             },
             legend: {
                 display: false
             },
             tooltips: {
                 backgroundColor: "rgb(255,255,255)",
                 bodyFontColor: "#858796",
                 titleMarginBottom: 10,
                 titleFontColor: '#6e707e',
                 titleFontSize: 14,
                 borderColor: '#dddfeb',
                 borderWidth: 1,
                 xPadding: 15,
                 yPadding: 15,
                 displayColors: false,
                 intersect: false,
                 mode: 'index',
                 caretPadding: 10,
                 callbacks: {
                     label: function(tooltipItem, chart) {
                         var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                         return datasetLabel + ': Rp. ' + number_format(tooltipItem.yLabel);
                     }
                 }
             }
         }
     });
 </script>
 <script>
     $(function() {
         $("#example1").DataTable({
             "paging": true,
             "responsive": true,
             "lengthChange": true,
             "autoWidth": false,
         }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
         $("#example3")
             .DataTable({
                 responsive: true,
                 lengthChange: true,
                 autoWidth: false,
                 buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
             })
             .buttons()
             .container()
             .appendTo("#example1_wrapper .col-md-6:eq(0)");
         $('#example2').DataTable({
             "paging": true,
             "lengthChange": true,
             "searching": true,
             "ordering": true,
             "info": true,
             "autoWidth": false,
             "responsive": true,
         });
     })

     const rpInputs = document.querySelectorAll('.rp-input');

     rpInputs.forEach(rpInput => {
         rpInput.addEventListener('input', function() {
             const inputValue = rpInput.value.replace(/[^\d]/g, ''); // Remove non-digit characters

             // Format the value as Rupiah
             if (inputValue) {
                 const formattedValue = formatRupiah(inputValue);
                 rpInput.value = formattedValue;
             }
         });
     });

     function formatRupiah(value) {
         const reverseValue = value.split('').reverse().join('');
         const ribuan = reverseValue.match(/\d{1,3}/g);
         const formattedValue = ribuan.join(',').split('').reverse().join('');
         return `${formattedValue}`;
     }

     $(function() {
         var url = window.location;
         $("ul.navbar-nav a").filter(function() {
             return this.href == url;
         }).addClass("font-weight-bold text-light");

         $(document).on("click", ".hapus", function(e) {
             e.preventDefault();
             var url = $(this).attr("href");
             Swal.fire({
                 title: 'Hapus Data',
                 text: "Apakah anda yakin ingin menghapus data?",
                 icon: 'warning',
                 showCancelButton: true,
                 confirmButtonColor: '#3085d6',
                 cancelButtonColor: '#d33',
                 confirmButtonText: 'Ya hapus data'
             }).then((result) => {
                 if (result.isConfirmed) {
                     let timerInterval
                     Swal.fire({
                         title: 'Loading',
                         html: 'Sedang memverifikasi data',
                         timer: 2000,
                         timerProgressBar: true,
                         didOpen: () => {
                             Swal.showLoading()
                             const b = Swal.getHtmlContainer().querySelector('b')
                             timerInterval = setInterval(() => {
                                 b.textContent = Swal.getTimerLeft()
                             }, 100)
                         },
                         willClose: () => {
                             clearInterval(timerInterval)
                         }
                     }).then((result) => {
                         /* Read more about handling dismissals below */
                         if (result.dismiss === Swal.DismissReason.timer) {
                             window.location.href = url;
                         }
                     })
                 }
             })
         })

         $(document).on("click", "#tambah-karyawan", function(e) {
             e.preventDefault();
             $("#btn-simpan").attr("name", "simpan_karyawan");
             $(".modal-body input").val("");
             $(".modal-body input[type=radio]").prop("checked", false);
         })

         $(document).on("click", ".edit-karyawan", function(e) {
             e.preventDefault();
             $(".modal-body #id_user").val($(this).data("id_user"));
             $(".modal-body #nama").val($(this).data("nama"));
             if ($(this).data("jk") == "L") {
                 $(".modal-body #exampleRadios1").prop("checked", true);
             } else if ($(this).data("jk") == "P") {
                 $(".modal-body #exampleRadios2").prop("checked", true);
             }
             $(".modal-body #alamat").val($(this).data("alamat"));
             $(".modal-body #no_hp").val($(this).data("no_hp"));
             $(".modal-body #username").val($(this).data("username"));
             $(".modal-body #password").val($(this).data("password"));
             $("#btn-simpan").attr("name", "update_karyawan");
         })

         $(document).on("click", "#tambah-customer", function(e) {
             e.preventDefault();
             $("#btn-simpan").attr("name", "simpan_customer");
             $(".modal-body input").val("");
             $(".modal-body input[type=radio]").prop("checked", false);
         })
         $(document).on("click", ".edit-customer", function(e) {
             e.preventDefault();
             console.log("test");
             $(".modal-body #id_customer").val($(this).data("id_customer"));
             $(".modal-body #nama").val($(this).data("nama"));
             if ($(this).data("jk") == "L") {
                 $(".modal-body #exampleRadios1").prop("checked", true);
             } else if ($(this).data("jk") == "P") {
                 $(".modal-body #exampleRadios2").prop("checked", true);
             }
             $(".modal-body #alamat").val($(this).data("alamat"));
             $(".modal-body #no_hp").val($(this).data("no_hp"));
             $("#btn-simpan").attr("name", "update_customer");
         })
         $(document).on("click", ".edit-bbm", function(e) {
             e.preventDefault();
             console.log("test");
             $(".modal-body #id_bbm").val($(this).data("id_bbm"));
             $(".modal-body #nama_bbm").val($(this).data("nama_bbm"));
             $(".modal-body #harga_perliter").val($(this).data("harga_perliter"));
             $("#btn-simpan").attr("name", "update_bbm");
         })
         $(document).on("click", "#tambah-bbm", function(e) {
             e.preventDefault();
             console.log("test");
             $("#btn-simpan").attr("name", "simpan_bbm");
             $(".modal-body input").val("");
         })

         var format = function(num) {
             var str = num.toString().replace("", ""),
                 parts = false,
                 output = [],
                 i = 1,
                 formatted = null;
             if (str.indexOf(".") > 0) {
                 parts = str.split(".");
                 str = parts[0];
             }
             str = str.split("").reverse();
             for (var j = 0, len = str.length; j < len; j++) {
                 if (str[j] != ",") {
                     output.push(str[j]);
                     if (i % 3 == 0 && j < (len - 1)) {
                         output.push(",");
                     }
                     i++;
                 }
             }
             formatted = output.reverse().join("");
             return ("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
         };


         $(document).on("click", ".bayar", function(e) {
             e.preventDefault();
             $('html, body').animate({
                 scrollTop: 0
             }, 800);
             $("#form-hutang").attr("hidden", false);
             $("#membayar").attr("readonly", false);
             let nama_bbm = $(this).data("nama_bbm");
             var membayar = $("#membayar").val();
             let id_pemasukan = $(this).data("id_pemasukan");
             let hutang = $(this).data("hutang");

             console.log();
             $("#id_pemasukan").val(id_pemasukan);
             $("#jml-hutang #hutang").val(format(hutang));

             $('#membayar').keyup((e) => {
                 var text_lter = e.currentTarget.value;
                 var membayar = text_lter.replace(/\,/g, "");
                 var kembalian = membayar - hutang;
                 console.log(kembalian);
                 $("#total").text(format(kembalian));
                 if (hutang > membayar) {
                     var kurang = hutang - membayar;
                     $("#hasil").text("Kurang : ").addClass("text-danger");
                     $("#kurang").val(kurang);
                 } else {
                     $("#hasil").text("Kembalian : ").removeClass("text-danger").addClass("text-success");
                     $("#kurang").val(0);
                 }
             });
             var total = membayar - hutang;

             if (total) {
                 if (hutang > membayar) {
                     var kurang = hutang - membayar;
                     $("#hasil").text("Kurang : ").addClass("text-danger");
                     $("#kurang").val(kurang);
                 } else {
                     $("#hasil").text("Kembalian : ").removeClass("text-danger");
                     $("#kurang").val(0);
                 }
             }

             $("#total").text(format(total));
             $("#nama-bbm").text("Nama BBM : " + nama_bbm);
         })

         $(document).on("click", "#hitung-rp", function(e) {
             var rp_perliter = $("#rp_perliter").val().replace(/\,/g, "");
             var isi_liter = $("#isi_liter").val().replace(/\,/g, "");
             var total_rp = rp_perliter * isi_liter;

             $("#total_rp").val(format(total_rp));
         })

         $("#msg-total").hide();
         $(document).on("click", ".modal-body #inp-pendTerakhir", function(e) {
             e.preventDefault();
             let pendTerakhir = $("#pendTerakhir").text();
             $(".modal-body #total_deposit").val(pendTerakhir);
             $("#msg-total").delay(500).slideUp(200, function() {
                 $("#msg-total").fadeIn();
             });
         })

         //print laporan keuangan
         $(document).on("click", "#print-pemasukan", function(e) {
             e.preventDefault();
             console.log("print-pemasukan");
             $(".modal-title").text("Dowload Laporan Pemasukan");
             $("#view-laporan").attr("action", "pdf/print_pemasukan.php");
         })
         $(document).on("click", "#print-pengeluaran", function(e) {
             e.preventDefault();
             console.log("print-pengeluaran");
             $(".modal-title").text("Dowload Laporan Pengeluaran");
             $("#view-laporan").attr("action", "pdf/print_pengeluaran.php");
         })
         $(document).on("submit", "#view-laporan", function(e) {
             e.preventDefault();
             let bulan = $("#bulan").val();
             console.log(bulan);
             $("#loading").html('<i class="fas fa-sync-alt fa-spin fa-2x"></i>');
             $("#simpan-pdf").attr("href", "pdf/print_pemasukan.php?bulan=" + bulan);
             $.ajax({
                 url: $(this).attr("action"),
                 method: "post",
                 dataType: "json",
                 data: $("#view-laporan").serialize(),
                 success: function(data) {
                     $(".content-laporan").html(data);
                 }
             })
         })
         $("#close-modal").click(function() {
             $(".content-laporan").html("");
             $(".modal-body input").val("");
         })
     })
 </script>

 </body>

 </html>