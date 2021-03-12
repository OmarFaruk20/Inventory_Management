<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/pace/pace.css?v='.$asset_v) }}">

<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css?v='.$asset_v) }}">

<!-- Styles -->
<link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui.min.css?v='.$asset_v) }}">
<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css?v='.$asset_v) }}">

@if( in_array(session()->get('user.language', config('app.locale')), config('constants.langs_rtl')) )
	<link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.rtl.min.css?v='.$asset_v) }}">
@endif

<!-- Ionicons -->
<link rel="stylesheet" href="{{ asset('plugins/ionicons/css/ionicons.min.css?v='.$asset_v) }}">
 <!-- Select2 -->
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/select2/select2.min.css?v='.$asset_v) }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('AdminLTE/css/AdminLTE.min.css?v='.$asset_v) }}">
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/iCheck/square/blue.css?v='.$asset_v) }}">

<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datepicker/bootstrap-datepicker.min.css?v='.$asset_v) }}">

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/DataTables/datatables.min.css?v='.$asset_v) }}">

<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css?v='.$asset_v) }}">
<!-- Bootstrap file input -->
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-fileinput/fileinput.min.css?v='.$asset_v) }}">

<!-- AdminLTE Skins.-->
<link rel="stylesheet" href="{{ asset('AdminLTE/css/skins/_all-skins.min.css?v='.$asset_v) }}">

@if( in_array(session()->get('user.language', config('app.locale')), config('constants.langs_rtl')) )
	<link rel="stylesheet" href="{{ asset('AdminLTE/css/AdminLTE.rtl.min.css?v='.$asset_v) }}">
@endif

<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/daterangepicker/daterangepicker.css?v='.$asset_v) }}">
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-tour/bootstrap-tour.min.css?v='.$asset_v) }}">
<link rel="stylesheet" href="{{ asset('plugins/calculator/calculator.css?v='.$asset_v) }}">

<link rel="stylesheet" href="{{ asset('plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css?v='.$asset_v) }}">

@yield('css')
<!-- app css -->
<link rel="stylesheet" href="{{ asset('css/app.css?v='.$asset_v) }}">

@if(isset($pos_layout) && $pos_layout)
	<style type="text/css">
		.content{
			padding-bottom: 0px !important;
		}
	</style>
@endif