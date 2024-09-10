<style>
    div.ex3 {
        height: 530px;
        width: 100%;
        overflow-y: auto;
    }

    div.ex1 {
        height: 850px;
        width: 100%;
        overflow-y: auto;
    }
</style>
<button class="btn btn-danger" onclick="kembali()">
    <i class="bi bi-backspace-fill mr-2"></i> Batal</button>
<div class="row">
    <div class="col-md-12">
        <div class="card mt-3 shadow-lg">
            <div class="card-header bg-light text-bold"><i class="bi bi-info-circle mr-2"></i>Info Pasien</div>
            <div class="card-body ">
                <div class="row">
                    <div class="col-12">
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->
                            <div class="row">
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    Nomor RM : {{ $mt_pasien[0]->no_rm }}
                                    <address>
                                        <strong>{{ $mt_pasien[0]->nama_px }}</strong><br>
                                        {{ strtoupper($mt_pasien[0]->tempat_lahir) }} ,
                                        {{ $mt_pasien[0]->tgl_lahir2 }}<br>
                                        Jenis Kelamin : @if ($mt_pasien[0]->jenis_kelamin == 'L')
                                            Laki Laki
                                        @else
                                            Perempuan
                                        @endif
                                        <br>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <address>
                                        <strong>Alamat</strong><br>
                                        {{ $mt_pasien[0]->alamat2 }}<br>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <br>
                                    <b>Nomor Identitas:</b> {{ $mt_pasien[0]->nik_bpjs }}<br>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <div class="accordion" id="accordionExample">
                                        <div class="card">
                                            <div class="card-header bg-info" id="headingOne">
                                                <h2 class="mb-0">
                                                    <button
                                                        class="btn btn-link btn-block text-left text-light text-bold"
                                                        type="button" data-toggle="collapse" data-target="#collapseOne"
                                                        aria-expanded="true" aria-controls="collapseOne">
                                                        <i class="bi bi-card-checklist mr-2"></i> Catatan Perkembangan
                                                        Pasien Terintegrasi
                                                    </button>
                                                </h2>
                                            </div>

                                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                                data-parent="#accordionExample">
                                                <div class="card-body ex3">
                                                    <div class="v_riwayat_pemeriksaan">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-success text-bold"><i
                                                class="bi bi-ui-radios mr-2"></i> Form Pemeriksaan</div>
                                        <div class="card-body">
                                            <form action="" class="formpemeriksaan">
                                                <input hidden type="text" name="counter" id="counter"
                                                    value="{{ $kunjungan[0]->counter }}">
                                                <input hidden type="text" name="kodekunjungan" id="kodekunjungan"
                                                    value="{{ $kunjungan[0]->kode_kunjungan }}">
                                                <input hidden type="text" name="norm" id="norm"
                                                    value="{{ $mt_pasien[0]->no_rm }}">
                                                <input hidden type="text" name="kode_unit" id="kode_unit"
                                                    value="{{ $kunjungan[0]->kode_unit }}">
                                                <input hidden type="text" name="tglmasuk" id="tglmasuk"
                                                    value="{{ $kunjungan[0]->tgl_masuk }}">
                                                <table class="table table-sm table-striped text-sm">
                                                    <tr>
                                                        <td colspan="2" class="text-center text-bold bg-secondary">
                                                            Tanda
                                                            - Tanda Vital
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-group row mt-4">
                                                                <label for="inputPassword"
                                                                    class="col-sm-2 col-form-label">Tekanan
                                                                    Darah</label>
                                                                <div class="col-sm-5">
                                                                    <div class="input-group mb-3">
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Masukan tekanan darah pasien ..."
                                                                            aria-label="Recipient's username"
                                                                            aria-describedby="basic-addon2"
                                                                            name="tekanandarah" id="tekanandarah"
                                                                            value="@if (count($cekassesmen) > 0) {{ $cekassesmen[0]->tekanan_darah }} @endif">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text"
                                                                                id="basic-addon2">mm Hg </span>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group row mt-4">
                                                                <label for="inputPassword"
                                                                    class="col-sm-2 col-form-label">Suhu Tubuh</label>
                                                                <div class="col-sm-5">
                                                                    <div class="input-group mb-3">
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Masukan suhu tubuh pasien ..."
                                                                            aria-label="Recipient's username"
                                                                            aria-describedby="basic-addon2"
                                                                            name="suhutubuh" id="suhutubuh"
                                                                            value="@if (count($cekassesmen) > 0) {{ $cekassesmen[0]->suhu_tubuh }} @endif">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text"
                                                                                id="basic-addon2">°C</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-bold" colspan="2">
                                                            <div class="form-group row">
                                                                <label for="inputPassword"
                                                                    class="col-sm-2 col-form-label">Subject ( S
                                                                    )</label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control" name="subject" id="subject" rows="3" placeholder="Subject Pemeriksaan ...">
@if (count($cekassesmen) > 0)
{{ $cekassesmen[0]->subject }}
@endif
</textarea>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-bold" colspan="2">
                                                            <div class="form-group row">
                                                                <label for="inputPassword"
                                                                    class="col-sm-2 col-form-label">Object ( O
                                                                    )</label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control" name="object" id="object" rows="3" placeholder="Object Pemeriksaan ...">
@if (count($cekassesmen) > 0)
{{ $cekassesmen[0]->object }}
@endif
</textarea>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-bold" colspan="2">
                                                            <div class="form-group row">
                                                                <label for="inputPassword"
                                                                    class="col-sm-2 col-form-label">Assesment ( A
                                                                    )</label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control" name="assesment" id="assesment" rows="3"
                                                                        placeholder="Assesment Pemeriksaan ...">
