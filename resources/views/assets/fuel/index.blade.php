@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> Manage {{ $title }}
                        ({{ $fuels->count() }})
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table1" class="table table-sm table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>BRANCH</th>
                                <th>DATE</th>
                                <th>TYPE</th>
                                <th>ASSET NAME</th>
                                <th>PREVIOUS</th>
                                <th>CURRENT</th>
                                <th>MILEAGE</th>
                                <th>FUEL</th>
                                <th>COST</th>
                                <th>USER</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fuels as $fuel)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $fuel->branch_name }}</td>
                                    <td>{{ $fuel->date }}</td>
                                    <td>{{ $fuel->type }}</td>
                                    <td>{{ $fuel->reg_no . ' - ' . $fuel->chassis_number }}
                                    </td>
                                    <td>{{ $fuel->previous }}Kms</td>
                                    <td>{{ $fuel->current }}Kms</td>
                                    <td>{{ $fuel->difference }}Kms</td>
                                    <td>{{ $fuel->capacity }}Ltrs</td>
                                    <td>Ksh {{ number_format($fuel->cost, 2) }}</td>
                                    <td>{{ $fuel->user_name }}</td>
                                    <td>
                                        <div class="margin">
                                            <div class="btn-group">
                                                <button type="button" data-toggle="modal"
                                                    data-target="#modalEditDetails-{{ $fuel->fuel_id }}"
                                                    class="btn btn-xs btn-warning"><i class="fa fa-edit"></i>
                                                    Edit</button>
                                            </div>
                                            <div class="btn-group">
                                                <a target="_blank" href="{{ route('admin.fuels.show', $fuel->fuel_id) }}"
                                                    title="Click to view receipt details">
                                                    <button type="button" class="btn btn-xs btn-info"><i
                                                            class="fa fa-eye"></i>
                                                        View</button>
                                                </a>
                                            </div>
                                            <div class="btn-group">
                                                <form action="{{ route('admin.fuels.destroy', $fuel->fuel_id) }}"
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
                                    <div class="modal fade" id="modalEditDetails-{{ $fuel->fuel_id }}"
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
                                                <form action="{{ route('admin.fuels.update', $fuel->fuel_id) }}"
                                                    method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="date">Date</label>
                                                                    <input type="date" name="date" class="form-control"
                                                                        id="date" value="{{ $fuel->date }}"
                                                                        placeholder="Select date done" autocomplete="on"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="cost">Fuel Cost</label>
                                                                    <input type="number" name="cost" class="form-control"
                                                                        id="cost" value="{{ $fuel->cost }}"
                                                                        placeholder="Enter fuel cost" autocomplete="on"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="cost">Receipt File <small
                                                                            class="text text-danger">
                                                                            (pdf, max
                                                                            size 2mb)
                                                                        </small></label>
                                                                    <div class="custom-file">
                                                                        <input type="file" name="file"
                                                                            class="custom-file-input" id="customFile">
                                                                        <label class="custom-file-label"
                                                                            for="customFile">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="capacity">Fuel
                                                                        Capacity</label>
                                                                    <input type="number" name="capacity"
                                                                        class="form-control" id="capacity"
                                                                        value="{{ $fuel->capacity }}"
                                                                        placeholder="Enter fuel capacity in ltrs"
                                                                        autocomplete="on" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="current">Mileage</label>
                                                                    <input type="number" name="current"
                                                                        class="form-control" id="capacity"
                                                                        value="{{ $fuel->mileage }}"
                                                                        placeholder="Enter current mileage reading"
                                                                        autocomplete="on" required>
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
