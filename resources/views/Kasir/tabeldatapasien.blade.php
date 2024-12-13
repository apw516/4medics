<div class="card mt-3">
    <div class="card-header">Data Pasien Kasir</div>
    <div class="card-body">
        <table id="tabelpasienpoli" class="table table-sm table-bordered text-sm">
            <thead>
                <th>Tgl Masuk</th>
                <th>No RM</th>
                <th>Nama Pasien</th>
                <th>Alamat</th>
                <th hidden>Unit Tujuan</th>
                <th>Dokter Pemeriksa</th>
                <th>Status Periksa</th>
                <th>Status Kunjungan</th>
                <th>Action</th>
            </thead>
            <tbody>
                @foreach ($data as $d)
                    <tr>
                        <td>{{ $d->tgl_masuk }}</td>
                        <td>{{ $d->no_rm }}</td>
                        <td>{{ $d->nama_pasien }}</td>
                        <td>{{ $d->alamat }}</td>
                        <td hidden>{{ $d->nama_unit }}</td>
                        <td>{{ $d->nama_dokter }}</td>
                        <td>@if($d->nama_dokter == NULL)Belum diperiksa @else sudah diperiksa @endif</td>
                        <td>@if($d->status_kunjungan == 1)Aktif @else Selesai @endif </td>
                        <td>
                            <button class="btn btn-success btn-sm pilihpasien" kode_kunjungan={{ $d->kode_kunjungan }}><i
                                    class="bi bi-journal-plus r-2"></i></button>
                                    <button kode_kunjungan="{{ $d->kode_kunjungan }}" class="btn btn-info btn-sm infopembayaran" data-toggle="modal" data-target="#modalinfo"><i
                                        class="bi bi-info-circle"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalinfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="v_data_pembayaran">

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
        $("#tabelpasienpoli").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            "pageLength": 6,
            "searching": true
        })
    });
    $(".pilihpasien").on('click', function(event) {
        $(".v_kedua").removeAttr('hidden', true);
        $(".v_utama").attr('hidden', true);
        kode_kunjungan = $(this).attr('kode_kunjungan')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                kode_kunjungan
            },
            url: '<?= route('ambildeatailtagihan') ?>',
            success: function(response) {
                $('.v_kedua').html(response);
                spinner.hide();
            }
        });
    });
    $(".infopembayaran").on('click', function(event) {
        kode_kunjungan = $(this).attr('kode_kunjungan')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                kode_kunjungan
            },
            url: '<?= route('detailsudahdibayar') ?>',
            success: function(response) {
                $('.v_data_pembayaran').html(response);
                spinner.hide();
            }
        });
    });
