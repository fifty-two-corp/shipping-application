<!DOCTYPE html>
<html lang="en">
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>CV. JUJUR PERKASA</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="{{ asset('public/css/fontgoogleapis.css') }}" rel="stylesheet" />
	<link href="{{ asset('public/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('public/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('public/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('public/css/animate.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('public/css/style.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('public/css/project.css') }}" rel="stylesheet" />
	<link href="{{ asset('public/css/style-responsive.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('public/css/theme/default.css') }}" rel="stylesheet" id="theme" />
	<!-- ================== END BASE CSS STYLE ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
  <link href="{{ asset('public/plugins/DataTables/css/data-table.css') }}" rel="stylesheet" />
  <link href="{{ asset('public/plugins/DataTables/css/dataTables.searchHighlight.css') }}" rel="stylesheet" />
  <link href="{{ asset('public/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
  <link href="{{ asset('public/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}" rel="stylesheet" />
  <link href="{{ asset('public/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" />
  <link href="{{ asset('public/plugins/bootstrap-datepicker/css/datepicker.css') }}" rel="stylesheet" />
  <link href="{{ asset('public/plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" />
  <link href="{{ asset('public/plugins/gritter/css/jquery.gritter.css') }}" rel="stylesheet" />
  <link href="{{ asset('public/plugins/sweetalert/sweetalert2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('public/plugins/jquery-filestyle/jquery-filestyle.css') }}" rel="stylesheet" />
  <link href="{{ asset('public/css/jstree.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('public/plugins/bootstrap3-editable/css/bootstrap-editable.css') }}" rel="stylesheet" />
	<!-- ================== END PAGE LEVEL STYLE ================== -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<!-- <script src="{{ asset('plugins/pace/pace.min.js') }}"></script> -->
	<!-- ================== END BASE JS ================== -->
