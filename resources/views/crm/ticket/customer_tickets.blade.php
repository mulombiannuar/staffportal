@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card card-warning card-outline">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#addticket" data-toggle="tab"><i
                                class="fa fa-user-plus"></i>
                            Add Customer Ticket</a></li>
                    <li class="nav-item"><a class="nav-link" href="#creditofficer" data-toggle="tab"><i
                                class="fa fa-list"></i>
                            Credit Officer</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="addticket">
                        <!-- Add Customer Ticket -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-user-plus"></i> Add Customer Ticket</h3>
                            </div>
                            <div class="card-body">
                                <form role="form" id="form" action="{{ route('crm.tickets.store_customer') }}"
                                    method="post">
                                    <input type="hidden" name="category" value="5">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="customer_name">Customer Name</label>
                                                    <input type="text" name="customer_name" class="form-control"
                                                        id="name" placeholder="Enter customer name" autocomplete="off"
                                                        value="{{ old('customer_name') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="customer_phone">Mobile No</label>
                                                    <input type="number" name="customer_phone" class="form-control"
                                                        id="customer_phone" placeholder="Enter Mobile Number"
                                                        value="{{ old('customer_phone') }}" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="residence">Residence</label>
                                                    <input type="text" name="residence" class="form-control"
                                                        id="residence" placeholder="Enter residence"
                                                        value="{{ old('residence') }}" autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="date_raised">Date Raised</label>
                                                    <input type="date" name="date_raised" class="form-control"
                                                        id="date_raised" placeholder="Enter date raised"
                                                        value="{{ date('Y-m-d') }}" required>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="business">Business</label>
                                                    <input type="text" name="business" class="form-control"
                                                        id="business" placeholder="Enter business activity"
                                                        value="{{ old('business') }}" autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="source">Source</label>
                                                    <select name="source" class="form-control select2" id="category"
                                                        required>
                                                        <option class="mb-1" value="">
                                                            - Select Ticket Source -</option>
                                                        @foreach ($sources as $source)
                                                            <option value="{{ $source->source_id }}">
                                                                {{ $source->source_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        @if (Auth::user()->hasRole('bimas staff|branch manager'))
                                            <input type="hidden" name="branch" value="{{ $user->branch }}">
                                            <input type="hidden" name="outpost_id" value="{{ $user->outpost }}">

                                            <input type="hidden" name="workflow_id" value="6">
                                            <input type="hidden" name="workflow_user_id" value="13">
                                            @if (Auth::user()->hasRole('branch manager'))
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="users">Outpost Users</label>
                                                            <select name="user_id" class="form-control select2" required>
                                                                <option class="mb-1" value="">
                                                                    - Select Outpost Users -</option>
                                                                @foreach ($outpost_users as $user)
                                                                    <option value="{{ $user->id }}">
                                                                        {{ $user->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            @endif
                                        @else
                                            <div class="row">
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="branch_id">Branch</label>
                                                        <select name="branch" id="branch"
                                                            class="form-control select2" id="branch_id" required>
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
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="outposts">Outpost</label>
                                                        <select name="outpost_id" class="form-control select2"
                                                            id="outposts" required>
                                                            <option class="mb-1" value="">
                                                                - Select Branch First -</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="users">Complaint Receiver</label>
                                                        <select name="user_id" id="users"
                                                            class="form-control select2" id="user_id" required>
                                                            <option class="mb-1" value="">
                                                                - Select Outpost First -</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="workflow_id">Workflow Level</label>
                                                        <select name="workflow_id" class="form-control select2"
                                                            id="workflows" required>
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
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="workflow_users">Workflow Users</label>
                                                        <select name="workflow_user_id" class="form-control select2"
                                                            id="workflow_users" required>
                                                            <option class="mb-1" value="">
                                                                - Select Workflow Level First -</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="message">Ticket Content</label>
                                                    <textarea class="form-control" name="message" id="message" cols="4" rows="3"
                                                        placeholder="Enter ticket content" autocomplete="on" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="submit" id="submit" disabled class="btn btn-primary"> <i
                                                class="fa fa-user-plus"></i>
                                            Submit Customer Ticket</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.Profile -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="creditofficer">
                        <!-- documents -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-list"></i> Credit Officer </h3>
                            </div>
                            <div class="card-body">
                                <table id="table1"
                                    class="table table-sm table-bordered table-striped table-head-fixed">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>TICKET ID</th>
                                            <th>NAMES</th>
                                            <th>MOBILE</th>
                                            <th>RESIDENCE</th>
                                            {{-- <th>BUSINESS</th> --}}
                                            {{-- <th>TICKET CONTENT</th> --}}
                                            <th>BUSINESS</th>
                                            <th>DATE</th>
                                            <th>BRANCH</th>
                                            <th>OFFICER</th>
                                            <th>CREATED AT</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tickets_data as $ticket_data)
                                            @if ($ticket_data->workflow_user_name == 'Credit Officer')
                                                @foreach ($ticket_data->tickets as $ticket)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $ticket->ticket_uuid }}</td>
                                                        <td>{{ strtoupper($ticket->customer_name) }}</td>
                                                        <td>{{ $ticket->customer_phone }}</td>
                                                        <td>{{ $ticket->residence }}</td>
                                                        <td>{{ $ticket->business }}</td>
                                                        <td>{{ $ticket->date_raised }}</td>
                                                        <td>{{ $ticket->outpost_name }}</td>
                                                        <td>{{ $ticket->officer_name }}</td>
                                                        <td>{{ $ticket->created_at }}</td>
                                                        <td>
                                                            <div class="margin">
                                                                <div class="btn-group">
                                                                    <a href="{{ route('crm.tickets.show', $ticket->ticket_id) }}"
                                                                        title="Click to view ticket details">
                                                                        <button type="button"
                                                                            class="btn btn-xs btn-info"><i
                                                                                class="fa fa-eye"></i>
                                                                            View</button>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- documents -->
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
            $('#form').on("keyup", action);

            function action() {
                if ($('#customer_phone').val().length == 10) {
                    $('#submit').prop("disabled", false);
                } else {
                    $('#submit').prop("disabled", true);
                }
            }

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
    </script>
@endpush
