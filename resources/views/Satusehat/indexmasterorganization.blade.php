@extends('Templates.main')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Master Organization</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Master Organization</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <button class="btn btn-info" data-toggle="modal" data-target="#modaladdukp"><i
                    class="bi bi-plus-lg mr-1 ml-1"></i> UKP,KEFARMASIAN,LABORATORIUM</button>
            <div class="v_tabel_ukp mt-4">
                <div class="card">
                    <div class="card-header">DATA UKP, KEFARMASIAN DAN LABORATORIUM</div>
                    <div class="card-body">
                        <div class="v2_tabel_ukp"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="modaladdukp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">INPUT DATA UKP, KEFARMASIAN DAN LABORATORIUM</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="formaddukp">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Organization</label>
                            <input type="email" class="form-control" id="namaorg" name="namaorg"
                                aria-describedby="emailHelp" placeholder="Masukan Nama UKP, FARMASI, LABORATORIUM ...">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Display Organization</label>
                            <input type="email" class="form-control" id="displayorg" name="displayorg"
                                aria-describedby="emailHelp" placeholder="Nama Display UKP, FARMASI, LABORATORIUM ...">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">No telp</label>
                            <input type="email" class="form-control" id="notelporg" name="notelporg"
                                aria-describedby="emailHelp" placeholder="Nomor telepon ...">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                aria-describedby="emailHelp" placeholder="Email ...">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Website</label>
                            <input type="email" class="form-control" id="website" name="website"
                                aria-describedby="emailHelp" placeholder="Website ...">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Kota</label>
                            <input type="email" class="form-control" id="kota" name="kota"
                                aria-describedby="emailHelp" placeholder="Masukan nama kota ...">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Kode Pos</label>
                            <input type="email" class="form-control" id="kodepos" name="kodepos"
                                aria-describedby="emailHelp" placeholder="Masukan kode pos ...">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Provinsi</label>
                            <input type="email" class="form-control" id="provinsiukp" name="provinsiukp"
                                aria-describedby="emailHelp" placeholder="Pilih Provinsi ...">
                            <input readonly type="email" class="form-control" id="kodeprovinsiukp"
                                name="kodeprovinsiukp" aria-describedby="emailHelp" placeholder="Pilih Provinsi ...">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Kabupaten/Kota</label>
                            <input type="email" class="form-control" id="kabupatenukp" name="kabupatenukp"
                                aria-describedby="emailHelp" placeholder="Pilih Kabupaten / Kota">
                            <input readonly type="email" class="form-control" id="kodekabupatenukp"
                                name="kodekabupatenukp" aria-describedby="emailHelp"
                                placeholder="Pilih Kabupaten / Kota">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Kecamatan</label>
                            <input type="email" class="form-control" id="kecamatanukp" name="kecamatanukp"
                                aria-describedby="emailHelp" placeholder="Pilih Kecamatan ...">
                            <input readonly type="email" class="form-control" id="kodekecamatanukp"
                                name="kodekecamatanukp" aria-describedby="emailHelp" placeholder="Pilih Kecamatan ...">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Desa</label>
                            <input type="email" class="form-control" id="desaukp" name="desaukp"
                                aria-describedby="emailHelp" placeholder="Pilih Desa ...">
                            <input readonly type="email" class="form-control" id="kodedesaukp" name="kodedesaukp"
                                aria-describedby="emailHelp" placeholder="Pilih Desa ...">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Alamat</label>
                            <textarea type="email" class="form-control" id="alamat" name="alamat" aria-describedby="emailHelp"
                                placeholder="Masukan Alamat ...."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="simpanukp()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(".preloader2").fadeOut();
        $(document).ready(function() {
            $('#provinsiukp').autocomplete({
                source: "<?= route('cariprovinsi') ?>",
                select: function(event, ui) {
                    $('[id="provinsiukp"]').val(ui.item.label);
                    $('[id="kodeprovinsiukp"]').val(ui.item.id);
                }
            });
            $('#kabupatenukp').autocomplete({
                source: function(request, response) {
                    $.getJSON("<?= route('carikabupaten') ?>", {
                            id: $('#kodeprovinsiukp').val(),
                            kabupaten: $('#kabupatenukp').val(),
                        },
                        response);
                },
                select: function(event, ui) {
                    $('[id="kabupatenukp"]').val(ui.item.label);
                    $('[id="kodekabupatenukp"]').val(ui.item.id);
                }
            });
            $('#kecamatanukp').autocomplete({
                source: function(request, response) {
                    $.getJSON("<?= route('carikecamatan') ?>", {
                            id: $('#kodekabupatenukp').val(),
                            kecamatan: $('#kecamatanukp').val(),
                        },
                        response);
                },
                select: function(event, ui) {
                    $('[id="kecamatanukp"]').val(ui.item.label);
                    $('[id="kodekecamatanukp"]').val(ui.item.id);
                }
            });
            $('#desaukp').autocomplete({
                source: function(request, response) {
                    $.getJSON("<?= route('caridesa') ?>", {
                            id: $('#kodekecamatanukp').val(),
                            desa: $('#desaukp').val(),
                        },
                        response);
                },
                select: function(event, ui) {
                    $('[id="desaukp"]').val(ui.item.label);
                    $('[id="kodedesaukp"]').val(ui.item.id);
                }
            });
        });

        function simpanukp() {
            spinner = $('#loader')
            spinner.show();
            var data = $('.formaddukp').serializeArray();
            $.ajax({
                async: true,
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    data: JSON.stringify(data),
                },
                url: '<?= route('simpandataukp') ?>',
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
                    if (data.kode == 500) {
                        spinner.hide()
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
                        setTimeout(function() {
                            spinner.hide()
                            location.reload()
                        }, 4000);
                    }
                }
            });
        }
    </script>
@endsection
