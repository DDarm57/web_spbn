<footer class="bg-light p-4 mt-4">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2023 SPBN Branta</strong>
</footer>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="../template/vendor/jquery/jquery.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="../template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../assets/bootstrap-select/dist/js/bootstrap-select.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script> -->
<!-- Page level custom scripts -->
<!-- <script src="../template/js/demo/datatables-demo.js"></script> -->
<!-- <script src="../assets/jquery.js"></script> -->
<script src="../assets/DataTables/datatables/jquery.dataTables.min.js"></script>
<script src="../assets/DataTables/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../assets/DataTables/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../assets/DataTables/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../assets/DataTables/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../assets/DataTables/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<!-- <script src="../assets/DataTables/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../assets/DataTables/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../assets/DataTables/plugins/datatables-buttons/js/buttons.colVis.min.js"></script> -->
<script>
    $(function() {
        $("#example1").DataTable({
            "paging": true,
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });

        var url = window.location;
        $("ul.navbar-nav a").filter(function() {
            return this.href == url;
        }).addClass("active");


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

    $(document).ready(function() {
        // $("#total_pendapatan").mask('000.000.000', {
        //     reverse: true
        // });
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


        $("#id_bbm").on("change", function() {
            var harga_perliter = $(this).find("option:selected").text();
            $("#liter_terjual").attr("readonly", false);
            $("#total_pendapatan").attr("readonly", false);
            console.log(harga_perliter);
            $('#liter_terjual').keyup((e) => {
                var text_liter = e.currentTarget.value;
                var jml_liter = text_liter.replace(/\,/g, "");
                var total = harga_perliter * jml_liter;

                console.log(total);

                $("#total").text(format(total));
                $("#total-rupiah").val(total);

                $('#total_pendapatan').keyup((e) => {
                    var text = e.currentTarget.value;
                    var membayar = text.replace(/\,/g, "");
                    var total = harga_perliter * jml_liter;
                    var kembalian = membayar - total;
                    $("#kembalian").text(format(kembalian));
                    if (membayar < total) {
                        var hutang = total - membayar;
                        $("#hasil").text("Kurang :");
                        $('#status').val("belum lunas");
                        $("#hutang").val(hutang);
                    } else {
                        $("#hasil").text("Kembalian :");
                        $('#status').val("lunas");
                        $("#hutang").val(0);
                    }
                });
            });
            var total_diklik = harga_perliter * $("#liter_terjual").val();
            $("#total").text(format(total_diklik));
            $("#total-rupiah").val(total_diklik);

            //atur kembalian
        });
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

        //Customer
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
    });
</script>

</body>

</html>