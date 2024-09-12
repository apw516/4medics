<form class="formedithunit">
    <div class="form-group">
        <label for="exampleFormControlInput1">Nama Unit</label>
        <input type="text" class="form-control" id="editnamaunit" name="editnamaunit" placeholder="name@example.com"
        value="{{ $mt_unit[0]->nama_unit }}"
        >
        <input hidden type="text" class="form-control" id="idunit" name="idunit" placeholder="name@example.com"
        value="{{ $mt_unit[0]->id }}"
        >
    </div>
    <div class="form-group">
        <label for="exampleFormControlSelect1">Tipe Unit</label>
        <select class="form-control" id="edittipeunit" name="edittipeunit">
            <option value="J" @if($mt_unit[0]->group_unit == 'J') selected @endif>Rawat Jalan</option>
            <option value="I" @if($mt_unit[0]->group_unit == 'I') selected @endif>Rawat Inap</option>
            <option value="L" @if($mt_unit[0]->group_unit == 'L') selected @endif>Lainnya</option>
        </select>
    </div>
</form>
