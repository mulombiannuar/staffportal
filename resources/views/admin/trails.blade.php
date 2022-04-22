@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-envelope"></i> {{ $title }} ({{ $trails->count() }})
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table1" class="table table-sm table-hover table-bordered table-head-fixed " width="100%">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>LOGGED DATE</th>
                                <th>USERNAME</th>
                                <th>EMAIL</th>
                                <th>ACTIVITY TYPE</th>
                                <th>DESCRIPTION</th>
                                <th>IP ADDRESS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trails as $trail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $trail->date }}</td>
                                    <td>{{ $trail->name }}</td>
                                    <td>{{ $trail->email }}</td>
                                    <td>{{ $trail->activity_type }}</td>
                                    <td>{{ $trail->description }}</td>
                                    <td>{{ $trail->ip_address }}</td>
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
