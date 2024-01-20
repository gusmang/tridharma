@extends('layouts.auth')

@section('body')
        <div class="auth_div vivify fadeIn">
            <div class="auth_brand">
                <a class="navbar-brand" href="#"><img src="/img/logo.jpg" width="50" class="d-inline-block align-top mr-2" alt=""> {{ env('SITE_NAME')}} </a>
            </div>
            <div class="card">
                <div class="header">
                    <p class="lead">Login to your account</p>
                    @error('password')
                          <span class="text-red" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                      @error('email')
                          <span class="text-red" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                </div>
                <div class="body">
                    <form class="form-auth-small" action="{{ route('login') }}" method="POST">
                      @csrf
                      <div class="form-group c_form_group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email address">
                      </div>
                      <div class="form-group c_form_group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password">

                      </div>
                      <div class="form-group clearfix">
                        <label class="fancy-checkbox element-left">
                        <input type="checkbox" name="remember" value="Y" />
                        <span>Remember me</span>
                        </label>
                      </div>
                      <button type="submit" class="btn btn-dark btn-lg btn-block btnFullscreen">LOGIN</button>
                      <div class="bottom">
                        <span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a href="{{ route('password.request') }}">Forgot password?</a></span>
                      </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
