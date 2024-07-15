@extends('Templates.main')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Info Akun</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form>
                <div class="form-group row">
                  <label for="staticEmail" class="col-sm-2 col-form-label">Nama</label>
                  <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ strtoupper(auth()->user()->nama) }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Username</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control-plaintext" id="inputPassword" value="{{ auth()->user()->username }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Unit</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control-plaintext" id="inputPassword" value="{{ strtoupper($data[0]->nama_unit) }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Hak Akses</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control-plaintext" id="inputPassword" value="{{ strtoupper(auth()->user()->hak_akses) }}">
                  </div>
                </div>
              </form>
        </div><!--/. container-fluid -->
    </section>
    <script>
        $(".preloader2").fadeOut();
    </script>
@endsection
