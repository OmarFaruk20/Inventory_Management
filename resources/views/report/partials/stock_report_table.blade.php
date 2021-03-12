<div class="table-responsive">
    <table class="table table-bordered table-striped" id="stock_report_table">
        <thead>
            <tr>
                <th>SKU</th>
                <th>@lang('business.product')</th>
                <th>@lang('sale.unit_price')</th>
                <th>@lang('report.current_stock')</th>
                <th>@lang('report.total_unit_sold')</th>
                <th>@lang('lang_v1.total_unit_transfered')</th>
                <th>@lang('lang_v1.total_unit_adjusted')</th>
            </tr>
        </thead>
        <tfoot>
            <tr class="bg-gray font-17 text-center footer-total">
                <td colspan="3"><strong>@lang('sale.total'):</strong></td>
                <td id="footer_total_stock"></td>
                <td id="footer_total_sold"></td>
                <td id="footer_total_transfered"></td>
                <td id="footer_total_adjusted"></td>
            </tr>
        </tfoot>
    </table>
</div>