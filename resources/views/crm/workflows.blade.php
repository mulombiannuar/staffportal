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
                    <table id="table1" class="table table-sm table-striped table-bordered table-head-fixed">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>WORKFLOW NAME</th>
                                <th>WORKFLOW USER</th>
                                <th>MAXIMUM DAYS</th>
                                <th>ESCALATION PERIOD</th>
                                <th>CREATED AT</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($workflows as $workflow)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ strtoupper($workflow->name) }}</strong></td>
                                    <td>{{ $workflow->workflow_user_name }}</td>
                                    <td>{{ $workflow->max_days }} Day</td>
                                    <td>{{ $workflow->escalation_period }} Days</td>
                                    <td>{{ $workflow->created_at }} </td>
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