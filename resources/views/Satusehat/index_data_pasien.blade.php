@extends('Templates.main')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Pasien</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Pasien</li>
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
                <div class="card-header">Data Pasien</div>
                <div class="card-body">
                    <div class="v_utama">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tanggal Awal</label>
                                    <input type="date" class="form-control" id="tglawal" aria-describedby="emailHelp"
                                        placeholder="Masukan nomor rm ...">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tanggal Akhir</label>
                                    <input type="date" class="form-control" id="tglakhir" aria-describedby="emailHelp"
                                        placeholder="Masukan nomor identitas ...">
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
            tglawal = $('#tglawal').val()
            tglakhir = $('#tglakhir').val()
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    tglawal,
                    tglakhir
                },
                url: '<?= route('ambil_data_pasien_ihs') ?>',
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
