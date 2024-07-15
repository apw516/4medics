<div class="card mt-3">
    <div class="card-header">Data Pasien</div>
    <div class="card-body">
        <table id="tabelpasienpoli" class="table table-sm table-bordered text-sm">
            <thead>
                <th>Tgl Masuk</th>
                <th>Kunjungan Ke</th>
                <th>No RM</th>
                <th>Nama Pasien</th>
                <th>Alamat</th>
                <th>Unit Tujuan</th>
                <th>Dokter Pemeriksa</th>
                <th>Action</th>
            </thead>
            <tbody>
                @foreach ($data as $d)
                    <tr>
                        <td>{{ $d->tgl_masuk }}</td>
                        <td>{{ $d->counter }}</td>
                        <td>{{ $d->no_rm }}</td>
                        <td>{{ $d->nama_pasien }}</td>
                        <td>{{ $d->alamat }}</td>
                        <td>{{ $d->nama_unit }}</td>
                        <td>{{ $d->nama_dokter }}</td>
                        <td>
                            <button kode_kunjungan="{{ $d->kode_kunjungan }}" class="btn btn-info btn-sm pilihpasien" data-toggle="modal" data-target="#modalresume"><i
                                    class="bi bi-info-circle"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalresume" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Pemeriksaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="v_data_pemeriksaan">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
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
        kode_kunjungan = $(this).attr('kode_kunjungan')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                kode_kunjungan
            },
            url: '<?= route('ambil_data_pemeriksaan_pasien') ?>',
            success: function(response) {
                $('.v_data_pemeriksaan').html(response);
                spinner.hide();
            }
        });
    });
