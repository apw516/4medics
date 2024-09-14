@extends('Templates.main')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Master Barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Master barang</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="form-inline">
                <div class="form-group mx-sm-3 mb-2">
                    <label for="inputPassword2" class="sr-only">Nama barang</label>
                    <input type="text" class="form-control" id="namabarang" placeholder="Masukan nama barang ...">
                </div>
                <button type="submit" class="btn btn-primary mb-2" onclick="ambilmasterbarang()"><i
                        class="bi bi-search ml-1 mr-1"></i> Cari Barang</button>
                <button type="button" class="btn btn-success mb-2 mr-1 ml-1" onclick="ambilformmasterbarang()"
                    data-toggle="modal" data-target="#modaladdmasterbarang"><i class="bi bi-folder-plus"></i> Add Master
                    Barang</button>
            </div>
            <div class="v_master_barang">

            </div>
        </div><!--/. container-fluid -->
    </section>

    <!-- Modal -->
    <div class="modal fade" id="modaladdmasterbarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Master Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="v_form_add_master_barang">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="simpanmasterbarang()" data-dismiss="modal">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(".preloader2").fadeOut();
        $(document).ready(function() {
            ambilmasterbarang()
        })

        function ambilmasterbarang() {
            nama = $('#namabarang').val()
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    nama
                },
                url: '<?= route('ambilmasterbarang') ?>',
                error: function(response) {
                    spinner.hide()
                    alert('error')
                },
                success: function(response) {
                    spinner.hide()
                    $('.v_master_barang').html(response);
                }
            });
        }

        function ambilformmasterbarang() {
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                url: '<?= route('ambilformmasterbarang') ?>',
                error: function(response) {
                    spinner.hide()
                    alert('error')
                },
                success: function(response) {
                    spinner.hide()
                    $('.v_form_add_master_barang').html(response);
                }
            });
        }

        function simpanmasterbarang() {
            spinner = $('#loader')
            spinner.show();
            var data = $('.formaddtambahmasterbarang').serializeArray();
            $.ajax({
                async: true,
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    data: JSON.stringify(data),
                },
                url: '<?= route('simpanmasterbarang') ?>',
                error: function(data) {
                    spinner.hide()
                    Swal.fire({
                        icon: 'error',
                        title: 'Ooops....',
                        text: 'Sepertinya ada masalah......',
                        footer: ''
                    })
                },
                success: function(data) {
                    spinner.hide()
                    if (data.kode == 500) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oopss...',
                            text: data.message,
                            footer: ''
                        })
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'OK',
                            text: data.message,
                            footer: ''
                        })
                        ambilmasterbarang()
                    }
                }
            });
        }
    </script>
@endsection
