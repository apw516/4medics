<div class="card">
    <div class="card-header">Riwayat Pendaftaran</div>
    <div class="card-body">
        <table id="tabel_riwayat" class="table table-sm table-bordered table-hover">
            <thead>
                <th>Tanggal Masuk</th>
                <th>Kunjungan Ke</th>
                <th>No RM</th>
                <th>Nama Pasien</th>
                <th>Unit Tujuan</th>
                <th>Dokter Pemeriksa</th>
                <th>PIC</th>
                <th>Status</th>
                <th>Action</th>
            </thead>
            <tbody>
                @foreach ($riwayat as $r)
                    <tr>
                        <td>{{ $r->tgl_masuk }}</td>
                        <td>{{ $r->counter }}</td>
                        <td>{{ $r->no_rm }}</td>
                        <td>{{ $r->nama_pasien }}</td>
                        <td>{{ $r->nama_unit }}</td>
                        <td>{{ $r->nama_dokter }}</td>
                        <td>{{ $r->pic }}</td>
                        <td>
                            @if ($r->status_kunjungan == 1)
                                Aktif
                            @elseif($r->status_kunjungan == 2)
                                Selesai
                            @else
                                Batal
                            @endif
                        </td>
                        <td><button class="btn btn-warning btn-sm editkunjunganbtn"
                                kodekunjungan="{{ $r->kode_kunjungan }}" data-toggle="modal"
                                data-target="#modaleditkunjungan"><i class="bi bi-pencil-square"></i></button>
                                <button kode_kunjungan="{{ $r->kode_kunjungan }}" class="btn btn-info btn-sm pilihpasien" data-toggle="modal" data-target="#modalresume"><i
                                    class="bi bi-info-circle"></i></button>
                            </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modaleditkunjungan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Kunjungan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="v_form_edit_kunjungan">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bi bi-x-square mr-2"></i> Tutup</button>
                <button type="button" class="btn btn-primary" onclick="simpaneditkunjungan()"><i class="bi bi-save2 mr-2"></i> Simpan Edit</button>
            </div>
        </div>
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
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#tabel_riwayat").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            "pageLength": 8,
            "searching": true,
            "ordering": false
        })
    });

    $(".editkunjunganbtn").on('click', function(event) {
        kodekunjungan = $(this).attr('kodekunjungan')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                kodekunjungan
            },
            url: '<?= route('ambil_detail_kunjungan') ?>',
            success: function(response) {
                $('.v_form_edit_kunjungan').html(response);
                spinner.hide();
            }
        });
    });

    function simpaneditkunjungan()
    {
        spinner = $('#loader')
        spinner.show();
        var data = $('.form_update_kunjungan').serializeArray();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                data: JSON.stringify(data),
            },
            url: '<?= route('simpaneditkunjungan') ?>',
            error: function(data) {
                spinner.hide()
                Swal.fire({
                    icon: 'error',
                    title: 'Ooops....',
                    text: 'Sepertinya ada masalah......',
                    footer: ''
                })
            },
            success: function(data) {
                if (data.kode == 500) {
                    spinner.hide()
                    Swal.fire({
                        icon: 'error',
                        title: 'Oopss...',
                        text: data.message,
                        footer: ''
                    })
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'OK',
                        text: data.message,
                        footer: ''
                    })
                    setTimeout(function() {
                        spinner.hide()
                        location.reload()
                    }, 3000);
                }
            }
        });
    }
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
