<!doctype html>
<html lang="en">

<head>
    <title>4Medics</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="{{ asset('public/img/4medics2.png') }}">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('public/login-form-18/css/style.css') }}">

</head>

<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-2">
                    <h2 class="heading-section text-bold"></h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="login-wrap p-4 p-md-5">
                        <div class="d-flex align-items-center justify-content-center mb-4">
                            <img class="" width="60%" src="{{ asset('public/img/4medics.png') }}"
                                alt="">
                        </div>
                        <div class="mb-4">
                            @if (session()->has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button class="btn-close" data-bs-dismiss="alert" aria-label="close"
                                        type="button"></button>
                                </div>
                            @endif
                            @if (session()->has('loginError'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('loginError') }}
                                    <button class="btn-close" data-bs-dismiss="alert" aria-label="close"
                                        type="button"></button>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-center mb-4" style="color: black">Silahkan Registrasi</h3>
                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Lengkap</label>
                                <input type="text" class="form-control" id="namalengkap" name="namalengkap"
                                    aria-describedby="emailHelp">
                                @error('namalengkap')
                                    <small id="emailHelp" class="form-text text-danger">Nama Tidak Boleh Kosong !</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Username</label>
                                <input type="text" class="form-control" id="username" name="username">
                                @error('username')
                                    <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Hak Akses</label>
                                <select class="form-control" id="hakakses" name="hakakses">
                                    <option value="1">Super Admin</option>
                                    <option value="2">Admin</option>
                                    <option value="3">Dokter</option>
                                    <option value="4">Farmasi</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Pilih Unit</label>
                                <select class="form-control" id="unit" name="unit">
                                    <option value="0">Silahkan Pilih</option>
                                    @foreach ($unit as $i )
                                    <option value="{{ $i->kode_unit }}">{{ $i->nama_unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                                @error('password')
                                <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Retype Password</label>
                                <input type="password" class="form-control" id="password2" name="password2">
                            </div>
                            {{-- <div class="form-group">
                                <input type="text" class="form-control rounded-left" placeholder="Username" name="username" id="username">
                            </div>
                            <div class="form-group d-flex">
                                <input type="password" class="form-control rounded-left" placeholder="Password"
                                   name="password" id="password">
                            </div> --}}
                            <div class="form-group d-md-flex">
                                <div class="w-50">
                                    <label class="checkbox-wrap checkbox-primary" style="color: black">Sudah punya akun
                                        ?</span>
                                    </label>
                                </div>
                                <div class="w-10 text-md-right">
                                    <a href="{{ route('/login') }}" style="color:blue">Register</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn rounded submit p-3 px-5 text-light"
                                    style="background-color: rgb(210, 66, 66)" href="">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('public/login-form-18/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/login-form-18/js/popper.js') }}"></script>
    <script src="{{ asset('public/login-form-18/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/login-form-18/js/main.js') }}"></script>
</body>

</html>
