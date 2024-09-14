@foreach ($data as $as )
<table class="table table-sm table-bordered">
    <tr>
        <td colspan="2" class="text-center text-bold">Tanda Tanda Vital</td>
    </tr>
    <tr>
        <td width="60%">
            <div class="form-group row mt-4">
                <label for="inputPassword" class="col-sm-2 col-form-label">Tekanan
                    Darah</label>
                <div class="col-sm-5">
                    {{ $as->tekanan_darah }} mm Hg
                </div>
            </div>
        </td>
        <td>
            <div class="form-group row mt-4">
                <label for="inputPassword" class="col-sm-4 col-form-label">Suhu Tubuh</label>
                <div class="col-sm-5">
                    {{ $as->suhu_tubuh }} °C
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="font-italic" colspan="2">
            Subject ( S ) : {{ trim($as->subject) }}
        </td>
    </tr>
    <tr>
        <td class="font-italic" colspan="2">
            Object ( O ) : {{ trim($as->object) }}

        </td>
    </tr>
    <tr>
        <td class="font-italic" colspan="2">
            Assesment ( A ) : {{ trim($as->assesment) }}
        </td>
    </tr>
    <tr>
        <td class="font-italic" colspan="1">
            PLanning ( P ) : {{ trim($as->planning) }}
        </td>
    </tr>
</table>
@endforeach
<div class="card">
    <div class="card-header">Order Faramsi</div>
    <div class="card-body">
        <table id="tabelriwayatobat" class="table table-sm table-bordered text-xs table-hover">
            <thead>
                <th>Tanggal order</th>
                <th>Nama Obat</th>
                <th>Dosis</th>
                <th>Aturan Pakai</th>
                <th>Sediaan</th>
                <th>QTY</th>
                <th>Status</th>
            </thead>
            <tbody>
                @foreach ($dataobat as $d )
                    <tr>
                        <td>{{ $d->tgl_entry}}</td>
                        <td>{{ $d->nama_barang}}</td>
                        <td>{{ $d->dosis}}</td>
                        <td>{{ $d->aturan_pakai}}</td>
                        <td>{{ $d->sediaan}}</td>
                        <td>{{ $d->qty}}</td>
                        <td>@if($d->status == 1)Terkirim
                            @elseif($d->status == 2) Selesai
                            @elseif($d->status == 3) Batal
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">Layanan Faramsi</div>
    <div class="card-body">
        <table id="tabelriwayatobat" class="table table-sm table-bordered text-xs table-hover">
            <thead>
                <th>Tanggal Entry</th>
                <th>Nama Obat</th>
                {{-- <th>Dosis</th> --}}
                <th>Aturan Pakai</th>
                <th>Sediaan</th>
                <th>QTY</th>
            </thead>
            <tbody>
                @foreach ($datalayananobat as $d )
                    <tr>
                        <td>{{ $d->tgl_entry}}</td>
                        <td>{{ $d->keterangan01}}</td>
                        {{-- <td>{{ $d->dosis}}</td> --}}
                        <td>{{ $d->aturan_pakai}}</td>
                        <td>{{ $d->satuan_barang}}</td>
                        <td>{{ $d->jumlah_layanan}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
