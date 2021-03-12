<div class="modal-dialog modal-xl" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close no-print" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="modalTitle"> @lang('lang_v1.purchase_return_details') (<b>@lang('purchase.ref_no'):</b> #{{ $purchase->return_parent->ref_no ?? $purchase->ref_no}})
        </h4>
    </div>

    <div class="modal-body">
      <div class="row">
        @if(!empty($purchase->return_parent))
        <div class="col-sm-6 col-xs-6">
            <h4>@lang('lang_v1.purchase_return_details'):</h4>
            <strong>@lang('lang_v1.return_date'):</strong> {{@format_date($purchase->return_parent->transaction_date)}}<br>
            <strong>@lang('purchase.supplier'):</strong> {{ $purchase->contact->name }} <br>
            <strong>@lang('purchase.business_location'):</strong> {{ $purchase->location->name }}
        </div>
        <div class="col-sm-6 col-xs-6">
            <h4>@lang('purchase.purchase_details'):</h4>
            <strong>@lang('purchase.ref_no'):</strong> {{ $purchase->ref_no }} <br>
            <strong>@lang('messages.date'):</strong> {{@format_date($purchase->transaction_date)}}
        </div>
        @else
            <div class="col-sm-6 col-xs-6">
                <h4>@lang('lang_v1.purchase_return_details'):</h4>
                <strong>@lang('lang_v1.return_date'):</strong> {{@format_date($purchase->transaction_date)}}<br>
                <strong>@lang('purchase.supplier'):</strong> {{ $purchase->contact->name ?? '' }} <br>
                <strong>@lang('purchase.business_location'):</strong> {{ $purchase->location->name }}
            </div>
        @endif
        @if(empty($purchase->return_parent))
            @if($purchase->document_path)
                <div class="col-md-12">
                    <a href="{{$purchase->document_path}}" 
                      download="{{$purchase->document_name}}" class="btn btn-sm btn-success pull-right no-print">
                        <i class="fa fa-download"></i> 
                          &nbsp;{{ __('purchase.download_document') }}
                    </a>
                </div>
            @endif
        @endif
      </div>
      <br>
      <div class="row">
        <div class="col-sm-12">
          <br>
          <table class="table bg-gray">
            <thead>
              <tr class="bg-green">
                  <th>#</th>
                  <th>@lang('product.product_name')</th>
                  <th>@lang('sale.unit_price')</th>
                  <th>@lang('lang_v1.return_quantity')</th>
                  <th>@lang('lang_v1.return_subtotal')</th>
              </tr>
          </thead>
          <tbody>
              @php
                $total_before_tax = 0;
              @endphp
              @foreach($purchase->purchase_lines as $purchase_line)
              @if($purchase_line->quantity_returned == 0)
                @continue
              @endif

              @php
                $unit_name = $purchase_line->product->unit->short_name;
                if(!empty($purchase_line->sub_unit)) {
                  $unit_name = $purchase_line->sub_unit->short_name;
                }
              @endphp
              <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>
                    {{ $purchase_line->product->name }}
                    @if( $purchase_line->product->type == 'variable')
                      - {{ $purchase_line->variations->product_variation->name}}
                      - {{ $purchase_line->variations->name}}
                    @endif
                  </td>
                  <td><span class="display_currency" data-currency_symbol="true">{{ $purchase_line->purchase_price_inc_tax }}</span></td>
                  <td>{{@format_quantity($purchase_line->quantity_returned)}} {{$unit_name}}</td>
                  <td>
                    @php
                      $line_total = $purchase_line->purchase_price_inc_tax * $purchase_line->quantity_returned;
                      $total_before_tax += $line_total ;
                    @endphp
                    <span class="display_currency" data-currency_symbol="true">{{$line_total}}</span>
                  </td>
              </tr>
              @endforeach
            </tbody>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
        <table class="table">
          <tr>
            <th>@lang('purchase.net_total_amount'): </th>
            <td></td>
            <td><span class="display_currency pull-right" data-currency_symbol="true">{{ $total_before_tax }}</span></td>
          </tr>
          
          <tr>
            <th>@lang('lang_v1.total_return_tax'):</th>
            <td><b>(+)</b></td>
            <td class="text-right">
                @if(!empty($purchase_taxes))
                  @foreach($purchase_taxes as $k => $v)
                    <strong><small>{{$k}}</small></strong> - <span class="display_currency pull-right" data-currency_symbol="true">{{ $v }}</span><br>
                  @endforeach
                @else
                0.00
                @endif
              </td>
          </tr>
          <tr>
            <th>@lang('lang_v1.return_total'):</th>
            <td></td>
            <td><span class="display_currency pull-right" data-currency_symbol="true" >{{ $purchase->return_parent->final_total ??  $purchase->final_total }}</span></td>
          </tr>
        </table>
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-primary no-print" aria-label="Print" 
      onclick="$(this).closest('div.modal-content').printThis();"><i class="fa fa-print"></i> @lang( 'messages.print' )
      </button>
      <button type="button" class="btn btn-default no-print" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var element = $('div.modal-xl');
		__currency_convert_recursively(element);
	});
</script>