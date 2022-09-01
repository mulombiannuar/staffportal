@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning card-outline">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#details" data-toggle="tab"><i
                                    class="fa fa-user"></i>
                                Asset Details</a></li>
                        <li class="nav-item"><a class="nav-link" href="#assignment" data-toggle="tab"><i
                                    class="fa fa-calendar-alt"></i>
                                Asset Assignments ({{ count($assigns) }})</a></li>
                        <li class="nav-item"><a class="nav-link" href="#fuel-consumption" data-toggle="tab"><i
                                    class="fa fa-list"></i>
                                Fuel Consumption ({{ count($fuels) }})</a></li>
                        <li class="nav-item"><a class="nav-link" href="#maintenance" data-toggle="tab"><i
                                    class="fa fa-calendar"></i>
                                Booking
                                Sevices ({{ count($logs) }})</a></li>
                        <li class="nav-item"><a class="nav-link" href="#licence" data-toggle="tab"><i
                                    class="fa fa-credit-card"></i>
                                Driving Licence ({{ count($licenses) }})</a></li>
                        <li class="nav-item"><a class="nav-link" href="#insurance" data-toggle="tab"><i
                                    class="fa fa-ambulance"></i>
                                Insurance Details</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="details">
                            <!-- Profile -->
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fa fa-user"></i> Asset Details</h3>
                                </div>
                                <div class="card-body">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="branch">Branch</label>
                                                    <input type="text" name="branch" class="form-control"
                                                        value="{{ $asset->branch_name }}" placeholder="Enter branch name"
                                                        autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="outpost">Outpost</label>
                                                    <input type="text" name="outpost" class="form-control"
                                                        value="{{ $asset->outpost_name }}" placeholder="Enter outpost name"
                                                        autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="user">Current User</label>
                                                    <input type="text" name="user" class="form-control"
                                                        value="{{ $asset->user_name }}" placeholder="Enter user name"
                                                        autocomplete="on" required>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="chassis_number">Chassis Number</label>
                                                    <input type="text" name="chassis_number" class="form-control"
                                                        id="start_date" value="{{ $asset->chassis_number }}"
                                                        placeholder="Enter chassis number" autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="name">Motor Name</label>
                                                    <input type="text" name="name" class="form-control" id="name"
                                                        value="{{ $asset->name }}" placeholder=" Enter motor name"
                                                        autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="model">Model</label>
                                                    <input type="text" name="model" class="form-control"
                                                        id="model" value="{{ $asset->model }}"
                                                        placeholder="Enter model" autocomplete="on" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="mileage">Mileage</label>
                                                    <input type="number" name="mileage" class="form-control"
                                                        id="mileage" value="{{ $asset->mileage }}"
                                                        placeholder="Enter mileage" autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="type">Type</label>
                                                    <select name="type" id="type" class="form-control select2"
                                                        id="type" required>
                                                        <option class="mb-1" value="{{ $asset->type }}">
                                                            {{ $asset->type }}</option>
                                                        <option selected value="Motorbike">Motorbike</option>
                                                        <option value="Vehicle">Vehicle</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="color">Color</label>
                                                    <input type="text" name="color" class="form-control"
                                                        id="color" value="{{ $asset->color }}"
                                                        placeholder="Enter color" autocomplete="on" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="engine">Engine</label>
                                                    <input type="text" name="engine" class="form-control"
                                                        id="engine" value="{{ $asset->engine }}"
                                                        placeholder="Enter engine details" autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="reg_no">Registration Number</label>
                                                    <input type="text" name="reg_no" class="form-control"
                                                        id="reg_no" value="{{ $asset->reg_no }}"
                                                        placeholder="Enter registration number" autocomplete="on"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="build_year">Build Year</label>
                                                    <input type="text" name="build_year" class="form-control"
                                                        id="processor" value="{{ $asset->build_year }}"
                                                        placeholder="Enter build year" autocomplete="on" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="last_maintenance">Last Maintenance</label>
                                                    <input type="date" name="last_maintenance" class="form-control"
                                                        id="last_maintenance" value="{{ $asset->last_maintenance }}"
                                                        placeholder="Select last maintenance date" autocomplete="on"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="date_assigned">Date Of Assigned</label>
                                                    <input type="date" name="date_assigned" class="form-control"
                                                        id="date_assigned" value="{{ $asset->date_assigned }}"
                                                        placeholder="Select date assigned" autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="date_purchased">Date Of Purchase</label>
                                                    <input type="date" name="date_purchased" class="form-control"
                                                        id="date_purchased" value="{{ $asset->date_purchased }}"
                                                        placeholder="Select date purchased" autocomplete="on" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="supplier">Supplier name</label>
                                                    <input type="text" name="supplier" class="form-control"
                                                        id="supplier" value="{{ $asset->supplier }}"
                                                        placeholder="Enter supplier name" autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label for="additional_info">Additional Info</label>
                                                    <textarea class="form-control" name="additional_info" id="additional_info" cols="4" rows="3"
                                                        placeholder="Enter additional info" autocomplete="on" required>{{ $asset->additional_info }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.Profile -->
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="assignment">
                            <!-- assignment -->
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fa fa-users"></i> Asset Assignment </h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="table2" class="table table-sm table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>PREVIOUS USER</th>
                                                <th>CURRENT USER</th>
                                                <th>ASSIGNED BY</th>
                                                <th>DATE ASSIGNED</th>
                                                <th>MESSAGE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($assigns as $assign)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $assign->previous_user }}</td>
                                                    <td>{{ $assign->current_user }}</td>
                                                    <td>{{ $assign->assigned_name }}</td>
                                                    <td>{{ $assign->date_assigned }}</td>
                                                    <td>{{ $assign->message }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- assignment -->
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="fuel-consumption">
                            <!-- fuels -->
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fa fa-user-plus"></i> Asset fuels </h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form action="{{ route('admin.fuels.store') }}" enctype="multipart/form-data"
                                        method="post">
                                        <input type="hidden" name="user_id" value="{{ $asset->assigned_to }}">
                                        <input type="hidden" name="product_id" value="{{ $asset->product_id }}">
                                        <input type="hidden" name="asset_id" value="{{ $asset->motor_id }}">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="date">Date</label>
                                                        <input type="date" name="date" class="form-control"
                                                            id="date" value="{{ date('Y-m-d') }}"
                                                            placeholder="Select date done" autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="cost">Fuel Cost</label>
                                                        <input type="number" name="cost" class="form-control"
                                                            id="cost" value="{{ old('cost') }}"
                                                            placeholder="Enter fuel cost" autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="file">Receipt File <small
                                                                class="text text-danger">
                                                                (Accepted format, pdf, maximum size 2mb)
                                                            </small></label>
                                                        <input type="file" name="file" class="form-control"
                                                            id="customFile" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="capacity">Fuel Capacity</label>
                                                        <input type="number" name="capacity" class="form-control"
                                                            id="capacity" value="{{ old('capacity') }}"
                                                            placeholder="Enter fuel capacity in ltrs" autocomplete="on"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="current">Mileage</label>
                                                        <input type="number" name="current" class="form-control"
                                                            id="capacity" value="{{ old('current') }}"
                                                            placeholder="Enter current mileage reading" autocomplete="on"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="submit" class="btn btn-primary"> <i
                                                    class="fa fa-user-plus"></i>
                                                Save Fuel Data</button>
                                        </div>
                                    </form>
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
                                                                    class="btn btn-xs btn-warning"><i
                                                                        class="fa fa-edit"></i>
                                                                    Edit</button>
                                                            </div>
                                                            <div class="btn-group">
                                                                <a target="_blank"
                                                                    href="{{ route('admin.fuels.show', $fuel->fuel_id) }}"
                                                                    title="Click to view receipt details">
                                                                    <button type="button" class="btn btn-xs btn-info"><i
                                                                            class="fa fa-eye"></i>
                                                                        View</button>
                                                                </a>
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
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <form
                                                                    action="{{ route('admin.fuels.update', $fuel->fuel_id) }}"
                                                                    method="post" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <div class="form-group">
                                                                                    <label for="date">Date</label>
                                                                                    <input type="date" name="date"
                                                                                        class="form-control"
                                                                                        id="date"
                                                                                        value="{{ $fuel->date }}"
                                                                                        placeholder="Select date done"
                                                                                        autocomplete="on" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-4">
                                                                                <div class="form-group">
                                                                                    <label for="cost">Fuel Cost</label>
                                                                                    <input type="number" name="cost"
                                                                                        class="form-control"
                                                                                        id="cost"
                                                                                        value="{{ $fuel->cost }}"
                                                                                        placeholder="Enter fuel cost"
                                                                                        autocomplete="on" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-4">
                                                                                <div class="form-group">
                                                                                    <label for="cost">Receipt File
                                                                                        <small class="text text-danger">
                                                                                            (pdf, max
                                                                                            size 2mb)
                                                                                        </small></label>
                                                                                    <input type="file" name="file"
                                                                                        class="form-control"
                                                                                        id="customFile">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <div class="form-group">
                                                                                    <label for="capacity">Fuel
                                                                                        Capacity</label>
                                                                                    <input type="number" name="capacity"
                                                                                        class="form-control"
                                                                                        id="capacity"
                                                                                        value="{{ $fuel->capacity }}"
                                                                                        placeholder="Enter fuel capacity in ltrs"
                                                                                        autocomplete="on" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-4">
                                                                                <div class="form-group">
                                                                                    <label for="current">Mileage</label>
                                                                                    <input type="number" name="current"
                                                                                        class="form-control"
                                                                                        id="capacity"
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
                            <!-- fuels -->
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="maintenance">
                            <!-- maintenance -->
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fa fa-calendar"></i> Booking
                                        Sevices
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="margin mb-2 text-right">
                                        <a href="{{ route('user.motor-logs.book', ['asset_id' => $asset->motor_id]) }}">
                                            <button type="button" class="btn btn-success"><i class="fa fa-plus"></i>
                                                Book
                                                Maintenance Sevices</button>
                                        </a>
                                    </div>
                                    <table id="table3" class="table table-sm table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>REFERENCE</th>
                                                <th>ASSET NAME</th>
                                                <th>BOOKED DATE</th>
                                                <th>USER</th>
                                                <th>TYPE</th>
                                                <th>STATUS</th>
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
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- maintenance -->
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="licence">
                            <!-- fuels -->
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fa fa-credit-card"></i> Driving License Details
                                    </h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form action="{{ route('admin.licenses.store') }}" method="post">
                                        <input type="hidden" name="user_id" value="{{ $asset->assigned_to }}">
                                        <input type="hidden" name="asset_id" value="{{ $asset->motor_id }}">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="license_no">License Number</label>
                                                        <input type="text" name="license_no" class="form-control"
                                                            id="cost" value="{{ old('license_no') }}"
                                                            placeholder="License Number" autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="issuance_date">Issuance Date</label>
                                                        <input type="date" name="issuance_date" class="form-control"
                                                            id="issuance_date" value="{{ date('Y-m-d') }}"
                                                            placeholder="Select issuance date" autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="expiry_date">Expiry Date</label>
                                                        <input type="date" name="expiry_date" class="form-control"
                                                            id="expiry_date" value="{{ date('Y-m-d') }}"
                                                            placeholder="Select expiry date" autocomplete="on" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="submit" class="btn btn-primary"> <i
                                                    class="fa fa-user-plus"></i>
                                                Save License Data</button>
                                        </div>
                                    </form>
                                    <br>
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
                                                                    class="btn btn-xs btn-warning"><i
                                                                        class="fa fa-edit"></i>
                                                                    Edit</button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <!--/.modal begin -->
                                                    <div class="modal fade"
                                                        id="modalEditDetails-{{ $license->license_id }}"
                                                        style="display: none;" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Update Details</h4>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <form
                                                                    action="{{ route('admin.licenses.update', $license->license_id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <div class="form-group">
                                                                                    <label for="license_no">License
                                                                                        Number</label>
                                                                                    <input type="text"
                                                                                        name="license_no"
                                                                                        class="form-control"
                                                                                        id="cost"
                                                                                        value="{{ $license->license_no }}"
                                                                                        placeholder="License Number"
                                                                                        autocomplete="on" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-4">
                                                                                <div class="form-group">
                                                                                    <label for="issuance_date">Issuance
                                                                                        Date</label>
                                                                                    <input type="date"
                                                                                        name="issuance_date"
                                                                                        class="form-control"
                                                                                        id="issuance_date"
                                                                                        value="{{ $license->issuance_date }}"
                                                                                        placeholder="Select issuance date"
                                                                                        autocomplete="on" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-4">
                                                                                <div class="form-group">
                                                                                    <label for="expiry_date">Expiry
                                                                                        Date</label>
                                                                                    <input type="date"
                                                                                        name="expiry_date"
                                                                                        class="form-control"
                                                                                        id="expiry_date"
                                                                                        value="{{ $license->expiry_date }}"
                                                                                        placeholder="Select expiry date"
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
                            <!-- fuels -->
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="insurance">
                            <!-- fuels -->
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fa fa-ambulance"></i> Insurance Details
                                    </h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    @if (empty($policy))
                                        <form action="{{ route('admin.insurances.store') }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="client_name">Client Name</label>
                                                            <input type="text" name="client_name" class="form-control"
                                                                id="client_name" value="{{ $asset->user_name }}"
                                                                placeholder="Enter client name" autocomplete="on" required
                                                                readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="client_phone">Client Phone</label>
                                                            <input type="number" name="client_phone"
                                                                class="form-control" id="client_phone"
                                                                value="{{ $asset->mobile_no }}"
                                                                placeholder="Enter client phone" autocomplete="on"
                                                                required readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="client_id">Client ID</label>
                                                            <input type="number" name="client_id" class="form-control"
                                                                id="client_id" value="{{ $asset->national_id }}"
                                                                placeholder="Enter client phone" autocomplete="on"
                                                                required readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="client_kra">Client KRA</label>
                                                            <input type="text" name="client_kra" class="form-control"
                                                                id="client_kra" value="{{ 'A00' . $asset->national_id }}"
                                                                placeholder="Enter client kra" autocomplete="on" required
                                                                readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="product">Product</label>
                                                            <select name="product" id="product"
                                                                class="form-control select2" id="product" required>
                                                                <option class="mb-1" value="">
                                                                    - Select Product -</option>
                                                                @foreach ($products as $product)
                                                                    <option value="{{ $product->product_id }}">
                                                                        {{ $product->product_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="branch_id">Branch</label>
                                                            <select name="branch" id="branch2"
                                                                class="form-control select2" id="branch_id" required>
                                                                <option class="mb-1" value="">
                                                                    - Select Branch -</option>
                                                                @foreach ($branches as $branch)
                                                                    <option value="{{ $branch->branch_id }}">
                                                                        {{ $branch->branch_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="outposts">Outpost</label>
                                                            <select name="outpost_id" class="form-control select2"
                                                                id="outposts2" required>
                                                                <option class="mb-1" value="">
                                                                    - Select Branch First -</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="users">Users</label>
                                                            <select name="user_id" id="users2"
                                                                class="form-control select2" required>
                                                                <option class="mb-1" value="">
                                                                    - Select Outpost First -</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="date_issued">Date Issued</label>
                                                            <input type="date" name="date_issued" class="form-control"
                                                                id="date_issued" value="{{ date('Y-m-d') }}"
                                                                placeholder="Select date issued" autocomplete="on"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="date_expired">Expiry Date</label>
                                                            <input type="date" name="date_expired"
                                                                class="form-control" id="date_expired"
                                                                value="{{ date('Y-m-d') }}"
                                                                placeholder="Select date expiring" autocomplete="on"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="sum_issued">Sum Issued</label>
                                                            <input type="number" name="sum_issued" class="form-control"
                                                                id="sum_issued" value="{{ old('sum_issued') }}"
                                                                placeholder="Enter sum issued" autocomplete="on" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="premium">Premium</label>
                                                            <input type="number" name="premium" class="form-control"
                                                                id="premium" value="{{ old('premium') }}"
                                                                placeholder="Enter premium" autocomplete="on" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="cheque_no">Cheque No.</label>
                                                            <input type="number" name="cheque_no" class="form-control"
                                                                id="cheque_no" value="{{ old('cheque_no') }}"
                                                                placeholder="Enter cheque no" autocomplete="on" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="reference">Motor Reg No</label>
                                                            <input type="text" name="reference" class="form-control"
                                                                id="reference" value="{{ $asset->reg_no }}"
                                                                placeholder="Enter reference" autocomplete="on" required
                                                                readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="company">Company</label>
                                                            <select name="company" id="company"
                                                                class="form-control select2" id="company" required>
                                                                <option class="mb-1" value="">
                                                                    - Select Company -</option>
                                                                @foreach ($companies as $company)
                                                                    <option value="{{ $company->co_id }}">
                                                                        {{ $company->company_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="submit" class="btn btn-primary"> <i
                                                        class="fa fa-user-plus"></i>
                                                    Save Insurance Data</button>
                                            </div>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.insurances.update', $policy->policy_id) }}"
                                            method="post">
                                            @csrf
                                            @method('put')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="client_name">Client Name</label>
                                                            <input type="text" name="client_name" class="form-control"
                                                                id="client_name" value="{{ $policy->client_name }}"
                                                                placeholder="Enter client name" autocomplete="on" required
                                                                readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="client_phone">Client Phone</label>
                                                            <input type="number" name="client_phone"
                                                                class="form-control" id="client_phone"
                                                                value="{{ $policy->client_phone }}"
                                                                placeholder="Enter client phone" autocomplete="on"
                                                                required readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="client_id">Client ID</label>
                                                            <input type="number" name="client_id" class="form-control"
                                                                id="client_id" value="{{ $policy->client_id }}"
                                                                placeholder="Enter client phone" autocomplete="on"
                                                                required readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="client_kra">Client KRA</label>
                                                            <input type="text" name="client_kra" class="form-control"
                                                                id="client_kra" value="{{ $policy->client_kra }}"
                                                                placeholder="Enter client kra" autocomplete="on" required
                                                                readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="product">Product</label>
                                                            <select name="product" id="product"
                                                                class="form-control select2" id="product" required>
                                                                <option class="mb-1" value="{{ $policy->product }}">
                                                                    {{ $policy->product_name }}</option>
                                                                @foreach ($products as $product)
                                                                    <option value="{{ $product->product_id }}">
                                                                        {{ $product->product_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="branch_id">Branch</label>
                                                            <select name="branch" id="branch2"
                                                                class="form-control select2" id="branch_id" required>
                                                                <option class="mb-1" value="{{ $policy->branch_id }}">
                                                                    {{ $policy->branch_name }}</option>
                                                                @foreach ($branches as $branch)
                                                                    <option value="{{ $branch->branch_id }}">
                                                                        {{ $branch->branch_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="outposts">Outpost</label>
                                                            <select name="outpost_id" class="form-control select2"
                                                                id="outposts2" required>
                                                                <option class="mb-1" value="{{ $policy->outpost }}">
                                                                    {{ $policy->outpost_name }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="users">Users</label>
                                                            <select name="user_id" id="users2"
                                                                class="form-control select2" required>
                                                                <option class="mb-1" value="{{ $policy->officer }}">
                                                                    {{ $policy->name }}</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="date_issued">Date Issued</label>
                                                            <input type="date" name="date_issued" class="form-control"
                                                                id="date_issued" value="{{ $policy->date_issued }}"
                                                                placeholder="Select date issued" autocomplete="on"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="date_expired">Expiry Date</label>
                                                            <input type="date" name="date_expired"
                                                                class="form-control" id="date_expired"
                                                                value="{{ $policy->date_expired }}"
                                                                placeholder="Select date expiring" autocomplete="on"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="sum_issued">Sum Issued</label>
                                                            <input type="number" name="sum_issued" class="form-control"
                                                                id="sum_issued" value="{{ $policy->sum_issued }}"
                                                                placeholder="Enter sum issued" autocomplete="on" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="premium">Premium</label>
                                                            <input type="number" name="premium" class="form-control"
                                                                id="premium" value="{{ $policy->premium }}"
                                                                placeholder="Enter premium" autocomplete="on" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="cheque_no">Cheque No.</label>
                                                            <input type="number" name="cheque_no" class="form-control"
                                                                id="cheque_no" value="{{ $policy->cheque_no }}"
                                                                placeholder="Enter cheque no" autocomplete="on" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="reference">Motor Reg No</label>
                                                            <input type="text" name="reference" class="form-control"
                                                                id="reference" value="{{ $policy->reference }}"
                                                                placeholder="Enter reference" autocomplete="on" required
                                                                readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="company">Company</label>
                                                            <select name="company" id="company"
                                                                class="form-control select2" id="company" required>
                                                                <option class="mb-1" value="{{ $policy->company }}">
                                                                    {{ $policy->company_name }}</option>
                                                                @foreach ($companies as $company)
                                                                    <option value="{{ $company->co_id }}">
                                                                        {{ $company->company_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="submit" class="btn btn-info"> <i class="fa fa-edit"></i>
                                                    Update Insurance Data</button>
                                            </div>
                                        </form>
                                    @endif

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- fuels -->
                        </div>
                        <!-- /.tab-pane -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
    </section>
    <!-- /.content -->
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#branch').change(function() {
                branch_id = $('#branch').val();
                if (branch_id != '') {
                    $.ajax({
                        url: "{{ route('get.outposts') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        data: {
                            branch_id: branch_id
                        },
                        success: function(data) {
                            console.log(data);
                            $('#outposts').html(data);
                        },
                        error: function(xhr, desc, err) {
                            console.log(xhr);
                            //console.log("Details0: " + desc + "\nError:" + err);
                        },
                    });
                } else {
                    $('#outposts').html('<option value="">Select Branch</option>');
                }
            });

            $('#outposts').change(function() {
                outpost = $('#outposts').val();
                if (outpost != '') {
                    $.ajax({
                        url: "{{ route('get.ousers') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "GET",
                        data: {
                            outpost: outpost
                        },
                        success: function(data) {
                            console.log(data);
                            $('#users').html(data);
                        },
                        error: function(xhr, desc, err) {
                            console.log(xhr);
                            //console.log("Details0: " + desc + "\nError:" + err);
                        },
                    });
                } else {
                    $('#users').html('<p value="text text-danger">No Users Found in that Branch</p>');
                }
            });

            $('#branch2').change(function() {
                branch_id = $('#branch2').val();
                if (branch_id != '') {
                    $.ajax({
                        url: "{{ route('get.outposts') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        data: {
                            branch_id: branch_id
                        },
                        success: function(data) {
                            console.log(data);
                            $('#outposts2').html(data);
                        },
                        error: function(xhr, desc, err) {
                            console.log(xhr);
                            //console.log("Details0: " + desc + "\nError:" + err);
                        },
                    });
                } else {
                    $('#outposts').html('<option value="">Select Branch</option>');
                }
            });

            $('#outposts2').change(function() {
                outpost = $('#outposts2').val();
                if (outpost != '') {
                    $.ajax({
                        url: "{{ route('get.ousers') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "GET",
                        data: {
                            outpost: outpost
                        },
                        success: function(data) {
                            console.log(data);
                            $('#users2').html(data);
                        },
                        error: function(xhr, desc, err) {
                            console.log(xhr);
                            //console.log("Details0: " + desc + "\nError:" + err);
                        },
                    });
                } else {
                    $('#users2').html('<p value="text text-danger">No Users Found in that Branch</p>');
                }
            });
        });
    </script>
@endpush
