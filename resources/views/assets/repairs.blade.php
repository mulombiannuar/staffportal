@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> Repairs Data ({{ $repairs->count() }})
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
                                <th>ASSET ISSUE</th>
                                <th>ACTION DONE</th>
                                <th>DATE DONE</th>
                                <th>COST</th>
                                <th>CURRENT USER</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($repairs as $repair)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $repair->branch_name }}</td>
                                    <td>{{ strtoupper($repair->asset_name) }}</td>
                                    <td>{{ is_null($repair->assetDetails)? ' ': $repair->assetDetails->name . ' - ' . $repair->assetDetails->serial_number }}
                                    </td>
                                    <td>{{ $repair->asset_issue }}</td>
                                    <td>{{ $repair->action_done }}</td>
                                    <td>{{ $repair->date_done }}</td>
                                    <td>Ksh {{ number_format($repair->cost, 2) }}</td>
                                    <td>{{ $repair->current_user }}</td>
                                    <td>
                                        <div class="margin">
                                            <div class="btn-group">
                                                <button type="button" data-toggle="modal"
                                                    data-target="#modalEditDetails-{{ $repair->repair_id }}"
                                                    class="btn btn-xs btn-warning"><i class="fa fa-edit"></i>
                                                    Edit</button>
                                            </div>
                                            <div class="btn-group">
                                                <form action="{{ route('admin.repairs.delete', $repair->repair_id) }}"
                                                    method="post"
                                                    onclick="return confirm('Do you really want to delete this record?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-xs btn-danger"><i
                                                            class="fa fa-trash"></i>
                                                        Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <!--/.modal begin -->
                                    <div class="modal fade" id="modalEditDetails-{{ $repair->repair_id }}"
                                        style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Update Details</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.repairs.update', $repair->repair_id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="date_done">Date Done</label>
                                                                    <input type="date" name="date_done"
                                                                        class="form-control" id="date_done"
                                                                        value="{{ $repair->date_done }}"
                                                                        placeholder="Select date done" autocomplete="on"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="cost">Repair Cost</label>
                                                                    <input type="number" name="cost" class="form-control"
                                                                        id="cost" value="{{ $repair->cost }}"
                                                                        placeholder="Enter repair cost" autocomplete="on"
                                                                        required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="asset_issue">Detailed Repair
                                                                        Issue</label>
                                                                    <textarea class="form-control" name="asset_issue" id="asset_issue" cols="4" rows="2"
                                                                        placeholder="Enter detailed asset repair issue"
                                                                        autocomplete="on"
                                                                        required>{{ $repair->asset_issue }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="action_done">ICT
                                                                        Action</label>
                                                                    <textarea class="form-control" name="action_done" id="action_done" cols="4" rows="2"
                                                                        placeholder="Enter action done by the ICT"
                                                                        autocomplete="on"
                                                                        required>{{ $repair->action_done }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-info"><i
                                                                class="fa fa-edit"></i>
                                                            Update
                                                            Data</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!--/modal end -->
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
