@extends('Templates.main')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Pasien Kasir</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Pasien Kasir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="v_utama">
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
                        <button class="btn btn-success" style="margin-top:32px" onclick="caridata()"><i class="bi bi-search mr-2"></i>Cari
                            Resep</button>
                    </div>
                </div>

                <div class="v_data_pasien mt-3">

                </div>
            </div>
            <div hidden class="v_kedua"></div>
            <div hidden class="v_ketiga"></div>
        </div>
    </section>
    <script>
        $(".preloader2").fadeOut();
        $(document).ready(function() {
            caridata()
        })
        function caridata()
        {
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
                url: '<?= route('caridatapasienkasir') ?>',
                error: function(response) {
                    spinner.hide()
                    alert('error')
                },
                success: function(response) {
                    spinner.hide()
                    $('.v_data_pasien').html(response);
                }
            });
        }
    </script>
@endsection