@if (count($cekassesmen) > 0)
{{ $cekassesmen[0]->assesment }}
@endif
</textarea>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-bold" colspan="2">
                                                            <div class="form-group row">
                                                                <label for="inputPassword"
                                                                    class="col-sm-2 col-form-label">Planning ( P
                                                                    )</label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control" name="planning" id="planning" rows="3"
                                                                        placeholder="Planning Pemeriksaan ...">
@if (count($cekassesmen) > 0)
{{ $cekassesmen[0]->planning }}
@endif
</textarea>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
                                            <div class="card">
                                                <div class="card-header bg-secondary">Order Farmasi</div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-inline">
                                                                <div class="form-group mx-sm-3 mb-2">
                                                                    <label for="inputPassword2"
                                                                        class="sr-only">Password</label>
                                                                    <input type="text" class="form-control"
                                                                        id="namaobat" placeholder="cari obat ...">
                                                                </div>
                                                                <button type="submit" class="btn btn-primary mb-2"
                                                                    onclick="cariobat()"><i
                                                                        class="bi bi-search mr-1 ml-1"></i> Cari
                                                                    Obat</button>
                                                            </div>
                                                            <div class="v_tabel_stok_obat">

                                                            </div>

                                                        </div>
                                                        <div class="col-md-7">
                                                            <div class="card">
                                                                <div class="card-header bg-warning">Obat yang dipilih
                                                                </div>
                                                                <div class="card-body">
                                                                    <form action="" method="post"
                                                                        class="form_layanan">
                                                                        <div class="input_layanan">
                                                                            <div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                <div class="card-footer">
                                                                    <button class="btn btn-info" data-toggle="modal"
                                                                        data-target="#modalriwayatobat" onclick="tampilriwayatobat()"><i
                                                                            class="bi bi-list-check mr-1 ml-1"></i>
                                                                        Riwayat Obat hari ini</button>
                                                                    <button class="btn btn-info" data-toggle="modal"
                                                                        data-target="#modalriwayatresep" onclick="tampilriwayatresep()"><i
                                                                            class="bi bi-list-check mr-1 ml-1"></i>
                                                                        Riwayat Resep Pasien</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->

                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-12">
                                    <button type="button" class="btn btn-success float-right"
                                        onclick="simpanpemeriksaan()"><i class="far fa-credit-card"></i> Simpan
                                    </button>
                                    <button type="button" class="btn btn-danger float-right"
                                        style="margin-right: 5px;" onclick="kembali()">
                                        <i class="bi bi-backspace-fill"></i> Batal
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalriwayatobat" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Riwayat obat hari ini ...</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="v_r_obat">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalriwayatresep" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Riwayat resep pasien ...</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="v_r_resep">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<input hidden type="text" value="{{ $rm }}" id="no_rm">
<script>
    $(document).ready(function() {
        riwayatpemeriksaan()
        cariobat()
    });

    function kembali() {
        $(".v_kedua").attr('hidden', true);
        $(".v_utama").removeAttr('hidden', true);
    }

    function simpanpemeriksaan() {
        spinner = $('#loader')
        spinner.show();
        var data = $('.formpemeriksaan').serializeArray();
        var data2 = $('.form_layanan').serializeArray();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                data: JSON.stringify(data),
                data2: JSON.stringify(data2),
            },
            url: '<?= route('simpanpemeriksaan') ?>',
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
                    riwayatpemeriksaan()
                    reload()
                }
            }
        });
    }

    function reload() {
        $(".v_kedua").removeAttr('hidden', true);
        $(".v_utama").attr('hidden', true);
        kode_kunjungan = $('#kodekunjungan').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                kode_kunjungan
            },
            url: '<?= route('ambil_data_pasien_erm') ?>',
            success: function(response) {
                $('.v_kedua').html(response);
                spinner.hide();
            }
        });
    }

    function riwayatpemeriksaan() {
        rm = $('#no_rm').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                rm
            },
            url: '<?= route('ambil_riwayat_pemeriksaan') ?>',
            error: function(response) {
                spinner.hide()
                alert('error')
            },
            success: function(response) {
                spinner.hide()
                $('.v_riwayat_pemeriksaan').html(response);
            }
        });
    }
    function tampilriwayatobat() {
        kode_kunjungan = $('#kodekunjungan').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                kode_kunjungan
            },
            url: '<?= route('ambil_riwayat_obat') ?>',
            error: function(response) {
                spinner.hide()
                alert('error')
            },
            success: function(response) {
                spinner.hide()
                $('.v_r_obat').html(response);
            }
        });
    }
    function tampilriwayatresep() {
        kode_kunjungan = $('#kodekunjungan').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                kode_kunjungan
            },
            url: '<?= route('ambil_riwayat_resep') ?>',
            error: function(response) {
                spinner.hide()
                alert('error')
            },
            success: function(response) {
                spinner.hide()
                $('.v_r_resep').html(response);
            }
        });
    }

    function cariobat() {
        namaobat = $('#namaobat').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                namaobat
            },
            url: '<?= route('cari_obat_erm') ?>',
            error: function(response) {
                spinner.hide()
                alert('error')
            },
            success: function(response) {
                spinner.hide()
                $('.v_tabel_stok_obat').html(response);
            }
        });
    }
