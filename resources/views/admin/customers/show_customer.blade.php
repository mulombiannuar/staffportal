@extends('layouts.admin.form')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-user"></i> {{ $title . ' - ' . $customer->created_at }}</h3>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="customer_name">Customer Name</label>
                                                <input type="text" name="customer_name" class="form-control"
                                                    id="name" placeholder="Enter customer name" autocomplete="off"
                                                    value="{{ $customer->customer_name }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="mobile_no">Mobile No.*</label>
                                                <input type="number" name="mobile_no" class="form-control" id="mobile_no"
                                                    placeholder="Enter Mobile Number"
                                                    value="{{ $customer->customer_phone }}" autocomplete="off" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="residence">Residence</label>
                                                <input type="text" name="residence" class="form-control" id="residence"
                                                    placeholder="Enter residence" value="{{ $customer->residence }}"
                                                    autocomplete="on" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="branch_id">Branch</label>
                                                <input type="text" name="branch" class="form-control" id="branch"
                                                    placeholder="Enter branch" value="{{ $customer->branch_name }}"
                                                    autocomplete="on" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="outposts">Outpost</label>
                                                <input type="text" name="outpost_name" class="form-control"
                                                    id="outpost_name" placeholder="Enter outpost_name"
                                                    value="{{ $customer->outpost_name }}" autocomplete="on" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="users">Officer Assigned</label>
                                                <input type="text" name="officer_name" class="form-control"
                                                    id="officer_name" placeholder="Enter officer_name"
                                                    value="{{ $customer->officer_name }}" autocomplete="on" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="business">Business</label>
                                                <input type="text" name="business" class="form-control" id="business"
                                                    placeholder="Enter business activity" value="{{ $customer->business }}"
                                                    autocomplete="on" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label for="message">Message</label>
                                                <textarea class="form-control" name="message" id="message" cols="4" rows="3"
                                                    placeholder="Enter customer message" autocomplete="on" readonly>{{ $customer->customer_message }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-envelope"></i> Officer Message
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('customers.save_officer_message', $customer->customer_id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="officer_message">Enter your message</label>
                                        <textarea class="form-control" name="officer_message" id="officer_message" cols="4" rows="2"
                                            placeholder="Enter your message here" autocomplete="on" required>{{ $customer->officer_message }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-warning"> <i class="fa fa-plus"></i>
                                Update Officer Message</button>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            @if (Auth::user()->hasRole('admin'))
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-list-alt"></i> Admin Message
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ route('customers.save_admin_message', $customer->customer_id) }}"
                            method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="type">Issue Resolved</label>
                                            <select name="issue_sorted" id="issue_sorted" class="form-control select2"
                                                id="issue_sorted" required>
                                                <option value="{{ $customer->issue_sorted }}">
                                                    @if ($customer->issue_sorted == 0)
                                                        {{ 'Not Resolved' }}
                                                    @else
                                                        {{ 'Resolved' }}
                                                    @endif
                                                </option>
                                                <option value="1">Resolved</option>
                                                <option value="0">Not Resolved</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label for="admin_message">Enter your message</label>
                                            <textarea class="form-control" name="admin_message" id="admin_message" cols="4" rows="2"
                                                placeholder="Enter your message here" autocomplete="on" required>{{ $customer->admin_message }}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="submit" class="btn btn-info"> <i class="fa fa-plus"></i>
                                    Update Admin Message</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            @endif
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
