@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-plus"></i> Book New {{ $asset->type }} Services -
                        {{ $asset->reg_no }}
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('admin.motor-logs.store') }}" method="post">
                        <input type="hidden" name="user_id" value="{{ $asset->assigned_to }}">
                        <input type="hidden" name="asset_id" value="{{ $asset->motor_id }}">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="type">Service Type</label>
                                        <select name="type" id="type" class="form-control select2" id="type" required>
                                            <option class="mb-1" value="">
                                                - Select Service Type -</option>
                                            <option value="Scheduled Maintenance">Scheduled Maintenance</option>
                                            <option value="Scheduled Repair">Scheduled Repair</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="date">Appointment Date</label>
                                        <input type="date" name="date" class="form-control" id="date"
                                            value="{{ date('Y-m-d') }}" placeholder="Select appointment date"
                                            autocomplete="on" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="message">Message</label>
                                        <textarea class="form-control" name="message" id="message" cols="4" rows="3" placeholder="Enter detailed message here"
                                            autocomplete="on" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary"> <i class="fa fa-user-plus"></i>
                                Book {{ $asset->type }} Services</button>
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
