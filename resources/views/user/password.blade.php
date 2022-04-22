@extends('layouts.admin.form')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-unlock"></i> {{ $title }}</h3>
      </div>
      <div class="card-body">
        <form role="form" method="post" action="{{ route('user.password.change', Auth::user()->id) }}"
          accept-charset="utf-8">
          @csrf
          @method('PUT')
          <div class="card-body">
            <div class="row">
              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="exampleInputPassword">Current Password</label>
                  <input type="password" name="current_password" class="form-control" id="password"
                    placeholder="Enter current password" autocomplete="off" value="{{ old('current_password') }}"
                    required>
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="exampleInputPassword">Password</label>
                  <input type="password" name="password" class="form-control" id="password"
                    placeholder="Enter new password" autocomplete="off" value="{{ old('password') }}" required>
                </div>
              </div>

              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="exampleInputConfirmPassword">Confirm Password</label>
                  <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
                    placeholder="Confirm password" autocomplete="off" value="{{ old('password_confirmation') }}"
                    required>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="modal-footer justify-content-between">
            <button type="submit" class="btn btn-primary"> <i class="fa fa-edit"></i>
              Update Password</button>
          </div>
        </form>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection