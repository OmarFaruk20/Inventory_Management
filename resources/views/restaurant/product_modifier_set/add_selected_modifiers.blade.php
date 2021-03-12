@if(empty($edit_modifiers))
<small>
	@foreach($modifiers as $modifier)
		@if (!$loop->first)
			{{', '}}
		@endif
		{{$modifier->name}}({{@num_format($modifier->sell_price_inc_tax)}})
		<input type="hidden" name="products[{{$index}}][modifier][]" 
			value="{{$modifier->id}}">
		<input type="hidden" class="modifiers_price" 
			name="products[{{$index}}][modifier_price][]" 
			value="{{@num_format($modifier->sell_price_inc_tax)}}">
		<input type="hidden" 
			name="products[{{$index}}][modifier_set_id][]" 
			value="{{$modifier->product_id}}">
	@endforeach
</small>
@else
	@foreach($modifiers as $modifier)
		@if (!$loop->first)
			{{', '}}
		@endif
		{{$modifier->variations->name or ''}}({{@num_format($modifier->unit_price_inc_tax)}})
		<input type="hidden" name="products[{{$index}}][modifier][]" 
			value="{{$modifier->variation_id}}">
		<input type="hidden" class="modifiers_price" 
			name="products[{{$index}}][modifier_price][]" 
			value="{{@num_format($modifier->unit_price_inc_tax)}}">
		<input type="hidden" 
			name="products[{{$index}}][modifier_set_id][]" 
			value="{{$modifier->product_id}}">
		<input type="hidden" 
			name="products[{{$index}}][modifier_sell_line_id][]" 
			value="{{$modifier->id}}">
	@endforeach
@endif