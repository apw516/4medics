<table id="tabelmasterparamedis" class="table table-sm table-bordered table-hover">
    <thead>
        <th>Kode</th>
        <th>Nama Lengkap</th>
        <th>Unit</th>
        <th>Akses</th>
        <th>Action</th>
    </thead>
    <tbody>
        @foreach ($paramedis as $u)
            <tr>
                <td>{{ $u->kode_paramedis }}</td>
                <td>{{ $u->nama_paramedis }}</td>
                <td>{{ $u->nama_unit }}</td>
                <td>
                    @if ($u->preffix == 1)
                        Super Admin
                    @elseif($u->preffix == 2)
                        Admin
                    @elseif($u->preffix == 3)
                        Dokter
                    @elseif($u->preffix == 4)
                        Farmasi
                    @endif
                </td>
                <td>
                    <button idparamedis="{{ $u->ID }}" class="btn btn-warning btn-sm editpegawai"
                        data-toggle="modal" data-target="#modaleditpegawai"><i class="bi bi-pencil-square"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="modaleditpegawai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="v_form_edit_pegawai">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="simpanupdate()">Simpan Update</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#tabelmasterparamedis").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            "pageLength": 8,
            "searching": true,
            "ordering": false
        })
    });
    $(".editpegawai").on('click', function(event) {
        idpegawai = $(this).attr('idparamedis')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                idpegawai
            },
            url: '<?= route('ambil_detail_pegawai') ?>',
            success: function(response) {
                $('.v_form_edit_pegawai').html(response);
                spinner.hide();
            }
        });
    });
    function simpanupdate() {
        spinner = $('#loader')
        spinner.show();
        var data = $('.formeditpegawai').serializeArray();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                data: JSON.stringify(data),
            },
            url: '<?= route('simpanupdatepegawai') ?>',
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
                spinner.hide()
                if (data.kode == 500) {
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
                    location.reload()
                }
            }
        });
    }
