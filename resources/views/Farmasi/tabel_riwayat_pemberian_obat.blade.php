<table id="tabelriwayatresep" class="table table-sm table-bordered">
    <thead>
        <th>Tanggal entry</th>
        <th>Nomor RM</th>
        <th>Nama Pasien</th>
        <th>Alamat</th>
        <th>Unit Asal</th>
        <th>Dokter Pengirim</th>
        <th></th>
    </thead>
    <tbody>
        @foreach ($data as $d)
            <tr>
                <td>{{ $d->tgl_resep }}</td>
                <td>{{ $d->no_rm }}</td>
                <td>{{ $d->nama_px }}</td>
                <td>{{ $d->alamat_pasien }}</td>
                <td>{{ $d->unit_asal }}</td>
                <td>{{ $d->nama_dokter_poli }}</td>
                <td>
                    <button idheader="{{ $d->idlayananheader }}" class="btn btn-info btn-sm detailresep"
                        data-toggle="modal" data-target="#modaldetailresep"><i
                            class="bi bi-info-circle mr-1 ml-1"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="modaldetailresep" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Resep</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="v_detail_resep">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $("#tabelriwayatresep").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            "pageLength": 10,
            "searching": true
        })
    });
    $(".detailresep").on('click', function(event) {
        id = $(this).attr('idheader')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                id
            },
            url: '<?= route('detail_riwayat_resep') ?>',
            error: function(response) {
                spinner.hide()
                alert('error')
            },
            success: function(response) {
                spinner.hide()
                $('.v_detail_resep').html(response);
            }
        });
    })
