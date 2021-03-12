@extends('layouts.app')
@section('title', __('barcode.barcodes'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('barcode.barcodes')
        <small>@lang('barcode.manage_your_barcodes')</small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">

	<div class="box">
        <div class="box-header">
        	<h3 class="box-title">@lang('barcode.all_your_barcode')</h3>
        	<div class="box-tools">
                <a class="btn btn-block btn-primary" href="{{action('BarcodeController@create')}}">
				<i class="fa fa-plus"></i> @lang('barcode.add_new_setting')</a>
            </div>
        </div>
        <div class="box-body">
        	<table class="table table-bordered table-striped" id="barcode_table">
        		<thead>
        			<tr>
        				<th>@lang('barcode.setting_name')</th>
						<th>@lang('barcode.setting_description')</th>
						<th>Action</th>
        			</tr>
        		</thead>
        	</table>
        </div>
    </div>

</section>
<!-- /.content -->
@stop
@section('javascript')
<script type="text/javascript">
    $(document).ready( function(){
        var barcode_table = $('#barcode_table').DataTable({
            processing: true,
            serverSide: true,
            buttons:[],
            ajax: '/barcodes',
            bPaginate: false,
            columnDefs: [ {
                "targets": 2,
                "orderable": false,
                "searchable": false
            } ]
        });
        $(document).on('click', 'button.delete_barcode_button', function(){
            var is_confirmed = confirm("{{ __('barcode.delete_confirm') }}");
            if(!is_confirmed){
                return;
            }

            var href = $(this).data('href');
            var data = $(this).serialize();

            $.ajax({
                method: "DELETE",
                url: href,
                dataType: "json",
                data: data,
                success: function(result){
                    if(result.success === true){
                        toastr.success(result.msg);
                        barcode_table.ajax.reload();
                    } else {
                        toastr.error(result.msg);
                    }
                }
            });
        });
        $(document).on('click', 'button.set_default', function(){
            var href = $(this).data('href');
            var data = $(this).serialize();

            $.ajax({
                method: "get",
                url: href,
                dataType: "json",
                data: data,
                success: function(result){
                    if(result.success === true){
                        toastr.success(result.msg);
                        barcode_table.ajax.reload();
                    } else {
                        toastr.error(result.msg);
                    }
                }
            });
        });
    });
</script>
@endsection