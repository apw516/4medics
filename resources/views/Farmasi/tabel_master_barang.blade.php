<table id="tabelmasterbarang" class="table table table-sm table-hover table-bordered text-sm">
    <thead>
        <th>Kode barang</th>
        <th>Nama barang</th>
        <th>Nama Generik</th>
        <th>Aturan Pakai</th>
        <th>Dosis</th>
        <th>Satuan Besar</th>
        <th>Satuan Sedang</th>
        <th>Sediaan</th>
        <th></th>
    </thead>
    <tbody>
        @foreach ($master_barang as $mb)
            <tr>
                <td>{{ $mb->kode_barang }}</td>
                <td>{{ $mb->nama_barang }}</td>
                <td>{{ $mb->nama_generik }}</td>
                <td>{{ $mb->aturan_pakai }}</td>
                <td>{{ $mb->dosis }}</td>
                <td>{{ $mb->satuan_besar }}</td>
                <td>{{ $mb->satuan }}</td>
                <td>{{ $mb->sediaan }}</td>
                <td>
                    <button class="btn btn-sm btn-warning editobat"  kodebarang ="{{ $mb->id }}" data-toggle="modal" data-target="#modaleditbarang"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-sm btn-success mr-1 ml-1 pilihobat" kodebarang ="{{ $mb->id }}"
                        data-toggle="modal" data-target="#modaladdstok"><i class="bi bi-database-fill-add"></i></button>
                    <button class="btn btn-sm btn-info liatstok" kodebarang ="{{ $mb->kode_barang }}"
                        data-toggle="modal" data-target="#modalinfostok"><i class="bi bi-info-circle"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="modaladdstok" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Masukan Stok Obat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form_stok_obat">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="simpanstok()" data-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modaleditbarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Masukan Stok Obat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form_edit_obat">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="simpanupdatebarang()" data-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalinfostok" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Info Stok Obat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="v_stok_obat">

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
        $("#tabelmasterbarang").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            "pageLength": 10,
            "searching": true,
            "ordering": false
        })
    });
    $(".pilihobat").on('click', function(event) {
        id = $(this).attr('kodebarang')
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                id
            },
            url: '<?= route('ambilformaddstok') ?>',
            error: function(response) {
                spinner.hide()
                alert('error')
            },
            success: function(response) {
                spinner.hide()
                $('.form_stok_obat').html(response);
            }
        });
    });
    $(".liatstok").on('click', function(event) {
        id = $(this).attr('kodebarang')
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                id
            },
            url: '<?= route('liatstokobat') ?>',
            error: function(response) {
                spinner.hide()
                alert('error')
            },
            success: function(response) {
                spinner.hide()
                $('.v_stok_obat').html(response);
            }
        });
    });
    $(".editobat").on('click', function(event) {
        id = $(this).attr('kodebarang')
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                id
            },
            url: '<?= route('formeditobat') ?>',
            error: function(response) {
                spinner.hide()
                alert('error')
            },
            success: function(response) {
                spinner.hide()
                $('.form_edit_obat').html(response);
            }
        });
    });
    function simpanstok()
    {
        spinner = $('#loader')
            spinner.show();
            var data = $('.formaddstokmasuk').serializeArray();
            $.ajax({
                async: true,
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    data: JSON.stringify(data),
                },
                url: '<?= route('simpanstokbarang') ?>',
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
                    }
                }
            });
    }
    function simpanupdatebarang()
    {
        spinner = $('#loader')
            spinner.show();
            var data = $('.formeditbarang').serializeArray();
            $.ajax({
                async: true,
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    data: JSON.stringify(data),
                },
                url: '<?= route('updatestokbarang') ?>',
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
