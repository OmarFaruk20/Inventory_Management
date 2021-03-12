@extends('layouts.app')

@section('title', __( 'lang_v1.view_user' ))

@section('content')

<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>@lang( 'lang_v1.view_user' )</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        @component('components.widget', ['class' => 'box-solid'])
            <div class="row">
                <div class="col-md-12">
                    <h3 class="profile-username">{{$user->user_full_name}}</h3>
                </div>
                <div class="col-md-6">
                    <p><strong>@lang( 'business.email' ): </strong> {{$user->email}}</p>
                    <p><strong>@lang( 'user.role' ): </strong> {{$user->role_name}}</p>
                    <p><strong>@lang( 'business.username' ): </strong> {{$user->username}}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>@lang( 'lang_v1.cmmsn_percent' ): </strong> {{$user->cmmsn_percent}}%</p>
                    <p>@if($user->status == 'active') <span class="label label-success">@lang('business.is_active')</span> @else <span class="label label-danger">@lang('business.inactive')</span> @endif</p>
                    <p><strong>@lang( 'lang_v1.cmmsn_percent' ): </strong> {{$user->cmmsn_percent}}%</p>
                    @php
                        $selected_contacts = ''
                    @endphp
                    @if(count($user->contactAccess)) 
                        @php
                            $selected_contacts_array = [];
                        @endphp
                        @foreach($user->contactAccess as $contact) 
                            @php
                                $selected_contacts_array[] = $contact->name; 
                            @endphp
                        @endforeach 
                        @php
                            $selected_contacts = implode(', ', $selected_contacts_array);
                        @endphp
                    @else 
                        @php
                            $selected_contacts = __('lang_v1.all'); 
                        @endphp
                    @endif
                    <p><strong>@lang( 'lang_v1.allowed_contacts' ): </strong> {{$selected_contacts}}</p>
                </div>
            </div>
           @include('user.show_details')
        @endcomponent
    </section>
@endsection