@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-edit"></i> Update {{ $asset->type }} Booking Services -
                        {{ $asset->reg_no }}
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('admin.motor-logs.update', $log->log_id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="type">Service Type</label>
                                        <select name="type" id="type" class="form-control select2" id="type" required>
                                            <option class="mb-1" value="{{ $log->type }}">
                                                {{ $log->type }}</option>
                                            <option value="Scheduled Maintenance">Scheduled Maintenance</option>
                                            <option value="Scheduled Repair">Scheduled Repair</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="date">Appointment Date</label>
                                        <input type="date" name="date" class="form-control" id="date"
                                            value="{{ $log->date }}" placeholder="Select appointment date"
                                            autocomplete="on" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="message">Message</label>
                                        <textarea class="form-control" name="message" id="message" cols="4" rows="3" placeholder="Enter detailed message here"
                                            autocomplete="on" required>{{ $log->message }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-info"> <i class="fa fa-edit"></i>
                                Update Booking Services</button>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
