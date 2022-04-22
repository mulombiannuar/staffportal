@extends('layouts.auth.auth')

 @section('content')
   <div class="card">
    <div class="card-body register-card-body">
      <h3 class="login-box-msg"><strong>Create Account</strong></h3>

      <form method="post" action="{{ route('register') }}">
        @csrf
        <div class="input-group mb-3">
            <input type="text" name="name"  class="form-control" placeholder="Full name" value="{{ old('name') }}" required autocomplete="off" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                <span class="fas fa-user"></span>
                </div>
            </div>
            @error('name')
                <span class="text text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="input-group mb-3">
            <input type="email"  name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" autocomplete="off" required>
            <div class="input-group-append">
                <div class="input-group-text">
                <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>
        @error('email')
            <span class="text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <div class="input-group mb-3">
            <input type="password" name="password"  class="form-control" placeholder="Password" autocomplete="off" required>
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
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" autocomplete="new-password" required>
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
        
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

       <p class="mb-1">
            <a href="{{ route('password.request') }}">Forgot Password?</a>
        </p>
        <p class="mb-0">
            <a href="{{ route('login') }}" class="text-center">Already having an account? Login Here</a>
        </p>
    </div>
    <!-- /.form-box -->
  </div>
 @endsection 