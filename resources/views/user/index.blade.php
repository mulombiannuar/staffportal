@extends('layouts.admin.table')

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="margin mb-2 text-right">
            <a href="{{ route('admin.users.create') }}">
                <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add New
                    User</button>
            </a>
        </div>
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-users"></i> {{ $title }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="table1" class="table table-sm table-bordered table-striped table-head-fixed">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>NAMES</th>
                            <th>GENDER</th>
                            <th>EMAIL ADDRESS</th>
                            <th>OUTPOST</th>
                            <th>ACTIVATE</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ Str::ucfirst($user->gender) }}</td>
                            <td><strong>{{ $user->email }}</strong></td>
                            <td>{{ $user->outpost_name }}</td>
                            <td>
                                @if ($user->status == 0)
                                <form action="{{ route('admin.users.activate', $user->id) }}" method="post"
                                    onclick="return confirm('Do you really want to activate this user?')">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-xs btn-danger"><i
                                            class="fa fa-times-circle"></i>
                                        Activate
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('admin.users.deactivate', $user->id) }}" method="post"
                                    onclick="return confirm('Do you really want to deactivate this user?')">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-xs btn-success"><i
                                            class="fa fa-check-circle"></i>
                                        Deactivate
                                    </button>
                                </form>
                                @endif
                            </td>
                            <td>
                                <div class="margin">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.users.edit', $user['id'] )}}">
                                            <button type="button" class="btn btn-xs btn-default"><i
                                                    class="fa fa-edit"></i>
                                                Edit</button>
                                        </a>
                                    </div>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.users.show', $user->id) }}"
                                            title="Click to view user details">
                                            <button type="button" class="btn btn-xs btn-info"><i class="fa fa-eye"></i>
                                                View</button>
                                        </a>
                                    </div>
                                    <div class="btn-group">
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="post"
                                            onclick="return confirm('Do you really want to delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger"><i
                                                    class="fa fa-trash"></i>
                                                Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection