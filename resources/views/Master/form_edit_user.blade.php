<form class="formedituser">
    <div class="form-group">
        <label for="exampleFormControlInput1">Kode Paramedis</label>
        <input type="text" class="form-control" id="kode_paramedis" name="kode_paramedis" placeholder="name@example.com"
            value="{{ $user[0]->kode_paramedis }}">
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Nama</label>
        <input type="text" class="form-control" id="namalengkap" name="namalengkap" placeholder="name@example.com"
            value="{{ $user[0]->nama }}">
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="name@example.com"
            value="{{ $user[0]->nama }}">
        <input hidden type="text" class="form-control" id="iduser" name="iduser" placeholder="name@example.com"
            value="{{ $user[0]->id }}">
    </div>
    <div class="form-group">
        <label for="exampleFormControlSelect1">Hak Akses</label>
        <select class="form-control" id="hakakses" name="hakakses">
            <option value="1" @if ($user[0]->hak_akses == 1) selected @endif>Super Admin</option>
            <option value="2" @if ($user[0]->hak_akses == 2) selected @endif>Admin</option>
            <option value="3" @if ($user[0]->hak_akses == 3) selected @endif>Dokter</option>
            <option value="4" @if ($user[0]->hak_akses == 4) selected @endif>Farmasi</option>
        </select>
    </div>
    <div class="form-group">
        <label for="exampleFormControlSelect1">Unit</label>
        <select class="form-control" id="unit" name="unit">
            @foreach ($mt_unit as $u)
                <option value="{{ $u->kode_unit }}" @if ($user[0]->unit == $u->kode_unit) selected @endif>
                    {{ $u->nama_unit }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="exampleFormControlSelect1">Status</label>
        <select class="form-control" id="status" name="status">
            <option value="1" @if ($user[0]->status == 1) selected @endif>Aktif</option>
            <option value="0"@if ($user[0]->status == 0) selected @endif>Tidak Aktif</option>
        </select>
    </div>
</form>
