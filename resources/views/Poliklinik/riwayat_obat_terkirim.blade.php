<div class="card">
    <div class="card-header bg-warning">Order yang dikirim</div>
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
                <th></th>
            </thead>
            <tbody>
                @foreach ($data as $d)
                    <tr>
                        <td>{{ $d->tgl_entry }}</td>
                        <td>{{ $d->nama_barang }}</td>
                        <td>{{ $d->dosis }}</td>
                        <td>{{ $d->aturan_pakai }}</td>
                        <td>{{ $d->sediaan }}</td>
                        <td>{{ $d->qty }}</td>
                        <td>
                            @if ($d->status == 1)
                                Terkirim
                            @elseif($d->status == 2)
                                Selesai
                            @elseif($d->status == 3)
                                Batal
                            @endif
                        </td>
                        <td>
                            @if ($d->status == 1)
                                <button class="btn btn-danger btn-sm batalorder" idheader="{{ $d->idheader}}" iddetail="{{ $d->iddetail }}"><i
                                        class="bi bi-trash3"></i></button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header bg-success">Obat yang dilayani</div>
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
<script>
    $(function() {
        $("#tabelriwayatobat").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            "pageLength": 6,
            "searching": true
        })
    });
    $(".batalorder").on('click', function(event) {
        Swal.fire({
            title: "Order obat akan dibatalkan ?",
            text: "Klik OK untuk melanjutkan ...",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                iddetail = $(this).attr('iddetail')
                idheader = $(this).attr('idheader')
                spinner = $('#loader')
                spinner.show();
                $.ajax({
                    async: true,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        iddetail,idheader
                    },
                    url: '<?= route('batalorderresep') ?>',
                    error: function(data) {
                        spinner.hide();
                    },
                    success: function(data) {
                        spinner.hide();
                        Swal.fire("Order berhasil dihapus !", "", "success");
                        $('#modalriwayatobat').modal('toggle');
                    }
                });
            }
        });
    });
