<table class="table table-sm">
    <thead>
        <th>Nama Obat</th>
        <th>Aturan Pakai</th>
        <th>Sediaan</th>
        <th>QTY</th>
    </thead>
    <tbody>
        @foreach ($detail as $d )
            <tr>
                <td>{{ $d->keterangan01 }}</td>
                <td>{{ $d->aturan_pakai }}</td>
                <td>{{ $d->satuan_barang }}</td>
                <td>{{ $d->jumlah_layanan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
