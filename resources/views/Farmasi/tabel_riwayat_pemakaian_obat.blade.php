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
                    <th colspan="6">Periode :
                        {{ \Carbon\Carbon::parse($awal)->formatLocalized('%d %B %Y') }} s/d
                        {{ \Carbon\Carbon::parse($akhir)->formatLocalized('%d %B %Y') }}</th>
                </tr>
                <tr>
                    <th>Tanggal Layanan</th>
                    <th>Nomor RM</th>
                    <th>Nama Pasien</th>
                    <th>Alamat Pasien</th>
                    <th>Nama Obat</th>
                    <th>Qty</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                    <tr>
                        <td>{{ $d->tgl_layanan }}</td>
                        <td>{{ $d->no_rm }}</td>
                        <td>{{ $d->nama_px }}</td>
                        <td>{{ $d->alamat_pasien }}</td>
                        <td>{{ $d->keterangan01 }}</td>
                        <td>{{ $d->jumlah_layanan }}</td>
                    </tr>
                @endforeach
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
            "pageLength": 12,
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
