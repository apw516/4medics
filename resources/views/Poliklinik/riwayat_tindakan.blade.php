<div class="card">
    <div class="card-header bg-warning">Riwayat Tindakan hari ini</div>
    <div class="card-body">
        <table id="tabelriwayatobat2" class="table table-sm table-bordered text-xs table-hover">
            <thead>
                <th>Tanggal</th>
                <th>Nama Tarif</th>
                <th>Tarif</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Status</th>
                <th>===</th>
            </thead>
            <tbody>
                @foreach ($riwayat as $d)
                    <tr>
                        <td>{{ $d->tgl_entry }}</td>
                        <td>{{ $d->keterangan01 }}</td>
                        <td>{{ $d->total_tarif }}</td>
                        <td>{{ $d->jumlah_layanan }}</td>
                        <td>{{ $d->total_layanan }}</td>
                        <td>
                            @if ($d->status_layanan == 1)
                                Terkirim
                            @elseif($d->status_layanan == 2)
                                Selesai
                            @elseif($d->status_layanan == 3)
                                Batal
                            @endif
                        </td>
                        <td>
                            @if ($d->status_layanan == 1)
                                <button class="btn btn-danger btn-sm bataltindakan" idheader="{{ $d->idheader}}" iddetail="{{ $d->iddetail }}"><i
                                        class="bi bi-trash3"></i></button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
     $(".bataltindakan").on('click', function(event) {
        Swal.fire({
            title: "Tarif tindakan dan laboratorium akan dibatalkan ?",
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
                    url: '<?= route('bataltindakan') ?>',
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

</script>
