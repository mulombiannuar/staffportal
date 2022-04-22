@extends('layouts.auth.auth')

@section('content')
<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="{{ Route::currentRouteName() }}" class="h1"><b>Staff</b>Portal</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Enter access token below</p>
        @error('mobile_no')
        <span class="text text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
  
        <form id="accessForm" action="{{ route('verify.token') }}" method="post">
          @csrf
          <div class="input-group mb-3">
            <input type="number" name="access_token" id="access_token" class="form-control"
            placeholder="Enter access token sent to your phone/email" autocomplete="off" required
            autofocus>
          </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-12">
              <button type="submit" id="submit" disabled class="btn btn-success btn-block">Verify Access Token</button>
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
@push('scripts')
<script>
$('#accessForm').on("keyup", action);
function action() {
   if ($('#access_token').val().length == 6) {
       $('#submit').prop("disabled", false);
   } else {
       $('#submit').prop("disabled", true);
   }
}
</script>
@endpush