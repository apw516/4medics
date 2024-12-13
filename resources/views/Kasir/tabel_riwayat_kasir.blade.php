<div class="card">
    <!-- title row -->
    @php
        use Carbon\Carbon;
        setlocale(LC_ALL, 'IND');
    @endphp
    <div class="card-header">Data Riwayat Pemakain Obat<div>
    <div class="card-body">
        <table id="tabelorderanresep" class="table table table-sm table-hover table-bordered text-md">
            <thead class="">
                <tr>
                    <th colspan="9">Periode :
                        {{ \Carbon\Carbon::parse($awal)->formatLocalized('%d %B %Y') }} s/d
                        {{ \Carbon\Carbon::parse($akhir)->formatLocalized('%d %B %Y') }}</th>
                </tr>
                <tr>
                    <th>NO</th>
                    <th>Tanggal Layanan</th>
                    <th>Nomor RM</th>
                    <th>Nama Pasien</th>
                    <th>Alamat Pasien</th>
                    <th>Nama Tarif / Obat</th>
                    <th>Qty</th>
                    <th>Tarif</th>
                    <th>Total Layanan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $urutan = 1;
                    $gt = 0;
                @endphp
                @foreach ($data as $d)
                    <tr>
                        <td>{{ $urutan}}</td>
                        <td>{{ $d->tgl_layanan }}</td>
                        <td>{{ $d->no_rm }}</td>
                        <td>{{ $d->nama_px }}</td>
                        <td>{{ $d->alamat_pasien }}</td>
                        <td>{{ $d->keterangan01 }}</td>
                        <td>{{ $d->jumlah_layanan }}</td>
                        <td>
                            Rp. {{ number_format($d->total_tarif, 2) }}
                        </td>
                        <td>Rp. {{ number_format($d->total_layanan, 2) }}</td>
                    </tr>
                    @php
                    $urutan = 1 + $urutan;
                    $gt = $d->total_layanan + $gt;
                @endphp
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-center text-bold text-lg">Grand Total</td>
                    <td class="text-center text-bold text-lg">Rp. {{ number_format($gt, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<input hidden type="text" id="title"
    value="Periode :  {{ \Carbon\Carbon::parse($awal)->formatLocalized('%d %B %Y') }} s/d
        {{ \Carbon\Carbon::parse($akhir)->formatLocalized('%d %B %Y') }}">
<script>
    $(function() {
        awal = $('#title').val()
        $("#tabelorderanresep").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            "pageLength": 20,
            "searching": true,
            "ordering": false,
            "dom": 'Bfrtip',
            "buttons": ["copy", {
                extend: 'excel',
                messageTop: awal
            }, {
                extend: 'pdf',
                messageTop: awal
            }, "csv", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)')
    });
