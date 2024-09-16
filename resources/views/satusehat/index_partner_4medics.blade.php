@extends('Templates.main')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Part Of 4medics</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Part Of 4medics</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <button class="btn btn-success" data-toggle="modal" data-target="#modaltambahunit"><i
                    class="bi bi-plus  mr-1 ml-1"></i> Tambah Unit</button>
            <div class="card mt-3">
                <div class="card-header">Data Part Of 4medics</div>
                <div class="card-body">
                    <div class="v_utama">

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
    </script>
@endsection
