@extends('layouts.restaurant')
@section('title', __( 'restaurant.orders' ))

@section('content')

<!-- Main content -->
<section class="content min-height-90hv no-print">
    
    <div class="row">
        <div class="col-md-12 text-center">
            <h3>@lang( 'restaurant.all_orders' ) @show_tooltip(__('lang_v1.tooltip_serviceorder'))</h3>
        </div>
        <div class="col-sm-12">
            <button type="button" class="btn btn-sm btn-primary pull-right" id="refresh_orders"><i class="fa fa-refresh"></i> @lang( 'restaurant.refresh' )</button>
        </div>
    </div>
    <br>
    <div class="row">
    @if(!$is_service_staff)
        @component('components.widget')
            <div class="col-sm-6">
                {!! Form::open(['url' => action('Restaurant\OrderController@index'), 'method' => 'get', 'id' => 'select_service_staff_form' ]) !!}
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user-secret"></i>
                        </span>
                        {!! Form::select('service_staff', $service_staff, null, ['class' => 'form-control select2', 'placeholder' => __('restaurant.select_service_staff'), 'id' => 'service_staff_id']); !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        @endcomponent
    @endif
    @component('components.widget', ['title' => __( 'lang_v1.line_orders' )])
        <input type="hidden" id="orders_for" value="waiter">
        <div class="row" id="line_orders_div">
         @include('restaurant.partials.line_orders', array('orders_for' => 'waiter'))   
        </div>
        <div class="overlay hide">
          <i class="fa fa-refresh fa-spin"></i>
        </div>
    @endcomponent

    @component('components.widget', ['title' => __( 'restaurant.all_your_orders' )])
        <input type="hidden" id="orders_for" value="waiter">
        <div class="row" id="orders_div">
         @include('restaurant.partials.show_orders', array('orders_for' => 'waiter'))   
        </div>
        <div class="overlay hide">
          <i class="fa fa-refresh fa-spin"></i>
        </div>
    @endcomponent
    </div>
</section>
<!-- /.content -->

@endsection

@section('javascript')
    <script type="text/javascript">
        $('select#service_staff_id').change( function(){
            $('form#select_service_staff_form').submit();
        });
        $(document).ready(function(){
            $(document).on('click', 'a.mark_as_served_btn', function(e){
                e.preventDefault();
                swal({
                  title: LANG.sure,
                  icon: "info",
                  buttons: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        var _this = $(this);
                        var href = _this.data('href');
                        $.ajax({
                            method: "GET",
                            url: href,
                            dataType: "json",
                            success: function(result){
                                if(result.success == true){
                                    refresh_orders();
                                    toastr.success(result.msg);
                                } else {
                                    toastr.error(result.msg);
                                }
                            }
                        });
                    }
                });
            });

            $(document).on('click', 'a.mark_line_order_as_served', function(e){
                e.preventDefault();
                swal({
                  title: LANG.sure,
                  icon: "info",
                  buttons: true,
                }).then((sure) => {
                    if (sure) {
                        var _this = $(this);
                        var href = _this.attr('href');
                        $.ajax({
                            method: "GET",
                            url: href,
                            dataType: "json",
                            success: function(result){
                                if(result.success == true){
                                    refresh_orders();
                                    toastr.success(result.msg);
                                } else {
                                    toastr.error(result.msg);
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection