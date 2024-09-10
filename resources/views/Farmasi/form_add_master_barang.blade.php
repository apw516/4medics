<form class="formaddtambahmasterbarang">
    <div class="form-group">
        <label for="exampleInputEmail1">Nama Barang</label>
        <input type="text" class="form-control" id="namabarang" name="namabarang" aria-describedby="emailHelp">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Nama Generik</label>
        <input type="text" class="form-control" id="namagenerik" name="namagenerik" aria-describedby="emailHelp">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Dosis</label>
        <input type="text" class="form-control" id="dosis" name="dosis" aria-describedby="emailHelp">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Aturan Pakai</label>
        <textarea type="text" class="form-control" id="aturanpakai" name="aturanpakai" aria-describedby="emailHelp"></textarea>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Satuan Besar</label>
        <select class="form-control" id="satuanbesar" name="satuanbesar">
            <option value="0"> Silahkan Pilih</option>
            @foreach ($satuan as $s )
            <option value="{{ $s->kode_satuan }}">{{ $s->nama_satuan}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Satuan Sedang</label>
        <select class="form-control" id="satuansedang" name="satuansedang">
            <option value="0"> Silahkan Pilih</option>
            @foreach ($satuan as $s )
            <option value="{{ $s->kode_satuan }}">{{ $s->nama_satuan}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Sediaan</label>
        <select class="form-control" id="sediaan" name="sediaan">
            <option value="0"> Silahkan Pilih</option>
            @foreach ($sediaan as $s )
            <option value="{{ $s->nama_sediaan }}">{{ $s->nama_sediaan}}</option>
            @endforeach
        </select>
    </div>
</form>
