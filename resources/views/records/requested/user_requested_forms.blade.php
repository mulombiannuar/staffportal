@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card card-warning card-outline">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#new-requests" data-toggle="tab"><i
                                class="fa fa-list"></i>
                            Pending Requests ({{ count($pendingRequests) }})</a></li>
                    <li class="nav-item"><a class="nav-link" href="#completed" data-toggle="tab"><i
                                class="fa fa-list-alt"></i> Completed Requests ({{ count($completedRequests) }})</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="new-requests">
                        <!-- User requests -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-list"></i> New User Requests</h3>
                                <div class="text-right">
                                    <a href="{{ route('user.loan-forms.request') }}">
                                        <button type="button" class="btn btn-secondary"><i class="fa fa-plus-circle"></i>
                                            Request
                                            New Loan Form</button>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table width="100%" id="table1"
                                    class="table table-sm table-bordered table-striped table-head-fixed table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>REFERENCE</th>
                                            <th>NAMES</th>
                                            <th>BR ID</th>
                                            <th>MOBILE</th>
                                            <th>NATIONAL ID</th>
                                            <th>OUTPOST</th>
                                            <th>DATE REQUESTED</th>
                                            <th>REQUESTED BY</th>
                                            <th>PRODUCT CODE</th>
                                            <th>AMOUNT</th>
                                            <th>DISBURSMENT DATE</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pendingRequests as $loan)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $loan->reference }}</td>
                                                <td>{{ $loan->client_name }}</td>
                                                <td>{{ $loan->bimas_br_id }}</td>
                                                <td>{{ $loan->client_phone }}</td>
                                                <td>{{ $loan->national_id }}</td>
                                                <td>{{ $loan->outpost_name }}</td>
                                                <td>{{ $loan->date_requested }}</td>
                                                <td>{{ $loan->name }}</td>
                                                <td>{{ $loan->product_code }}</td>
                                                <td>{{ $loan->amount }}</td>
                                                <td>{{ $loan->disbursment_date }}</td>
                                                <td>
                                                    <div class="margin">
                                                        <div class="btn-group">
                                                            <a href="{{ route('user.loan-forms.requested', $loan->request_id) }}"
                                                                title="Click to view details">
                                                                <button type="button" class="btn btn-xs btn-info"><i
                                                                        class="fa fa-eye"></i>
                                                                    View Details</button>
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
                        <!-- /.User requests -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="completed">
                        <!-- roles user -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-list-alt"></i> Completed Requests</h3>
                            </div>
                            <div class="card-body">
                                <table width="100%" id="table2"
                                    class="table table-sm table-bordered table-striped table-head-fixed table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>REFERENCE</th>
                                            <th>NAMES</th>
                                            <th>BR ID</th>
                                            <th>MOBILE</th>
                                            <th>NATIONAL ID</th>
                                            <th>OUTPOST</th>
                                            <th>DATE REQUESTED</th>
                                            <th>DATE APPROVED</th>
                                            <th>PRODUCT CODE</th>
                                            <th>AMOUNT</th>
                                            <th>DISBURSMENT DATE</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($completedRequests as $loan)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $loan->reference }}</td>
                                                <td>{{ $loan->client_name }}</td>
                                                <td>{{ $loan->bimas_br_id }}</td>
                                                <td>{{ $loan->client_phone }}</td>
                                                <td>{{ $loan->national_id }}</td>
                                                <td>{{ $loan->outpost_name }}</td>
                                                <td>{{ $loan->date_requested }}</td>
                                                <td>{{ $loan->date_approved }}</td>
                                                <td>{{ $loan->product_code }}</td>
                                                <td>{{ $loan->amount }}</td>
                                                <td>{{ $loan->disbursment_date }}</td>
                                                <td>
                                                    <div class="margin">
                                                        <div class="btn-group">
                                                            <a href="{{ route('user.loan-forms.requested', $loan->request_id) }}"
                                                                title="Click to view request details">
                                                                <button type="button" class="btn btn-xs btn-secondary"><i
                                                                        class="fa fa-bars"></i>
                                                                </button>
                                                            </a>
                                                        </div>

                                                        @if ($loan->is_locked)
                                                            <div class="btn-group">
                                                                <button class="btn btn-xs btn-danger">
                                                                    <i class="fa fa-lock"></i>
                                                                </button>
                                                            </div>
                                                        @else
                                                            <div class="btn-group">
                                                                <a class="btn btn-xs btn-primary" target="_new"
                                                                    href="{{ route('user.loan-forms.attachment', $loan->request_id) }}"
                                                                    title="Click to view requested loan form">
                                                                    <i class="fa fa-external-link-alt"></i>
                                                                </a>
                                                            </div>
                                                        @endif
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
    </section>
    <!-- /.content -->
@endsection
