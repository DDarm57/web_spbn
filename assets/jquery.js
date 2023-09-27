$(function(){
    //jquery edit
    $(document).on("click", ".hapus", function(e){
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

    $(document).on("click", "#tambah-karyawan", function(e){
        e.preventDefault();
        $("#btn-simpan").attr("name", "simpan_karyawan");
        $(".modal-body input").val("");
        $(".modal-body input[type=radio]").prop("checked", false);
    })    

    $(document).on("click", ".edit-karyawan", function(e){
        e.preventDefault();
        $(".modal-body #id_user").val($(this).data("id_user"));
        $(".modal-body #nama").val($(this).data("nama"));
        if($(this).data("jk") == "L"){
            $(".modal-body #exampleRadios1").prop("checked", true);
        }else if($(this).data("jk") == "P"){
            $(".modal-body #exampleRadios2").prop("checked", true);
        }
        $(".modal-body #alamat").val($(this).data("alamat"));
        $(".modal-body #no_hp").val($(this).data("no_hp"));
        $(".modal-body #username").val($(this).data("username"));
        $(".modal-body #password").val($(this).data("password"));
        $("#btn-simpan").attr("name", "update_karyawan");
    })

    $(document).on("click", "#tambah-customer", function(e){
        e.preventDefault();
        $("#btn-simpan").attr("name", "simpan_customer");
        $(".modal-body input").val("");
        $(".modal-body input[type=radio]").prop("checked", false);
    })    
    $(document).on("click", ".edit-customer", function(e){
        e.preventDefault();
        console.log("test");
        $(".modal-body #id_customer").val($(this).data("id_customer"));
        $(".modal-body #nama").val($(this).data("nama"));
        if($(this).data("jk") == "L"){
            $(".modal-body #exampleRadios1").prop("checked", true);
        }else if($(this).data("jk") == "P"){
            $(".modal-body #exampleRadios2").prop("checked", true);
        }
        $(".modal-body #alamat").val($(this).data("alamat"));
        $(".modal-body #no_hp").val($(this).data("no_hp"));
        $("#btn-simpan").attr("name", "update_customer");
    })
})