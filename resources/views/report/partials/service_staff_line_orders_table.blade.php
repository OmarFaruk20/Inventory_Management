<table class="table table-bordered table-striped" id="service_staff_line_orders" style="width: 100%;">
    <thead>
        <tr>
            <th>@lang('messages.date')</th>
            <th>@lang('sale.invoice_no')</th>
            <th>@lang('restaurant.service_staff')</th>
            <th>@lang('sale.product')</th>
            <th>@lang('lang_v1.quantity')</th>
            <th>@lang('sale.unit_price')</th>
            <th>@lang('sale.discount')</th>
            <th>@lang('sale.tax')</th>
            <th>@lang('lang_v1.net_price')</th>
            <th>@lang('sale.total')</th>
        </tr>
    </thead>
    <tfoot>
        <tr class="bg-gray font-17 footer-total text-center">
            <td colspan="4"><strong>@lang('sale.total'):</strong></td>
            <td id="sslo_quantity"></td>
            <td><span class="display_currency" id="sslo_unit_price" data-currency_symbol ="true"></span></td>
            <td><span class="display_currency" id="sslo_total_discount" data-currency_symbol ="true"></span></td>
            <td><span class="display_currency" id="sslo_total_tax" data-currency_symbol ="true"></span></td>
            <td><span class="display_currency" id="sslo_subtotal" data-currency_symbol ="true"></span></td>
            <td><span class="display_currency" id="sslo_total" data-currency_symbol ="true"></span></td>
        </tr>
    </tfoot>
</table>