<div class="card">
    <div class="card-header">Data POLI ( RUANG )</div>
    <div class="card-body">
        <table class="table table-sm table-bordered table-hover text-xs" id="Tabelpolisatusehat">
            <thead>
                <th>Nama Poli</th>
                <th>Deskripsi</th>
                <th>Lokasi Altitude</th>
                <th>Lokasi Longitude</th>
                <th>Lokasi Latitude</th>
                <th>ID satu sehat</th>
                <th>ID Organization satu sehat</th>
            </thead>
            <tbody>
                @foreach ($DATA as $d)
                    <tr>
                        <td>{{ $d->nama_poli }}</td>
                        <td>{{ $d->deskripsi }}</td>
                        <td>{{ $d->altitude }}</td>
                        <td>{{ $d->latitude }}</td>
                        <td>{{ $d->longitude }}</td>
                        <td>{{ $d->id_poli_satu_sehat }}</td>
                        <td>{{ $d->organization_id_satu_sehat }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">Data POLI ( ORG )</div>
    <div class="card-body">
        <table class="table table-sm table-bordered table-hover text-xs" id="Tabelpolisatusehat">
            <thead>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Kota</th>
                <th>ID satu sehat</th>
                <th>ID Organization satu sehat</th>
            </thead>
            <tbody>
                @foreach ($DATA2 as $d)
                    <tr>
                        <td>{{ $d->nama }}</td>
                        <td>{{ $d->alamat }}</td>
                        <td>{{ $d->kota }}</td>
                        <td>{{ $d->id_satu_sehat }}</td>
                        <td>{{ $d->organization_id_satu_sehat }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(function() {
        $("#Tabelpolisatusehat").DataTable({
            "responsive": false,
            "lengthChange": false,
            "autoWidth": true,
            "pageLength": 8,
            "searching": true,
            "ordering": false
        })
    });
