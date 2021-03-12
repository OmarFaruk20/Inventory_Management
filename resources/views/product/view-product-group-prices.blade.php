<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
		    <button type="button" class="close no-print" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      <h4 class="modal-title" id="modalTitle">{{$product->name}}</h4>
	    </div>
	    <div class="modal-body">
      		<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table bg-gray">
							<tr class="bg-green">
								@if($product->type == 'variable')
									<th>@lang('product.variations')</th>
								@endif
								@can('access_default_selling_price')
							        <th>@lang('product.default_selling_price') (@lang('product.inc_of_tax'))</th>
						        @endcan
						        @if(!empty($allowed_group_prices))
						        	<th>@lang('lang_v1.group_prices')</th>
						        @endif
							</tr>
							@foreach($product->variations as $variation)
							<tr>
								@if($product->type == 'variable')
									<td>
										{{$variation->product_variation->name}} - {{ $variation->name }}
									</td>
								@endif
								@can('access_default_selling_price')
									<td>
										<span class="display_currency" data-currency_symbol="true">{{ $variation->sell_price_inc_tax }}</span>
									</td>
								@endcan
								@if(!empty($allowed_group_prices))
						        	<td class="td-full-width">
						        		@foreach($allowed_group_prices as $key => $value)
						        			<strong>{{$value}}</strong> - @if(!empty($group_price_details[$variation->id][$key]))
						        				<span class="display_currency" data-currency_symbol="true">{{ $group_price_details[$variation->id][$key] }}</span>
						        			@else
						        				0
						        			@endif
						        			<br>
						        		@endforeach
						        	</td>
						        @endif
							</tr>
							@endforeach
						</table>
					</div>
				</div>
			</div>
      	</div>
      	<div class="modal-footer">
	      	<button type="button" class="btn btn-default no-print" data-dismiss="modal">@lang( 'messages.close' )</button>
	    </div>
	</div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    var element = $('div.view_modal');
    __currency_convert_recursively(element);
  });
</script>
