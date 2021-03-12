<table class='table table-condensed table-striped'>
	<tr>
	    <th>@lang('business.operations')</th>
	    <th>@lang('business.keyboard_shortcut')</th>
	</tr>
	<tr>
	    <td>@lang('lang_v1.recent_product_quantity'):</td>
	    <td>
	    	@if(!empty($shortcuts["pos"]["recent_product_quantity"]))
		    	{{ $shortcuts["pos"]["recent_product_quantity"] }}
		    @endif
	    </td>
	</tr>

	<tr>
	    <td>@lang('lang_v1.add_new_product'):</td>
	    <td>
	    	@if(!empty($shortcuts["pos"]["add_new_product"]))
		    	{{ $shortcuts["pos"]["add_new_product"] }}
		    @endif
	    </td>
	</tr>
	
</table>