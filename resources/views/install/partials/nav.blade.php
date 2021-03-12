<ul class="nav nav-pills nav-justified">
  <li role="presentation" @if($active == 'install') class="active" @endif>
    <a href="#">Instructions</a>
  </li>
  <!-- <li role="presentation" @if($active == 'server') class="active" @endif>
    <a href="#">Server Requirements</a>
  </li> -->
  <li role="presentation" @if($active == 'app_details') class="active" @endif>
    <a href="#">Application Details</a>
  </li>
  <li role="presentation" @if($active == 'success') class="active" @endif>
    <a href="#">Success</a>
  </li>
</ul>
<br/>