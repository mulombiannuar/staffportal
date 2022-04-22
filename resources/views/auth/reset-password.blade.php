@extends('layouts.auth.auth')

@section('content')
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b>Staff</b>Portal</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Reset your password below</p>
      @error('mobile_no')
      <span class="text text-danger" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror

      <form action=" {{ route('password.update') }}" method="post">
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        @csrf

        <div class="input-group mb-3">
          <input type="hidden" name="email" class="form-control" value="{{ $request->email }}">
          <input type="password" name="password" class="form-control" placeholder="Enter new password"
            autocomplete="off" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        @error('password')
        <span class="text text-danger" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror

        <div class="input-group mb-3">
          <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password"
            autocomplete="new-password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        @error('password_confirmation')
        <span class="text text-danger" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror

       
          <div style="text-align: start; color: rgb(128, 128, 128);">
            <p style="mb-0">Password MUST meet the following:</p>
            <ul>
              <li>Atleast One uppercase letter</li>
              <li>Atleast One lowercase letter</li>
              <li>Atleast One number</li>
              <li>Atleast one special character e.g @ # %</li>
              <li>A minimum of eight characters</li>
            </ul>
          </div>
          <div class="clearfix"></div>
      

        <div class="row">
          <!-- /.col -->
          <div class="col-12 mt-3">
            <button type="submit" class="btn btn-primary btn-block">Update Password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

@endsection