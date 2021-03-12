<table class="table table-condensed bg-gray">
  <tr>
    <th>@lang('purchase.ref_no')</th>
    <th>@lang('lang_v1.paid_on')</th>
    <th>@lang('sale.amount')</th>
    <th>@lang('contact.contact')</th>
    <th>@lang('lang_v1.payment_method')</th>
    <th>@if($child_payments->first()->transaction->type == 'purchase') @lang('purchase.ref_no') @else  @lang('sale.invoice_no') @endif</th>
    <th class="no-print">@lang('messages.action')</th>
  </tr>
  @forelse ($child_payments as $payment)
    <tr>
      <td>{{ $payment->payment_ref_no }}</td>
      <td>{{ @format_date($payment->paid_on) }}</td>
      <td><span class="display_currency" data-currency_symbol="true">{{ $payment->amount }}</span></td>
      <td>{{$payment->transaction->contact->name}}</td>
      <td>{{ $payment_types[$payment->method] }}</td>
      <td>@if($payment->transaction->type != 'opening_balance') <a data-href="@if($payment->transaction->type == 'sell'){{action('SellController@show', [$payment->transaction_id]) }}@else{{action('PurchaseController@show', [$payment->transaction_id]) }}@endif" href="#" data-container=".view_modal" class="btn-modal">@if($payment->transaction->type == 'sell') {{$payment->transaction->invoice_no}} @else {{$payment->transaction->ref_no}} @endif</a> @else
        @lang('lang_v1.opening_balance_payments')
      @endif</td>
      <td class="no-print">
        <button type="button" class="btn btn-primary btn-xs view_payment" data-href="{{ action('TransactionPaymentController@viewPayment', [$payment->id]) }}" >@lang("messages.view")
                    </button>
      </td>
    </tr>
  @empty
    <tr class="text-center">
      <td colspan="6">@lang('purchase.no_records_found')</td>
    </tr>
  @endforelse
</table>