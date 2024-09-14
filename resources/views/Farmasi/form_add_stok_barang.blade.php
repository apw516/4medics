<form class="formaddstokmasuk">
    <div class="form-group">
        <label for="exampleInputEmail1">Satuan Besar</label>
        <input readonly type="text" class="form-control" id="satuanbesar" name="satuanbesar"
            value="{{ $barang[0]->satuan_besar }}">
        <input hidden readonly type="text" class="form-control" id="kodebarang" name="kodebarang"
            value="{{ $barang[0]->kode_barang }}">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Satuan Sedang</label>
        <input readonly type="text" class="form-control" id="satuansedang" name="satuansedang"
            value="{{ $barang[0]->nama_satuan }}">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Satuan Kecil</label>
        <input readonly type="text" class="form-control" id="satuankecil" name="satuankecil"
            value="{{ $barang[0]->sediaan }}">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Satuan yang dimasukan</label>
        <select class="form-control" id="satuanmasuk" name="satuanmasuk">
            {{-- <option value="1">Satuan Besar</option> --}}
            <option value="2">Satuan Sedang</option>
            <option value="3">Satuan Kecil</option>
        </select>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Rasio Kecil</label>
        <input type="text" class="form-control" id="rasiokecil" name="rasiokecil" placeholder="Masukan angka ...">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Jumlah Stok Masuk</label>
        <input type="text" class="form-control" id="jumlahstok" name="jumlahstok" placeholder="Masukan angka ...">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Expired Data</label>
        <input type="date" class="form-control" id="ed" name="ed" placeholder="Masukan angka ...">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Harga Beli</label>
        <input type="text" class="form-control" id="hargabeli" name="hargabeli" placeholder="Masukan angka ...">
    </div>
    <label for="exampleInputPassword1">Harga Jual ( dalam persen )</label><br>
    <div class="input-group mb-3">
        <input type="text" class="form-control col-md-5" placeholder="Masukan angka ..." aria-label="Recipient's username"
            aria-describedby="basic-addon2" name="hargajual" id="hargajual">
        <div class="input-group-append">
            <span class="input-group-text" id="basic-addon2">%</span>
        </div>
    </div>
</form>
