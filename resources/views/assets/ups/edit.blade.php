@extends('layouts.admin.form')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-edit"></i> {{ $title }} -
                        {{ $asset->serial_number }}</h3>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <form action="{{ route('admin.ups.update', $asset->ups_id) }}" method="post">
                                    @method('PUT')
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="branch_id">Branch</label>
                                                    <select name="branch" id="branch" class="form-control select2"
                                                        id="branch_id" required>
                                                        <option class="mb-1" value="{{ $asset->branch_id }}">
                                                            {{ $asset->branch_name }}</option>
                                                        @foreach ($branches as $branch)
                                                            <option value="{{ $branch->branch_id }}">
                                                                {{ $branch->branch_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="outposts">Outpost</label>
                                                    <select name="outpost_id" class="form-control select2" id="outposts"
                                                        required>
                                                        <option class="mb-1" value="{{ $asset->outpost_id }}">
                                                            {{ $asset->outpost_name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="users">Users</label>
                                                    <select name="user_id" id="users" class="form-control select2"
                                                        id="user_id" required>
                                                        <option class="mb-1" value="{{ $asset->assigned_to }}">
                                                            {{ $asset->user_name }}</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="name">UPS Name</label>
                                                    <input type="text" name="name" class="form-control" id="name"
                                                        value="{{ $asset->name }}" placeholder="Enter UPS name"
                                                        autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="serial_number">Serial Number</label>
                                                    <input type="text" name="serial_number" class="form-control"
                                                        id="serial_number" value="{{ $asset->serial_number }}"
                                                        placeholder="Enter serial number" autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="battery_time">Battery Time</label>
                                                    <input type="text" name="battery_time" class="form-control"
                                                        id="battery_time" value="{{ $asset->battery_time }}"
                                                        placeholder="Enter battery recharge time" autocomplete="on"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="supplier">Supplier</label>
                                                    <input type="text" name="supplier" class="form-control" id="supplier"
                                                        value="{{ $asset->supplier }}" placeholder="Enter supplier name"
                                                        autocomplete="on" required>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="date_purchased">Date Purchased</label>
                                                    <input type="date" name="date_purchased" class="form-control"
                                                        id="date_purchased" value="{{ $asset->date_purchased }}"
                                                        placeholder="Select date purchased" autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="date_assigned">Date Assigned</label>
                                                    <input type="date" name="date_assigned" class="form-control"
                                                        id="date_assigned" value="{{ $asset->date_assigned }}"
                                                        placeholder="Select date assigned" autocomplete="on" required>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="input_capacity">Input Capacity</label>
                                                    <input type="text" name="input_capacity" class="form-control"
                                                        id="input_capacity" value="{{ $asset->input_capacity }}"
                                                        placeholder="Enter input capacity" autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="output_capacity">Output Capacity</label>
                                                    <input type="text" name="output_capacity" class="form-control"
                                                        id="output_capacity" value="{{ $asset->output_capacity }}"
                                                        placeholder="Enter output capacity" autocomplete="on" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="additional_info">Additional Info</label>
                                                    <textarea class="form-control" name="additional_info" id="additional_info" cols="4" rows="3"
                                                        placeholder="Enter additional info" autocomplete="on"
                                                        required>{{ $asset->additional_info }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="submit" class="btn btn-info"> <i class="fa fa-edit"></i>
                                            Update UPS Details</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
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
