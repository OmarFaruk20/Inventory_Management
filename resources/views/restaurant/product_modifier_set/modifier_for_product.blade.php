@php
  $id = 'modifier_' . $row_count . '_' . time();
@endphp
<div>
  <span class="selected_modifiers">
    @if(!empty($edit_modifiers) && !empty($product->modifiers) )
      @include('restaurant.product_modifier_set.add_selected_modifiers', array('index' => $row_count, 'modifiers' => $product->modifiers ) )
    @endif
  </span>&nbsp;  
  <i class="fa fa-external-link-square cursor-pointer text-primary select-modifiers-btn" title="@lang('restaurant.modifiers_for_product')" data-toggle="modal" data-target="#{{$id}}"></i>
</div>
<div class="modal fade modifier_modal" id="{{$id}}" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
  <div class="modal-content">

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'restaurant.modifiers_for_product' ): <span class="text-success"></span>
      </h4>
    </div>

    <div class="modal-body">
      @if(!empty($product_ms))
        <div class="panel-group" id="accordion{{$id}}" role="tablist" aria-multiselectable="true">

      @foreach($product_ms as $modifier_set)
        @php
          $collapse_id = 'collapse'. $modifier_set->id . $id;
        @endphp

        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
              <a role="button" data-toggle="collapse" data-parent="#accordion{{$id}}" 
                href="#{{$collapse_id}}" 
                aria-expanded="true" aria-controls="collapseOne">
                {{$modifier_set->name}}
              </a>
            </h4>
          </div>
          <input type="hidden" class="modifiers_exist" value="true">
          <input type="hidden" class="index" value="{{$row_count}}">

          <div id="{{$collapse_id}}" class="panel-collapse collapse @if($loop->index==0) in @endif" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
              <div class="btn-group" data-toggle="buttons">
                @foreach($modifier_set->variations as $modifier)
                  <label class="btn btn-primary @if(!empty($edit_modifiers) && in_array($modifier->id, $product->modifiers_ids) ) active @endif">
                    <input type="checkbox" autocomplete="off" 
                      value="{{$modifier->id}}" @if(!empty($edit_modifiers) && in_array($modifier->id, $product->modifiers_ids) ) checked @endif> 
                      {{$modifier->name}}
                  </label>
                @endforeach
              </div>
            </div>
          </div>
        </div>
          
        
      @endforeach

        </div>
      @endif
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-primary add_modifier" data-dismiss="modal">
        @lang( 'messages.add' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>

<script type="text/javascript">
if( typeof $ !== 'undefined'){
  $(document).ready(function(){
    $('div#{{$id}}').modal('show');
  });
}
</script>