</head>
<body>
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	<!-- begin #page-container -->
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<!-- begin #header -->
		<div id="header" class="header navbar navbar-default navbar-fixed-top">
			<!-- begin container-fluid -->
			<div class="container-fluid">
				<!-- begin mobile sidebar expand / collapse button -->
				<div class="navbar-header">
					<a href="{{URL('/')}}" class="navbar-brand" style="width: 260px"><span class="navbar-logo"></span><strong>CV. JUJUR PERKASA</strong></a>
					<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<!-- end mobile sidebar expand / collapse button -->
				<!-- begin header navigation right -->
				<ul class="nav navbar-nav navbar-right">
					<!-- <li>
						<form class="navbar-form full-width">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Enter keyword" />
								<button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
							</div>
						</form>
					</li> -->
					<!-- <li class="dropdown">
						<a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-14">
							<i class="fa fa-bell-o"></i>
							<span class="label"></span>
						</a>
						<ul class="dropdown-menu media-list pull-right animated fadeInDown"></ul>
					</li> -->
					<li class="dropdown navbar-user">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<img src="{{ asset('photo/'.Auth::user()->photo) }}" alt="" />
							<span class="hidden-xs">{{ Auth::user()->username }}</span> <b class="caret"></b>
						</a>
						<ul class="dropdown-menu animated fadeInLeft">
							<li class="arrow"></li>
							<li><a href="{{URL('profile')}}">Edit Profile</a></li>
							<!-- <li><a href="javascript:;"><span class="badge badge-danger pull-right">2</span> Inbox</a></li>
							<li><a href="javascript:;">Setting</a></li> -->
							<li class="divider"></li>
							<li><a href="{{ route('logout') }}">Log Out</a></li>
						</ul>
					</li>
				</ul>
			</div><!-- end header navigation right -->
		</div><!-- end container-fluid -->
		<!-- end #header -->
		
		<div id="sidebar" class="sidebar"><!-- begin #sidebar -->
			<div data-scrollbar="true" data-height="100%"><!-- begin sidebar scrollbar -->
				<ul class="nav"><!-- begin sidebar user -->
					<li class="nav-profile">
						<div class="image">
							<a href="{{URL('profile')}}"><img src="{{ asset('photo/'.Auth::user()->photo) }}" alt="" /></a>
						</div>
						<div class="info">
							{{ Auth::user()->name }}
							<small>{{ Auth::user()->roles[0]->display_name }}</small>
						</div>
					</li>
				</ul><!-- end sidebar user -->
				<!-- begin sidebar nav -->
				<ul class="nav">
					<li class="nav-header">Navigation</li>
					<li class="has-sub" id="dashboard-menu">
						<a href="{{URL('/')}}">
						<i class="fa fa-home"></i>
						<span>Dashboard</span>
						</a>
					</li>
					<li class="has-sub" id="master-menu">
						<a href="javascript:;">
							<b class="caret pull-right"></b>
							<i class="fa fa-gear"></i>
							<span>Master</span>
						</a>
						<ul class="sub-menu">
							<li id="customer-menu"><a href="{{URL('customer')}}">Customer</a></li>
							<li id="employees-menu"><a href="{{URL('employees')}}">Employees</a></li>
							<li id="vendor-menu"><a href="{{URL('vendors')}}">Vendor</a></li>
							<li id="vehicle-menu"><a href="{{URL('vehicle')}}">Vehicle</a></li>
						</ul>
					</li>

					<li class="has-sub" id="cost-menu">
						<a href="javascript:;">
							<b class="caret pull-right"></b>
							<i class="fa fa-money"></i>
							<span>Cost</span>
						</a>
						<ul class="sub-menu">
							<li id="customercost-menu"><a href="{{URL('customer-cost')}}">Customer Cost</a></li>
							<li id="vendorcost-menu"><a href="{{URL('vendor-cost')}}">Vendor Cost</a></li>
							<li id="city-menu"><a href="{{URL('city')}}">City Cost</a></li>
							<li id="service-menu"><a href="{{URL('service')}}">Service Cost</a></li>
						</ul>
					</li>

					<li class="has-sub" id="transaction-menu">
						<a href="javascript:;">
							<b class="caret pull-right"></b>
							<i class="fa fa-tasks"></i>
							<span>Transaction</span>
						</a>
						<ul class="sub-menu">
							<li id="shipping-menu"><a href="{{URL('shipping')}}">Create Shipping</a></li>
							<li id="load_list-menu"><a href="javascript:;" onclick="under_maintenance()">Load List</a></li>
							<li id="cost-menu"><a href="javascript:;" onclick="under_maintenance()">Cost</a></li>
						</ul>
					</li>

					<li class="has-sub">
						<a href="javascript:;">
							<b class="caret pull-right"></b>
							<i class="fa fa-bar-chart-o"></i>
							<span>Report</span>
						</a>
						<ul class="sub-menu">
						<li><a href="javascript:;" onclick="under_maintenance()">Financial statements</a></li>
							<li><a href="javascript:;" onclick="under_maintenance()">General Report</a></li>
							<li><a href="javascript:;" onclick="under_maintenance()">Income History</a></li>
						</ul>
					</li>
					
					<li class="has-sub" id="administrator-menu">
						<a href="javascript:;">
							<b class="caret pull-right"></b>
							<i class="fa fa-user"></i>
							<span>Admnistrator</span>
						</a>
						<ul class="sub-menu">
							@if(Auth::user()->can('setting-list') == 1)
								<li id="settings-menu"><a href="javascript:;" onclick="under_maintenance()">Settings</a></li>
							@endif
							@if(Auth::user()->can('user-list') == 1)
								<li id="user-management-menu"><a href="{{URL('users')}}">User Management</a></li>
							@endif
							@if(Auth::user()->can('role-list') == 1)
								<li id="role-management-menu"><a href="{{URL('roles')}}">Role Management</a></li>
							@endif
							@if(Auth::user()->can('permission-list') == 1)
								<li id="menu-permission-management"><a href="{{URL('menu_permission')}}">Menu Permission</a></li>
							@endif
							@if(Auth::user()->can('backup-list') == 1)
								<li id="backup-management-menu"><a href="javascript:;" onclick="under_maintenance()">Backup Database</a></li>
							@endif
						</ul>
					</li>
					<!-- begin sidebar minify button -->
					<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
					<!-- end sidebar minify button -->
				</ul>
				<!-- end sidebar nav -->
			</div>
			<!-- end sidebar scrollbar -->
		</div>
		<div class="sidebar-bg"></div>
		<!-- end #sidebar -->
		
		<!-- begin #content -->	
		@yield('content')
		<!-- end #content -->
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
		</div>
			<!-- end page container -->
		<!-- ================== BEGIN BASE JS ================== -->
		<script src="{{ asset('public/plugins/jquery/jquery-1.12.4.js') }}"></script>
		<script src="{{ asset('public/plugins/jquery/jquery-migrate-1.1.0.min.js') }}"></script>
		<script src="{{ asset('public/plugins/jquery-ui/ui/minified/jquery-ui.min.js') }}"></script>
		<script src="{{ asset('public/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
		<!--[if lt IE 9]>
			<script src="{{ asset('public/crossbrowserjs/html5shiv.js') }}"></script>
			<script src="{{ asset('public/crossbrowserjs/respond.min.js') }}"></script>
			<script src="{{ asset('public/crossbrowserjs/excanvas.min.js') }}"></script>
		<![endif]-->
		<script src="{{ asset('public/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
		<script src="{{ asset('public/plugins/jquery-cookie/jquery.cookie.js') }}"></script>
		<!-- ================== END BASE JS ================== -->
			
		<!-- ================== BEGIN PAGE LEVEL JS ================== -->
		<script src="{{ asset('public/js/keypress.js') }}"></script>
		<script src="{{ asset('public/js/jquery.price_format.2.0.js') }}"></script>
		<script src="{{ asset('public/plugins/flot/jquery.flot.min.js') }}"></script>
		<script src="{{ asset('public/plugins/flot/jquery.flot.time.min.js') }}"></script>
		<script src="{{ asset('public/plugins/flot/jquery.flot.resize.min.js') }}"></script>
		<script src="{{ asset('public/plugins/flot/jquery.flot.pie.min.js') }}"></script>
		<script src="{{ asset('public/plugins/sparkline/jquery.sparkline.js') }}"></script>
		<script src="{{ asset('public/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
		<script src="{{ asset('public/plugins/jquery-jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
		<script src="{{ asset('public/plugins/sweetalert/sweetalert2.min.js') }}"></script>
		<script src="{{ asset('public/plugins/sweetalert/core.js') }}"></script>
		<script src="{{ asset('public/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
		<script src="{{ asset('public/plugins/DataTables/js/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('public/plugins/DataTables/js/dataTables.buttons.js') }}"></script>
		<script src="{{ asset('public/plugins/DataTables/js/jquery.highlight.js') }}"></script>
		<script src="{{ asset('public/plugins/DataTables/js/dataTables.searchHighlight.min.js') }}"></script>
		<script src="{{ asset('public/plugins/DataTables/js/dataTables.responsive.js') }}"></script>
		<script src="{{ asset('public/plugins/DataTables/js/dataTables.searchHighlight.min.js') }}"></script>
		<script src="{{ asset('public/plugins/DataTables/js/jquery.highlight.js') }}"></script>
		<script src="{{ asset('public/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
		<script src="{{ asset('public/plugins/jquery.countdown/jquery.plugin.js') }}"></script>
		<script src="{{ asset('public/plugins/jquery.countdown/jquery.countdown.js') }}"></script>
		<script src="{{ asset('public/plugins/jquery-filestyle/jquery-filestyle.js') }}"></script>
		<script src="{{ asset('public/plugins/bootstrap3-editable/js/bootstrap-editable.min.js') }}"></script>
		<script src="{{ asset('public/js/ui-modal-notification.demo.min.js') }}"></script>
		<script src="{{ asset('public/js/jstree.min.js') }}"></script>
		<script src="{{ asset('public/js/coming-soon.demo.min.js') }}"></script>
		<script src="{{ asset('public/js/dashboard.min.js') }}"></script>
		<script src="{{ asset('public/js/apps.min.js') }}"></script>
		<!-- ================== END PAGE LEVEL JS ================== -->
		@stack('js')
		<script>
		$(document).ready(function() {
			App.init();
		});

		function under_maintenance(){
			swal(
				'Sorry',
				'Page under maintenance',
				'warning'
			)
		}
		</script>
		<!-- <script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-XXXXX-Y', 'auto');
		ga('send', 'pageview');
		</script> -->
</body>
</html>
