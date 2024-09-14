<form class="form_update_kunjungan">
    <div class="form-group">
        <label for="exampleFormControlInput1">Tanggal Masuk</label>
        <input hidden type="text" class="form-control" id="kodekunjungan" name="kodekunjungan" placeholder="name@example.com"
            value="{{ $kunjungan[0]->kode_kunjungan }}">
        <input type="date" class="form-control" id="tglmasuk" name="tglmasuk" placeholder="name@example.com"
            value="{{ $kunjungan[0]->tgl_masuk2 }}">
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Dokter Pemeriksa</label>
        <input type="text" class="form-control"  placeholder="name@example.com"
            value="{{ $kunjungan[0]->nama_dokter }}" id="namadokter" name="namadokter">
        <input hidden readonly type="text" class="form-control" id="kodeparamedis" name="kodeparamedis" placeholder="name@example.com"
            value="{{ $kunjungan[0]->kode_paramedis }}">
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Unit Tujuan</label>
        <input type="text" class="form-control"  placeholder="name@example.com"
            value="{{ $kunjungan[0]->nama_unit }}" id="namaunit" name="namaunit">
        <input hidden readonly type="text" class="form-control" id="kodeunit" name="kodeunit" placeholder="name@example.com"
            value="{{ $kunjungan[0]->kode_unit }}">
    </div>

    <div class="form-group">
        <label for="exampleFormControlSelect1">Status Kunjungan</label>
        <select class="form-control" id="status_kunjungan" name="status_kunjungan">
            <option @if ($kunjungan[0]->status_kunjungan == 1) selected @endif value="1">Aktif</option>
            <option @if ($kunjungan[0]->status_kunjungan == 2) selected @endif value="2">Selesai</option>
            <option @if ($kunjungan[0]->status_kunjungan != 1 && $kunjungan[0]->status_kunjungan != 2) selected @endif value="8">Batal</option>
        </select>
    </div>
</form>
<script>
      $(document).ready(function() {
        $('#namadokter').autocomplete({
            source: "<?= route('caridokter') ?>",
            select: function(event, ui) {
                $('[id="namadokter"]').val(ui.item.label);
                $('[id="kodeparamedis"]').val(ui.item.id);
            }
        });
        $('#namaunit').autocomplete({
            source: "<?= route('cariunit') ?>",
            select: function(event, ui) {
                $('[id="namaunit"]').val(ui.item.label);
                $('[id="kodeunit"]').val(ui.item.id);
            }
        });
    });
</script>
