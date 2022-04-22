@extends('layouts.admin.table')

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-list"></i> {{ $title }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="mt-0">
                    <table id="table1" class="table table-sm table-bordered table-hover table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>NAMES</th>
                                <th>EMAIL ADDRESS</th>
                                <th>ROLES</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td><strong>{{ $user->email }}</strong></td>
                                <td>
                                    @foreach ($user->roles as $role)
                                    {{ $role->name }},
                                    @endforeach
                                </td>
                                <td>
                                    <div class="margin">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.roles.user', $user->id) }}"
                                                title="Click to edit user roles">
                                                <button type="button" class="btn btn-xs btn-warning"><i
                                                        class="fa fa-eye"></i>
                                                    Edit Roles</button>
                                            </a>
                                        </div>

                                        <div class="btn-group">
                                            <a href="{{ route('admin.roles.user', $user->id) }}"
                                                title="Click to user permissions">
                                                <button type="button" class="btn btn-xs btn-success"><i
                                                        class="fa fa-user-plus"></i>
                                                    Edit Permissions</button>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection