@extends('Templates.main')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Master Tarif</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Master Tarif</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            {{-- <button class="btn btn-success" data-toggle="modal" data-target="#modaltambahunit"><i
                    class="bi bi-plus  mr-1 ml-1"></i> Tambah Unit</button> --}}
            <div class="card mt-3">
                <div class="card-header">Data Master Tarif</div>
                <div class="card-body">
                    <button class="btn btn-success" data-toggle="modal" data-target="#modaltambahpegawai"><i
                            class="bi bi-plus  mr-1 ml-1"></i> Tambah Tarif</button>
                    <div class="v_utama">

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="modaltambahpegawai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Tarif</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="formtambahtarif">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama Tarif</label>
                            <input type="text" class="form-control" id="namatarif" name="namatarif"
                                placeholder="masukan nama ...">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tarif</label>
                            <input type="text" class="form-control" id="tarif" name="tarif"
                                placeholder="masukan harga ...">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Jenis Tarif</label>
                            <select class="form-control" id="hakakses" name="jenistarif">
                                <option value="0">Silahkan Pilih</option>
                                <option value="NON-PAKET">NON-PAKET</option>
                                <option value="NON-PAKET">PAKET</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Unit</label>
                            <select class="form-control" id="unittarif" name="unittarif">
                                <option value="0">Silahkan Pilih</option>
                                @foreach ($mt_unit as $u )
                                <option value="{{ $u->kode_unit }}">{{ $u->nama_unit}}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="simpantarifbaru()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(".preloader2").fadeOut();
        $(document).ready(function() {
            ambilmastertarif()
        })

        function ambilmastertarif() {
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                url: '<?= route('ambilmastertarif') ?>',
                error: function(response) {
                    spinner.hide()
                    alert('error')
                },
                success: function(response) {
                    spinner.hide()
                    $('.v_utama').html(response);
                }
            });
        }
        function simpantarifbaru() {
            spinner = $('#loader')
            spinner.show();
            var data = $('.formtambahtarif').serializeArray();
            $.ajax({
                async: true,
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    data: JSON.stringify(data),
                },
                url: '<?= route('simpantarifbaru') ?>',
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
    </script>
@endsection
