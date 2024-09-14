<table id="tabelorderanresep" class="table table table-sm table-hover table-bordered text-sm">
    <thead>
        <th>Tanggal order</th>
        <th>Nomor RM</th>
        <th>Nama Pasien</th>
        <th>Nama Dokter</th>
        <th>Unit Kirim</th>
        <th>Status</th>
        <th>Action</th>
    </thead>
    <tbody>
        @foreach ($data as $d)
            <tr>
                <td>{{ $d->tgl_entry }}</td>
                <td>{{ $d->no_rm }}</td>
                <td>{{ $d->nama_pasien }}</td>
                <td>{{ $d->nama_dokter }}</td>
                <td>{{ $d->nama_unit_kirim }}</td>
                <td>
                    @if ($d->status == 1)
                        Belum dilayani
                    @elseif ($d->status == 2)
                        Selesai
                    @elseif ($d->status == 3)
                        Batal
                    @endif
                </td>
                <td>
                    {{-- @if ($d->status == 1) --}}
                        <button class="btn btn-success btn-sm pilihheader" idheader="{{ $d->id }}"><i
                                class="bi bi-receipt"></i></button>
                    {{-- @elseif($d->status == 2) --}}
                        <button class="btn btn-info btn-sm infolayanan" data-toggle="modal" data-target="#modalinfo"
                            idheader="{{ $d->id }}" idlayanan="{{ $d->id_layanan_header }}"><i class="bi bi-receipt"></i></button>
                    {{-- @endif --}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="modalinfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Resep</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="v_d_l">

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
        $("#tabelorderanresep").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            "pageLength": 10,
            "searching": true,
            "ordering": false
        })
    });
    $(".pilihheader").on('click', function(event) {
        $(".v_kedua").removeAttr('hidden', true);
        $(".v_utama").attr('hidden', true);
        idheader = $(this).attr('idheader')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                idheader
            },
            url: '<?= route('ambil_detail_orderan') ?>',
            success: function(response) {
                $('.v_kedua').html(response);
                spinner.hide();
            }
        });
    });
    $(".infolayanan").on('click', function(event) {
        idheader = $(this).attr('idheader')
        idlayanan = $(this).attr('idlayanan')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                idheader,idlayanan
            },
            url: '<?= route('ambil_detail_layanan') ?>',
            success: function(response) {
                $('.v_d_l').html(response);
                spinner.hide();
            }
        });
    });
