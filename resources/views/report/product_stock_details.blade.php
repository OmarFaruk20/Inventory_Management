@extends('layouts.app')
@section('title', __('lang_v1.product_stock_details'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>{{ __('lang_v1.product_stock_details')}}</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary" id="accordion">
              <div class="box-header with-border">
                <h3 class="box-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseFilter">
                    <i class="fa fa-filter" aria-hidden="true"></i> @lang('report.filters')
                  </a>
                </h3>
              </div>
              <div id="collapseFilter" class="panel-collapse active collapse in" aria-expanded="true">
                <div class="box-body">
                    <div class="row">
                        {!! Form::open(['url' => action('ReportController@productStockDetails'), 'method' => 'get' ]) !!}
                        <div class="col-md-4">
                            <div class="form-group">
                            {!! Form::label('search_product', __('lang_v1.search_product') . ':') !!}
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-search"></i>
                                    </span>
                                    {!! Form::select('variation_id', [], null, ['class' => 'form-control', 'id' => 'variation_id', 'placeholder' => __('lang_v1.search_product_placeholder')]); !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('location_id', __('purchase.business_location').':') !!}
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-map-marker"></i>
                                    </span>
                                    {!! Form::select('location_id', $business_locations, null, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'required']); !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <br>
                                <button type="submit" class="btn btn-primary">@lang('lang_v1.search')</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>

                    @if(!empty($stock_details))
                        <div class="col-md-12">
                        <hr>
                        <div class="row">
                            <table class="table">
                                <tr>
                                    <th>
                                        Product
                                    </th>
                                    <th>
                                        {{ __('report.opening_stock') }}
                                    </th>
                                    <th>
                                        {{ __('home.total_purchase') }}:
                                    </th>
                                    <th>
                                        {{ __('lang_v1.total_purchase_return') }}
                                    </th>
                                    <th>
                                        {{ __('report.total_stock_adjustment') }}
                                    </th>
                                    <th>
                                        {{ __('lang_v1.total_stock_transfered_to_the_location') }}
                                    </th>
                                    <th>
                                        {{ __('lang_v1.total_sold') }}
                                    </th>
                                    <th>
                                        {{ __('lang_v1.total_sell_return') }}
                                    </th>
                                    <th>
                                        {{ __('lang_v1.total_stock_transfered_from_the_location') }}
                                    </th>
                                    <th>
                                        Correct Stock
                                        <small>({{ __('lang_v1.total_stock_calculated') }})</small>
                                    </th>
                                    <th>
                                        Incorrect Stock
                                        <small>({{ __('lang_v1.total_stock_available') }})</small>
                                    </th>
                                    <th>
                                        Fix
                                    </th>
                                </tr>

                            @foreach($stock_details as $row)
                                @php
                                    $stock_mismatch = $row->stock - $row->total_stock_calculated;
                                @endphp
                                @if($stock_mismatch == 0)
                                    @continue
                                @endif

                                <tr>
                                    <td>
                                        {{$row->product}} 
                                        @if($row->type == "variable")     
                                            {{$row->product_variation}} - {{$row->variation_name}} ({{$row->sub_sku}}) 
                                        @else 
                                            ({{$row->sku}}) 
                                        @endif
                                    </td>

                                    <td>
                                        {{$row->total_opening_stock}}
                                    </td>
                                    <td>
                                        {{$row->total_purchased}}
                                    </td>
                                    <td>
                                        {{$row->total_purchase_return}}
                                    </td>
                                    <td>
                                        {{$row->total_adjusted}}
                                    </td>
                                    <td>
                                        {{$row->total_sell_transfered}}
                                    </td>
                                    <td>
                                        {{$row->total_sold}}
                                    </td>
                                    <td>
                                        {{$row->total_sell_return}}
                                    </td>
                                    <td>
                                        {{$row->total_sell_transfered}}
                                    </td>
                                    <td>
                                        {{$row->total_stock_calculated}}
                                    </td>
                                    <td>
                                        {{$row->stock}}
                                    </td>
                                    <td>
                                        <a href="{{action('ReportController@adjustProductStock')}}?location_id={{$location->id}}&variation_id={{$row->variation_id}}&stock={{$row->total_stock_calculated}}" class="btn btn-primary">Fix</a>
                                    </td>
                                </tr>
                            @endforeach
                            </table>
                        </div>
                        </div>
                    @endif
                </div>
              </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
<div class="modal fade view_register" tabindex="-1" role="dialog" 
    aria-labelledby="gridSystemModalLabel">
</div>

@endsection

@section('javascript')
    <script src="{{ asset('js/report.js?v=' . $asset_v) }}"></script>
    <script type="text/javascript">
        $(document).ready( function () {
            //get customer
            $('#variation_id').select2({
                ajax: {
                    url: '/purchases/get_products',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                          term: params.term, // search term
                        };
                    },
                    processResults: function (data) {
                        var data_formated = [];
                        data.forEach(function (item) {
                            var temp = {
                                'id': item.variation_id,
                                'text': item.text
                            }
                            data_formated.push(temp);
                        });
                        return {
                            results: data_formated
                        };
                    }
                },
                minimumInputLength: 1,
            });
        });
    </script>
@endsection