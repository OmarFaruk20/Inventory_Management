<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close no-print" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title no-print">
        @lang( 'lang_v1.view_payment' )
        @if(!empty($single_payment_line->payment_ref_no))
          ( @lang('purchase.ref_no'): {{ $single_payment_line->payment_ref_no }} )
        @endif
      </h4>
      <h4 class="modal-title visible-print-block">
        @if(!empty($single_payment_line->payment_ref_no))
          ( @lang('purchase.ref_no'): {{ $single_payment_line->payment_ref_no }} )
        @endif
      </h4>
    </div>
    <div class="modal-body">
      @if(!empty($transaction))
      <div class="row">
        @if(in_array($transaction->type, ['purchase', 'purchase_return']))
            <div class="col-xs-6">
              @lang('purchase.supplier'):
              <address>
                <strong>{{ $transaction->contact->supplier_business_name }}</strong>
                {{ $transaction->contact->name }}
                @if(!empty($transaction->contact->landmark))
                  <br>{{$transaction->contact->landmark}}
                @endif
                @if(!empty($transaction->contact->city) || !empty($transaction->contact->state) || !empty($transaction->contact->country))
                  <br>{{implode(',', array_filter([$transaction->contact->city, $transaction->contact->state, $transaction->contact->country]))}}
                @endif
                @if(!empty($transaction->contact->tax_number))
                  <br>@lang('contact.tax_no'): {{$transaction->contact->tax_number}}
                @endif
                @if(!empty($transaction->contact->mobile))
                  <br>@lang('contact.mobile'): {{$transaction->contact->mobile}}
                @endif
                @if(!empty($transaction->contact->email))
                  <br>Email: {{$transaction->contact->email}}
                @endif
              </address>
            </div>
            <div class="col-xs-6">
              @lang('business.business'):
              <address>
                <strong>{{ $transaction->business->name }}</strong>
                {{ $transaction->location->name }}
                @if(!empty($transaction->location->landmark))
                  <br>{{$transaction->location->landmark}}
                @endif
                @if(!empty($transaction->location->city) || !empty($transaction->location->state) || !empty($transaction->location->country))
                  <br>{{implode(',', array_filter([$transaction->location->city, $transaction->location->state, $transaction->location->country]))}}
                @endif
                
                @if(!empty($transaction->business->tax_number_1))
                  <br>{{$transaction->business->tax_label_1}}: {{$transaction->business->tax_number_1}}
                @endif

                @if(!empty($transaction->business->tax_number_2))
                  <br>{{$transaction->business->tax_label_2}}: {{$transaction->business->tax_number_2}}
                @endif

                @if(!empty($transaction->location->mobile))
                  <br>@lang('contact.mobile'): {{$transaction->location->mobile}}
                @endif
                @if(!empty($transaction->location->email))
                  <br>@lang('business.email'): {{$transaction->location->email}}
                @endif
              </address>
            </div>
        @else
          <div class="col-xs-6">
             @lang('contact.customer'):
            <address>
              <strong>{{ $transaction->contact->name ?? '' }}</strong>
             
              @if(!empty($transaction->contact->landmark))
                <br>{{$transaction->contact->landmark}}
              @endif
              @if(!empty($transaction->contact->city) || !empty($transaction->contact->state) || !empty($transaction->contact->country))
                <br>{{implode(',', array_filter([$transaction->contact->city, $transaction->contact->state, $transaction->contact->country]))}}
              @endif
              @if(!empty($transaction->contact->tax_number))
                <br>@lang('contact.tax_no'): {{$transaction->contact->tax_number}}
              @endif
              @if(!empty($transaction->contact->mobile))
                <br>@lang('contact.mobile'): {{$transaction->contact->mobile}}
              @endif
              @if(!empty($transaction->contact->email))
                <br>Email: {{$transaction->contact->email}}
              @endif
            </address>
          </div>
          <div class="col-xs-6">
            @lang('business.business'):
            <address>
              <strong>{{ $transaction->business->name }}</strong>
              {{ $transaction->location->name }}
              @if(!empty($transaction->location->landmark))
                <br>{{$transaction->location->landmark}}
              @endif
              @if(!empty($transaction->location->city) || !empty($transaction->location->state) || !empty($transaction->location->country))
                <br>{{implode(',', array_filter([$transaction->location->city, $transaction->location->state, $transaction->location->country]))}}
              @endif
              
              @if(!empty($transaction->business->tax_number_1))
                <br>{{$transaction->business->tax_label_1}}: {{$transaction->business->tax_number_1}}
              @endif

              @if(!empty($transaction->business->tax_number_2))
                <br>{{$transaction->business->tax_label_2}}: {{$transaction->business->tax_number_2}}
              @endif

              @if(!empty($transaction->location->mobile))
                <br>@lang('contact.mobile'): {{$transaction->location->mobile}}
              @endif
              @if(!empty($transaction->location->email))
                <br>@lang('business.email'): {{$transaction->location->email}}
              @endif
            </address>
          </div>
        @endif
      </div>
      @endif
      <div class="row">
          <br>
          <div class="col-xs-6">
            <strong>@lang('purchase.amount') :</strong>
            <span class="display_currency" data-currency_symbol="true">
              {{$single_payment_line->amount}}
            </span><br>
            <strong>@lang('lang_v1.payment_method') :</strong>
            {{ $payment_types[$single_payment_line->method] }}<br>
            @if($single_payment_line->method == "card")
              <strong>@lang('lang_v1.card_holder_name') :</strong>
              {{ $single_payment_line->card_holder_name }} <br>
              <strong>@lang('lang_v1.card_number') :</strong>
              {{ $single_payment_line->card_number }} <br>
              <strong>@lang('lang_v1.card_transaction_number') :</strong>
              {{ $single_payment_line->card_transaction_number }}
              
            @elseif($single_payment_line->method == "cheque")
              <strong>@lang('lang_v1.cheque_number') :</strong>
              {{ $single_payment_line->cheque_number }}
            @elseif($single_payment_line->method == "bank_transfer")

            @elseif($single_payment_line->method == "custom_pay_1")

              <strong>@lang('lang_v1.transaction_number') :</strong>
              {{ $single_payment_line->transaction_no }}
            @elseif($single_payment_line->method == "custom_pay_2")

              <strong>@lang('lang_v1.transaction_number') :</strong>
              {{ $single_payment_line->transaction_no }}
            @elseif($single_payment_line->method == "custom_pay_3")

              <strong> @lang('lang_v1.transaction_number'):</strong>
              {{ $single_payment_line->transaction_no }}
            @endif
            <strong>@lang('purchase.payment_note') :</strong>
              {{ $single_payment_line->note }}
          </div>
          <div class="col-xs-6">
            <b>@lang('purchase.ref_no'):</b> 
              @if(!empty($single_payment_line->payment_ref_no))
                {{ $single_payment_line->payment_ref_no }}
              @else
                --
              @endif
              <br/>
            <b>@lang('lang_v1.paid_on'):</b> {{ @format_date($single_payment_line->paid_on) }}<br/>
            <br>
            @if(!empty($single_payment_line->document_path))
              <a href="{{$single_payment_line->document_path}}" class="btn btn-success btn-xs no-print" download="{{$single_payment_line->document_name}}"><i class="fa fa-download" data-toggle="tooltip" title="{{__('purchase.download_document')}}"></i> {{__('purchase.download_document')}}</a>
            @endif
          </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-primary no-print" 
        aria-label="Print" 
          onclick="$(this).closest('div.modal').printThis();">
        <i class="fa fa-print"></i> @lang( 'messages.print' )
      </button>
      <button type="button" class="btn btn-default no-print" data-dismiss="modal">@lang( 'messages.close' )
      </button>
    </div>
  </div>
</div>