@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> Motors Maintenance Logs Data
                        ({{ $logs->count() }})
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table1" class="table table-sm table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>REFERENCE</th>
                                <th>ASSET NAME</th>
                                <th>BOOKED DATE</th>
                                <th>USER</th>
                                <th>TYPE</th>
                                <th>STATUS</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $log->reference }}</td>
                                    <td>{{ $log->name . ' - ' . $log->reg_no }}</td>
                                    <td>{{ date_format(date_create($log->date), 'D, d M Y') }}</td>
                                    <td>{{ $log->booker_name }}</td>
                                    <td>{{ $log->type }}</td>
                                    <td>{{ $log->approval }}</td>
                                    <td>
                                        <div class="margin">
                                            @if ($log->status == 0)
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.motor-logs.edit', $log->log_id) }}">
                                                        <button type="button" class="btn btn-xs btn-default"><i
                                                                class="fa fa-edit"></i>
                                                            Edit</button>
                                                    </a>
                                                </div>
                                                <div class="btn-group">
                                                    <form action="{{ route('admin.motor-logs.destroy', $log->log_id) }}"
                                                        method="post"
                                                        onclick="return confirm('Do you really want to delete this record?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-xs btn-danger"><i
                                                                class="fa fa-trash"></i>
                                                            Delete</button>
                                                    </form>
                                                </div>
                                            @endif

                                            <div class="btn-group">
                                                <a href="{{ route('admin.motor-logs.show', $log->log_id) }}"
                                                    title="Click to view log details">
                                                    <button type="button" class="btn btn-xs btn-info"><i
                                                            class="fa fa-eye"></i>
                                                        View</button>
                                                </a>
                                            </div>
                                            <div class="btn-group">
                                                <a href="{{ route('export.logs.show', ['log_id' => $log->log_id, 'product_id' => $log->product_id]) }}"
                                                    title="Click to print log details">
                                                    <button type="button" class="btn btn-xs btn-success"><i
                                                            class="fa fa-print"></i>
                                                        Print</button>
                                                </a>
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
