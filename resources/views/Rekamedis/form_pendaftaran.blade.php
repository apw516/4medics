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
                                <th>Hasil Pemeriksaan</th>
                            </thead>
                            <tbody>
                                @foreach ($kunjungan as $k)
                                    <tr>
                                        <td class="text-center">{{ $k->counter }}</td>
                                        <td>{{ $k->tgl_masuk }}</td>
                                        <td>{{ $k->nama_unit }}</td>
                                        <td>{{ $k->nama_dokter }}</td>
                                        <td>
                                            @if ($k->status_kunjungan == 1)
                                                Aktif
                                            @elseif($k->status_kunjungan == 2)
                                                Selesai
                                            @else
                                                Batal
                                            @endif
                                        </td>
                                        <td>
                                            <button kode_kunjungan="{{ $k->kode_kunjungan }}" class="btn btn-info btn-sm pilihkunjungan" data-toggle="modal" data-target="#modalresume2"><i
                                                class="bi bi-info-circle"></i></button>
                                        </td>
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
                    <div class="card">
                        <div class="card-header bg-warning">Pemeriksaan Tanda Tanda Vital</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tekanan Darah</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder=""
                                                aria-label="Recipient's username" aria-describedby="basic-addon2" name="tekanandarah">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">mmHg</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Frekunesi Nafas</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder=""
                                                aria-label="Recipient's username" aria-describedby="basic-addon2" name="frekuensinafas">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">x/menit</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Suhu tubuh</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder=""
                                                aria-label="Recipient's username" aria-describedby="basic-addon2" name="suhutubuh">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">°C</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tinggi badan</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder=""
                                                aria-label="Recipient's username" aria-describedby="basic-addon2" name="tinggibadan">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">Cm</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Berat badan</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder=""
                                                aria-label="Recipient's username" aria-describedby="basic-addon2" name="beratbadan">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">Kg</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Usia pasien</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder=""
                                                aria-label="Recipient's username" aria-describedby="basic-addon2" name="usiapasien">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">tahun</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Keluhan Pasien</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="keluhanutama"></textarea>
                                    </div>
                                </div>
                            </div>
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
<!-- Modal -->
<div class="modal fade" id="modalresume2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        $("#tabelriwayatkunjungan").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            "pageLength": 3,
            "ordering": false,
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
    $(".pilihkunjungan").on('click', function(event) {
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
</script>
