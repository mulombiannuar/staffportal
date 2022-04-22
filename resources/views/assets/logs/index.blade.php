@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> Maintenance Logs Data ({{ $logs->count() }})
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table1" class="table table-sm table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>BRANCH</th>
                                <th>CATEGORY</th>
                                <th>ASSET NAME</th>
                                <th>SCHEDULE DATE</th>
                                <th>CURRENT USER</th>
                                <th>COST</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $log->branch_name }}</td>
                                    <td>{{ strtoupper($log->asset_name) }}</td>
                                    <td>{{ $log->assetDetails->name . ' - ' . $log->assetDetails->serial_number }}
                                    </td>
                                    <td>{{ date_format(date_create($log->date_done), 'D, d M Y') }}</td>
                                    <td>{{ $log->current_user }}</td>
                                    <td>Ksh {{ number_format($log->cost, 2) }}</td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <button type="button" class="btn btn-warning dropdown-toggle"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu" style="">
                                                    <li class="dropdown-item"><a
                                                            href="{{ route('admin.logs.edit', $log->log_id) }}"><i
                                                                class="fa fa-edit"></i>
                                                            Edit</a></li>

                                                    <li class="dropdown-item"><a
                                                            href="{{ route('admin.logs.show', ['log_id' => $log->log_id, 'product_id' => $log->product_id]) }}"><i
                                                                class="fa fa-eye"></i> View</a></li>

                                                    <li class="dropdown-item"><a target="_blank"
                                                            href="{{ route('export.logs.show', ['log_id' => $log->log_id, 'product_id' => $log->product_id]) }}"><i
                                                                class="fa fa-print"></i>
                                                            Print</i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="btn-group">
                                            <form action="{{ route('admin.logs.delete', $log->log_id) }}" method="post"
                                                onclick="return confirm('Do you really want to delete this record?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-xs btn-danger"><i
                                                        class="fa fa-trash"></i>
                                                    Delete</button>
                                            </form>
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
