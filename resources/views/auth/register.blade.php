@extends('layouts.app')

@section('content')

    <div class="container">

        <h1 class="title text-center"> Please Sign Up </h1>

        <div class="row">

            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-default">

                <div class="panel-body">

                    <div class="row">

                        <div class="col-md-12">

                            <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                                    <label for="firstname" class="cols-sm-4 control-label"> First Name</label>
                                    @if ($errors->has('firstname'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('firstname') }}</strong>
                                        </span>
                                    @endif
                                    <div class="cols-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user" aria-hidden="true"></i></span>
                                            <input type="text" class="form-control" name="firstname" id="firstname"  placeholder="Enter your First Name" value="{{ old('firstname') }}" tabindex="1" required autofocus />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                                    <label for="lastname" class="cols-sm-4 control-label"> Last Name</label>
                                    @if ($errors->has('lastname'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('lastname') }}</strong>
                                        </span>
                                    @endif
                                    <div class="cols-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user" aria-hidden="true"></i></span>
                                            <input type="text" class="form-control" name="lastname" id="lastname"  placeholder="Enter your Last Name" value="{{ old('lastname') }}" tabindex="2" required autofocus />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="cols-sm-4 control-label"> Email Address </label>
                                    @if ($errors->has('email'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                    <div class="cols-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i></span>
                                            <input type="email" class="form-control" name="email" id="email"  placeholder="Enter your Email Address" value="{{ old('email') }}" tabindex="3" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="cols-sm-4 control-label"> Password </label>
                                    @if ($errors->has('password'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif

                                    <div class="cols-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock" aria-hidden="true"></i></span>
                                            <input type="password" class="form-control" name="password" id="password"  placeholder="Enter your Password" value="{{ old('password') }}" tabindex="4" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="cols-sm-4 control-label"> Confirm Password </label>
                                    <div class="cols-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock" aria-hidden="true"></i></span>
                                            <input id="password-confirm" type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" tabindex="5" />                           
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="cols-sm-4 control-label" for="userrole"> Select your desired Access </label>

                                    <select id="userrole" name="userrole" class="form-control">
                                        <option value="driver"> Driver </option>
                                        <option value="merchant"> Merchant </option>
                                        <option value="individual"> Individual </option>
                                        <option value="corporation"> Corporation </option>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-xs-4 col-sm-3 col-md-3">
                                        <span class="button-checkbox">
                                            <button type="button" class="btn" data-color="info" tabindex="6">I Agree</button>
                                            <input type="checkbox" name="t_and_c" id="t_and_c" class="hidden" value="1">
                                        </span>
                                    </div>
                                    <div class="col-xs-8 col-sm-9 col-md-9">
                                        By clicking <strong class="label label-primary">Register</strong>, you agree to the <a href="#" data-toggle="modal" data-target="#t_and_c_m">Terms and Conditions</a> set out by this site, including our Cookie Use.
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <input type="submit" value="Register" class="btn btn-primary btn-lg pull-right" tabindex="7" disabled />
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="modal fade" id="t_and_c_m" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Terms & Conditions</h4>
                    </div>
                    <div class="modal-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">I Agree</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

    </div>

@endsection