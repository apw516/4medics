<button class="btn btn-danger" onclick="kembali()"><i class="bi bi-backspace-fill mr-2"></i> Batal</button>
<div class="row mt-3">
    <div class="col-md-4">
        <div class="card" style="height: 595px">
            <div class="card-header">Detail Pasien</div>
            <div class="card-body">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ asset('public/adminlte/dist/img/user4-128x128.jpg') }}"
                                alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center">{{ $pasien[0]->nama_px }}</h3>

                        <p class="text-muted text-center">{{ $pasien[0]->no_rm }}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Nomor Identitas</b> <a class="float-right text-dark">{{ $pasien[0]->nik_bpjs }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Tempat, tanggal lahir</b> <a
                                    class="float-right text-dark">{{ strtoupper($pasien[0]->tempat_lahir) }} |
                                    {{ $pasien[0]->tgl_lahir }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Alamat</b> <a class="float-right text-dark">{{ $pasien[0]->alamat }}</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Form Pendaftaran</div>
            <div class="card-body">
                <div class="card">
                    <div class="card-header bg-light">Riwayat Kunjungan</div>
                    <div class="card-body">
                        <table id="tabelriwayatkunjungan" class="table table-sm table-borderd table-hover">
                            <thead>
                                <th class="text-center">Kunjungan ke</th>
                                <th>Tanggal Masuk</th>
                                <th>Nama Unit</th>
                                <th>Dokter</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                @foreach ($kunjungan as $k )
                                    <tr>
                                        <td class="text-center">{{ $k->counter}}</td>
                                        <td>{{ $k->tgl_masuk}}</td>
                                        <td>{{ $k->nama_unit}}</td>
                                        <td>{{ $k->nama_dokter}}</td>
                                        <td>@if($k->status_kunjungan == 1) Aktif @elseif($k->status_kunjungan == 2) Selesai @else Batal @endif</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <form class="form_pendaftaran_pasien">
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Tanggal Kunjungan</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="tanggalkunjungan" name="tanggalkunjungan"
                                value="{{ $date }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Unit Tujuan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="unittujuan" name="unittujuan">
                            <input hidden type="text" class="form-control" id="idunit" name="idunit">
                            <input hidden type="text" class="form-control" id="rm" name="rm"
                                value="{{ $pasien[0]->no_rm }}">
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <button class="btn btn-success float-right" onclick="simpanpendaftaran()"><i
                        class="bi bi-save mr-2"></i>Simpan</button>
                <button class="btn btn-danger float-right ml-1 mr-1" onclick="kembali()"><i
                        class="bi bi-backspace-fill mr-2"></i>Batal</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#tabelriwayatkunjungan").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            "pageLength": 3,
            "searching": true
        })
    });
    function kembali() {
        $(".v_kedua").attr('hidden', true);
        $(".v_utama").removeAttr('hidden', true);
    }
    function simpanpendaftaran() {
        spinner = $('#loader')
        spinner.show();
        var data = $('.form_pendaftaran_pasien').serializeArray();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                data: JSON.stringify(data),
            },
            url: '<?= route('simpanpendaftaran') ?>',
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
                    }, 4000);
                }
            }
        });
    }
    $(document).ready(function() {
        $('#unittujuan').autocomplete({
            source: "<?= route('cariunit') ?>",
            select: function(event, ui) {
                $('[id="unittujuan"]').val(ui.item.label);
                $('[id="idunit"]').val(ui.item.id);
            }
        });
    });
</script>
