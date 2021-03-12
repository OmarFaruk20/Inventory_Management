@extends('layouts.auth')

@section('content')

<div class="row">

    <h1 class="page-header text-center">{{ config('app.name', 'ultimatePOS') }}</h2>
    
    <div class="col-md-8 col-md-offset-2">
        
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title text-center">Register and Get Started in minutes</h3>
            </div>

            {!! Form::open(['url' => {{ route('business.postRegister') }}]) !!}
            {!! Form::token(); !!}

                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('name','Business Name:') !!}
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-suitcase"></i>
                                </span>
                                {!! Form::text('name', null, ['class' => 'form-control','placeholder' => 'Business name']); !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('start_date','Start Date:') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            {!! Form::text('start_date', null, ['class' => 'form-control start-date-picker','placeholder' => 'Start Date', 'readonly']); !!}
                        </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('currency','Currency:') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-money"></i>
                            </span>
                            {!! Form::select('currency', $currencies, '', ['class' => 'form-control','placeholder' => 'Select Currency']); !!}
                        </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                        {!! Form::label('country','Country:') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-globe"></i>
                            </span>
                            {!! Form::text('country', null, ['class' => 'form-control','placeholder' => 'Country']); !!}
                        </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                        {!! Form::label('state','State:') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-map-marker"></i>
                            </span>
                            {!! Form::text('state', null, ['class' => 'form-control','placeholder' => 'State']); !!}
                        </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                        {!! Form::label('city','City:') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-map-marker"></i>
                            </span>
                            {!! Form::text('city', null, ['class' => 'form-control','placeholder' => 'City']); !!}
                        </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('zip_code','Zip Code:') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-map-marker"></i>
                            </span>
                            {!! Form::text('zip_code', null, ['class' => 'form-control','placeholder' => 'Zip/Postal Code']); !!}
                        </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('landmark','Landmark:') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-map-marker"></i>
                            </span>
                            {!! Form::text('landmark', null, ['class' => 'form-control','placeholder' => 'Landmark']); !!}
                        </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <hr/>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('tax_label_1','Tax 1 Name:') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-info"></i>
                            </span>
                            {!! Form::text('tax_label_1', null, ['class' => 'form-control','placeholder' => 'GST / VAT / Other']); !!}
                        </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('tax_number_1','Tax 1 No.:') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-info"></i>
                            </span>
                            {!! Form::text('tax_number_1', null, ['class' => 'form-control',]); !!}
                        </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('tax_label_2','Tax 2 Name:') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-info"></i>
                            </span>
                            {!! Form::text('tax_label_2', null, ['class' => 'form-control','placeholder' => 'GST / VAT / Other']); !!}
                        </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('tax_number_2','Tax 2 No.:') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-info"></i>
                            </span>
                            {!! Form::text('tax_number_2', null, ['class' => 'form-control',]); !!}
                        </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <hr/>
                    </div>

                    <!-- Owner Information -->
                    <div class="col-md-4">
                        <div class="form-group">
                        {!! Form::label('surname','Surname:') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-info"></i>
                            </span>
                            {!! Form::text('surname', null, ['class' => 'form-control','placeholder' => 'GST / VAT / Other']); !!}
                        </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                        {!! Form::label('first_name','First Name:') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-info"></i>
                            </span>
                            {!! Form::text('first_name', null, ['class' => 'form-control','placeholder' => 'Owner Name']); !!}
                        </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                        {!! Form::label('last_name','Last Name:') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-info"></i>
                            </span>
                            {!! Form::text('last_name', null, ['class' => 'form-control','placeholder' => 'Owner Name']); !!}
                        </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('username','Username:') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </span>
                            {!! Form::text('username', null, ['class' => 'form-control','placeholder' => 'Username used for login']); !!}
                        </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('email','Email:') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-envelope"></i>
                            </span>
                            {!! Form::text('email', null, ['class' => 'form-control','placeholder' => '']); !!}
                        </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('password','Password:') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-lock"></i>
                            </span>
                            {!! Form::password('password', ['class' => 'form-control','placeholder' => 'Login Password']); !!}
                        </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('confirm_password','Confirm Password:') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-lock"></i>
                            </span>
                            {!! Form::password('confirm_password', ['class' => 'form-control','placeholder' => 'Same as Login Password']); !!}
                        </div>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                
                <div class="box-footer">
                    <button type="button" class="btn btn-success pull-right">Register</button>
                </div>

            {!! Form::close() !!}
            
        </div>
          <!-- /.box -->
    </div>

</div>

@endsection