@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card card-warning card-outline">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#all" data-toggle="tab"><i class="fa fa-users"></i>
                            All Customer Tickets({{ count($tickets) }})</a></li>
                    @foreach ($workflows as $workflow)
                        <li class="nav-item"><a class="nav-link" href="#workflow-{{ $workflow->workflow_id }}"
                                data-toggle="tab"><i class="fa fa-list"></i>
                                {{ $workflow->name }}({{ $workflow->count }}) </a></li>
                    @endforeach
                    <li class="nav-item"><a class="nav-link" href="#closed" data-toggle="tab"><i
                                class="fa fa-briefcase"></i>
                            Closed Tickets</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="all">
                        <!-- All -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-users"></i> All Customer Tickets</h3>
                                <div class="text-right">
                                    <a href="{{ route('crm.tickets.create') }}">
                                        <button type="button" class="btn btn-secondary"><i class="fa fa-plus"></i> Add New
                                            Customer Ticket</button>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="table1" class="table table-sm table-bordered table-striped table-head-fixed">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>TICKET ID</th>
                                            <th>NAMES</th>
                                            <th>MOBILE</th>
                                            <th>RESIDENCE</th>
                                            {{-- <th>BUSINESS</th> --}}
                                            {{-- <th>TICKET CONTENT</th> --}}
                                            <th>DATE</th>
                                            <th>BRANCH</th>
                                            <th>OFFICER</th>
                                            <th>CURRENT LEVEL</th>
                                            <th>CREATED AT</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tickets as $ticket)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $ticket->ticket_uuid }}</td>
                                                <td>{{ strtoupper($ticket->customer_name) }}</td>
                                                <td>{{ $ticket->customer_phone }}</td>
                                                <td>{{ $ticket->residence }}</td>
                                                {{-- <td>{{ $ticket->business }}</td> --}}
                                                {{-- <td>{{ $ticket->message }}</td> --}}
                                                <td>{{ $ticket->date_raised }}</td>
                                                <td>{{ $ticket->outpost_name }}</td>
                                                <td>{{ $ticket->officer_name }}</td>
                                                <td><strong>{{ $ticket->current_level }}</strong></td>
                                                <td>{{ $ticket->created_at }}</td>
                                                <td>
                                                    <div class="margin">
                                                        <div class="btn-group">
                                                            <a href="{{ route('crm.tickets.edit', $ticket->ticket_id) }}">
                                                                <button type="button" class="btn btn-xs btn-default"><i
                                                                        class="fa fa-edit"></i>
                                                                    Edit</button>
                                                            </a>
                                                        </div>
                                                        <div class="btn-group">
                                                            <a href="{{ route('crm.tickets.show', $ticket->ticket_id) }}"
                                                                title="Click to view ticket details">
                                                                <button type="button" class="btn btn-xs btn-info"><i
                                                                        class="fa fa-eye"></i>
                                                                    View</button>
                                                            </a>
                                                        </div>
                                                        <div class="btn-group">
                                                            <form
                                                                action="{{ route('crm.tickets.destroy', $ticket->ticket_id) }}"
                                                                method="post"
                                                                onclick="return confirm('Do you really want to delete this ticket?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-xs btn-danger"><i
                                                                        class="fa fa-trash"></i>
                                                                    Delete</button>
                                                            </form>
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
                        <!-- /.All -->
                    </div>
                    <!-- /.tab-pane -->
                    @foreach ($workflows as $workflow)
                        <div class="tab-pane" id="workflow-{{ $workflow->workflow_id }}">
                            <!-- documents -->
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fa fa-list"></i> {{ $workflow->name }}</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-bordered table-striped table-head-fixed">
                                        <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>TICKET ID</th>
                                                <th>NAMES</th>
                                                <th>MOBILE</th>
                                                <th>RESIDENCE</th>
                                                {{-- <th>BUSINESS</th> --}}
                                                {{-- <th>TICKET CONTENT</th> --}}
                                                <th>DATE</th>
                                                <th>BRANCH</th>
                                                <th>OFFICER</th>
                                                <th>CURRENT LEVEL</th>
                                                <th>CREATED AT</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($workflow->tickets as $ticket)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $ticket->ticket_uuid }}</td>
                                                    <td>{{ strtoupper($ticket->customer_name) }}</td>
                                                    <td>{{ $ticket->customer_phone }}</td>
                                                    <td>{{ $ticket->residence }}</td>
                                                    {{-- <td>{{ $ticket->business }}</td> --}}
                                                    {{-- <td>{{ $ticket->message }}</td> --}}
                                                    <td>{{ $ticket->date_raised }}</td>
                                                    <td>{{ $ticket->outpost_name }}</td>
                                                    <td>{{ $ticket->officer_name }}</td>
                                                    <td><strong>{{ $ticket->current_level }}</strong></td>
                                                    <td>{{ $ticket->created_at }}</td>
                                                    <td>
                                                        <div class="margin">
                                                            <div class="btn-group">
                                                                <a href="{{ route('crm.tickets.show', $ticket->ticket_id) }}"
                                                                    title="Click to view ticket details">
                                                                    <button type="button" class="btn btn-xs btn-warning"><i
                                                                            class="fa fa-bars"></i>
                                                                        View </button>
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
                            <!-- documents -->
                        </div>
                        <!-- /.tab-pane -->
                    @endforeach
                    <div class="tab-pane" id="closed">
                        <!-- roles user -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-briefcase"></i> Closed Tickets</h3>
                            </div>
                            <div class="card-body">
                                Closed Tickets
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
