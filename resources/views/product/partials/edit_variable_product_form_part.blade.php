<div class="col-sm-12">
  <h4>Add Variation:* 
  <button type="button" class="btn btn-primary" id="add_variation" data-action="edit" >+</button></h4>
</div>
<div class="col-sm-12">
    <div class="table-responsive">
    <table class="table table-bordered add-product-price-table table-condensed" id="product_variation_form_part">
        <thead>
          <tr>
            <th class="col-sm-2">@lang('product.variation_name')</th>
            <th class="col-sm-9">@lang('product.variation_values')</th>
          </tr>
        </thead>
        <tbody>
        @foreach( $product_variations as $product_variation)
          <?php $count = $loop->index; ?>
          <tr class="variation_row">
            <td>
              {!! Form::text('product_variation[' . $loop->index . '][name]', $product_variation->name,
              ['class' => 'form-control input-sm variation_name', 'required']); !!}
              <input type="hidden" class="row_index" value="{{  $loop->index }}">
              {!! Form::hidden('product_variation[' . $loop->index . '][product_variation_id]', $product_variation->id); !!}
            </td>
            <td>
                <table class="table table-condensed table-bordered blue-header variation_value_table">
                    <tr>
                        <th>@lang('product.value')</th>
                        <th>@lang('product.default_purchase_price') &nbsp;&nbsp;<b><i class="fa fa-info-circle" aria-hidden="true" data-toggle="popover" data-html="true" data-trigger="hover" data-content="<p class='text-primary'>Drag the mouse over the table cells to copy input values</p>" data-placement="top"></i></b></th>
                        <th>@lang('product.default_selling_price') &nbsp;&nbsp;<b><i class="fa fa-info-circle" aria-hidden="true" data-toggle="popover" data-html="true" data-trigger="hover" data-content="<p class='text-primary'>Drag the mouse over the table cells to copy input values</p>" data-placement="top"></i></b></th>
                        <th><button type="button" class="btn btn-success btn-xs add_variation_value_row">+</button></th>
                    </tr>
                    @foreach($product_variation->variations as $variation )
                    <tr>
                        <td>
                          {!! Form::text('product_variation[' . $loop->parent->index . '][variations][' . $loop->index . '][value]',
                          $variation->name, ['class' => 'form-control input-sm variation_value_name', 'required']); !!}
                          {!! Form::hidden('product_variation[' . $loop->parent->index . '][variations][' . $loop->index . '][variation_id]', $variation->id); !!}
                        </td>
                        <td class="drag-select">
                          {!! Form::number('product_variation[' . $loop->parent->index . '][variations][' . $loop->index . '][default_purchase_price]',
                          $variation->default_purchase_price, ['class' => 'form-control input-sm dpp', 'min' => '0']); !!}
                        </td>
                        <td class="drag-select">
                          {!! Form::number('product_variation[' . $loop->parent->index . '][variations][' . $loop->index . '][default_sell_price]',
                          $variation->default_sell_price, ['class' => 'form-control input-sm variable_dsp', 'min' => '0', 'placeholder' => __('product.exc_of_tax')]); !!}
                          {!! Form::number('product_variation[' . $loop->parent->index . '][variations][' . $loop->index . '][sell_price_inc_tax]',
                          $variation->sell_price_inc_tax, ['class' => 'form-control input-sm variable_dsp_inc_tax', 'min' => '0', 'placeholder' => __('product.inc_of_tax')]); !!}
                        </td>
                        <td><button type="button" class="btn btn-danger btn-xs remove_variation_value_row">-</button>
                        <input type="hidden" class="variation_row_index" value="{{ $loop->index }}"></td>
                    </tr>
                    @endforeach
                </table>
            </td>
          </tr>
        @endforeach
        </tbody>
    </table>
    </div>
</div>
<input type="hidden" id="variation_counter" value="{{ $count + 1 }}">