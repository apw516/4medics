<table id="tabelmasterunit" class="table table-sm table-bordered table-hover">
    <thead>
        <th>Kode Unit</th>
        <th>Nama Unit</th>
        <th>Tipe Unit</th>
        <th>Action</th>
    </thead>
    <tbody>
        @foreach ($mt_unit as $u)
            <tr>
                <td>{{ $u->kode_unit }}</td>
                <td>{{ $u->nama_unit }}</td>
                <td>
                    @if ($u->group_unit == 'J')
                        Rawat Jalan
                    @elseif($u->group_unit == 'I')
                        Rawat Inap
                    @else
                        Lainnya
                    @endif
                </td>
                <td>
                    <button idunit="{{ $u->id }}" class="btn btn-warning btn-sm editunit" data-toggle="modal"
                        data-target="#modaleditunit"><i class="bi bi-pencil-square"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="modaleditunit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="v_form_edit_unit">

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

    $(".editunit").on('click', function(event) {
        idunit = $(this).attr('idunit')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                idunit
            },
            url: '<?= route('ambil_detail_unit') ?>',
            success: function(response) {
                $('.v_form_edit_unit').html(response);
                spinner.hide();
            }
        });
    });

    function simpanupdate() {
        spinner = $('#loader')
        spinner.show();
        var data = $('.formedithunit').serializeArray();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                data: JSON.stringify(data),
            },
            url: '<?= route('simpanupdate') ?>',
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
