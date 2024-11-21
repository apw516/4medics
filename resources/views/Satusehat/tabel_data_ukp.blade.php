<table id="tabelukp" class="table table-sm table-bordered table-hover">
    <thead>
        <th>ID satu sehat</th>
        <th>Nama</th>
        <th>Nama Display</th>
        <th>Nomor Telp</th>
        <th>Email</th>
        <th>Website</th>
        <th>Kota</th>
        <th>Alamat</th>
        <th>Tgl Entry</th>
        <th>Action</th>
    </thead>
    <tbody>
        @foreach ($DATA as $D)
            <tr>
                <td>{{ $D->id_satu_sehat }}</td>
                <td>{{ $D->nama_ukp }}</td>
                <td>{{ $D->nama_display }}</td>
                <td>{{ $D->nomor_telp }}</td>
                <td>{{ $D->email }}</td>
                <td>{{ $D->website }}</td>
                <td>{{ $D->kota }}</td>
                <td>{{ $D->alamat }}</td>
                <td>{{ $D->tgl_entry }}</td>
                <td>
                    <button class="btn btn-info pilihorganization" idtabel="{{ $D->id }}"
                        idorganization="{{ $D->id_satu_sehat }}" data-toggle="modal" data-target="#modaladdpoliruang"><i
                            class="bi bi-plus-lg mr-1 ml-1"></i> Poli ( Ruang )</button>
                    <button class="btn btn-info pilihorganization2" idtabel="{{ $D->id }}"
                        idorganization="{{ $D->id_satu_sehat }}" data-toggle="modal" data-target="#modaladdpoliorg"><i
                            class="bi bi-plus-lg mr-1 ml-1"></i> Poli ( Org )</button>
                            <button class="btn btn-success infopoli" idtabel="{{ $D->id }}" data-toggle="modal" data-target="#modalinfopoli"><i class="bi bi-info-circle mr-1 ml-1"></i> Info Poli</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="modaladdpoliruang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">INPUT DATA POLI ( RUANG )</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="formaddpoliruang">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Poli</label>
                        <input type="email" class="form-control" id="namapoli" name="namapoli"
                            aria-describedby="emailHelp" placeholder="Masukan Nama UKP, FARMASI, LABORATORIUM ...">
                        <input type="email" class="form-control" id="idorganization" name="idorganization"
                            aria-describedby="emailHelp" placeholder="Masukan Nama UKP, FARMASI, LABORATORIUM ...">
                        <input type="email" class="form-control" id="idtable" name="idtable"
                            aria-describedby="emailHelp" placeholder="Masukan Nama UKP, FARMASI, LABORATORIUM ...">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Deskripsi</label>
                        <input type="email" class="form-control" id="deskripsi" name="deskripsi"
                            aria-describedby="emailHelp" placeholder="Nama Display UKP, FARMASI, LABORATORIUM ...">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tipe</label>
                        <select class="form-control" id="tipe" name="tipe">
                            <option value="-">Silahkan Pilih</option>
                            @foreach ($tipe as $t)
                                <option value="{{ $t->code }}">{{ $t->display }} | {{ $t->definition }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Posisi Longitude</label>
                        <input type="email" class="form-control" id="posisilongitude" name="posisilongitude"
                            aria-describedby="emailHelp" placeholder="Masukan kode pos ...">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Posisi Latitude</label>
                        <input type="email" class="form-control" id="posisilatitude" name="posisilatitude"
                            aria-describedby="emailHelp" placeholder="Masukan kode pos ...">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Posisi Altitude</label>
                        <input type="email" class="form-control" id="posisialtitude" name="posisialtitude"
                            aria-describedby="emailHelp" placeholder="Masukan kode pos ...">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="simpanpoliruang()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalinfopoli" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Info Poli Organization</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="v_tabel_poli">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modaladdpoliorg" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Data Koordinator Poli</h5>
                <button disabled type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="formaddkoordpoli">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Lengkap</label>
                        <input type="email" class="form-control" id="namalengkap" name="namalengkap" aria-describedby="emailHelp">
                        <input type="email" class="form-control" id="idtabel" name="idtabel" aria-describedby="emailHelp">
                        <input type="email" class="form-control" id="idorganization2" name="idorganization2" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">No Telp</label>
                        <input type="email" class="form-control" id="notelp" name="notelp" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Alamat Kota</label>
                        <input type="email" class="form-control" id="alamatkota" name="alamatkota" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Alamat Jalan</label>
                        <input type="email" class="form-control" id="alamatjalan" name="alamatjalan" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kode Pos</label>
                        <input type="email" class="form-control" id="kodepos" name="kodepos" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Provinsi</label>
                        <input type="email" class="form-control" id="provinsiorg" name="provinsiorg"
                            aria-describedby="emailHelp" placeholder="Pilih Provinsi ...">
                        <input readonly type="email" class="form-control" id="kodeprovinsiorg" name="kodeprovinsiorg"
                            aria-describedby="emailHelp" placeholder="Pilih Provinsi ...">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kabupaten/Kota</label>
                        <input type="email" class="form-control" id="kabupatenorg" name="kabupatenorg"
                            aria-describedby="emailHelp" placeholder="Pilih Kabupaten / Kota">
                        <input readonly type="email" class="form-control" id="kodekabupatenorg"
                            name="kodekabupatenorg" aria-describedby="emailHelp" placeholder="Pilih Kabupaten / Kota">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kecamatan</label>
                        <input type="email" class="form-control" id="kecamatanorg" name="kecamatanorg"
                            aria-describedby="emailHelp" placeholder="Pilih Kecamatan ...">
                        <input readonly type="email" class="form-control" id="kodekecamatanorg"
                            name="kodekecamatanorg" aria-describedby="emailHelp" placeholder="Pilih Kecamatan ...">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Desa</label>
                        <input type="email" class="form-control" id="desaorg" name="desaorg"
                            aria-describedby="emailHelp" placeholder="Pilih Desa ...">
                        <input readonly type="email" class="form-control" id="kodedesaorg" name="kodedesaorg"
                            aria-describedby="emailHelp" placeholder="Pilih Desa ...">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="simpankoordpoli()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#tabelukp").DataTable({
            "responsive": false,
            "lengthChange": false,
            "autoWidth": true,
            "pageLength": 8,
            "searching": true,
            "ordering": false
        })
    });
    $(document).ready(function() {
        $('#provinsiorg').autocomplete({
            source: "<?= route('cariprovinsi') ?>",
            select: function(event, ui) {
                $('[id="provinsiorg"]').val(ui.item.label);
                $('[id="kodeprovinsiorg"]').val(ui.item.id);
            }
        });
        $('#kabupatenorg').autocomplete({
            source: function(request, response) {
                $.getJSON("<?= route('carikabupaten') ?>", {
                        id: $('#kodeprovinsiorg').val(),
                        kabupaten: $('#kabupatenorg').val(),
                    },
                    response);
            },
            select: function(event, ui) {
                $('[id="kabupatenorg"]').val(ui.item.label);
                $('[id="kodekabupatenorg"]').val(ui.item.id);
            }
        });
        $('#kecamatanorg').autocomplete({
            source: function(request, response) {
                $.getJSON("<?= route('carikecamatan') ?>", {
                        id: $('#kodekabupatenorg').val(),
                        kecamatan: $('#kecamatanorg').val(),
                    },
                    response);
            },
            select: function(event, ui) {
                $('[id="kecamatanorg"]').val(ui.item.label);
                $('[id="kodekecamatanorg"]').val(ui.item.id);
            }
        });
        $('#desaorg').autocomplete({
            source: function(request, response) {
                $.getJSON("<?= route('caridesa') ?>", {
                        id: $('#kodekecamatanorg').val(),
                        desa: $('#desaorg').val(),
                    },
                    response);
            },
            select: function(event, ui) {
                $('[id="desaorg"]').val(ui.item.label);
                $('[id="kodedesaorg"]').val(ui.item.id);
            }
        });
    });
    $(".pilihorganization").on('click', function(event) {
        idorganization = $(this).attr('idorganization')
        idtabel = $(this).attr('idtabel')
        $('#idorganization').val(idorganization)
        $('#idtable').val(idtabel)
    });
    $(".pilihorganization2").on('click', function(event) {
        idorganization = $(this).attr('idorganization')
        idtabel = $(this).attr('idtabel')
        $('#idtabel').val(idtabel)
        $('#idorganization2').val(idorganization)
    });
    $(".infopoli").on('click', function(event) {
        idtabel = $(this).attr('idtabel')
        $.ajax({
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",idtabel
                },
                url: '<?= route('ambildatapoli') ?>',
                error: function(response) {
                    spinner.hide()
                    alert('error')
                },
                success: function(response) {
                    spinner.hide()
                    $('.v_tabel_poli').html(response);
                }
            });
    });

    function simpanpoliruang() {
        spinner = $('#loader')
        spinner.show();
        var data = $('.formaddpoliruang').serializeArray();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                data: JSON.stringify(data),
            },
            url: '<?= route('simpandatapoli') ?>',
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
                    $('#modaladdpoliruang').modal('toggle')
                    Swal.fire({
                        icon: 'success',
                        title: 'OK',
                        text: data.message,
                        footer: ''
                    })
                    setTimeout(function() {
                        spinner.hide()
                        ambildataukp()
                    }, 4000);
                }
            }
        });
    }
    function simpankoordpoli() {
        spinner = $('#loader')
        spinner.show();
        var data = $('.formaddkoordpoli').serializeArray();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                data: JSON.stringify(data),
            },
            url: '<?= route('simpandatakoordpoli') ?>',
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
                    $('#modaladdpoliorg').modal('toggle')
                    Swal.fire({
                        icon: 'success',
                        title: 'OK',
                        text: data.message,
                        footer: ''
                    })
                    setTimeout(function() {
                        spinner.hide()
                        ambildataukp()
                    }, 4000);
                }
            }
        });
    }
</script>
