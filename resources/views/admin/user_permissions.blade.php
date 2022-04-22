@extends('layouts.admin.table')

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-list"></i>Role Permissions : {{ $role->name }}</h3>
            </div>
            <div class="card-body">
                <table id="table1" class="table table-sm table-striped table-bordered table-head-fixed">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>NAMES</th>
                            <th>DESCRIPTION</th>
                            <th>CREATED AT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $permission->name }}</strong></td>
                            <td>{{ $permission->description }}</td>
                            <td>{{ $permission->created_at }}</td>
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