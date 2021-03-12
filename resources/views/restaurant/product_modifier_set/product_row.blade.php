<tr>
	<td>{{$product->name}} ({{$product->sku}})</td>
	<input type="hidden" name="products[]" value="{{$product->id}}">
	<td><button type="button" class="btn btn-danger btn-xs remove_modifier_product"><i class="fa fa-close"></i></button></td>
</tr>