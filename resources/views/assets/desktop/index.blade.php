@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="margin mb-2 text-right">
                <a href="{{ route('admin.desktops.create') }}">
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Desktop</button>
                </a>
            </div>
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> Manage Desktops ({{ $assets->count() }})</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table1" class="table table-sm table-bordered table-striped table-head-fixed">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>COMPUTER NAME</th>
                                <th>SERIAL NUMBER</th>
                                <th>OPERATING SYSTEM</th>
                                <th>MS OFFICE</th>
                                <th>SYSTEM MODEL</th>
                                <th>PROCESSOR</th>
                                <th>USER</th>
                                <th>OUTPOST</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assets as $asset)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ strtoupper($asset->name) }}</td>
                                    <td>{{ $asset->serial_number }}</td>
                                    <td>{{ $asset->operating_system }} / {{ $asset->os_key }}</td>
                                    <td>{{ $asset->office_name }} / {{ $asset->office_key }}</td>
                                    <td>{{ $asset->model }}</td>
                                    <td>{{ $asset->processor }}</td>
                                    <td>{{ $asset->user_name }}</td>
                                    <td>{{ $asset->outpost_name }}</td>
                                    <td>
                                        <div class="margin">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.desktops.edit', $asset->desktop_id) }}">
                                                    <button type="button" class="btn btn-xs btn-default"><i
                                                            class="fa fa-edit"></i>
                                                        Edit</button>
                                                </a>
                                            </div>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.desktops.show', $asset->desktop_id) }}">
                                                    <button type="button" class="btn btn-xs btn-info"><i
                                                            class="fa fa-eye"></i>
                                                        View</button>
                                                </a>
                                            </div>
                                            <div class="btn-group">
                                                <form action="{{ route('admin.desktops.destroy', $asset->desktop_id) }}"
                                                    method="post"
                                                    onclick="return confirm('Do you really want to delete this desktop?')">
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
