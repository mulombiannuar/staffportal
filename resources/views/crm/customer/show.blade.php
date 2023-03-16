@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card card-warning card-outline">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#details" data-toggle="tab"><i class="fa fa-user"></i>
                            Customer Details</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tickets" data-toggle="tab"><i class="fa fa-list-alt"></i>
                            Customer Tickets ({{ count($tickets) }})</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="details">
                        <!-- Profile -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-user"></i> Customer Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="customer_name">Customer Name</label>
                                            <input type="text" class="form-control"
                                                value="{{ $customer->customer_name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="customer_phone">Mobile No</label>
                                            <input type="text" class="form-control"
                                                value="{{ $customer->customer_phone }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="residence">Residence</label>
                                            <input type="text" name="residence" class="form-control"
                                                value="{{ $customer->residence }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="customer_name">Business</label>
                                            <input type="text" class="form-control" value="{{ $customer->business }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="customer_phone">Branch </label>
                                            <input type="text" class="form-control" value="{{ $customer->branch_name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="residence">Outpost </label>
                                            <input type="text" name="residence" class="form-control"
                                                value="{{ $customer->outpost_name }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.Profile -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="tickets">
                        <!-- roles user -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-list-alt"></i> Customer Tickets</h3>
                            </div>
                            <div class="card-body">
                                <table id="table1" class="table table-sm table-bordered table-striped table-head-fixed">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>TICKET ID</th>
                                            <th>DATE</th>
                                            <th>OFFICER</th>
                                            <th>CURRENT LEVEL</th>
                                            <th>TICKET CONTENT</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tickets as $ticket)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $ticket->ticket_uuid }}</td>
                                                <td>{{ $ticket->date_raised }}</td>
                                                <td>{{ $ticket->officer_name }}</td>
                                                <td>Finance manager</td>
                                                <td>{{ $ticket->message }}</td>
                                                <td>
                                                    <div class="margin">
                                                        <div class="btn-group">
                                                            <a href="{{ route('crm.tickets.show', $ticket->ticket_id) }}"
                                                                title="Click to view ticket details">
                                                                <button type="button" class="btn btn-xs btn-info"><i
                                                                        class="fa fa-eye"></i>
                                                                    View</button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- roles user -->
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- /.nav-tabs-custom -->
    </section>
    <!-- /.content -->
@endsection
