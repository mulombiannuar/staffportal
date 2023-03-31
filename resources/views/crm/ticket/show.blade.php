@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card card-warning card-outline">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#details" data-toggle="tab"><i class="fa fa-bars"></i>
                            Ticket Details</a></li>

                    <li class="nav-item"><a class="nav-link" href="#addcomment" data-toggle="tab"><i
                                class="fa fa-user-plus"></i>
                            Add Comment</a></li>

                    <li class="nav-item"><a class="nav-link" href="#escalation" data-toggle="tab"><i
                                class="fa fa-list-alt"></i> Ticket Escalation</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="details">
                        <!-- Ticket Details -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-bars"></i> Ticket Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="customer_name">Customer Name</label>
                                                <input type="text" name="customer_name" class="form-control"
                                                    id="name" placeholder="Enter customer name" autocomplete="off"
                                                    value="{{ $customer->customer_name }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="customer_phone">Mobile No</label>
                                                <input type="number" name="customer_phone" class="form-control"
                                                    id="customer_phone" placeholder="Enter Mobile Number"
                                                    value="{{ $customer->customer_phone }}" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="residence">Residence</label>
                                                <input type="text" name="residence" class="form-control" id="residence"
                                                    placeholder="Enter residence" value="{{ $customer->residence }}"
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
                                                    placeholder="Enter business activity" value="{{ $customer->business }}"
                                                    autocomplete="on" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="workflow_id">Current Workflow Level</label>
                                                <input type="text" name="workflow_id" class="form-control"
                                                    id="business" placeholder="Enter workflow"
                                                    value="{{ $current_workflow->workflow_user_name }}" autocomplete="on"
                                                    required>
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
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="category">Category</label>
                                                <input type="text" name="workflow_id" class="form-control"
                                                    id="business" placeholder="Enter category"
                                                    value="{{ $ticket->category_name }}" autocomplete="on" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="source">Source</label>
                                                <input type="text" name="source_name" class="form-control"
                                                    id="source_name" placeholder="Enter source"
                                                    value="{{ $ticket->source_name }}" autocomplete="on" required>
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

                    <div class="tab-pane" id="addcomment">
                        <!-- roles user -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-user-plus"></i> Ticket Comment</h3>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('crm.tickets.save_comment') }}">
                                    <input type="hidden" name="ticket_id" value="{{ $ticket->ticket_id }}">
                                    <input type="hidden" name="current_id" value="{{ $current_workflow->id }}">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="ticket_resolved">Has Ticket Been Resolved at your
                                                        level?</label>
                                                    <select name="ticket_resolved" class="form-control select2"
                                                        id="ticket_resolved" required>
                                                        <option selected value="1">Yes, it has been resolved</option>
                                                        <option value="0">Nop, lemme forward to the next person
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="hidden" style="display: none">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="workflow_id">Forward to Workflow Level</label>
                                                        <select name="workflow_id" class="form-control select2"
                                                            id="workflows">
                                                            <option class="mb-1" value="">
                                                                - Select Wokflow Level -</option>
                                                            @foreach ($workflows as $workflow)
                                                                <option value="{{ $workflow->workflow_id }}">
                                                                    {{ $workflow->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="workflow_users">Forwarded to User</label>
                                                        <select name="workflow_user_id" class="form-control select2"
                                                            id="workflow_users">
                                                            <option class="mb-1" value="">
                                                                - Select Workflow Level First -</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="workflow_message">Officer Comment</label>
                                                    <textarea class="form-control" name="workflow_message" id="workflow_message" cols="4" rows="2"
                                                        placeholder="Enter ticket comment" autocomplete="on" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="submit" class="btn btn-primary"> <i class="fa fa-user-plus"></i>
                                            Submit Ticket Comment</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- roles user -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="escalation">
                        <!-- roles user -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-list-alt"></i> Ticket Escalation</h3>
                            </div>
                            <div class="card-body">
                                <table id="table1" class="table table-sm table-hover table-bordered table-head-fixed">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>NAME</th>
                                            <th>EMAIL</th>
                                            <th>LEVEL</th>
                                            <th>COMMENT</th>
                                            <th>DATE</th>
                                            <th>RESOLVED?</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($escalations as $ticket)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ strtoupper($ticket->officer_name) }}</td>
                                                <td>{{ $ticket->email }}</td>
                                                <td>{{ $ticket->workflow_user_name }}</td>
                                                <td>{{ $ticket->workflow_message }}</td>
                                                <td>{{ $ticket->date_responded }}</td>
                                                <td>{{ $ticket->ticket_resolved ? 'Yes' : 'No' }}</td>
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
