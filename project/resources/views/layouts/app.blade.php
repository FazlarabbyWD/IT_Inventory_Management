<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="{{asset('uploads/settings/'.$settingsInfo->icon_1)}}" type="image/png" />
	<title>{!! $settingsInfo->title !!}</title>
	<meta name="og:title" content="{!! $settingsInfo->title !!}">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!--plugins-->
	<link href="{{asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet"/>
	<link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/select2/css/select2-bootstrap4.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/datetimepicker/css/classic.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/datetimepicker/css/classic.time.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/datetimepicker/css/classic.date.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.min.css')}}" rel="stylesheet">
	<link href="{{asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
	<!-- loader-->
	<link href="{{asset('assets/css/pace.min.css')}}" rel="stylesheet" />
	<script src="{{asset('assets/js/pace.min.js')}}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/app.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/icons.css')}}" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link href="{{asset('assets/css/dark-theme.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/css/semi-dark.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/css/header-colors.css')}}" rel="stylesheet" />

	<!-- new -->
	<link href="{{asset('assets/plugins/fileupload/bootstrap-fileupload.min.css')}}" rel="stylesheet">

	<style type="text/css">
		.fileupload{
			margin-bottom: 0px
		}
	</style>

	@stack('css')

</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		@include('includes.sidebar')
		<!--end sidebar wrapper -->
		<!--start header -->
		@include('includes.header')
		<!--end header -->

		<!--start page wrapper -->
		@yield('content')
		<!--end page wrapper -->

		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->

		<footer class="page-footer">
			<p class="mb-0">Copyright © {!! date('Y') !!}. All right reserved.</p>
		</footer>

	</div>
	<!--end wrapper-->

	<!--start switcher-->
	@include('includes.switcher')
	<!--end switcher-->


	<!-- Bootstrap JS -->
	<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
	<!--plugins-->
	<script src="{{asset('assets/js/jquery.min.js')}}"></script>
	<script src="{{asset('assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
	<script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
	<script src="{{asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
	<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
	<script src="{{asset('assets/plugins/datetimepicker/js/legacy.js')}}"></script>
	<script src="{{asset('assets/plugins/datetimepicker/js/picker.js')}}"></script>
	<script src="{{asset('assets/plugins/datetimepicker/js/picker.time.js')}}"></script>
	<script src="{{asset('assets/plugins/datetimepicker/js/picker.date.js')}}"></script>
	<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/moment.min.js')}}"></script>
	<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js')}}"></script>
	<script src="{{asset('assets/plugins/chartjs/js/Chart.min.js')}}"></script>
	<script src="{{asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
	<script src="{{asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
	<script src="{{asset('assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js')}}"></script>
	<script src="{{asset('assets/plugins/sparkline-charts/jquery.sparkline.min.js')}}"></script>
	<script src="{{asset('assets/plugins/jquery-knob/excanvas.js')}}"></script>
	<script src="{{asset('assets/plugins/jquery-knob/jquery.knob.js')}}"></script>
	<script>
		$(function() {
			$(".knob").knob();
		});
	</script>
	<script src="{{asset('assets/js/index.js')}}"></script>
	<!--app JS-->
	<script src="{{asset('assets/js/app.js')}}"></script>
	<script src="{{asset('assets/plugins/fileupload/bootstrap-fileupload.min.js')}}"></script>

	<!-- delete message -->
	<script type="text/javascript">
		$('.confirmDelete').click(function() {
			if (confirm('Do you want to delete?')) {
				return true;
			} else {
				return false;
			}
		})
	</script>

	<script type="text/javascript">
		$('.single-select').select2({
			theme: 'bootstrap4',
			width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
			placeholder: $(this).data('placeholder'),
			allowClear: Boolean($(this).data('allow-clear')),
		});
		$('.multiple-select').select2({
			theme: 'bootstrap4',
			width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
			placeholder: $(this).data('placeholder'),
			allowClear: Boolean($(this).data('allow-clear')),
		});
	</script>

	<script>
		$('.datepicker').pickadate({
			selectMonths: true,
			selectYears: true,
		}),
		$('.timepicker').pickatime()
	</script>
	<script>
		$(function () {
			$('#date-time').bootstrapMaterialDatePicker({
				format: 'YYYY-MM-DD HH:mm'
			});
			$('#date').bootstrapMaterialDatePicker({
				time: false
			});
			$('#time').bootstrapMaterialDatePicker({
				date: false,
				format: 'HH:mm'
			});
		});
	</script>

	@stack('js')

</body>

</html>
