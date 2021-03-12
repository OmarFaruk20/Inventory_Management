<tr class="product_row">
	<td>
		{{$product->product_name}}
		<br/>
		{{$product->sub_sku}}@if(!empty($product->brand)), {{$product->brand}} @endif
		&nbsp;
		<input type="hidden" class="enable_sr_no" value="{{$product->enable_sr_no}}">
		<i class="fa fa-commenting cursor-pointer text-primary add-pos-row-description" title="@lang('lang_v1.add_description')" data-toggle="modal" data-target="#row_description_modal_{{$row_count}}"></i>
	</td>
	<td>
		<input type="hidden" name="products[{{$row_count}}][product_id]" class="form-control product_id" value="{{$product->product_id}}">

		<input type="hidden" value="{{$product->variation_id}}" 
			name="products[{{$row_count}}][variation_id]" class="row_variation_id">

		<input type="hidden" value="{{$product->enable_stock}}" 
			name="products[{{$row_count}}][enable_stock]">
		
		@if(empty($product->quantity_ordered))
			@php
				$product->quantity_ordered = 1;
			@endphp
		@endif
		<div class="input-group input-number">
			<span class="input-group-btn"><button type="button" class="btn btn-default btn-flat quantity-down"><i class="fa fa-minus text-danger"></i></button></span>
		<input type="text" class="form-control pos_quantity input_number mousetrap" value="{{@num_format($product->quantity_ordered)}}" name="products[{{$row_count}}][quantity]" 
		@if($product->unit_allow_decimal == 1) data-decimal=1 @else data-decimal=0 data-rule-abs_digit="true" data-msg-abs_digit="@lang('lang_v1.decimal_value_not_allowed')" @endif
		data-rule-required="true" data-msg-required="@lang('validation.custom-messages.this_field_is_required')" >
		<span class="input-group-btn"><button type="button" class="btn btn-default btn-flat quantity-up"><i class="fa fa-plus text-success"></i></button></span>
		</div>
		{{$product->unit}}
		
	</td>
	<td>
		<input type="text" name="products[{{$row_count}}][unit_price]" class="form-control pos_unit_price input_number mousetrap" value="{{@num_format($product->default_sell_price)}}">
	</td>
	@php
		$hide_tax = 'hide';
        if(session()->get('business.enable_inline_tax') == 1){
            $hide_tax = '';
        }
        
		$tax_id = $product->tax_id;
		$unit_price_inc_tax = $product->sell_price_inc_tax;
		if($hide_tax == 'hide'){
			$tax_id = null;
			$unit_price_inc_tax = $product->default_sell_price;
		}
	@endphp
	<td class="{{$hide_tax}}">
		<input type="hidden" name="products[{{$row_count}}][item_tax]" class="form-control item_tax">
		
		{!! Form::select("products[$row_count][tax_id]", $tax_dropdown['tax_rates'], $tax_id, ['placeholder' => 'Select', 'class' => 'form-control tax_id'], $tax_dropdown['attributes']); !!}
	</td>
	<td class="{{$hide_tax}}">
		<input type="text" name="products[{{$row_count}}][unit_price_inc_tax]" class="form-control pos_unit_price_inc_tax input_number" value="{{@num_format($unit_price_inc_tax)}}">
	</td>
	<td>
		<input type="text" readonly name="products[{{$row_count}}][price]" class="form-control pos_line_total" value="{{@num_format($product->quantity_ordered*$unit_price_inc_tax )}}">
	</td>
	@if(session('business.enable_lot_number'))
        <td>
            {!! Form::text('products[' . $row_count . '][lot_number]', null, ['class' => 'form-control input-sm']); !!}
        </td>
    @endif

    @if(session('business.enable_product_expiry'))
        <td style="text-align: left;">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </span>
                {!! Form::text('products[' . $row_count . '][exp_date]', null, ['class' => 'form-control input-sm expiry_datepicker', 'readonly']); !!}
            </div>
        </td>
    @endif

	<td class="text-center">
		<i class="fa fa-trash pos_remove_row cursor-pointer" aria-hidden="true"></i>
	</td>
</tr>

<script type="text/javascript">
	$(document).ready(function(){
		$('input.expiry_datepicker').datepicker({
        	autoclose: true,
        	format:datepicker_date_format
    	});
	});
</script>