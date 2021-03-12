<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('AccountReportsController@postLinkAccount'), 'method' => 'post', 'id' => 'link_account_form' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'account.link_account' ) - @lang( 'account.payment_ref_no' ): - {{$payment->payment_ref_no}}</h4>
    </div>

    <div class="modal-body">
        <div class="form-group">
            {!! Form::hidden('transaction_payment_id', $payment->id); !!}
            {!! Form::label('account_id', __( 'account.account' ) .":") !!}
            {!! Form::select('account_id', $accounts, $payment->account_id, ['class' => 'form-control', 'required']); !!}
        </div>
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->