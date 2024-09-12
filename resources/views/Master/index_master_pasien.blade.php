@extends('Templates.main')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Master Pasien</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Master Pasien</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card mt-3">
                <div class="card-header">Data Master Pasien</div>
                <div class="card-body">
                    <div class="v_utama">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nomor RM</label>
                                    <input type="email" class="form-control" id="norm" aria-describedby="emailHelp"
                                        placeholder="Masukan nomor rm ...">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nomor Identitas</label>
                                    <input type="email" class="form-control" id="noidentitas" aria-describedby="emailHelp"
                                        placeholder="Masukan nomor identitas ...">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Pasien</label>
                                    <input type="email" class="form-control" id="namapasien" aria-describedby="emailHelp"
                                        placeholder="Masukan nama pasien ...">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Alamat</label>
                                    <input type="email" class="form-control" id="alamat" aria-describedby="emailHelp"
                                        placeholder="Masukan alamat ...">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" style="margin-top:32px" onclick="caripasien()"><i
                                        class="bi bi-search mr-2"></i>Cari Pasien</button>
                            </div>
                        </div>
                        <div class="v_tb_pasien">

                        </div>
                    </div>
                    <div class="v_kedua" hidden></div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(".preloader2").fadeOut();
        $(document).ready(function() {
            caripasien()
        })

        function caripasien() {
            rm = $('#norm').val()
            id = $('#noidentitas').val()
            nama = $('#namapasien').val()
            alamat = $('#alamat').val()
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    rm,
                    id,
                    nama,
                    alamat
                },
                url: '<?= route('ambil_master_pasien') ?>',
                error: function(response) {
                    spinner.hide()
                    alert('error')
                },
                success: function(response) {
                    spinner.hide()
                    $('.v_tb_pasien').html(response);
                }
            });
        }
    </script>
@endsection
