@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> {{ $title }} ({{ count($tickets) }})</h3>
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
                                <th>BUSINESS</th>
                                <th>DATE</th>
                                <th>BRANCH</th>
                                <th>OFFICER</th>
                                <th>CURRENT LEVEL</th>
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
                                    <td>{{ $ticket->business }}</td>
                                    {{-- <td>{{ $ticket->message }}</td> --}}
                                    <td>{{ $ticket->date_raised }}</td>
                                    <td>{{ $ticket->outpost_name }}</td>
                                    <td>{{ $ticket->officer_name }}</td>
                                    <td><strong>{{ $ticket->current_level }}</strong></td>
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
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
