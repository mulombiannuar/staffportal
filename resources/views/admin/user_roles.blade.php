@extends('layouts.admin.table')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-list"></i> {{ $title }}</h3>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.roles.storerole') }}" method="post">
          <input type="hidden" name="user_id" value="{{ $user->id }}">
          @csrf
          <div class="row">
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                @foreach ($roles as $role)
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}"
                    @if($user_roles->pluck('role_id')->contains($role->id))
                  checked
                  @endif>
                  <label class="form-check-label">{{ ucwords($role->name) }}</label>
                </div>
                @endforeach
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <div class="icheck-primary d-inline">
                  <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-user-plus"></i> Assign
                    Selected Roles</button>
                </div>
              </div>
            </div>
          </div>
        </form>
        @if ($user_roles->count() == 0)
        <div class="alert alert-danger">
          User has not been assigned any roles yet
        </div>
        @else
        <table id="table1" class="table table-sm table-bordered table-hover">
          <thead>
            <tr>
              <th>S.N</th>
              <th>NAME</th>
              <th>DIPLAY NAME</th>
              <th>DATE ASSIGNED</th>
              {{-- <th>ACTION</th> --}}
            </tr>
          </thead>
          <tbody>
            @foreach ($user_roles as $role)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td><strong>{{ $role->name }}</strong></td>
              <td>{{ $role->display_name }}</td>
              <td>{{ $role->created_at }}</td>
              {{-- <td>
                <div class="btn-group">
                  <form action="{{ route('admin.roles.deleterole', $role->id) }}" method="post"
                    onclick="return confirm('Do you really want to delete this user role?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i>
                      Delete</button>
                  </form>
                </div>
              </td> --}}
            </tr>
            @endforeach
          </tbody>
        </table>
        @endif
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection