<table class="table table-condensed no-border">
	@if(!empty($tax_details['tax_details']))
		@foreach( $tax_details['tax_details'] as $tax_rate)
		 <tr>
		 	<th @if($tax_rate['is_tax_group']) rowspan="2" @endif>{{ $tax_rate['tax_name'] }}</th>
		 	<td><span class="display_currency" data-currency_symbol="true">{{ $tax_rate['tax_amount'] }}</span></td>
		 </tr>
		 @if($tax_rate['is_tax_group'])
		 	<tr>
		 		<td class="text-muted" style="padding-top: 0;">
		 			@foreach($tax_rate['group_tax_details'] as $group_tax)
		 				<small>{{ $group_tax['name'] }}</small> - <small><span class="display_currency" data-currency_symbol="true">{{ $group_tax['calculated_tax'] }}</span></small><br>
		 			@endforeach
		 		</td>
		 	</tr>
		@endif
		 	
		@endforeach
	@endif
	<tr>
		<th>@lang('sale.total')</th>
		<th><span class="display_currency" data-currency_symbol="true">{{$tax_details['total_tax']}}</span></th>
	</tr>
</table>