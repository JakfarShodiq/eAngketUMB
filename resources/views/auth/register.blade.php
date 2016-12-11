@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="identity_number" class="col-md-4 control-label">Identity Number</label>

                                <div class="col-md-6">
                                    {{ Form::text('identity_number','',array('class'    =>  'form-control')) }}
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Full Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required>

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="roles" class="col-md-4 control-label">Select Roles</label>

                                <div class="col-md-6">
                                    {{ Form::select('role_id',$roles,'',array('class'=>'form-control')) }}
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="address" class="col-md-4 control-label">Address</label>

                                <div class="col-md-6">
                                    {{ Form::textarea('address','',array('class'    =>  'form-control')) }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone" class="col-md-4 control-label">Mobile Number</label>

                                <div class="col-md-6">
                                    {{ Form::text('phone','',array('class'    =>  'form-control')) }}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <label for="male" class="col-md-4 control-label">
                                        {{ Form::radio('gender','Male',true,array('id'    =>  'male')) }}
                                        Male</label>
                                    <label for="female" class="col-md-4 control-label">
                                        {{ Form::radio('gender','Female',false,array('id'    =>  'female')) }}
                                        Female</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="birth_place" class="col-md-4 control-label">Birth Place</label>

                                <div class="col-md-6">
                                    {{ Form::text('birth_place','',array('class'    =>  'form-control')) }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="birth_date" class="col-md-4 control-label">Birth Date</label>

                                <div class="col-md-6">
                                    {{ Form::text('birth_date','',array('class'    =>  'form-control','id' => 'birth_date')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="education" class="col-md-4 control-label">Education</label>

                                <div class="col-md-6">
                                    {{ Form::text('education','',array('class'    =>  'form-control','placeholder'  =>  'ex : SMA / D3 / S1 etc...')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function () {

        $('#birth_date').datepicker({
            format: "yyyy-mm-dd"
        });
    });
</script>
@endsection