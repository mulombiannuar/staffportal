@extends('layouts.auth.auth')

@section('content')
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="{{ Route::currentRouteName() }}" class="h1"><b>Staff</b>Portal</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Enter your email address below</p>
      @error('mobile_no')
      <span class="text text-danger" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror

      <form action=" {{ route('password.request') }}" method="post">
        @csrf
        @error('email')
        <span class="text text-danger mb-10" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Enter your email address"
            autocomplete="off" required autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <p class="mb-1">
        <a href="{{ route('login') }}">Have Account? Login</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

@endsection