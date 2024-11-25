<div class="row mt-3">
    <div class="col-md-2">
        <div class="form-group">
            <label for="exampleInputEmail1">Cari ID Satu Sehat</label>
            <input type="text" class="form-control" id="nomorktpss" aria-describedby="emailHelp"
                placeholder="Masukan nomor ktp ...">
        </div>
    </div>
    <div class="col-md-2">
        <button class="btn btn-success caripasiensatusehat" style="margin-top:32px" onclick="caripasienss()"
            data-toggle="modal" data-target="#modalcaripasienihs"><i class="bi bi-search mr-2"></i>Cari Pasien Satu
            Sehat</button>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalcaripasienihs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Pasien</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="v_data_px_s">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<table id="tabelpasien" class="table table-sm table-bordered text-sm table-hover">
    <thead>
        <th>No RM</th>
        <th>Id Satu Sehat</th>
        <th>No Identitas</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
        <th>Jenis Kelamin</th>
        <th>Alamat</th>
        <th>Action</th>
    </thead>
    <tbody>
        @foreach ($pasien as $p)
            <tr>
                <td>{{ $p->no_rm }}</td>
                <td>{{ $p->id_satu_sehat }}</td>
                <td>{{ $p->NIK }}</td>
                <td>{{ $p->nama_pasien }}</td>
                <td>{{ $p->TGL_LAHIR }}</td>
                <td>{{ $p->jenis_kelamin }}</td>
                <td>{{ $p->alamat }}</td>
                <td>
                    <button class="btn btn-xs btn-success kirimsatusehat" rm="{{ $p->no_rm }}"><i
                            class="bi bi-send"></i></button>
                    <button class="btn btn-xs btn-warning inputdatasatusehat" rm="{{ $p->no_rm }}"
                        nama="{{ $p->nama_pasien }}" data-toggle="modal" data-target="#modalinputidsatusehat"><i
                            class="bi bi-pencil-square"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="modalinputidsatusehat" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Masukan ID Satu Sehat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="formupdatesatusehat">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nomor RM</label>
                        <input type="text" class="form-control" id="rmpasien" name="rmpasien"
                            aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Pasien</label>
                        <input type="text" class="form-control" id="namapasien1" name="namapasien1"
                            aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">ID Satu Sehat</label>
                        <input type="text" class="form-control" id="idsatusehatpasien" name="idsatusehatpasien">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updatemtpsaienihs()">SIMPAN</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $("#tabelpasien").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            "pageLength": 6,
            "searching": true
        })
    });
    $('#tabelpasien').on('click', '.kirimsatusehat', function() {
        rm = $(this).attr('rm')
        Swal.fire({
            title: "Data pasien akan dikirim ke satu sehat ?",
            text: "Klik cancel untuk batal",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, kirim!"
        }).then((result) => {
            if (result.isConfirmed) {
                kirimsatusehat(rm)
            }
        });
    });

    function kirimsatusehat(rm) {
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                rm
            },
            url: '<?= route('kirimdatapasiensatusehat') ?>',
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

    function updatemtpsaienihs() {
        spinner = $('#loader')
        spinner.show();
        var data = $('.formupdatesatusehat').serializeArray();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                data: JSON.stringify(data),
            },
            url: '<?= route('editpasienihs') ?>',
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

    function caripasienss() {
        nomorktp = $('#nomorktpss').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                nomorktp
            },
            url: '<?= route('caripasienihs') ?>',
            error: function(response) {
                spinner.hide()
                alert('error')
            },
            success: function(response) {
                spinner.hide()
                $('.v_data_px_s').html(response);
            }
        });
    }
    $(".inputdatasatusehat").on('click', function(event) {
        rm = $(this).attr('rm')
        nama = $(this).attr('nama')
        $('#rmpasien').val(rm)
        $('#namapasien1').val(nama)
    });
</script>
