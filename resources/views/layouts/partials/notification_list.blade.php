@if(!empty($notifications_data))
  @foreach($notifications_data as $notification_data)
    <li class="@if(empty($notification_data['read_at'])) bg-aqua-lite @endif">
      <a href="{{$notification_data['link'] ?? '#'}}">
        <i class="{{$notification_data['icon_class'] ?? ''}}"></i> {!! $notification_data['msg'] ?? '' !!} <br>
        <small>{{$notification_data['created_at']}}</small>
      </a>
    </li>
  @endforeach
@else
  <li class="text-center no-notification">
    @lang('lang_v1.no_notifications_found')
  </li>
@endif