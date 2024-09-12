<table id="tabelmasterunit" class="table table-sm table-bordered table-hover">
    <thead>
        <th>Nama Lengkap</th>
        <th>Username</th>
        <th>Hak Akses</th>
        <th>Unit</th>
        <th>Status</th>
        <th>Action</th>
    </thead>
    <tbody>
        @foreach ($user as $u)
            <tr>
                <td>{{ $u->nama }}</td>
                <td>{{ $u->username }}</td>
                <td>
                    @if ($u->hak_akses == '1')
                        Super admin
                    @elseif($u->hak_akses == '2')
                        Admin
                    @elseif($u->hak_akses == '3')
                        Dokter
                    @elseif($u->hak_akses == '4')
                        Farmasi
                    @else
                        Lainnya
                    @endif
                </td>
                <td>{{ $u->unit }}</td>
                <td>@if($u->status == 0)Tidak Aktif @elseif($u->status == 1)Aktif @endif</td>
                <td>
                    <button iduser="{{ $u->id }}" class="btn btn-warning btn-sm edituser" data-toggle="modal"
                        data-target="#modaledituser"><i class="bi bi-pencil-square"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="modaledituser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="v_form_edit_user">

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
        $("#tabelmasterunit").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            "pageLength": 8,
            "searching": true,
            "ordering": false
        })
    });
    //

    $(".edituser").on('click', function(event) {
        iduser = $(this).attr('iduser')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                iduser
            },
            url: '<?= route('ambil_detail_user') ?>',
            success: function(response) {
                $('.v_form_edit_user').html(response);
                spinner.hide();
            }
        });
    });

    function simpanupdate() {
        spinner = $('#loader')
        spinner.show();
        var data = $('.formedituser').serializeArray();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                data: JSON.stringify(data),
            },
            url: '<?= route('simpanupdateuser') ?>',
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
