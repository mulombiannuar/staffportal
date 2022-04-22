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
                        <li class="nav-item"><a class="nav-link" href="#repairs" data-toggle="tab"><i
                                    class="fa fa-list"></i>
                                Repairs Data ({{ count($repairs) }})</a></li>
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
                                                        value="{{ $asset->outpost_name }}"
                                                        placeholder="Enter outpost name" autocomplete="on" required>
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
                                                    <label for="name">Scanner Name</label>
                                                    <input type="text" name="name" class="form-control" id="name"
                                                        value="{{ $asset->name }}" placeholder="Enter scanner name"
                                                        autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="serial_number">Serial Number</label>
                                                    <input type="text" name="serial_number" class="form-control"
                                                        id="serial_number" value="{{ $asset->serial_number }}"
                                                        placeholder="Enter serial number" autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="date_assigned">Date Assigned</label>
                                                    <input type="date" name="date_assigned" class="form-control"
                                                        id="date_assigned" value="{{ $asset->date_assigned }}"
                                                        placeholder="Select date assigned" autocomplete="on" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="date_purchased">Date Purchased</label>
                                                    <input type="date" name="date_purchased" class="form-control"
                                                        id="date_purchased" value="{{ $asset->date_purchased }}"
                                                        placeholder="Select date purchased" autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="supplier">Supplier</label>
                                                    <input type="text" name="supplier" class="form-control" id="supplier"
                                                        value="{{ $asset->supplier }}" placeholder="Enter supplier name"
                                                        autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="additional_info">Additional Info</label>
                                                    <textarea class="form-control" name="additional_info" id="additional_info" cols="4" rows="3"
                                                        placeholder="Enter additional info" autocomplete="on"
                                                        required>{{ $asset->additional_info }}</textarea>
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
                                    <h3 class="card-title"><i class="fa fa-users"></i> Asset assignment </h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form action="{{ route('admin.assets.assign') }}" method="post">
                                        <input type="hidden" name="current_user" value="{{ $asset->assigned_to }}">
                                        <input type="hidden" name="product_id" value="{{ $asset->product_id }}">
                                        <input type="hidden" name="asset_id" value="{{ $asset->scanner_id }}">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="date_assigned">Date Assigned</label>
                                                        <input type="date" name="date_assigned" class="form-control"
                                                            id="date_assigned" value="{{ date('Y-m-d') }}"
                                                            placeholder="Select date assigned" autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="branch_id">Branch</label>
                                                        <select name="branch" id="branch" class="form-control select2"
                                                            id="branch_id" required>
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
                                                        <select name="outpost_id" class="form-control select2" id="outposts"
                                                            required>
                                                            <option class="mb-1" value="">
                                                                - Select Branch First -</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="users">Users</label>
                                                        <select name="user_id" id="users" class="form-control select2"
                                                            id="user_id" required>
                                                            <option class="mb-1" value="">
                                                                - Select Outpost First -</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="message">Additional Info</label>
                                                        <textarea class="form-control" name="message" id="message" cols="4" rows="2" placeholder="Enter additional info"
                                                            autocomplete="on" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="submit" class="btn btn-primary"> <i class="fa fa-user-plus"></i>
                                                Reassign Asset</button>
                                        </div>
                                    </form>
                                    <br>
                                    <table id="table2" class="table table-sm table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>PREVIOUS USER</th>
                                                <th>CURRENT USER</th>
                                                <th>ASSIGNED BY</th>
                                                <th>DATE ASSIGNED</th>
                                                <th>MESSAGE</th>
                                                <th>ACTION</th>
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
                                                    <td>
                                                        <div class="margin">
                                                            <div class="btn-group">
                                                                <button type="button" data-toggle="modal"
                                                                    data-target="#modalEditDetails-{{ $assign->assigned_id }}"
                                                                    class="btn btn-xs btn-warning"><i
                                                                        class="fa fa-edit"></i>
                                                                    Edit</button>
                                                            </div>
                                                            <div class="btn-group">
                                                                <form
                                                                    action="{{ route('admin.assets.delete', $assign->assigned_id) }}"
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
                                                    <div class="modal fade"
                                                        id="modalEditDetails-{{ $assign->assigned_id }}"
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
                                                                    action="{{ route('admin.assets.update', $assign->assigned_id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <div class="form-group">
                                                                                    <label for="date_assigned">Date
                                                                                        Assigned</label>
                                                                                    <input type="date" name="date_assigned"
                                                                                        class="form-control"
                                                                                        id="date_assigned"
                                                                                        value="{{ $assign->date_assigned }}"
                                                                                        placeholder="Select date assigned"
                                                                                        autocomplete="on" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <div class="form-group">
                                                                                    <label for="message">Additional
                                                                                        Info</label>
                                                                                    <textarea class="form-control" name="message" id="message" cols="4" rows="2" placeholder="Enter additional info"
                                                                                        autocomplete="on"
                                                                                        required>{{ $assign->message }}</textarea>
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
                            <!-- assignment -->
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="repairs">
                            <!-- repairs -->
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fa fa-user-plus"></i> Asset repairs </h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form action="{{ route('admin.repairs.save') }}" method="post">
                                        <input type="hidden" name="current_user" value="{{ $asset->assigned_to }}">
                                        <input type="hidden" name="product_id" value="{{ $asset->product_id }}">
                                        <input type="hidden" name="asset_id" value="{{ $asset->scanner_id }}">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="date_done">Date Done</label>
                                                        <input type="date" name="date_done" class="form-control"
                                                            id="date_done" value="{{ date('Y-m-d') }}"
                                                            placeholder="Select date done" autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="cost">Repair Cost</label>
                                                        <input type="number" name="cost" class="form-control" id="cost"
                                                            value="{{ old('cost') }}" placeholder="Enter repair cost"
                                                            autocomplete="on" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="asset_issue">Detailed Repair Issue</label>
                                                        <textarea class="form-control" name="asset_issue" id="asset_issue" cols="4" rows="2"
                                                            placeholder="Enter detailed asset repair issue"
                                                            autocomplete="on" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="action_done">Action Done</label>
                                                        <textarea class="form-control" name="action_done" id="action_done" cols="4" rows="2" placeholder="Enter action done"
                                                            autocomplete="on" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="submit" class="btn btn-primary"> <i class="fa fa-user-plus"></i>
                                                Save Repair Data</button>
                                        </div>
                                    </form>
                                    <br>
                                    <table id="table4" class="table table-sm table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>S.N</th>
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
                                                                    class="btn btn-xs btn-warning"><i
                                                                        class="fa fa-edit"></i>
                                                                    Edit</button>
                                                            </div>
                                                            <div class="btn-group">
                                                                <form
                                                                    action="{{ route('admin.repairs.delete', $repair->repair_id) }}"
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
                                                    <div class="modal fade"
                                                        id="modalEditDetails-{{ $repair->repair_id }}"
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
                                                                    action="{{ route('admin.repairs.update', $repair->repair_id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label for="date_done">Date Done</label>
                                                                                    <input type="date" name="date_done"
                                                                                        class="form-control"
                                                                                        id="date_done"
                                                                                        value="{{ $repair->date_done }}"
                                                                                        placeholder="Select date done"
                                                                                        autocomplete="on" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label for="cost">Repair Cost</label>
                                                                                    <input type="number" name="cost"
                                                                                        class="form-control" id="cost"
                                                                                        value="{{ $repair->cost }}"
                                                                                        placeholder="Enter repair cost"
                                                                                        autocomplete="on" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label for="asset_issue">Detailed Repair
                                                                                        Issue</label>
                                                                                    <textarea class="form-control" name="asset_issue" id="asset_issue" cols="4" rows="2" placeholder="Enter detailed asset repair issue"
                                                                                        autocomplete="on"
                                                                                        required>{{ $repair->asset_issue }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label for="action_done">
                                                                                        Action Done</label>
                                                                                    <textarea class="form-control" name="action_done" id="action_done" cols="4" rows="2" placeholder="Enter action done"
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
                            <!-- repairs -->
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
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
        });
    </script>
@endpush
