<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - {{SITE_TITLE}}</title>

    <link rel="icon" href="{{asset('resources/super-admin/images/favicon.png')}}" type="image/gif" sizes="16x16">

    <!--Bootsrap 4 CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <!--Custom styles-->
    <link rel="stylesheet" type="text/css" href="{{asset('resources/super-admin/css/login.css')}}">
    <!------ Include the above in your HEAD tag ---------->
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-center h-100">
        <div class="card">
            <div class="card-header">
                {{--<h3>Lavella</h3>--}}
                <div class="d-flex justify-content-center" style="margin:20px 0 20px 0;">
                    {{--<h3 class="text-dark">Administration</h3>--}}
                    <img src="{{asset('resources/super-admin/images/logo-white.png')}}" style="width:140px;">
                </div>
            </div>
            <div class="card-body">
                <form id="sign_in" method="POST" action="{{route('superadmin.login')}}">
                    {!! csrf_field() !!}
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control"  placeholder="Username" name="username" id="username" value="{{old('username')}}" autofocus>
                    </div>
                    @if ($errors->has('username'))
                        <span class="help-block">
                            <p style="color:red">{{ $errors->first('username') }}</p>
                        </span>
                    @endif
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    </div>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <p style="color:red">{{ $errors->first('password') }}</p>
                        </span>
                    @endif

                    {{--<div class="row align-items-center remember">--}}
                    {{--<input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>Remember Me--}}
                    {{--</div>--}}
                    <div class="form-group">
                        <input type="submit" value="Login" class="btn float-right login_btn">
                    </div>
                </form>
            </div>
            <div class="col-12 text-center" style="border-top: 1px solid #c2c2c2;padding: 6px;max-height: 32px;">
                <a href="{{route('home.index')}}">
                    <h6 class="text-white">Visit Site <i class="fa fa-globe"></i></h6>
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>