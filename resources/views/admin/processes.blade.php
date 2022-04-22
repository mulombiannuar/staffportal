@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="margin mb-2 text-right">
                <button type="button" data-toggle="modal" data-target="#modalProcess" class="btn btn-primary"><i
                        class="fa fa-cog"></i> Run New System Process</button>
            </div>
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> {{ $title }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table1" class="table table-sm table-hover table-bordered table-head-fixed " width="100%">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>PROCESS NAME</th>
                                <th>LAST RAN DATE</th>
                                <th>RECORDS</th>
                                <th>USER</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ran_process as $process)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $process->name }}</td>
                                    <td>{{ $process->created_at }}</td>
                                    <td>{{ $process->records }}</td>
                                    <td>{{ $process->user_name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!--/.modal begin -->
                    <div class="modal fade" id="modalProcess" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Run New System Process</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <form action="{{ route('admin.processes.policyexpirationstatus') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="process_type">Process Type </label>
                                                    <input type="hidden" name="date" value="{{ date('Y-m-d') }}">
                                                    <select name="process_type" class="form-control select2"
                                                        id="process_type" required>
                                                        <option class="mb-1" value="">
                                                            - Select Process Type -</option>
                                                        @foreach ($system_processes as $process)
                                                            <option value="{{ $process }}">{{ $process }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-info"><i class="fa fa-cog"></i> Run
                                            Process Now</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!--/modal end -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
