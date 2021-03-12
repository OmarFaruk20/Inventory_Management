<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('DiscountController@update', [$discount->id]), 'method' => 'put', 'id' => 'discount_form' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'sale.edit_discount' )</h4>
    </div>

    <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            {!! Form::label('name', __( 'unit.name' ) . ':*') !!}
              {!! Form::text('name', $discount->name, ['class' => 'form-control', 'required', 'placeholder' => __( 'unit.name' ) ]); !!}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            {!! Form::label('brand_id', __('product.brand') . ':') !!}
              {!! Form::select('brand_id', $brands, $discount->brand_id, ['placeholder' => __('messages.please_select'), 'class' => 'form-control select2']); !!}
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            {!! Form::label('category_id', __('product.category') . ':') !!}
              {!! Form::select('category_id', $categories, $discount->category_id, ['placeholder' => __('messages.please_select'), 'class' => 'form-control select2']); !!}
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            {!! Form::label('location_id', __('sale.location') . ':*') !!}
              {!! Form::select('location_id', $locations, $discount->location_id, ['placeholder' => __('messages.please_select'), 'class' => 'form-control select2', 'required']); !!}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            {!! Form::label('priority', __( 'lang_v1.priority' ) . ':') !!}
              {!! Form::text('priority', $discount->priority, ['class' => 'form-control input_number', 'required', 'placeholder' => __( 'lang_v1.priority' ) ]); !!}
          </div>
        </div>
         <div class="col-sm-6">
          <div class="form-group">
            {!! Form::label('discount_type', __('sale.discount_type') . ':*') !!}
              {!! Form::select('discount_type', ['fixed' => __('lang_v1.fixed'), 'percentage' => __('lang_v1.percentage')], $discount->discount_type, ['placeholder' => __('messages.please_select'), 'class' => 'form-control select2', 'required']); !!}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            {!! Form::label('discount_amount', __( 'sale.discount_amount' ) . ':*') !!}
              {!! Form::text('discount_amount', $discount->discount_amount, ['class' => 'form-control input_number', 'required', 'placeholder' => __( 'sale.discount_amount' ) ]); !!}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            {!! Form::label('starts_at', __( 'lang_v1.starts_at' ) . ':') !!}
              {!! Form::text('starts_at', $starts_at, ['class' => 'form-control discount_date', 'required', 'placeholder' => __( 'lang_v1.starts_at' ), 'readonly' ]); !!}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            {!! Form::label('ends_at', __( 'lang_v1.ends_at' ) . ':') !!}
              {!! Form::text('ends_at', $ends_at, ['class' => 'form-control discount_date', 'required', 'placeholder' => __( 'lang_v1.ends_at' ), 'readonly' ]); !!}
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group">
            <br>
            <label>
              {!! Form::checkbox('applicable_in_spg', 1, !empty($discount->applicable_in_spg), ['class' => 'input-icheck']); !!} <strong>@lang('lang_v1.applicable_in_cpg')</strong>
            </label>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <br>
            <label>
              {!! Form::checkbox('applicable_in_cg', 1, !empty($discount->applicable_in_cg), ['class' => 'input-icheck']); !!} <strong>@lang('lang_v1.applicable_in_cg')</strong>
            </label>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group">
            <label>
              {!! Form::checkbox('is_active', 1, !empty($discount->is_active), ['class' => 'input-icheck']); !!} <strong>@lang('lang_v1.is_active')</strong>
            </label>
          </div>
        </div>

      </div>
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.update' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->