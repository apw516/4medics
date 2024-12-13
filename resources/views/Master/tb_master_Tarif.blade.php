<table id="tabelmastertarif" class="table table-sm table-bordered table-hover mt-3">
    <thead>
        <th>ID</th>
        <th>Nama Tarif</th>
        <th>Tarif</th>
        <th>Jenit Tarif</th>
        <th>Status</th>
        <th>Unit</th>
        <th>Action</th>
    </thead>
    <tbody>
        @foreach ($tarif as $u)
            <tr>
                <td>{{ $u->idtarif }}</td>
                <td>{{ $u->nama_tarif }}</td>
                <td>{{ $u->tarif }}</td>
                <td>{{ $u->jenis_tarif }}</td>
                <td>{{ $u->status }}</td>
                <td>{{ $u->nama_unit }}</td>
                <td>
                    <button idtarif="{{ $u->idtarif }}" class="btn btn-warning btn-sm edittarif" data-toggle="modal"
                        data-target="#modaledittarif"><i class="bi bi-pencil-square"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="modaledittarif" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Tarif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="v_form_edit_tarif">

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
        $("#tabelmastertarif").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            "pageLength": 8,
            "searching": true,
            "ordering": false
        })
    });
    //

    $(".edittarif").on('click', function(event) {
        idtarif = $(this).attr('idtarif')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                idtarif
            },
            url: '<?= route('ambil_detail_tarif') ?>',
            success: function(response) {
                $('.v_form_edit_tarif').html(response);
                spinner.hide();
            }
        });
    });


    function simpanupdate() {
        spinner = $('#loader')
        spinner.show();
        var data = $('.formedittarif').serializeArray();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                data: JSON.stringify(data),
            },
            url: '<?= route('simpanupdatetarif') ?>',
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
