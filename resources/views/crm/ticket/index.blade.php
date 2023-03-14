@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-users"></i> {{ $title }}</h3>
                    <div class="text-right">
                        <a href="{{ route('crm.tickets.create') }}">
                            <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add New
                                Customer Ticket</button>
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
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
                                <th>TICKET CONTENT</th>
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
                                    {{-- <td>{{ $ticket->business }}</td> --}}
                                    <td>{{ $ticket->message }}</td>
                                    <td>{{ $ticket->date_raised }}</td>
                                    <td>{{ $ticket->outpost_name }}</td>
                                    <td>{{ $ticket->officer_name }}</td>
                                    <td>Finance manager</td>
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
                                                <form action="{{ route('crm.tickets.destroy', $ticket->ticket_id) }}"
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
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
