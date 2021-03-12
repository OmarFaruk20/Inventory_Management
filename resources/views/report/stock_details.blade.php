<div class="row">
	<div class="col-md-10 col-md-offset-1 col-xs-12">
		<div class="table-responsive">
			<table class="table table-condensed bg-gray">
				<tr>
					<th>SKU</th>
					<th>Variation</th>
					<th>@lang('sale.unit_price')</th>
					<th>@lang('report.current_stock')</th>
					<th>@lang('report.total_unit_sold')</th>
					<th>@lang('lang_v1.total_unit_transfered')</th>
                    <th>@lang('lang_v1.total_unit_adjusted')</th>
				</tr>
				@foreach( $product_details as $details )
					<tr>
						<td>{{ $details->sub_sku}}</td>
						<td>
							{{ $details->product . '-' . $details->product_variation . 
							'-' .  $details->variation }}
						</td>
						<td><span class="display_currency" data-currency_symbol=true>{{$details->sell_price_inc_tax}}</span></td>
						<td>
							@if($details->stock)
								<span class="display_currency" data-currency_symbol=false>{{ (float)$details->stock }}</span> {{$details->unit}}
							@else
							 0
							@endif
						</td>
						<td>
							@if($details->total_sold)
								<span class="display_currency" data-currency_symbol=false>{{ (float)$details->total_sold }}</span> {{$details->unit}}
							@else
							 0
							@endif
						</td>
						<td>
							@if($details->total_transfered)
								<span class="display_currency" data-currency_symbol=false>{{ (float)$details->total_transfered }}</span> {{$details->unit}}
							@else
							 0
							@endif
						</td>
						<td>
							@if($details->total_adjusted)
								<span class="display_currency" data-currency_symbol=false>{{ (float)$details->total_adjusted }}</span> {{$details->unit}}
							@else
							 0
							@endif
						</td>
					</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>