<form class="formaddkoordpoli">
    <div class="form-group">
        <label for="exampleInputEmail1">Nama Koordintaor</label>
        <input type="text" class="form-control form-control-sm" id="namaukp" name="namaukp"
            aria-describedby="emailHelp" placeholder="Masukan Nama Koordinator ...">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Nomor Telephone</label>
        <input type="text" class="form-control form-control-sm" id="nomortelepon" name="nomortelepon"
            aria-describedby="emailHelp" placeholder="Masukan nomor telephone ...">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Email</label>
        <input type="text" class="form-control form-control-sm" id="emai" name="email"
            aria-describedby="emailHelp" placeholder="Masukan Email ...">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Website</label>
        <input type="text" class="form-control form-control-sm" id="website" name="website"
            aria-describedby="emailHelp" placeholder="Masukan alamat website ...">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Alamat</label>
        <textarea type="text" class="form-control form-control-sm" id="alamat" name="alamat"
            aria-describedby="emailHelp" placeholder="Masukan alamat jalan dll ..."></textarea>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Kota</label>
        <input type="text" class="form-control form-control-sm" id="kota" name="kota"
            aria-describedby="emailHelp" placeholder="Ketika Kota Asal ...">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Kode Pos</label>
        <input type="text" class="form-control form-control-sm" id="kodepos" name="kodepos"
            aria-describedby="emailHelp" placeholder="Masukan kode pos wilayah ...">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Pilih Provinsi</label>
        <input type="text" class="form-control form-control-sm" id="cariprovinsi" name="cariprovinsi"
            aria-describedby="emailHelp" placeholder="Silahkan Pilih Provinsi ...">
        <input hidden  type="text" class="form-control form-control-sm" id="kodeprovinsi" name="kodeprovinsi"
            aria-describedby="emailHelp">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Pilih Kabupaten</label>
        <input type="text" class="form-control form-control-sm" id="carikabupaten" name='carikabupaten'
            aria-describedby="emailHelp" placeholder="Silahkan Pilih Kabupaten ...">
        <input  hidden type="text" class="form-control form-control-sm" id="kodekabupaten" name='kodekabupaten'
            aria-describedby="emailHelp">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Pilih Kecamatan</label>
        <input type="text" class="form-control form-control-sm" id="carikecamatan" name="carikecamatan"
            aria-describedby="emailHelp" placeholder="Silahkan Pilih Kecamatan ...">
        <input hidden  type="text" class="form-control form-control-sm" id="kodekecamatan" name="kodekecamatan"
            aria-describedby="emailHelp">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Pilih Desa</label>
        <input type="text" class="form-control form-control-sm" id="caridesa" name="caridesa"
            aria-describedby="emailHelp" placeholder="Silahkan Pilih Desa ...">
        <input  hidden type="text" class="form-control form-control-sm" id="kodedesa" name="kodedesa"
            aria-describedby="emailHelp">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Pilih Organization</label>
        <input type="text" class="form-control form-control-sm" id="cariorganization" name="cariorganization">
        <input hidden type="text" class="form-control form-control-sm" id="kodesuborg" name="kodesuborg">
    </div>
</form>
<script>
    $(document).ready(function() {
        $('#cariprovinsi').autocomplete({
            source: "<?= route('cariprovinsi_satusehat') ?>",
            select: function(event, ui) {
                $('[id="cariprovinsi"]').val(ui.item.label);
                $('[id="kodeprovinsi"]').val(ui.item.kode);
            }
        });
        $('#carikabupaten').autocomplete({
            source: "<?= route('carikabupaten_satusehat') ?>",
            select: function(event, ui) {
                $('[id="carikabupaten"]').val(ui.item.label);
                $('[id="kodekabupaten"]').val(ui.item.kode);
            }
        });
        $('#carikecamatan').autocomplete({
            source: "<?= route('carikecamatan_satusehat') ?>",
            select: function(event, ui) {
                $('[id="carikecamatan"]').val(ui.item.label);
                $('[id="kodekecamatan"]').val(ui.item.kode);
            }
        });
        $('#caridesa').autocomplete({
            source: "<?= route('caridesa_satusehat') ?>",
            select: function(event, ui) {
                $('[id="caridesa"]').val(ui.item.label);
                $('[id="kodedesa"]').val(ui.item.kode);
            }
        });
        $('#cariorganization').autocomplete({
            source: "<?= route('carisuborg_satusehat') ?>",
            select: function(event, ui) {
                $('[id="cariorganization"]').val(ui.item.label);
                $('[id="kodesuborg"]').val(ui.item.kode);
            }
        });
    })
</script>
