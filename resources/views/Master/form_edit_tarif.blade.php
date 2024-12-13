<form class="formedittarif">
    <div class="form-group">
        <label for="exampleFormControlInput1">Nama Tarif</label>
        <input type="text" class="form-control" id="namatarif" name="namatarif"
            placeholder="masukan nama ..." value="{{ $mt_tarif[0]->nama_tarif}}">
        <input hidden type="text" class="form-control" id="namatarif" name="idtarif"
            placeholder="masukan nama ..." value="{{ $mt_tarif[0]->id}}">
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Tarif</label>
        <input type="text" class="form-control" id="tarif" name="tarif"
            placeholder="masukan harga ..." value="{{ $mt_tarif[0]->tarif}}">
    </div>
    <div class="form-group">
        <label for="exampleFormControlSelect1">Jenis Tarif</label>
        <select class="form-control" id="hakakses" name="jenistarif">
            <option value="0">Silahkan Pilih</option>
            <option value="NON-PAKET" @if($mt_tarif[0]->jenis_tarif == 'NON-PAKET') selected @endif>NON-PAKET</option>
            <option value="NON-PAKET" @if($mt_tarif[0]->jenis_tarif == 'PAKET') selected @endif>PAKET</option>
        </select>
    </div>
    <div class="form-group">
        <label for="exampleFormControlSelect1">Unit</label>
        <select class="form-control" id="unittarif" name="unittarif">
            <option value="0">Silahkan Pilih</option>
            @foreach ($mt_unit as $u )
            <option value="{{ $u->kode_unit }}" @if($mt_tarif[0]->kode_unit == $u->kode_unit) selected @endif>{{ $u->nama_unit}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="exampleFormControlSelect1">Status</label>
        <select class="form-control" id="unittarif" name="status">
            <option value="1" @if($mt_tarif[0]->status == '1') selected @endif>Aktif</option>
            <option value="2" @if($mt_tarif[0]->status == '2') selected @endif>Tidak Aktif</option>
        </select>
    </div>
</form>
