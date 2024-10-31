@extends('Templates.main')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Struktur Organisai Dan Lokasi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Struktur Organisai Dan Lokasi</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <button class="btn btn-success tambahukp" data-toggle="modal" data-target="#modaltambahukp"><i
                    class="bi bi-plus  mr-1 ml-1"></i> Create UKP / Kefarmasian / Lab</button>

            <button class="btn btn-warning tambahkoordpoli" data-toggle="modal" data-target="#modaltambahkoord"><i
                    class="bi bi-plus  mr-1 ml-1"></i> Create Koord Poli</button>

            <button class="btn btn-danger" data-toggle="modal" data-target="#modaltambahruangan"><i
                    class="bi bi-plus  mr-1 ml-1"></i> Create Ruangan Poli</button>

            <div class="card mt-3">
                <div class="card-header">Data Organization Part Of 4medics</div>
                <div class="card-body">
                    <div class="v_utama">

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modaltambahukp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create UKP / Kefarmasian / Lab</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="v_form_add_ukp">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="simpanukp()">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modaltambahkoord" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Koord Poli</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="v_form_add_koord_poli">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="simpankoord()">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modaltambahruangan" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Ruangan Poli</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(".preloader2").fadeOut();
        $(document).ready(function() {
            ambilldatapartner()
        })
        function simpanukp()
        {
            spinner = $('#loader')
            spinner.show();
            var data = $('.formaddukp').serializeArray();
            $.ajax({
                async: true,
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    data: JSON.stringify(data),
                },
                url: '<?= route('simpanukpbaru') ?>',
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
                        $('.formaddukp').find('input:text').val('');
                    }
                }
            });
        }
        function simpankoord()
        {
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
                url: '<?= route('simpankoordbaru') ?>',
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
                        $('.formaddkoordpoli').find('input:text').val('');
                    }
                }
            });
        }
        function ambilldatapartner() {
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                url: '<?= route('ambildatapartner') ?>',
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

        $(".tambahukp").on('click', function(event) {
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                url: '<?= route('ambil_form_add_ukp') ?>',
                success: function(response) {
                    $('.v_form_add_ukp').html(response);
                    spinner.hide();
                }
            });
        });

        $(".tambahkoordpoli").on('click', function(event) {
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                url: '<?= route('ambil_form_add_koord_poli') ?>',
                success: function(response) {
                    $('.v_form_add_koord_poli').html(response);
                    spinner.hide();
                }
            });
        });
    </script>
@endsection
