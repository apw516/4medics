<table id="tablepartof2" class="table table-sm table-bordered">
    <thead>
        <th>ID</th>
        <th>NAMA</th>
        <th>Part Of</th>
        <th>Referensi</th>
        <th>Alamat</th>
        <th>===</th>
    </thead>
    <tbody>
        @foreach ($p['data'] as $ad )
            <tr>
                <td>{{ $ad->resource->id}}</td>
                <td>{{ $ad->resource->name}}</td>
                <td>{{ $ad->resource->partOf->display}}</td>
                <td>{{ $ad->resource->partOf->reference}}</td>
                <td>{{ $ad->resource->address[0]->city}}</td>
                <td>
                    <button class="btn btn-info pilihpartof" idorganization="{{ $ad->resource->id}}" data-toggle="modal"
                        data-target="#modaldetaillocation">Info</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="modaldetaillocation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="v_data_location">

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
        $("#tablepartof2").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            "pageLength": 8,
            "searching": true,
            "ordering": false
        })
    });
    $(".pilihpartof2").on('click', function(event) {
        idorganization = $(this).attr('idorganization')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                idorganization
            },
            url: '<?= route('ambil_loaction_by_orgId') ?>',
            success: function(response) {
                $('.v_data_location').html(response);
                spinner.hide();
            }
        });
    });
