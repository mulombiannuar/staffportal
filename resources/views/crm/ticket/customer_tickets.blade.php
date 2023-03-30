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

                    {{-- /. branch manager/credit officer --}}
                    @if (Auth::user()->hasRole('credit officer|branch manager'))
                        <li class="nav-item"><a class="nav-link" href="#creditofficer" data-toggle="tab"><i
                                    class="fa fa-list"></i>
                                Credit Officer ({{ count($creditofficer) }})</a></li>
                    @endif

                    {{-- /. branch manager --}}
                    @if (Auth::user()->hasRole('branch manager') || Auth::user()->hasRole('operations manager'))
                        <li class="nav-item"><a class="nav-link" href="#branchmanager" data-toggle="tab"><i
                                    class="fa fa-list"></i>
                                Branch Manager ({{ count($branchmanager) }})</a></li>
                    @endif

                    {{-- /. senior managers --}}
                    @if ($senior_manager || Auth::user()->hasRole('general manager') || Auth::user()->hasRole('chief executive officer'))
                        <li class="nav-item"><a class="nav-link" href="#seniormanagers" data-toggle="tab"><i
                                    class="fa fa-list"></i>
                                Senior Managers
                                ({{ count($creditsmanager) + count($auditmanager) + count($legalmanager) + count($financemanager) + count($ictmanager) + count($marketingmanager) + count($humanresourcemanager) }})</a>
                        </li>
                    @endif

                    {{-- /. general manager --}}
                    @if (Auth::user()->hasRole('general manager') || Auth::user()->hasRole('chief executive officer'))
                        <li class="nav-item"><a class="nav-link" href="#generalmanager" data-toggle="tab"><i
                                    class="fa fa-list"></i>
                                General Manager ({{ count($generalmanager) }})</a></li>
                    @endif

                    {{-- /. chief executive officer --}}
                    @if (Auth::user()->hasRole('chief executive officer'))
                        <li class="nav-item"><a class="nav-link" href="#ceo" data-toggle="tab"><i class="fa fa-list"></i>
                                Chief Executive Officer ({{ count($ceo) }})</a></li>
                    @endif
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <!--/. Add new ticket-->
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
                                        @if (Auth::user()->hasRole('credit officer|branch manager'))
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

                    <!--/. Credit officer-->
                    @if (Auth::user()->hasRole('credit officer|branch manager'))
                        <div class="tab-pane" id="creditofficer">
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
                                                <th>BUSINESS</th>
                                                <th>DATE</th>
                                                <th>BRANCH</th>
                                                <th>OFFICER</th>
                                                <th>CREATED AT</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($creditofficer as $ticket)
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
                                                                <a href="{{ route('crm.tickets.details', $ticket->ticket_id) }}"
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
                        </div>
                    @endif
                    <!-- /.tab-pane -->

                    <!--/. Branch Manager-->
                    @if (Auth::user()->hasRole('branch manager') || Auth::user()->hasRole('operations manager'))
                        <div class="tab-pane" id="branchmanager">
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fa fa-list"></i> Branch Manager </h3>
                                </div>
                                <div class="card-body">
                                    <table id="table2"
                                        class="table table-sm table-bordered table-striped table-head-fixed">
                                        <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>TICKET ID</th>
                                                <th>NAMES</th>
                                                <th>MOBILE</th>
                                                <th>RESIDENCE</th>
                                                <th>BUSINESS</th>
                                                <th>DATE</th>
                                                <th>BRANCH</th>
                                                <th>OFFICER</th>
                                                <th>CREATED AT</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($branchmanager as $ticket)
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
                                                                <a href="{{ route('crm.tickets.details', $ticket->ticket_id) }}"
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
                        </div>
                    @endif
                    <!-- /.tab-pane -->

                    <!--/. Senior Manager -->
                    @if ($senior_manager || Auth::user()->hasRole('general manager') || Auth::user()->hasRole('chief executive officer'))
                        @php
                            $manager_tickets = [];
                            $ticket_title = 'Senior Manager Tickets';
                        @endphp
                        @if (Auth::user()->hasRole('finance manager'))
                            @php
                                $manager_tickets = $financemanager;
                                $ticket_title = 'Finance Manager Tickets';
                            @endphp
                        @endif

                        @if (Auth::user()->hasRole('ict manager'))
                            @php
                                $manager_tickets = $ictmanager;
                                $ticket_title = 'ICT Manager Tickets';
                            @endphp
                        @endif

                        @if (Auth::user()->hasRole('audit manager'))
                            @php
                                $manager_tickets = $auditmanager;
                                $ticket_title = 'AudiT Manager Tickets';
                            @endphp
                        @endif

                        @if (Auth::user()->hasRole('legal manager'))
                            @php
                                $manager_tickets = $legalmanager;
                                $ticket_title = 'Legal Manager Tickets';
                            @endphp
                        @endif

                        @if (Auth::user()->hasRole('credits manager'))
                            @php
                                $manager_tickets = $creditsmanager;
                                $ticket_title = 'Credits Manager Tickets';
                            @endphp
                        @endif

                        @if (Auth::user()->hasRole('marketing manager'))
                            @php
                                $manager_tickets = $marketingmanager;
                                $ticket_title = 'Marketing Manager Tickets';
                            @endphp
                        @endif

                        @if (Auth::user()->hasRole('operations manager'))
                            @php
                                $manager_tickets = $operationsmanager;
                                $ticket_title = 'Operations Manager Tickets';
                            @endphp
                        @endif

                        @if (Auth::user()->hasRole('human resource manager'))
                            @php
                                $manager_tickets = $humanresourcemanager;
                                $ticket_title = 'Human Resource Manager Tickets';
                            @endphp
                        @endif

                        <div class="tab-pane" id="seniormanagers">
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fa fa-list"></i> {{ $ticket_title }} </h3>
                                </div>
                                <div class="card-body">
                                    <table id="table3"
                                        class="table table-sm table-bordered table-striped table-head-fixed">
                                        <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>TICKET ID</th>
                                                <th>NAMES</th>
                                                <th>MOBILE</th>
                                                <th>RESIDENCE</th>
                                                <th>BUSINESS</th>
                                                <th>DATE</th>
                                                <th>BRANCH</th>
                                                <th>OFFICER</th>
                                                <th>CREATED AT</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($manager_tickets as $ticket)
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
                                                                <a href="{{ route('crm.tickets.details', $ticket->ticket_id) }}"
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
                        </div>
                    @endif
                    <!-- /.tab-pane -->

                    <!--/. General Manager-->
                    @if (Auth::user()->hasRole('general manager') || Auth::user()->hasRole('chief executive officer'))
                        <div class="tab-pane" id="generalmanager">
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fa fa-list"></i> General Manager </h3>
                                </div>
                                <div class="card-body">
                                    <table id="table"
                                        class="table table-sm table-bordered table-striped table-head-fixed">
                                        <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>TICKET ID</th>
                                                <th>NAMES</th>
                                                <th>MOBILE</th>
                                                <th>RESIDENCE</th>
                                                <th>BUSINESS</th>
                                                <th>DATE</th>
                                                <th>BRANCH</th>
                                                <th>OFFICER</th>
                                                <th>CREATED AT</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($generalmanager as $ticket)
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
                                                                <a href="{{ route('crm.tickets.details', $ticket->ticket_id) }}"
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
                        </div>
                    @endif
                    <!-- /.tab-pane -->

                    <!--/. CEO-->
                    @if (Auth::user()->hasRole('chief executive officer'))
                        <div class="tab-pane" id="ceo">
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fa fa-list"></i> Chief Executive Officer </h3>
                                </div>
                                <div class="card-body">
                                    <table id="table"
                                        class="table table-sm table-bordered table-striped table-head-fixed">
                                        <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>TICKET ID</th>
                                                <th>NAMES</th>
                                                <th>MOBILE</th>
                                                <th>RESIDENCE</th>
                                                <th>BUSINESS</th>
                                                <th>DATE</th>
                                                <th>BRANCH</th>
                                                <th>OFFICER</th>
                                                <th>CREATED AT</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ceo as $ticket)
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
                                                                <a href="{{ route('crm.tickets.details', $ticket->ticket_id) }}"
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
                        </div>
                    @endif
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
