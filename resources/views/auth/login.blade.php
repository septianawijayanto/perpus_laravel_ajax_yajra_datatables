<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
    <title>Login | Perpus</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{asset('klorofil')}}/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('klorofil')}}/assets/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('klorofil')}}/assets/vendor/linearicons/style.css">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{asset('klorofil')}}/assets/css/main.css">
    <!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
    <link rel="stylesheet" href="{{asset('klorofil')}}/assets/css/demo.css">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('klorofil')}}/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('klorofil')}}/assets/img/favicon.png">
</head>

<body>
    <!-- WRAPPER -->
    <div id="wrapper">
        <div class="vertical-align-wrap">
            <div class="vertical-align-middle">
                <div class="auth-box ">
                    <div class="left">
                        <div class="content">
                            <div class="header">
                                <div class="logo text-center"><img src="{{asset('gambar')}}/Logo.png" alt="Klorofil Logo"></div>
                                <h4 class="lead">Selamat Datang</h4>
                            </div>

                            @include('auth.alert')

                            <form class="form-auth-small" method="POST" action="{{ url('post/login') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="signin-email" class="control-label sr-only">Username</label>
                                    <input type="text" name="username" class="form-control" required id="signin-email" value="{{ old('username') }}" placeholder="Username">
                                    @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="signin-password" class="control-label sr-only">Password</label>
                                    <input type="password" name="password" class="form-control" required id="signin-password" value="{{ old('password') }}" placeholder="Password">
                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>


                                <select class="form-control" name="masuk_sebagai" id="masuk_sebagai" required>
                                    <option value="">--Login Sebagai--</option>
                                    <option value="admin">Admin</option>
                                    <option value="anggota">Anggota</option>
                                </select>
                                <div class="form-group clearfix">
                                    <label class="fancy-checkbox element-left">
                                        <input type="checkbox">
                                        <span>Remember me</span>
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
                                <div class="bottom">
                                    <span class="helper-text"><i class="fa fa-lock"></i> <a href="#">Forgot password?</a></span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="right">
                        <div class="overlay"></div>
                        <div class="content text">
                            <h1 class="heading">Sistem Informasi Perpustakaan</h1>
                            <p>SMP Negeri 9 Tebo</p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- END WRAPPER -->

</body>

</html>