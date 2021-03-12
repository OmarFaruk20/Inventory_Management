<div class="table-responsive">
    <table class="table table-bordered table-striped" id="service_staff_report">
	    <thead>
	        <tr>
	            <th>@lang('messages.date')</th>
	            <th>@lang('sale.invoice_no')</th>
	            <th>@lang('restaurant.service_staff')</th>
	            <th>@lang('sale.location')</th>
	            <th>@lang('sale.subtotal')</th>
	            <th>@lang('lang_v1.total_discount')</th>
	            <th>@lang('lang_v1.total_tax')</th>
	            <th>@lang('sale.total_amount')</th>
	        </tr>
	    </thead>
	    <tfoot>
	        <tr class="bg-gray font-17 footer-total text-center">
	            <td colspan="4"><strong>@lang('sale.total'):</strong></td>
	            <td><span class="display_currency" id="footer_subtotal" data-currency_symbol ="true"></span></td>
	            <td><span class="display_currency" id="footer_total_discount" data-currency_symbol ="true"></span></td>
	            <td><span class="display_currency" id="footer_total_tax" data-currency_symbol ="true"></span></td>
	            <td><span class="display_currency" id="footer_total_amount" data-currency_symbol ="true"></span></td>
	        </tr>
	    </tfoot>
	</table>
</div>