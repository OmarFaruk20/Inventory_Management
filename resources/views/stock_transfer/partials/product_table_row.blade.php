<tr class="product_row">
    <td>
        {{$product->product_name}}
        <br/>
        {{$product->sub_sku}}
    </td>
    <td>
        {{-- If edit then transaction sell lines will be present --}}
        @if(!empty($product->transaction_sell_lines_id))
            <input type="hidden" name="products[{{$row_index}}][transaction_sell_lines_id]" class="form-control" value="{{$product->transaction_sell_lines_id}}">
        @endif

        <input type="hidden" name="products[{{$row_index}}][product_id]" class="form-control product_id" value="{{$product->product_id}}">

        <input type="hidden" value="{{$product->variation_id}}" 
            name="products[{{$row_index}}][variation_id]">

        <input type="hidden" value="{{$product->enable_stock}}" 
            name="products[{{$row_index}}][enable_stock]">
        
        @if(empty($product->quantity_ordered))
            @php
                $product->quantity_ordered = 1;
            @endphp
        @endif

        <input type="text" class="form-control product_quantity input_number input_quantity" value="{{@format_quantity($product->quantity_ordered)}}" name="products[{{$row_index}}][quantity]" 
        @if($product->unit_allow_decimal == 1) data-decimal=1 @else data-decimal=0 data-rule-abs_digit="true" data-msg-abs_digit="@lang('lang_v1.decimal_value_not_allowed')" @endif
        data-rule-required="true" data-msg-required="@lang('validation.custom-messages.this_field_is_required')" @if($product->enable_stock) data-rule-max-value="{{$product->qty_available}}" data-msg-max-value="@lang('validation.custom-messages.quantity_not_available', ['qty'=> $product->formatted_qty_available, 'unit' => $product->unit  ])" @endif >
        {{$product->unit}}
    </td>
    <td>
        <input type="text" name="products[{{$row_index}}][unit_price]" class="form-control product_unit_price input_number" value="{{@num_format($product->last_purchased_price)}}">
    </td>
    <td>
        <input type="text" readonly name="products[{{$row_index}}][price]" class="form-control product_line_total" value="{{@num_format($product->quantity_ordered*$product->last_purchased_price)}}">
    </td>
    <td class="text-center">
        <i class="fa fa-trash remove_product_row cursor-pointer" aria-hidden="true"></i>
    </td>
</tr>