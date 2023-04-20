@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card card-warning card-outline">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#details" data-toggle="tab"><i class="fa fa-user"></i>
                            Customer Ticket Details</a></li>

                    <li class="nav-item"><a class="nav-link" href="#responses" data-toggle="tab"><i class="fa fa-list"></i>
                            Customer Responses</a></li>


                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="details">
                        <!-- Ticket Details -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-user"></i> Ticket Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="customer_name">Customer Name</label>
                                                <input type="text" name="customer_name" class="form-control"
                                                    id="name" placeholder="Enter customer name" autocomplete="off"
                                                    value="{{ $ticket->customer_name }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="customer_phone">Mobile No</label>
                                                <input type="number" name="customer_phone" class="form-control"
                                                    id="customer_phone" placeholder="Enter Mobile Number"
                                                    value="{{ $ticket->customer_phone }}" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="residence">Residence</label>
                                                <input type="text" name="residence" class="form-control" id="residence"
                                                    placeholder="Enter residence" value="{{ $ticket->residence }}"
                                                    autocomplete="on" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="branch_id">Branch</label>
                                                <input type="text" name="branch" class="form-control" id="branch"
                                                    placeholder="Enter branch" value="{{ $ticket->branch_name }}"
                                                    autocomplete="on" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="outposts">Outpost</label>
                                                <input type="text" name="outpost_id" class="form-control" id="outpost_id"
                                                    placeholder="Enter outpost_id" value="{{ $ticket->outpost_name }}"
                                                    autocomplete="on" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="users">Complaint Receiver</label>
                                                <input type="text" name="officer_name" class="form-control"
                                                    id="outpost_id" placeholder="Enter officer_name"
                                                    value="{{ $ticket->officer_name }}" autocomplete="on" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="business">Business</label>
                                                <input type="text" name="business" class="form-control" id="business"
                                                    placeholder="Enter business activity" value="{{ $ticket->business }}"
                                                    autocomplete="on" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="date_raised">Date Raised</label>
                                                <input type="date" name="date_raised" class="form-control"
                                                    id="date_raised" placeholder="Enter date raised"
                                                    value="{{ $ticket->date_raised }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="message">Ticket Content</label>
                                                <textarea class="form-control" name="message" id="message" cols="4" rows="3"
                                                    placeholder="Enter ticket content" autocomplete="on" required>{{ $ticket->message }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.Ticket Details -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="responses">
                        <!-- roles user -->
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-list"></i>
                                    {{ $ticket->customer_name }} Responses
                                </h3>
                            </div>
                            <div class="card-body">
                                <table id="table1" class="table table-sm table-hover table-bordered table-head-fixed">
                                    <thead>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th>QUESTION</th>
                                            <th>CUSTOMER RESPONSE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Q1.</td>
                                            <td> What was your issue all about? e.g Savings refund, Loan disbursment,
                                                Logbook release</td>
                                            <td>{{ $response['Q1'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Q2.</td>
                                            <td> How satisfied were you with the services from our officer?</td>
                                            <td>{{ $response['Q2'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Q3.</td>
                                            <td> Was your issue resolved by our team?</td>
                                            <td>{{ $response['Q3'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Q4.</td>
                                            <td> Based on your experience, how likely would you recommend Bimas Kenya to
                                                your friends and family?</td>
                                            <td>{{ $response['Q4'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Q5.</td>
                                            <td> Enter your Overall Remarks</td>
                                            <td>{{ $response['Q5'] }}</td>
                                        </tr>
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

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#workflows').change(function() {
                workflow = $('#workflows').val();
                if (workflow != '') {
                    $.ajax({
                        url: "{{ route('get.workflowusers') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "GET",
                        data: {
                            workflow: workflow
                        },
                        success: function(data) {
                            console.log(data);
                            $('#workflow_users').html(data);
                        },
                        error: function(xhr, desc, err) {
                            console.log(xhr);
                            //console.log("Details0: " + desc + "\nError:" + err);
                        },
                    });
                } else {
                    $('#users').html('<p value="text text-danger">No Workflow Users Found </p>');
                }
            });
        });

        $('#ticket_resolved').change(function() {
            ticket_resolved = $('#ticket_resolved').val();
            if (ticket_resolved != '') {
                if (ticket_resolved == 0) {
                    document.getElementById("hidden").style.display = "block";
                }
            }
        });
    </script>
@endpush
