<script type="text/javascript">
    base_path = "{{url('/')}}";
</script>

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js?v=$asset_v"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js?v=$asset_v"></script>
<![endif]-->

<script src="{{ asset('AdminLTE/plugins/pace/pace.min.js?v=' . $asset_v) }}"></script>

<!-- jQuery 2.2.3 -->
<script src="{{ asset('AdminLTE/plugins/jQuery/jquery-2.2.3.min.js?v=' . $asset_v) }}"></script>
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js?v=' . $asset_v) }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('bootstrap/js/bootstrap.min.js?v=' . $asset_v) }}"></script>
<!-- iCheck -->
<script src="{{ asset('AdminLTE/plugins/iCheck/icheck.min.js?v=' . $asset_v) }}"></script>
<!-- Select2 -->
<script src="{{ asset('AdminLTE/plugins/select2/select2.full.min.js?v=' . $asset_v) }}"></script>
<!-- Add language file for select2 -->
@if(file_exists(public_path('AdminLTE/plugins/select2/lang/' . session()->get('user.language', config('app.locale')) . '.js')))
    <script src="{{ asset('AdminLTE/plugins/select2/lang/' . session()->get('user.language', config('app.locale') ) . '.js?v=' . $asset_v) }}"></script>
@endif
<!-- bootstrap datepicker -->
<script src="{{ asset('AdminLTE/plugins/datepicker/bootstrap-datepicker.min.js?v=' . $asset_v) }}"></script>
<!-- DataTables -->
<script src="{{ asset('AdminLTE/plugins/DataTables/datatables.min.js?v=' . $asset_v) }}"></script>
<script src="{{ asset('AdminLTE/plugins/DataTables/pdfmake-0.1.32/pdfmake.min.js?v=' . $asset_v) }}"></script>
<script src="{{ asset('AdminLTE/plugins/DataTables/pdfmake-0.1.32/vfs_fonts.js?v=' . $asset_v) }}"></script>

<!-- jQuery Validator -->
<script src="{{ asset('js/jquery-validation-1.16.0/dist/jquery.validate.min.js?v=' . $asset_v) }}"></script>
<script src="{{ asset('js/jquery-validation-1.16.0/dist/additional-methods.min.js?v=' . $asset_v) }}"></script>
@php
    $validation_lang_file = 'messages_' . session()->get('user.language', config('app.locale') ) . '.js';
@endphp
@if(file_exists(public_path() . '/js/jquery-validation-1.16.0/src/localization/' . $validation_lang_file))
    <script src="{{ asset('js/jquery-validation-1.16.0/src/localization/' . $validation_lang_file . '?v=' . $asset_v) }}"></script>
@endif

<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js?v=' . $asset_v) }}"></script>
<!-- Bootstrap file input -->
<script src="{{ asset('plugins/bootstrap-fileinput/fileinput.min.js?v=' . $asset_v) }}"></script>
<!--accounting js-->
<script src="{{ asset('plugins/accounting.min.js?v=' . $asset_v) }}"></script>

<script src="{{ asset('AdminLTE/plugins/daterangepicker/moment.min.js?v=' . $asset_v) }}"></script>

<script src="{{ asset('plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js?v=' . $asset_v) }}"></script>

<script src="{{ asset('AdminLTE/plugins/daterangepicker/daterangepicker.js?v=' . $asset_v) }}"></script>

<script src="{{ asset('AdminLTE/plugins/ckeditor/ckeditor.js?v=' . $asset_v) }}"></script>

<script src="{{ asset('plugins/sweetalert/sweetalert.min.js?v=' . $asset_v) }}"></script>

<script src="{{ asset('plugins/bootstrap-tour/bootstrap-tour.min.js?v=' . $asset_v) }}"></script>

<script src="{{ asset('plugins/printThis.js?v=' . $asset_v) }}"></script>

<script src="{{ asset('plugins/screenfull.min.js?v=' . $asset_v) }}""></script>

<script src="{{ asset('plugins/moment-timezone-with-data.min.js?v=' . $asset_v) }}"></script>
@php
    $business_date_format = session('business.date_format');
    $datepicker_date_format = str_replace('d', 'dd', $business_date_format);
    $datepicker_date_format = str_replace('m', 'mm', $datepicker_date_format);
    $datepicker_date_format = str_replace('Y', 'yyyy', $datepicker_date_format);

    $moment_date_format = str_replace('d', 'DD', $business_date_format);
    $moment_date_format = str_replace('m', 'MM', $moment_date_format);
    $moment_date_format = str_replace('Y', 'YYYY', $moment_date_format);

    $business_time_format = session('business.time_format');
    $moment_time_format = 'HH:mm';
    if($business_time_format == 12){
        $moment_time_format = 'hh:mm A';
    }

@endphp
<script>
    moment.tz.setDefault('{{ Session::get("business.time_zone") }}');
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        @if(config('app.debug') == false)
            $.fn.dataTable.ext.errMode = 'throw';
        @endif
    });
    
    var financial_year = {
    	start: moment('{{ Session::get("financial_year.start") }}'),
    	end: moment('{{ Session::get("financial_year.end") }}'),
    }
    @if(file_exists(public_path('AdminLTE/plugins/select2/lang/' . session()->get('user.language', config('app.locale')) . '.js')))
    //Default setting for select2
    $.fn.select2.defaults.set("language", "{{session()->get('user.language', config('app.locale'))}}");
    @endif

    var datepicker_date_format = "{{$datepicker_date_format}}";
    var moment_date_format = "{{$moment_date_format}}";
    var moment_time_format = "{{$moment_time_format}}";

    var app_locale = "{{session()->get('user.language', config('app.locale'))}}";
    var non_utf8_languages = [
        @foreach(config('constants.non_utf8_languages') as $const)
        "{{$const}}",
        @endforeach
    ];
</script>

<!-- Scripts -->
<script src="{{ asset('js/AdminLTE-app.js?v=' . $asset_v) }}"></script>

@if(file_exists(public_path('js/lang/' . session()->get('user.language', config('app.locale')) . '.js')))
    <script src="{{ asset('js/lang/' . session()->get('user.language', config('app.locale') ) . '.js?v=' . $asset_v) }}"></script>
@else
    <script src="{{ asset('js/lang/en.js?v=' . $asset_v) }}"></script>
@endif

<script src="{{ asset('js/functions.js?v=' . $asset_v) }}"></script>
<script src="{{ asset('js/common.js?v=' . $asset_v) }}"></script>
<script src="{{ asset('js/app.js?v=' . $asset_v) }}"></script>
<script src="{{ asset('js/help-tour.js?v=' . $asset_v) }}"></script>
<script src="{{ asset('plugins/calculator/calculator.js?v=' . $asset_v) }}"></script>
@yield('javascript')

@if(Module::has('Essentials'))
  @includeIf('essentials::layouts.partials.footer_part')
@endif