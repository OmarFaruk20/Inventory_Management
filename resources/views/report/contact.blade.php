@extends('layouts.app')
@section('title', __('report.customer') . ' - ' . __('report.supplier') . ' ' . __('report.reports'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>{{ __('report.customer')}} & {{ __('report.supplier')}} {{ __('report.reports')}}</h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-primary'])
    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="supplier_report_tbl">
            <thead>
                <tr>
                    <th>@lang('report.contact')</th>
                    <th>@lang('report.total_purchase')</th>
                    <th>@lang('lang_v1.total_purchase_return')</th>
                    <th>@lang('report.total_sell')</th>
                    <th>@lang('lang_v1.total_sell_return')</th>
                    <th>@lang('lang_v1.opening_balance_due')</th>
                    <th>@lang('report.total_due') &nbsp;&nbsp;<i class="fa fa-info-circle text-info no-print" data-toggle="tooltip" data-placement="bottom" data-html="true" data-original-title="{{ __('messages.due_tooltip')}}" aria-hidden="true"></i></th>
                </tr>
            </thead>
            <tfoot>
                <tr class="bg-gray font-17 footer-total text-center">
                    <td><strong>@lang('sale.total'):</strong></td>
                    <td><span class="display_currency" id="footer_total_purchase" data-currency_symbol ="true"></span></td>
                    <td><span class="display_currency" id="footer_total_purchase_return" data-currency_symbol ="true"></span></td>
                    <td><span class="display_currency" id="footer_total_sell" data-currency_symbol ="true"></span></td>
                    <td><span class="display_currency" id="footer_total_sell_return" data-currency_symbol ="true"></span></td>
                    <td><span class="display_currency" id="footer_total_opening_bal_due" data-currency_symbol ="true"></span></td>
                    <td><span class="display_currency" id="footer_total_due" data-currency_symbol ="true"></span></td>
                </tr>
            </tfoot>
        </table>
    </div>
    @endcomponent
</section>
<!-- /.content -->

@endsection

@section('javascript')
    <script src="{{ asset('js/report.js?v=' . $asset_v) }}"></script>
@endsection