<tr class="product_row">
    <td>
        {{$product->product_name}}
        <br/>
        {{$product->sub_sku}}
    </td>
    @if(session('business.enable_lot_number'))
        <td>
            <input type="text" name="products[{{$row_index}}][lot_number]" class="form-control" value="{{$product->lot_number ?? ''}}">
        </td>
    @endif
    @if(session('business.enable_product_expiry'))
        <td>
            <input type="text" name="products[{{$row_index}}][exp_date]" class="form-control expiry_datepicker" value="@if(!empty($product->exp_date)){{@format_date($product->exp_date)}}@endif" readonly>
        </td>
    @endif
    <td>
        <input type="hidden" name="products[{{$row_index}}][product_id]" class="form-control product_id" value="{{$product->product_id}}">

        <input type="hidden" value="{{$product->variation_id}}" 
            name="products[{{$row_index}}][variation_id]">

        <input type="hidden" value="{{$product->enable_stock}}" 
            name="products[{{$row_index}}][enable_stock]">

        @if(!empty($edit))
            <input type="hidden" value="{{$product->purchase_line_id}}" 
            name="products[{{$row_index}}][purchase_line_id]">
            @php
                $qty = $product->quantity_returned;
                $purchase_price = $product->purchase_price;
            @endphp
        @else
            @php
                $qty = 1;
                $purchase_price = $product->last_purchased_price;
            @endphp
        @endif

        <input type="text" class="form-control product_quantity input_number input_quantity" value="{{@format_quantity($qty)}}" name="products[{{$row_index}}][quantity]" 
        @if($product->unit_allow_decimal == 1) data-decimal=1 @else data-rule-abs_digit="true" data-msg-abs_digit="@lang('lang_v1.decimal_value_not_allowed')" data-decimal=0 @endif
        data-rule-required="true" data-msg-required="@lang('validation.custom-messages.this_field_is_required')" @if($product->enable_stock) data-rule-max-value="{{$product->qty_available}}" data-msg-max-value="@lang('validation.custom-messages.quantity_not_available', ['qty'=> $product->formatted_qty_available, 'unit' => $product->unit  ])"
        data-qty_available="{{$product->qty_available}}" 
        data-msg_max_default="@lang('validation.custom-messages.quantity_not_available', ['qty'=> $product->formatted_qty_available, 'unit' => $product->unit  ])"
         @endif >
        {{$product->unit}}
    </td>
    <td>
        <input type="text" name="products[{{$row_index}}][unit_price]" class="form-control product_unit_price input_number" value="{{@num_format($purchase_price)}}">
    </td>
    <td>
        <input type="text" readonly name="products[{{$row_index}}][price]" class="form-control product_line_total" value="{{@num_format($qty*$purchase_price)}}">
    </td>
    <td class="text-center">
        <i class="fa fa-trash remove_product_row cursor-pointer" aria-hidden="true"></i>
    </td>
</tr>