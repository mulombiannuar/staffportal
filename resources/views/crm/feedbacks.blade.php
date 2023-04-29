@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card card-warning card-outline">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#pending" data-toggle="tab"><i class="fa fa-bars"></i>
                            Pending Responses ({{ count($pending_feedbacks) }})</a></li>
                    <li class="nav-item"><a class="nav-link" href="#completed" data-toggle="tab"><i
                                class="fa fa-list-alt"></i>
                            Completed Responses ({{ count($completed_feedbacks) }})</a></li>

                    {{-- <li class="nav-item"><a class="nav-link" href="#syncdata" data-toggle="tab"><i
                                class="fa fa-user-plus"></i>
                            Sync Survey Data </a></li> --}}
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="pending">
                        <!-- pending -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-bars"></i> Pending Clients Responses</h3>
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
                                            <th>DATE RAISED</th>
                                            <th>BRANCH</th>
                                            <th>OFFICER</th>
                                            <th>DATE SENT</th>
                                            <th>SENT BY</th>
                                            <th>LINK</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pending_feedbacks as $ticket)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $ticket->ticket_uuid }}</td>
                                                <td>{{ strtoupper($ticket->customer_name) }}</td>
                                                <td>{{ $ticket->customer_phone }}</td>
                                                <td>{{ $ticket->residence }}</td>
                                                <td>{{ $ticket->date_raised }}</td>
                                                <td>{{ $ticket->outpost_name }}</td>
                                                <td>{{ $ticket->officer_name }}</td>
                                                <td>{{ $ticket->date_sent }}</td>
                                                <td>{{ $ticket->sent_by }}</td>
                                                <td>
                                                    <div class="margin">
                                                        <div class="btn-group">
                                                            <a target="_new" href="{{ $ticket->survey_link }}">
                                                                <button type="button" class="btn btn-xs btn-info"><i
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
                        <!-- /.Profile -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="completed">
                        <!-- documents -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-list-alt"></i> Completed Client Responses
                                </h3>
                            </div>
                            <div class="card-body">
                                <table id="table2" class="table table-sm table-bordered table-striped table-head-fixed">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>TICKET ID</th>
                                            <th>NAMES</th>
                                            <th>MOBILE</th>
                                            <th>RESIDENCE</th>
                                            <th>DATE RAISED</th>
                                            <th>BRANCH</th>
                                            <th>OFFICER</th>
                                            <th>DATE SENT</th>
                                            <th>DATE RESPONDED</th>
                                            <th>SENT BY</th>
                                            <th>RESPONSES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($completed_feedbacks as $ticket)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $ticket->ticket_uuid }}</td>
                                                <td>{{ strtoupper($ticket->customer_name) }}</td>
                                                <td>{{ $ticket->customer_phone }}</td>
                                                <td>{{ $ticket->residence }}</td>
                                                <td>{{ $ticket->date_raised }}</td>
                                                <td>{{ $ticket->outpost_name }}</td>
                                                <td>{{ $ticket->officer_name }}</td>
                                                <td>{{ $ticket->date_sent }}</td>
                                                <td>{{ $ticket->date_responded }}</td>
                                                <td>{{ $ticket->sent_by }}</td>
                                                <td>
                                                    <div class="margin">
                                                        <div class="btn-group">
                                                            <a href="{{ route('crm.tickets.feedbacks.show', $ticket->ticket_uuid) }}"
                                                                title="Click to view ticket details">
                                                                <button type="button" class="btn btn-xs btn-warning"><i
                                                                        class="fa fa-bars"></i>
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
                        <!-- documents -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="syncdata">
                        <!-- documents -->
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-list-alt"></i> Sync Survey Data
                                </h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('crm.tickets.sync-data') }}" method="post"
                                    onclick="return confirm('Do you really want to sync survey data?')">
                                    @csrf
                                    <button type="submit" class="btn btn-warning"> <i class="fa fa-user-plus"></i>
                                        Sync Survey Data</button>
                                </form>
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
