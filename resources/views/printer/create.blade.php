@extends('layouts.app')
@section('title',  __('printer.add_printer'))

@section('content')
<style type="text/css">



</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('printer.add_printer')</h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">
{!! Form::open(['url' => action('PrinterController@store'), 'method' => 'post', 'id' => 'add_printer_form' ]) !!}
	<div class="box box-solid">
    <div class="box-body">
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            {!! Form::label('name', __('printer.name') . ':*') !!}
              {!! Form::text('name', null, ['class' => 'form-control', 'required',
              'placeholder' => __('lang_v1.printer_name_help')]); !!}
          </div>
        </div>
        <div class="col-sm-12">
          <div class="form-group">
            {!! Form::label('connection_type',__('printer.connection_type') . ':*') !!}
            {!! Form::select('connection_type', $connection_types, null, ['class' => 'form-control select2']); !!}
          </div>
        </div>

        <div class="col-sm-12">
          <div class="form-group">
            {!! Form::label('capability_profile',__('printer.capability_profile') . ':*') !!}
            @show_tooltip(__('tooltip.capability_profile'))
            {!! Form::select('capability_profile', $capability_profiles, null, ['class' => 'form-control select2']); !!}
          </div>
        </div>

        <div class="col-sm-12">
          <div class="form-group">
            {!! Form::label('char_per_line', __('printer.character_per_line') . ':*') !!}
              {!! Form::number('char_per_line', 42, ['class' => 'form-control', 'required',
              'placeholder' => __('lang_v1.char_per_line_help')]); !!}
          </div>
        </div>

        <div class="col-sm-12" id="ip_address_div">
          <div class="form-group">
            {!! Form::label('ip_address', __('printer.ip_address') . ':*') !!}
            {!! Form::text('ip_address', null, ['class' => 'form-control', 'required', 'placeholder' => __('lang_v1.ip_address_help')]); !!}
          </div>
        </div>

        <div class="col-sm-12" id="port_div">
          <div class="form-group">
            {!! Form::label('port', __('printer.port') . ':*') !!}
              {!! Form::text('port', 9100, ['class' => 'form-control', 'required']); !!}
              <span class="help-block">@lang('lang_v1.port_help')</span>
          </div>
        </div>

        <div class="col-sm-12 hide" id="path_div">
          <div class="form-group">
            {!! Form::label('path', __('printer.path') . ':*') !!}
            {!! Form::text('path', null, ['class' => 'form-control', 'required']); !!}
            <span class="help-block">
              <b>Connection Type Windows: </b> The device files will be along the lines of <code>LPT1</code> (parallel) or <code>COM1</code> (serial). <br/>
              <b>Connection Type Linux: </b> Your printer device file will be somewhere like <code>/dev/lp0</code> (parallel), <code>/dev/usb/lp1</code> (USB), <code>/dev/ttyUSB0</code> (USB-Serial), <code>/dev/ttyS0</code> (serial). <br/>
            </span>
          </div>
        </div>

        <div class="col-sm-12">
          <button type="submit" class="btn btn-primary pull-right">@lang('messages.save')</button>
        </div>
      </div>
    </div>
  </div>
  {!! Form::close() !!}
</section>
<!-- /.content -->
@endsection