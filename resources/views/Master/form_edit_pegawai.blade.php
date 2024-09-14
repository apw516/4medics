<form class="formeditpegawai">
    <div class="form-group">
        <label for="exampleFormControlInput1">Nama Lengkap</label>
        <input type="text" class="form-control" id="namapegawai" name="namapegawai"
            placeholder="name@example.com" value="{{ $pegawai[0]->nama_paramedis}}">
        <input hidden type="text" class="form-control" id="idpegawai" name="idpegawai"
            placeholder="name@example.com" value="{{ $pegawai[0]->ID}}">
    </div>
    <div class="form-group">
        <label for="exampleFormControlSelect1">Hak Akses</label>
        <select class="form-control" id="hakakses" name="hakakses">
            <option value="0">Silahkan Pilih</option>
            <option value="1" @if ($pegawai[0]->preffix == 1) selected @endif>Super Admin</option>
            <option value="2" @if ($pegawai[0]->preffix == 2) selected @endif>Admin</option>
            <option value="3" @if ($pegawai[0]->preffix == 3) selected @endif>Dokter</option>
            <option value="4" @if ($pegawai[0]->preffix == 4) selected @endif>Farmasi</option>
        </select>
    </div>
    <div class="form-group">
        <label for="exampleFormControlSelect1">Unit</label>
        <select class="form-control" id="unitkerja" name="unitkerja">
            <option value="0">Silahkan Pilih</option>
            @foreach ($mt_unit as $u )
            <option value="{{ $u->kode_unit }}" @if($pegawai[0]->unit == $u->kode_unit) selected @endif>{{ $u->nama_unit}}</option>
            @endforeach
        </select>
    </div>
</form>
