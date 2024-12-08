@extends('Templates.main')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Master Lokasi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Master Lokasi</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">Get Master Kabupaten</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Pilih Provinsi</label>
                                <input type="email" class="form-control" id="namaprovinsi1" name="namaprovinsi1"
                                    aria-describedby="emailHelp">
                                <input type="email" class="form-control" id="kodeprovinsi1" name="kodeprovinsi1"
                                    aria-describedby="emailHelp">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success" style="margin-top:32px"><i class="bi bi-search mr-1 ml-1"></i>Get Kabupaten</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Get Master Kecamatan</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Pilih Provinsi</label>
                                <input type="email" class="form-control" id="namaprovinsi2" name="namaprovinsi2"
                                    aria-describedby="emailHelp">
                                <input type="email" class="form-control" id="kodeprovinsi2" name="kodeprovinsi2"
                                    aria-describedby="emailHelp">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Pilih Kabupaten</label>
                                <input type="email" class="form-control" id="namakabupaten1" name="namakabupaten1"
                                    aria-describedby="emailHelp">
                                <input type="email" class="form-control" id="kodekabupaten1" name="kodekabupaten1"
                                    aria-describedby="emailHelp">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success" style="margin-top:32px"><i class="bi bi-search mr-1 ml-1"></i>Get Kecamatan</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Get Master Desa</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Pilih Provinsi</label>
                                <input type="email" class="form-control" id="namaprovinsi3" name="namaprovinsi3"
                                    aria-describedby="emailHelp">
                                <input type="email" class="form-control" id="kodeprovinsi3" name="kodeprovinsi3"
                                    aria-describedby="emailHelp">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Pilih Kabupaten</label>
                                <input type="email" class="form-control" id="namakabupaten2" name="namakabupaten2"
                                    aria-describedby="emailHelp">
                                <input type="email" class="form-control" id="kodekabupaten2" name="kodekabupaten2"
                                    aria-describedby="emailHelp">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Pilih Kecamatan</label>
                                <input type="email" class="form-control" id="namakecamatan1" name="namakecamatan1"
                                    aria-describedby="emailHelp">
                                <input type="email" class="form-control" id="kodekecamatan1" name="kodekecamatan1"
                                    aria-describedby="emailHelp">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success" style="margin-top:32px" onclick="getmasterdesa()"><i class="bi bi-search mr-1 ml-1"></i>Get Desa</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(".preloader2").fadeOut();
        $(document).ready(function() {
            $('#namaprovinsi1').autocomplete({
                source: "<?= route('cariprovinsi') ?>",
                select: function(event, ui) {
                    $('[id="namaprovinsi1"]').val(ui.item.label);
                    $('[id="kodeprovinsi1"]').val(ui.item.kode);
                }
            });
            $('#namaprovinsi2').autocomplete({
                source: "<?= route('cariprovinsi') ?>",
                select: function(event, ui) {
                    $('[id="namaprovinsi2"]').val(ui.item.label);
                    $('[id="kodeprovinsi2"]').val(ui.item.kode);
                }
            });
            $('#namaprovinsi3').autocomplete({
                source: "<?= route('cariprovinsi') ?>",
                select: function(event, ui) {
                    $('[id="namaprovinsi3"]').val(ui.item.label);
                    $('[id="kodeprovinsi3"]').val(ui.item.kode);
                }
            });
            $('#namakabupaten1').autocomplete({
                source: function(request, response) {
                    $.getJSON("<?= route('carikabupaten_byprov') ?>", {
                            namakabupaten: $('#namakabupaten1').val(),
                            kodeprovinsi2: $('#kodeprovinsi2').val(),
                        },
                        response);
                },
                select: function(event, ui) {
                    $('[id="namakabupaten1"]').val(ui.item.label);
                    $('[id="kodekabupaten1"]').val(ui.item.kode);
                }
            });
            $('#namakabupaten2').autocomplete({
                source: function(request, response) {
                    $.getJSON("<?= route('carikabupaten_byprov') ?>", {
                            namakabupaten: $('#namakabupaten2').val(),
                            kodeprovinsi2: $('#kodeprovinsi2').val(),
                        },
                        response);
                },
                select: function(event, ui) {
                    $('[id="namakabupaten2"]').val(ui.item.label);
                    $('[id="kodekabupaten2"]').val(ui.item.kode);
                }
            });
            $('#namakecamatan1').autocomplete({
                source: function(request, response) {
                    $.getJSON("<?= route('carikecamatan_bykab') ?>", {
                            namakecamatan: $('#namakecamatan1').val(),
                            kodekabupaten2: $('#kodekabupaten2').val(),
                        },
                        response);
                },
                select: function(event, ui) {
                    $('[id="namakecamatan1"]').val(ui.item.label);
                    $('[id="kodekecamatan1"]').val(ui.item.kode);
                }
            });
        })
        function getmasterdesa(){
            $kecamatan = $('#kodekecamatan1').val()
            $.ajax({
                async: true,
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    kecamatan
                },
                url: '<?= route('getmasterdesa') ?>',
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
                        location.reload()
                    }
                }
            });
        }
    </script>
@endsection
