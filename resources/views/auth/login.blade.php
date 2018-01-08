<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<!--<![endif]-->

<head>
	<meta charset="utf-8" />
	<title>{{ config('app.name', 'Login') }}</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
	<link href="{{ asset('public/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('public/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('public/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('public/css/animate.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('public/css/style.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('public/css/style-responsive.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('public/css/theme/default.css') }}" rel="stylesheet" id="theme" />
	<!-- ================== END BASE CSS STYLE ================== -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{ asset('public/plugins/pace/pace.min.js') }}"></script>
	<!-- ================== END BASE JS ================== -->
</head>
<body class="pace-top bg-white">
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<div id="page-container" class="fade">
        <div class="login login-with-news-feed">
            <div class="news-feed">
                <div class="news-image">
                    <img src="{{ asset('public/img/bg-7.jpg') }}" data-id="login-cover-image" alt="" />
                </div>
                <div class="news-caption">
                    <h4 class="caption-title">CARGO SERVICE - JAWA, BALI, SUMATRA</h4>
                    <p>
                        Perum. Taman Hedona, Blok B5/3, Lingkar Timur, Siduarjo, Telp./Fax: (031) 807 6110, (031) 716 25334
                    </p>
                </div>
            </div>
            <div class="right-content">
                <div class="login-header">
                    <div class="brand">
                        <div align="center" style="padding-bottom: 20px"><img src="{{ asset('public/img/jp-logo.png') }}" data-id="login-cover-image" width="100px" alt="" /></div>
                        <img src="{{ asset('public/img/jp-name-logo.png') }}" data-id="login-cover-image" width="380px" alt="" />
                        <small></small>
                    </div>
                    <!-- <div class="icon">
                        <i class="fa fa-sign-in"></i>
                    </div> -->
                </div>
                <div class="login-content">
                    <form class="margin-bottom-0" method="POST" action="{{ route('login') }}">
                        <div class="form-group m-b-15 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input type="text" class="form-control input-lg" name="email" id="email" placeholder="Email Address" value="{{ old('email') }}" autofocus />
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group m-b-15 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input type="password" id="password" class="form-control input-lg" name="password" placeholder="Password" />
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="checkbox m-b-30">
                            <label>
                                <input type="checkbox"  name="remember_me" /> Remember Me
                            </label>
                        </div>
                        <div class="login-buttons">
                            <button type="submit" class="btn btn-primary btn-block btn-lg">Sign in</button>
                        </div>
                        <!-- <div class="m-t-20 m-b-40 p-b-40">
                            Not a member yet? Click <a href="register_v3.html" class="text-success">here</a> to register.
                        </div> -->
                        <hr />
                        <p class="text-center text-inverse">
                            &copy; Fifty Two All Right Reserved {{ date("Y") }}
                        </p>
                    </form>
                </div>
                <!-- end login-content -->
            </div>
            <!-- end right-container -->
        </div>
        <!-- end login -->
	</div>
	<!-- end page container -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{ asset('public/plugins/jquery/jquery-1.9.1.min.js') }}"></script>
	<script src="{{ asset('public/plugins/jquery/jquery-migrate-1.1.0.min.js') }}"></script>
	<script src="{{ asset('public/plugins/jquery-ui/ui/minified/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('public/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
	<!--[if lt IE 9]>
		<script src="{{ asset('public/crossbrowserjs/html5shiv.js') }}"></script>
		<script src="{{ asset('public/crossbrowserjs/respond.min.js') }}"></script>
		<script src="{{ asset('public/crossbrowserjs/excanvas.min.js') }}"></script>
	<![endif]-->
	<!-- <script src="{{ asset('public/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script> -->
	<script src="{{ asset('public/plugins/jquery-cookie/jquery.cookie.js') }}"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="{{ asset('public/js/apps.min.js') }}"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->

	<script>
		$(document).ready(function() {
			App.init();
		});
	</script>
	<script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-XXXXX-Y', 'auto');
        ga('send', 'pageview');
    </script>
</body>
</html>
