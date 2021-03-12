<div class="table-responsive">
<table class="table table-bordered table-striped" id="sr_expenses_report" style="width: 100%;">
    <thead>
        <tr>
            <th>@lang('messages.date')</th>
            <th>@lang('purchase.ref_no')</th>
            <th>@lang('expense.expense_category')</th>
            <th>@lang('business.location')</th>
            <th>@lang('sale.payment_status')</th>
            <th>@lang('sale.total_amount')</th>
            <th>@lang('expense.expense_for')</th>
            <th>@lang('expense.expense_note')</th>
        </tr>
    </thead>
    <tfoot>
        <tr class="bg-gray font-17 text-center footer-total">
            <td colspan="4"><strong>@lang('sale.total'):</strong></td>
            <td id="er_footer_payment_status_count"></td>
            <td><span class="display_currency" id="footer_expense_total" data-currency_symbol ="true"></span></td>
            <td colspan="2"></td>
        </tr>
    </tfoot>
</table>
</div>