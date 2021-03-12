<div class="row">
	<div class="col-xs-12 col-sm-10 col-sm-offset-1">
		<div class="table-responsive">
			<table class="table table-condensed bg-gray">
				<tr>
					<th>@lang('sale.product')</th>
					@if(!empty($lot_n_exp_enabled))
                		<th>{{ __('lang_v1.lot_n_expiry') }}</th>
              		@endif
					<th>@lang('sale.qty')</th>
					<th>@lang('sale.unit_price')</th>
					<th>@lang('sale.subtotal')</th>
				</tr>
				@foreach( $stock_adjustment_details as $details )
					<tr>
						<td>
							{{ $details->product }} 
							@if( $details->type == 'variable')
							 {{ '-' . $details->product_variation . '-' . $details->variation }} 
							@endif 
							( {{ $details->sub_sku }} )
						</td>
						@if(!empty($lot_n_exp_enabled))
                			<td>{{ $details->lot_number or '--' }}
			                  @if( session()->get('business.enable_product_expiry') == 1 && !empty($details->exp_date))
			                    ({{@format_date($details->exp_date)}})
			                  @endif
			                </td>
              			@endif
						<td>
							{{@format_quantity($details->quantity)}}
						</td>
						<td>
							{{@num_format($details->unit_price)}}
						</td>
						<td>
							{{@num_format($details->unit_price * $details->quantity)}}
						</td>
					</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>