@extends('Templates.main')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pendaftaran</h1>
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
            <div class="v_utama">
                <button class="btn btn-success" onclick="ambilformpasienbaru()"><i class="bi bi-eye mr-1"></i> Pasien
                    Baru</button>
                <button class="btn btn-primary" onclick="formpencarianpasien()"><i class="bi bi-eye mr-1"></i> Pencarian
                    Pasien</button>
                <button class="btn btn-warning" onclick="riwayatpendaftaran()"><i class="bi bi-eye mr-1"></i> Riwayat
                    Pendaftaran</button>
                <div class="v_pencarianpasien">
                    <div class="card mt-3">
                        <div class="card-header text-bold ">Pencarian Pasien</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nomor RM</label>
                                        <input type="email" class="form-control" id="norm"
                                            aria-describedby="emailHelp" placeholder="Masukan nomor rm ...">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nomor Identitas</label>
                                        <input type="email" class="form-control" id="noidentitas"
                                            aria-describedby="emailHelp" placeholder="Masukan nomor identitas ...">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nama Pasien</label>
                                        <input type="email" class="form-control" id="namapasien"
                                            aria-describedby="emailHelp" placeholder="Masukan nama pasien ...">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Alamat</label>
                                        <input type="email" class="form-control" id="alamat"
                                            aria-describedby="emailHelp" placeholder="Masukan alamat ...">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary" style="margin-top:32px" onclick="caripasien()"><i
                                            class="bi bi-search mr-2"></i>Cari Pasien</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-primary">Data Pasien</div>
                                        <div class="card-body">
                                            <div class="v_tabel_pasien">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div hidden class="v_form_pasien_baru">
                    <div class="card mt-3">
                        <div class="card-header text-bold bg-success">Form Pasien Baru</div>
                        <div class="card-body">
                            <form class="formpasienbaru">
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Nomor Identitas</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="nomoridentitas" name="nomoridentitas"
                                            placeholder="Masukan nomor identitas ktp/sim/dsb ...">

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Nama Pasien</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="namapasien" name="namapasien"
                                            placeholder="masukan nama pasien ...">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Tempat lahir</label>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" id="tempatlahir" name="tempatlahir"
                                            placeholder="masukan tempat lahir pasien ...">
                                    </div>
                                    <label for="inputPassword" class="col-sm-1 col-form-label text-right">Tanggal
                                        lahir</label>
                                    <div class="col-md-2">
                                        <input type="date" class="form-control" id="tgllahir" name="tgllahir">
                                    </div>
                                    <label for="inputPassword" class="col-sm-1 col-form-label text-right">Jenis
                                        Kelamin</label>
                                    <div class="col-md-2">
                                        <div class="form-check form-check-inline mt-2">
                                            <input class="form-check-input" type="radio" name="jeniskelamin"
                                                id="jeniskelamin" value="L" selected>
                                            <label class="form-check-label" for="inlineRadio1">Laki - Laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jeniskelamin"
                                                id="jeniskelamin" value="P">
                                            <label class="form-check-label" for="inlineRadio2">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Provinsi</label>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" id="provinsi" name="provinsi"
                                            placeholder="pilih provinsi ...">
                                        <input type="text" hidden class="form-control" id="idprovinsi"
                                            name="idprovinsi" placeholder="pilih desa ...">
                                    </div>
                                    <label for="inputPassword"
                                        class="col-sm-1 col-form-label text-right">Kabupaten</label>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" id="kabupaten" name="kabupaten"
                                            placeholder="pilih kabupaten ...">
                                        <input type="text" hidden class="form-control" id="idkabupaten"
                                            name="idkabupaten" placeholder="pilih desa ...">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Kecamatan</label>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" id="kecamatan" name="kecamatan"
                                            placeholder="pilih kecamatan ...">
                                        <input type="text" hidden class="form-control" id="idkecamatan"
                                            name="idkecamatan" placeholder="pilih desa ...">
                                    </div>
                                    <label for="inputPassword" class="col-sm-1 col-form-label text-right">Desa</label>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" id="desa" name="desa"
                                            placeholder="pilih desa ...">
                                        <input type="text" hidden class="form-control" id="iddesa" name="iddesa"
                                            placeholder="pilih desa ...">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Alamat</label>
                                    <div class="col-md-5">
                                        <textarea type="text" class="form-control" id="alamat" name="alamat"
                                            placeholder="masukan alamat pasien cth : RT 002 RW 006 JL. MERDEKA BLOK 1"></textarea>
                                    </div>
                                </div>
                        </div>
                        </form>
                        <div class="card-footer">
                            <button class="btn btn-success float-right" onclick="simpanpasienbaru()"><i
                                    class="bi bi-save mr-1"></i>Simpan</button>
                        </div>
                    </div>
                </div>
                <div hidden class="v_riwayat_pendaftaran">
                    <div class="card mt-3">
                        <div class="card-header text-bold bg-warning">Riwayat Pendafaran</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tanggal Riwayat</label>
                                        <input type="date" class="form-control" id="tanggalriwayat"
                                            aria-describedby="emailHelp" value="{{ $date }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-success" style="margin-top:32px" onclick="caririwayat()"><i
                                            class="bi bi-search mr-2"></i>Cari
                                        Riwayat</button>
                                </div>
                            </div>
                            <div class="v_r_daftar">

                            </div>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
            </div>
            <div hidden class="v_kedua">

            </div>
        </div>
    </section>
    <script>
        $(".preloader2").fadeOut();
        function ambilformpasienbaru() {
            $('.v_pencarianpasien').attr('hidden', true)
            $('.v_form_pasien_baru').removeAttr('hidden', true)
            $('.v_riwayat_pendaftaran').attr('hidden', true)
        }

        function formpencarianpasien() {
            $('.v_pencarianpasien').removeAttr('hidden', true)
            $('.v_form_pasien_baru').attr('hidden', true)
            $('.v_riwayat_pendaftaran').attr('hidden', true)
        }

        function riwayatpendaftaran() {
            $('.v_riwayat_pendaftaran').removeAttr('hidden', true)
            $('.v_pencarianpasien').attr('hidden', true)
            $('.v_form_pasien_baru').attr('hidden', true)
        }

        $(document).ready(function() {
            caripasien()
            caririwayat()
            $('#provinsi').autocomplete({
                source: "<?= route('cariprovinsi') ?>",
                select: function(event, ui) {
                    $('[id="provinsi"]').val(ui.item.label);
                    $('[id="idprovinsi"]').val(ui.item.kode);
                }
            });
            $('#kabupaten').autocomplete({
                source: "<?= route('carikabupaten') ?>",
                select: function(event, ui) {
                    $('[id="kabupaten"]').val(ui.item.label);
                    $('[id="idkabupaten"]').val(ui.item.kode);
                }
            });
            $('#kecamatan').autocomplete({
                source: "<?= route('carikecamatan') ?>",
                select: function(event, ui) {
                    $('[id="kecamatan"]').val(ui.item.label);
                    $('[id="idkecamatan"]').val(ui.item.kode);
                }
            });
            $('#desa').autocomplete({
                source: function(request, response) {
                    $.getJSON("<?= route('caridesa') ?>", {
                            id: $('#idkecamatan').val(),
                            desa: $('#desa').val(),
                        },
                        response);
                },
                select: function(event, ui) {
                    $('[id="desa"]').val(ui.item.label);
                    $('[id="iddesa"]').val(ui.item.kode);
                }
            });
        });


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
                url: '<?= route('cari_data_pasien') ?>',
                error: function(response) {
                    spinner.hide()
                    alert('error')
                },
                success: function(response) {
                    spinner.hide()
                    $('.v_tabel_pasien').html(response);
                }
            });
        }

        function simpanpasienbaru() {
            spinner = $('#loader')
            spinner.show();
            var data = $('.formpasienbaru').serializeArray();
            $.ajax({
                async: true,
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    data: JSON.stringify(data),
                },
                url: '<?= route('simpanpasienbaru') ?>',
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
                        formpencarianpasien()
                        $('#norm').val(data.rm)
                        caripasien()
                        $('.v_form_pasien_baru').find('input:text').val('');
                    }
                }
            });
        }

        function caririwayat() {
            tanggalriwayat = $('#tanggalriwayat').val()
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    tanggalriwayat
                },
                url: '<?= route('cari_riwayat_pendaftaran_today') ?>',
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
