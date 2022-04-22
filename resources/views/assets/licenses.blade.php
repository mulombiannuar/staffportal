@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> Licenses Data ({{ $licenses->count() }})
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
                                <th>LICENSE NO</th>
                                <th>ISSUANCE DATE</th>
                                <th>EXPIRY DATE</th>
                                <th>USER</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($licenses as $license)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $license->branch_name }}</td>
                                    <td>{{ strtoupper($license->type) }}</td>
                                    <td>{{ $license->reg_no . ' - ' . $license->chassis_number }}
                                    </td>
                                    <td>{{ $license->license_no }}</td>
                                    <td>{{ $license->issuance_date }}</td>
                                    <td>{{ $license->expiry_date }}</td>
                                    <td>{{ $license->user_name }}</td>
                                    <td>
                                        <div class="margin">
                                            <div class="btn-group">
                                                <button type="button" data-toggle="modal"
                                                    data-target="#modalEditDetails-{{ $license->license_id }}"
                                                    class="btn btn-xs btn-warning"><i class="fa fa-edit"></i>
                                                    Edit</button>
                                            </div>
                                            <div class="btn-group">
                                                <form
                                                    action="{{ route('admin.licenses.destroy', $license->license_id) }}"
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
                                    <div class="modal fade" id="modalEditDetails-{{ $license->license_id }}"
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
                                                <form action="{{ route('admin.licenses.update', $license->license_id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="license_no">License
                                                                        Number</label>
                                                                    <input type="text" name="license_no"
                                                                        class="form-control" id="cost"
                                                                        value="{{ $license->license_no }}"
                                                                        placeholder="License Number" autocomplete="on"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="issuance_date">Issuance
                                                                        Date</label>
                                                                    <input type="date" name="issuance_date"
                                                                        class="form-control" id="issuance_date"
                                                                        value="{{ $license->issuance_date }}"
                                                                        placeholder="Select issuance date" autocomplete="on"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="expiry_date">Expiry
                                                                        Date</label>
                                                                    <input type="date" name="expiry_date"
                                                                        class="form-control" id="expiry_date"
                                                                        value="{{ $license->expiry_date }}"
                                                                        placeholder="Select expiry date" autocomplete="on"
                                                                        required>
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
