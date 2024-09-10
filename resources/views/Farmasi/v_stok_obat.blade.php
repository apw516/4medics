<table class="table table-sm table-bordered">
    <thead>
        <th>Tgl Stok</th>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Dosis</th>
        <th>Aturan Pakai</th>
        <th>Sediaan</th>
        <th>Stok Current</th>
    </thead>
    <tbody>
        @foreach ($stok as $s )
            <tr>
                <td>{{ $s->tgl_stok }}</td>
                <td>{{ $s->kode_barang }}</td>
                <td>{{ $barang[0]->nama_barang }}</td>
                <td>{{ $barang[0]->dosis }}</td>
                <td>{{ $barang[0]->aturan_pakai }}</td>
                <td>{{ $barang[0]->sediaan }}</td>
                <td>{{ $s->stok_current }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="card mt-3">
    <div class="card-header">Stok Persediaan</div>
    <div class="card-body">
        <table class="table table-sm table-bordered">
            <thead>
                <th>Nama Barang</th>
                <th>Harga Beli</th>
                <th>Expired Data</th>
                <th>Stok</th>
                <th>Tanggal entry</th>
            </thead>
            <tbody>
                @foreach ($stok_sediaan as $D)
                    <tr>
                        <td>{{ $D->nama_barang}}</td>
                        <td>{{ $D->harga_beli}}</td>
                        <td>{{ $D->ed}}</td>
                        <td>{{ $D->stok}}</td>
                        <td>{{ $D->tgl_entry}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
