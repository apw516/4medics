<div class="card mt-2">
    <div class="card-header">Detail Tagihan Pasien</div>
    <div class="card-body">
        <table class="table table-sm table-bordered table-hover">
            <thead>
                <th>Kode layanan Header</th>
                <th>Kode layanan Detail</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Tarif</th>
                <th>Jumlah</th>
                <th>Total</th>
            </thead>
            <tbody>
                @php
                    $gt = 0;
                @endphp
                @foreach ($data as $d)
                    <tr>
                        <td>{{ $d->kode_layanan_header }}</td>
                        <td>{{ $d->id_layanan_detail }}</td>
                        <td>{{ $d->keterangan01 }}</td>
                        <td>{{ $d->status_layanan_detail }}</td>
                        <td>
                            Rp. {{ number_format($d->total_tarif, 2) }}
                        </td>
                        <td>
                            {{ $d->jumlah_layanan }}
                        </td>
                        <td>
                            Rp. {{ number_format($d->total_layanan, 2) }}

                        </td>
                    </tr>
                    @php
                        $gt = $d->total_layanan + $gt;
                    @endphp
                @endforeach
                <tr class="text-center text-bold bg-light">
                    <td colspan="6">Grand Total</td>
                    <td> Rp. {{ number_format($gt, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card-footer">
    </div>
</div>
