@extends('Templates.main')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Riwayat Pendaftaran</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tanggal Awal</label>
                        <input type="date" class="form-control" id="tanggalawal" aria-describedby="emailHelp"
                            value="{{ $date }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="tanggalakhir" aria-describedby="emailHelp"
                            value="{{ $date }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-success" style="margin-top:32px" onclick="caririwayat()"><i class="bi bi-search mr-2"></i>Cari
                        Riwayat</button>
                </div>
            </div>

            <div class="v_r_daftar mt-3">

            </div>
        </div>
    </section>
    <script>
        $(".preloader2").fadeOut();
        $(document).ready(function() {
            caririwayat()
        });

        function caririwayat() {
            awal = $('#tanggalawal').val()
            akhir = $('#tanggalakhir').val()
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    awal,
                    akhir
                },
                url: '<?= route('cari_riwayat_pendaftaran') ?>',
                error: function(response) {
                    spinner.hide()
                    alert('error')
                },
                success: function(response) {
                    spinner.hide()
                    $('.v_r_daftar').html(response);
                }
            });
        }
    </script>
@endsection
