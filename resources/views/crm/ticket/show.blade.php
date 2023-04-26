@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card card-warning card-outline">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#details" data-toggle="tab"><i class="fa fa-bars"></i>
                            Ticket Details</a></li>

                    <li class="nav-item"><a class="nav-link" href="#escalation" data-toggle="tab"><i
                                class="fa fa-list-alt"></i> Ticket Escalation</a></li>
                    @if (!$ticketData->ticket_closed)
                        <li class="nav-item"><a class="nav-link" href="#addcomment" data-toggle="tab"><i
                                    class="fa fa-plus-circle"></i>
                                Submit Your Comment</a></li>
                    @endif

                    @if (Auth::user()->hasRole('administrator') || Auth::user()->hasRole('communication'))
                        <li class="nav-item"><a class="nav-link" href="#closeticket" data-toggle="tab"><i
                                    class="fa fa-calendar"></i>
                                Ticket Closure</a></li>

                        <li class="nav-item"><a class="nav-link" href="#survey" data-toggle="tab"><i
                                    class="fa fa-question-circle"></i>
                                Ticket Survey</a></li>
                    @endif
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
                                                <input type="text" name="business" class="form-control"
                                                    id="business" placeholder="Enter business activity"
                                                    value="{{ $customer->business }}" autocomplete="on" required>
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
                                <h3 class="card-title"><i class="fa fa-plus-circle"></i> Ticket Comment</h3>
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
                                        <button type="submit" class="btn btn-primary"> <i class="fa fa-plus-circle"></i>
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
                                            <th>DATE RESPONDED</th>
                                            <th>RES. TIME</th>
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
                                                <td>{{ $ticket->resolution_time }}Hrs</td>
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

                    <div class="tab-pane" id="closeticket">
                        <!-- roles user -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-calendar"></i>
                                    {{ $ticketData->ticket_closed ? 'Ticket Closure Details' : 'Ticket Comment' }} </h3>
                            </div>
                            <div class="card-body">
                                @if ($ticketData->ticket_closed)
                                    <table class="table table-sm table-hover table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>IS CLOSED</th>
                                                <td>{{ $ticketData->ticket_closed ? 'Ticket Closed' : 'Ticket Open' }}</td>
                                            </tr>
                                            <tr>
                                                <th>DATE CLOSED</th>
                                                <td>{{ $ticketData->date_closed }}</td>
                                            </tr>
                                            <tr>
                                                <th>CLOSURE COMMENT</th>
                                                <td>{{ $ticketData->closure_comment }}</td>
                                            </tr>
                                            <tr>
                                                <th>SURVEY SENT</th>
                                                <td>{{ $ticketData->customer_sent_survey ? 'Yes' : 'Not' }}</td>
                                            </tr>
                                            <tr>
                                                <th>SURVEY RESPONDED</th>
                                                <td>{{ $ticketData->customer_responded_survey ? 'Yes' : 'Not' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @else
                                    <form method="post" action="{{ route('crm.tickets.close') }}">
                                        <input type="hidden" name="ticket_id" value="{{ $ticketData->ticket_id }}">
                                        <input type="hidden" name="current_id" value="{{ $current_workflow->id }}">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="date_closed">Date Closed</label>
                                                        <input type="date" name="date_closed" class="form-control"
                                                            id="date_closed" placeholder="Enter date closed"
                                                            value="{{ date('Y-m-d') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="closure_message">Your Comment</label>
                                                        <textarea class="form-control" name="closure_message" id="closure_comment" cols="4" rows="2"
                                                            placeholder="Enter your comment" autocomplete="on" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="submit" class="btn btn-warning"> <i
                                                    class="fa fa-user-plus"></i>
                                                Close Ticket</button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- roles user -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="survey">
                        <!-- roles user -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-question-circle"></i>
                                    {{ $ticketData->customer_sent_survey ? 'Ticket Sent Survey Details' : 'Send Survey Question' }}
                                </h3>
                            </div>
                            <div class="card-body">
                                @if ($ticketData->customer_sent_survey)
                                    <table class="table table-sm table-hover table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>DATE SENT</th>
                                                <td>{{ $survey_data->date_sent }}</td>
                                            </tr>
                                            <tr>
                                                <th>SENT BY</th>
                                                <td>{{ $survey_data->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>CUSTOMER MESSAGE</th>
                                                <td>{{ $survey_data->survey_message }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>SURVEY QUESTION LINK</th>
                                                <td><a target="_blank"
                                                        href="{{ $survey_data->survey_link }}">{{ $survey_data->survey_link }}</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>SURVEY RESPONDED</th>
                                                <td>
                                                    @if ($ticketData->customer_responded_survey)
                                                        <div class="btn-group">
                                                            <a href="{{ route('crm.tickets.feedbacks.show', $survey_data->ticket_uuid) }}"
                                                                title="Click to view ticket details">
                                                                <button type="button" class="btn btn-xs btn-warning"><i
                                                                        class="fa fa-bars"></i>
                                                                    View Details</button>
                                                            </a>
                                                        </div>
                                                    @else
                                                        Not
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <form action="{{ route('crm.tickets.resend-message') }}"
                                                        method="post"
                                                        onclick="return confirm('Do you really want to send customer reminder message')">
                                                        @csrf
                                                        <input type="hidden" name="ticket_id"
                                                            value="{{ $ticketData->ticket_id }}">
                                                        <input type="hidden" name="survey_message"
                                                            value="{{ $survey_data->survey_message }}">
                                                        <button type="submit" class="btn btn-secondary"> <i
                                                                class="fa fa-envelope"></i>
                                                            Send Reminder Message</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @else
                                    <form method="post" action="{{ route('crm.tickets.save-survey') }}">
                                        <input type="hidden" name="ticket_id" value="{{ $ticketData->ticket_id }}">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-7 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="survey_message">Survey Message</label>
                                                        <textarea class="form-control" name="survey_message" id="survey_message" cols="4" rows="2"
                                                            placeholder="Enter survey message" autocomplete="on" required>Thank you for contacting Bimas Kenya Limited. We value your feedback. Please rate your experience here </textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-5 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="source">Survey Link</label>
                                                        <input type="text" name="survey_link" class="form-control"
                                                            id="survey_link" value="{{ $ticket_url }}"
                                                            autocomplete="on" readonly required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="submit" class="btn btn-secondary"> <i
                                                    class="fa fa-user-plus"></i>
                                                Send Client Message</button>
                                        </div>
                                    </form>
                                @endif
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
