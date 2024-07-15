<!doctype html>
<html lang="en">

<head>
    <title>Login 08</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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
                            <img class="" width="60%" src="{{ asset('public/img/4medics.png')}}" alt="">
                        </div>
                        <div class="mb-4">
                            @if(session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button class="btn-close" data-bs-dismiss="alert" aria-label="close" type="button"></button>
                            </div>
                            @endif
                            @if(session()->has('loginError'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('loginError') }}
                                <button class="btn-close" data-bs-dismiss="alert" aria-label="close" type="button"></button>
                            </div>
                            @endif
                        </div>
                        <h3 class="text-center mb-4" style="color: black">Silahkan Login</h3>
                        <form action="{{ route('login')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control rounded-left" placeholder="Username" name="username" id="username">
                            </div>
                            <div class="form-group d-flex">
                                <input type="password" class="form-control rounded-left" placeholder="Password"
                                   name="password" id="password">
                            </div>
                            <div class="form-group d-md-flex">
                                <div class="w-50">
                                    <label class="checkbox-wrap checkbox-primary" style="color: black">Tidak punya akun ?</span>
                                    </label>
                                </div>
                                <div class="w-10 text-md-right">
                                    <a href="" style="color:blue">Daftar</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn rounded submit p-3 px-5 text-light" style="background-color: rgb(210, 66, 66)" href="">Login</button>
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
