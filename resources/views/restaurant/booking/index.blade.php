@extends('layouts.app')
@section('title', __('restaurant.bookings'))

@section('content')
<link rel="stylesheet" href="{{ asset('plugins/fullcalendar/fullcalendar.min.css?v='.$asset_v) }}">


<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'restaurant.bookings' )</h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        @if(count($business_locations) > 1)
        <div class="col-sm-12">
            <select id="business_location_id" class="select2" style="width:50%">
                <option value="">@lang('purchase.business_location')</option>
                @foreach( $business_locations as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        @endif
    </div>
    <br>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('restaurant.todays_bookings')</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-condensed" id="todays_bookings_table">
                        <thead>
                        <tr>
                            <th>@lang('contact.customer')</th>
                            <th>@lang('restaurant.booking_starts')</th>
                            <th>@lang('restaurant.booking_ends')</th>
                            <th>@lang('restaurant.table')</th>
                            <th>@lang('messages.location')</th>
                            <th>@lang('restaurant.service_staff')</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-primary pull-right" id="add_new_booking_btn"><i class="fa fa-plus"></i> @lang('restaurant.add_booking')</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="box box-solid">
                <div class="box-body">
                    <!-- the events -->
                    <div class="external-event bg-light-blue text-center" style="position: relative;">
                        <small>@lang('restaurant.booked')</small>
                    </div>
                    <div class="external-event bg-green text-center" style="position: relative;">
                        <small>@lang('restaurant.completed')</small>
                    </div>
                    <div class="external-event bg-red text-center" style="position: relative;">
                        <small>@lang('restaurant.cancelled')</small>
                    </div>
                    <small>
                    <p class="help-block">
                        <i>@lang('restaurant.click_on_any_booking_to_view_or_change_status')<br><br>
                        @lang('restaurant.double_click_on_any_day_to_add_new_booking')
                        </i>
                    </p>
                    </small>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>

    @include('restaurant.booking.create')

</section>
<!-- /.content -->

@endsection

@section('javascript')
    <script src="{{ asset('plugins/fullcalendar/fullcalendar.min.js?v=' . $asset_v) }}"></script>

@php
    $fullcalendar_lang_file = session()->get('user.language', config('app.locale') ) . '.js';
@endphp
@if(file_exists(public_path() . '/plugins/fullcalendar/locale/' . $fullcalendar_lang_file))
    <script src="{{ asset('plugins/fullcalendar/locale/' . $fullcalendar_lang_file . '?v=' . $asset_v) }}"></script>
@endif
    
    <script type="text/javascript">
        $(document).ready(function(){
            clickCount = 0;
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listWeek'
                },
                eventLimit: 2,
                events: '/bookings',
                eventRender: function (event, element) {
                    var title_html = event.customer_name;
                    if(event.table){
                        title_html += '<br>' + event.table;
                    }
                    // title_html += '<br>' + event.start_time + ' - ' + event.end_time;

                    element.find('.fc-title').html(title_html);
                    element.attr('data-href', event.url);
                    element.attr('data-container', '.view_modal');
                    element.addClass('btn-modal');
                },
                dayClick:function( date, jsEvent, view ) {
                    clickCount ++;
                    if( clickCount == 2 ){
                       $('#add_booking_modal').modal('show');
                       $('form#add_booking_form #start_time').data("DateTimePicker").date(date).ignoreReadonly(true);
                       $('form#add_booking_form #end_time').data("DateTimePicker").date(date).ignoreReadonly(true);
                    }
                    var clickTimer = setInterval(function(){
                        clickCount = 0;
                        clearInterval(clickTimer);
                    }, 500);
                }
            });

            //If location is set then show tables.

            $('#add_booking_modal').on('shown.bs.modal', function (e) {
                getLocationTables($('select#booking_location_id').val());
                $(this).find('select').each( function(){
                    if(!($(this).hasClass('select2'))){
                        $(this).select2({
                            dropdownParent: $('#add_booking_modal')
                        });
                    }
                });
                booking_form_validator = $('form#add_booking_form').validate({
                    submitHandler: function(form) {
                        $(form).find('button[type="submit"]').attr('disabled', true);
                        var data = $(form).serialize();

                        $.ajax({
                            method: "POST",
                            url: $(form).attr("action"),
                            dataType: "json",
                            data: data,
                            success: function(result){
                                if(result.success == true){
                                    if(result.send_notification){
                                        $( "div.view_modal" ).load( result.notification_url,function(){
                                            $(this).modal('show');
                                        });
                                    }

                                    $('div#add_booking_modal').modal('hide');
                                    toastr.success(result.msg);
                                    reload_calendar();
                                    todays_bookings_table.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            }
                        });
                    }
                });
            });
            $('#add_booking_modal').on('hidden.bs.modal', function (e) {
                booking_form_validator.destroy();
                reset_booking_form();
            });

            $('form#add_booking_form #start_time').datetimepicker({
                format: moment_date_format + ' ' +moment_time_format,
                ignoreReadonly: true
            });
            
            $('form#add_booking_form #end_time').datetimepicker({
                format: moment_date_format + ' ' +moment_time_format,
                ignoreReadonly: true,
            });

            $('.view_modal').on('shown.bs.modal', function (e) {
                $('form#edit_booking_form').validate({
                    submitHandler: function(form) {
                        $(form).find('button[type="submit"]').attr('disabled', true);
                        var data = $(form).serialize();

                        $.ajax({
                            method: "PUT",
                            url: $(form).attr("action"),
                            dataType: "json",
                            data: data,
                            success: function(result){
                                if(result.success == true){
                                    $('div.view_modal').modal('hide');
                                    toastr.success(result.msg);
                                    reload_calendar();
                                    todays_bookings_table.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            }
                        });
                    }
                });
            });

            todays_bookings_table = $('#todays_bookings_table').DataTable({
                            processing: true,
                            serverSide: true,
                            "ordering": false,
                            'searching': false,
                            "pageLength": 10,
                            dom:'frtip',
                            "ajax": {
                                "url": "/bookings/get-todays-bookings",
                                "data": function ( d ) {
                                    d.location_id = $('#business_location_id').val();
                                }
                            },
                            columns: [
                                {data: 'customer'},
                                {data: 'booking_start', name: 'booking_start'},
                                {data: 'booking_end', name: 'booking_end'},
                                {data: 'table'},
                                {data: 'location'},
                                {data: 'waiter'},
                            ]
                        });
            $('button#add_new_booking_btn').click( function(){
                $('div#add_booking_modal').modal('show');
            });

        });
        $(document).on('change', 'select#booking_location_id', function(){
            getLocationTables($(this).val());
        });

        $(document).on('change', 'select#business_location_id', function(){
            reload_calendar();
            todays_bookings_table.ajax.reload();
        });

        $(document).on('click', 'button#delete_booking', function(){
            swal({
              title: LANG.sure,
              icon: "warning",
              buttons: true,
              dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    var href = $(this).data('href');
                    $.ajax({
                        method: "DELETE",
                        url: href,
                        dataType: "json",
                        success: function(result){
                            if(result.success == true){
                                $('div.view_modal').modal('hide');
                                toastr.success(result.msg);
                                reload_calendar();
                                todays_bookings_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        }
                    });
                }
            });
        });

        function getLocationTables(location_id){
            $.ajax({
                method: "GET",
                url: '/modules/data/get-pos-details',
                data: {'location_id': location_id},
                dataType: "html",
                success: function(result){
                    $('div#restaurant_module_span').html(result);
                }
            });
        }

        function reset_booking_form(){
            $('select#booking_location_id').val('').change();
            $('select#booking_customer_id').val('').change();
            $('select#correspondent').val('').change();
            $('#booking_note').val('');
        }

        function reload_calendar(){
            var location_id = '';
            if($('select#business_location_id').val()){
                location_id = $('select#business_location_id').val();
            }

            var events_source = {
                    url: '/bookings',
                    type: 'get',
                    data: {
                        'location_id': location_id
                    }
                }
                $('#calendar').fullCalendar( 'removeEventSource', events_source);
                $('#calendar').fullCalendar( 'addEventSource', events_source);         
                $('#calendar').fullCalendar( 'refetchEvents' );
        }

    </script>
@endsection
