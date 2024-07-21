<button class="btn btn-danger" onclick="kembali()"><i class="bi bi-backspace-fill mr-2"></i> Batal</button>
<div class="card mt-3">
    <div class="card-header text-bold bg-warning">Form Edit Data Pasien</div>
    <div class="card-body">
        <form class="formeditpasien">
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Nomor RM</label>
                <div class="col-sm-5">
                    <input readonly type="text" class="form-control" id="nomorrm" name="nomorrm" value="{{ $pasien[0]->no_rm}}"
                        placeholder="Masukan nomor identitas ktp/sim/dsb ...">

                </div>
            </div>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Nomor Identitas</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="nomoridentitas" name="nomoridentitas"
                        placeholder="Masukan nomor identitas ktp/sim/dsb ..." value="{{ $pasien[0]->nik_bpjs}}">

                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Nama Pasien</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="namapasien" name="namapasien"  value="{{ $pasien[0]->nama_px}}"
                        placeholder="masukan nama pasien ...">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Tempat lahir</label>
                <div class="col-md-2">
                    <input type="text" class="form-control" id="tempatlahir" name="tempatlahir"
                        placeholder="masukan tempat lahir pasien ..."  value="{{ strtoupper($pasien[0]->tempat_lahir)}}">
                </div>
                <label for="inputPassword" class="col-sm-1 col-form-label text-right">Tanggal
                    lahir</label>
                <div class="col-md-2">
                    <input type="date" class="form-control" id="tgllahir" name="tgllahir"  value="{{ $pasien[0]->tgl_lahir }}">
                </div>
                <label for="inputPassword" class="col-sm-1 col-form-label text-right">Jenis
                    Kelamin</label>
                <div class="col-md-2">
                    <div class="form-check form-check-inline mt-2">
                        <input class="form-check-input" type="radio" name="jeniskelamin"
                            id="jeniskelamin" value="L" @if($pasien[0]->jenis_kelamin == 'L') checked @endif>
                        <label class="form-check-label" for="inlineRadio1">Laki - Laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jeniskelamin"
                            id="jeniskelamin" value="P" @if($pasien[0]->jenis_kelamin == 'P') checked @endif>
                        <label class="form-check-label" for="inlineRadio2">Perempuan</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Provinsi</label>
                <div class="col-md-2">
                    <input type="text" class="form-control" id="provinsi2" name="provinsi2"
                        placeholder="pilih provinsi ..." value="@foreach ($provinsi as $p ) {{ $p->name }}@endforeach">
                    <input readonly type="text" class="form-control" id="idprovinsi2"
                        name="idprovinsi2" placeholder="pilih desa ..." value="@foreach ($provinsi as $p ) {{ $p->id }}@endforeach">
                </div>
                <label for="inputPassword"
                    class="col-sm-1 col-form-label text-right">Kabupaten</label>
                <div class="col-md-2">
                    <input type="text" class="form-control" id="kabupaten2" name="kabupaten2"
                        placeholder="pilih kabupaten ..." value="@foreach ($kabupaten as $kab ) {{ $kab->name }}@endforeach">
                    <input readonly type="text"  class="form-control" id="idkabupaten2"
                        name="idkabupaten2" placeholder="pilih desa ..."  value="@foreach ($kabupaten as $kab ) {{ $kab->id }}@endforeach">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Kecamatan</label>
                <div class="col-md-2">
                    <input type="text" class="form-control" id="kecamatan2" name="kecamatan2"
                        placeholder="pilih kecamatan ..." value="@foreach ($kecamatan as $kec ) {{ $kec->name }}@endforeach">
                    <input readonly type="text"  class="form-control" id="idkecamatan2"
                        name="idkecamatan2" placeholder="pilih desa ..." value="@foreach ($kecamatan as $kec ) {{ $kec->id }}@endforeach">
                </div>
                <label for="inputPassword" class="col-sm-1 col-form-label text-right">Desa</label>
                <div class="col-md-2">
                    <input type="text" class="form-control" id="desa2" name="desa2"
                        placeholder="pilih desa ..." value="@foreach ($desa as $des ) {{ $des->name }}@endforeach">
                    <input readonly type="text"  class="form-control" id="iddesa2" name="iddesa2"
                        placeholder="pilih desa ..." value="@foreach ($desa as $des ) {{ $des->id }}@endforeach">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-md-5">
                    <textarea type="text" class="form-control" id="alamat" name="alamat"
                        placeholder="masukan alamat pasien cth : RT 002 RW 006 JL. MERDEKA BLOK 1">{{ $pasien[0]->alamat}}</textarea>
                </div>
            </div>
    </div>
    </form>
    <div class="card-footer">
        <button class="btn btn-success float-right" onclick="simpaneditpasien()"><i
                class="bi bi-save mr-1"></i>Simpan</button>
    </div>
</div>
<script>
    function kembali() {
        $(".v_kedua").attr('hidden', true);
        $(".v_utama").removeAttr('hidden', true);
    }

    $(document).ready(function() {
            $('#provinsi2').autocomplete({
                source: "<?= route('cariprovinsi') ?>",
                select: function(event, ui) {
                    $('[id="provinsi2"]').val(ui.item.label);
                    $('[id="idprovinsi2"]').val(ui.item.kode);
                }
            });
            $('#kabupaten2').autocomplete({
                source: "<?= route('carikabupaten') ?>",
                select: function(event, ui) {
                    $('[id="kabupaten2"]').val(ui.item.label);
                    $('[id="idkabupaten2"]').val(ui.item.kode);
                }
            });
            $('#kecamatan2').autocomplete({
                source: "<?= route('carikecamatan') ?>",
                select: function(event, ui) {
                    $('[id="kecamatan2"]').val(ui.item.label);
                    $('[id="idkecamatan2"]').val(ui.item.kode);
                }
            });
            $('#desa2').autocomplete({
                source: function(request, response) {
                    $.getJSON("<?= route('caridesa') ?>", {
                            id: $('#idkecamatan2').val(),
                            desa: $('#desa2').val(),
                        },
                        response);
                },
                select: function(event, ui) {
                    $('[id="desa2"]').val(ui.item.label);
                    $('[id="iddesa2"]').val(ui.item.kode);
                }
            });
        });

        function simpaneditpasien() {
            spinner = $('#loader')
            spinner.show();
            var data = $('.formeditpasien').serializeArray();
            $.ajax({
                async: true,
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    data: JSON.stringify(data),
                },
                url: '<?= route('simpaneditpasien') ?>',
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
                        kembali()
                        formpencarianpasien()
                        $('#norm').val(data.rm)
                        caripasien()
                    }
                }
            });
        }
</script>
