<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">@lang( 'restaurant.booking_details' )</h4>
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="col-sm-6">
						<strong>@lang('contact.customer'):</strong> {{ $booking->customer->name }}<br>
						<strong>@lang('restaurant.service_staff'):</strong> {{ $booking->waiter->user_full_name or '--' }}<br>
						<strong>@lang('restaurant.correspondent'):</strong> {{ $booking->correspondent->user_full_name or '--' }}<br>
						@if(!empty($booking->booking_note))
						<strong>@lang('restaurant.customer_note'):</strong> {{ $booking->booking_note }}
						@endif
					</div>
					<div class="col-sm-6">
						<strong>@lang('messages.location'):</strong> {{ $booking->location->name }}<br>
						<strong>@lang('restaurant.table'):</strong> {{ $booking->table->name or '--' }}<br>
						<strong>@lang('restaurant.booking_starts'):</strong> {{ $booking_start }}<br>
						<strong>@lang('restaurant.booking_ends'):</strong> {{ $booking_end }}
					</div>
				</div>
				<br>
				<hr>
				<div class="row">
					<div class="col-sm-12">
						<button type="button" class="btn btn-info btn-modal pull-right" data-href="{{action('NotificationController@getTemplate', ['transaction_id' => $booking->id,'template_for' => 'new_booking'])}}" data-container=".view_modal">@lang('restaurant.send_notification_to_customer')</button>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-sm-9">
						{!! Form::open(['url' => action('Restaurant\BookingController@update', [$booking->id]), 'method' => 'PUT', 'id' => 'edit_booking_form' ]) !!}
							<div class="input-group">
				                <!-- /btn-group -->
				                {!! Form::select('booking_status', $booking_statuses, $booking->booking_status, ['class' => 'form-control', 'placeholder' => __('restaurant.change_booking_status'), 'required']); !!}
				                <div class="input-group-btn">
				                  <button type="submit" class="btn btn-primary">@lang('messages.update')</button>
				                </div>
				             </div>
						{!! Form::close() !!}
					</div>
					<div class="col-sm-3 text-center">
						<button type="button" class="btn btn-danger" id="delete_booking" data-href="{{action('Restaurant\BookingController@destroy', [$booking->id])}}">@lang('restaurant.delete_booking')</button>
					</div>
				</div>
			<br>
			<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
			</div>
		

	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->