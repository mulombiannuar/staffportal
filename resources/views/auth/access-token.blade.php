@extends('layouts.auth.auth')

@section('content')
<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="{{ Route::currentRouteName() }}" class="h1"><b>Staff</b>Portal</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Enter mobile number to get token</p>
        @error('mobile_no')
        <span class="text text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
  
        <form id="accessForm" action="{{ route('send.token') }}" method="get">
            @csrf
          <div class="input-group mb-3">
            <input type="number" id="mobile_no" name="mobile_no" class="form-control"
            placeholder="Enter your mobile number" autocomplete="off" required autofocus>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-phone"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-12">
              <button type="submit" id="submit" disabled class="btn btn-primary btn-block">Get Access Token</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
  
        <p class="mb-1 mt-3">
          <a href="{{ route('password.request') }}">Forgot my password?</a>
        </p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->
  
@endsection
@push('scripts')
<script>
$('#accessForm').on("keyup", action);
function action() {
   if ($('#mobile_no').val().length == 10) {
       $('#submit').prop("disabled", false);
   } else {
       $('#submit').prop("disabled", true);
   }
}
</script>
@endpush