<!--Purchase related settings -->
<div class="pos-tab-content">
    <div class="row">
    @if(!config('constants.disable_purchase_in_other_currency', true))
    <div class="col-sm-4">
        <div class="form-group">
            <div class="checkbox">
                <label>
                {!! Form::checkbox('purchase_in_diff_currency', 1, $business->purchase_in_diff_currency , 
                [ 'class' => 'input-icheck', 'id' => 'purchase_in_diff_currency']); !!} {{ __( 'purchase.allow_purchase_different_currency' ) }}
                </label>
              @show_tooltip(__('tooltip.purchase_different_currency'))
            </div>
        </div>
    </div>
    <div class="col-sm-4 @if($business->purchase_in_diff_currency != 1) hide @endif" id="settings_purchase_currency_div">
        <div class="form-group">
            {!! Form::label('purchase_currency_id', __('purchase.purchase_currency') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-money"></i>
                </span>
                {!! Form::select('purchase_currency_id', $currencies, $business->purchase_currency_id, ['class' => 'form-control select2', 'placeholder' => __('business.currency'), 'required', 'style' => 'width:100% !important']); !!}
            </div>
        </div>
    </div>
    <div class="col-sm-4 @if($business->purchase_in_diff_currency != 1) hide @endif" id="settings_currency_exchange_div">
        <div class="form-group">
            {!! Form::label('p_exchange_rate', __('purchase.p_exchange_rate') . ':') !!}
            @show_tooltip(__('tooltip.currency_exchange_factor'))
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-info"></i>
                </span>
                {!! Form::number('p_exchange_rate', $business->p_exchange_rate, ['class' => 'form-control', 'placeholder' => __('business.p_exchange_rate'), 'required', 'step' => '0.001']); !!}
            </div>
        </div>
    </div>
    @endif
    <div class="clearfix"></div>
    <div class="col-sm-4">
        <div class="form-group">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('enable_editing_product_from_purchase', 1, $business->enable_editing_product_from_purchase , 
                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.enable_editing_product_from_purchase' ) }}
              </label>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <div class="checkbox">
                <label>
                {!! Form::checkbox('enable_purchase_status', 1, $business->enable_purchase_status , [ 'class' => 'input-icheck', 'id' => 'enable_purchase_status']); !!} {{ __( 'lang_v1.enable_purchase_status' ) }}
                </label>
              @show_tooltip(__('lang_v1.tooltip_enable_purchase_status'))
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <div class="checkbox">
                <label>
                {!! Form::checkbox('enable_lot_number', 1, $business->enable_lot_number , [ 'class' => 'input-icheck', 'id' => 'enable_lot_number']); !!} {{ __( 'lang_v1.enable_lot_number' ) }}
                </label>
              @show_tooltip(__('lang_v1.tooltip_enable_lot_number'))
            </div>
        </div>
    </div>

    </div>
</div>