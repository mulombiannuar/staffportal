@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-calendar"></i> {{ $asset->type }} Booking Services -
                        {{ $log->reference }}
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>REFERENCE</th>
                                <th>ASSET NAME</th>
                                <th>BOOKED DATE</th>
                                <th>USER</th>
                                <th>TYPE</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $log->reference }}</td>
                                <td>{{ $log->name . ' - ' . $log->reg_no }}</td>
                                <td>{{ date_format(date_create($log->date), 'D, d M Y') }}</td>
                                <td>{{ $log->booker_name }}</td>
                                <td>{{ $log->type }}</td>
                                <td>{{ $approval }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- /.if user has rights -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-calendar"></i> Booking Approval
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if (!is_null($log->approved_by))
                        <table class="table  table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>DATE APPROVED</th>
                                    <th>DATE BOOKED </th>
                                    <th>APPROVED BY</th>
                                    <th>MESSAGE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ date_format(date_create($log->date_approved), 'D, d M Y') }}</td>
                                    <td>{{ date_format(date_create($log->date), 'D, d M Y') }}</td>
                                    <td>{{ $log->approver_name }}</td>
                                    <td>{{ $log->approval_message }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                    @endif

                    <form action="{{ route('admin.motor-logs.approve', $log->log_id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="type">Approval</label>
                                        <select name="status" id="status" class="form-control select2" id="type" required>
                                            <option class="mb-1"
                                                value="{{ $log->status == 0 ? 'Select Approval Status' : $log->status }}">
                                                @if ($log->status == 0)
                                                    {{ 'Select Approval Status' }}
                                                @elseif ($log->status == 0)
                                                    {{ 'Approve Booking' }}
                                                @else
                                                    {{ 'Reschedule Booking' }}
                                                @endif
                                            </option>
                                            <option value="1">Approve Booking</option>
                                            <option value="2">Reschedule Booking</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="date">Booked Date</label>
                                        <input type="date" name="date" class="form-control" id="date"
                                            value="{{ $log->date }}" placeholder="Select appointment date"
                                            autocomplete="on" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="approval_message">Approval Message</label>
                                        <textarea class="form-control" name="approval_message" id="approval_message" cols="4" rows="3"
                                            placeholder="Enter approval message here" autocomplete="on"
                                            required>{{ $log->approval_message }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary"> <i class="fa fa-plus"></i>
                                Save Booking Data</button>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            @if (!is_null($log->approved_by))
                <!-- /.if user has rights -->
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-list-alt"></i> Services Peformed
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ route('admin.motor-logs.save', $log->log_id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="type">Service Cause</label>
                                            <select name="service_cause" id="service_cause" class="form-control select2"
                                                id="service_cause" required>
                                                <option class="mb-1"
                                                    value="{{ is_null($log->service_cause) ? '' : $log->service_cause }}">
                                                    {{ is_null($log->service_cause) ? '- Select Cause of Service -' : $log->service_cause }}
                                                </option>
                                                <option value="Cause of Accident">Cause of Accident</option>
                                                <option value="Cause of Mileage Limit">Cause of Mileage Limit</option>
                                                <option value="Cause of Fire">Cause of Fire</option>
                                                <option value="Others">Others (Specify Below)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="service_date">Service Date</label>
                                            <input type="date" name="service_date" class="form-control" id="service_date"
                                                value="{{ is_null($log->service_date) ? date('Y-m-d') : $log->service_date }}"
                                                placeholder="Select service date" autocomplete="on" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="service_cost">Service Cost</label>
                                            <input type="number" name="service_cost" class="form-control"
                                                id="service_cost" value="{{ $log->service_cost }}"
                                                placeholder="Enter service cost" autocomplete="on" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="service_done">Services Done</label>
                                            <textarea class="form-control" name="service_done" id="service_done" cols="4" rows="3"
                                                placeholder="Enter detailed services done here" autocomplete="on"
                                                required>{{ $log->service_done }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="additional_info">Additional Information & Recommendations</label>
                                            <textarea class="form-control" name="additional_info" id="additional_info" cols="4" rows="3"
                                                placeholder="Enter Additional Information & Recommendations"
                                                autocomplete="on" required>{{ $log->additional_info }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="submit" class="btn btn-warning"> <i class="fa fa-plus"></i>
                                    Save Maintance Data</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            @endif
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
