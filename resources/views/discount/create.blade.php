<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('DiscountController@store'), 'method' => 'post', 'id' => 'discount_form' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'lang_v1.add_discount' )</h4>
    </div>

    <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            {!! Form::label('name', __( 'unit.name' ) . ':*') !!}
              {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'unit.name' ) ]); !!}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            {!! Form::label('brand_id', __('product.brand') . ':') !!}
              {!! Form::select('brand_id', $brands, null, ['placeholder' => __('messages.please_select'), 'class' => 'form-control select2']); !!}
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            {!! Form::label('category_id', __('product.category') . ':') !!}
              {!! Form::select('category_id', $categories, null, ['placeholder' => __('messages.please_select'), 'class' => 'form-control select2']); !!}
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-6">
          <div class="form-group">
            {!! Form::label('location_id', __('sale.location') . ':*') !!}
              {!! Form::select('location_id', $locations, null, ['placeholder' => __('messages.please_select'), 'class' => 'form-control select2', 'required']); !!}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            {!! Form::label('priority', __( 'lang_v1.priority' ) . ':') !!} @show_tooltip(__('lang_v1.discount_priority_help'))
              {!! Form::text('priority', null, ['class' => 'form-control input_number', 'required', 'placeholder' => __( 'lang_v1.priority' ) ]); !!}
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-6">
          <div class="form-group">
            {!! Form::label('discount_type', __('sale.discount_type') . ':*') !!}
              {!! Form::select('discount_type', ['fixed' => __('lang_v1.fixed'), 'percentage' => __('lang_v1.percentage')], null, ['placeholder' => __('messages.please_select'), 'class' => 'form-control select2', 'required']); !!}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            {!! Form::label('discount_amount', __( 'sale.discount_amount' ) . ':*') !!}
              {!! Form::text('discount_amount', null, ['class' => 'form-control input_number', 'required', 'placeholder' => __( 'sale.discount_amount' ) ]); !!}
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-6">
          <div class="form-group">
            {!! Form::label('starts_at', __( 'lang_v1.starts_at' ) . ':') !!}
              {!! Form::text('starts_at', null, ['class' => 'form-control discount_date', 'required', 'placeholder' => __( 'lang_v1.starts_at' ), 'readonly' ]); !!}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            {!! Form::label('ends_at', __( 'lang_v1.ends_at' ) . ':') !!}
              {!! Form::text('ends_at', null, ['class' => 'form-control discount_date', 'required', 'placeholder' => __( 'lang_v1.ends_at' ), 'readonly' ]); !!}
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-6">
          <div class="form-group">
            <br>
            <label>
              {!! Form::checkbox('applicable_in_spg', 1, false, ['class' => 'input-icheck']); !!} <strong>@lang('lang_v1.applicable_in_cpg')</strong>
            </label>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <br>
            <label>
              {!! Form::checkbox('applicable_in_cg', 1, false, ['class' => 'input-icheck']); !!} <strong>@lang('lang_v1.applicable_in_cg')</strong>
            </label>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-6">
          <div class="form-group">
            <label>
              {!! Form::checkbox('is_active', 1, true, ['class' => 'input-icheck']); !!} <strong>@lang('lang_v1.is_active')</strong>
            </label>
          </div>
        </div>

      </div>
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->