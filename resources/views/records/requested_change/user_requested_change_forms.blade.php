@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card card-warning card-outline">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#new-requests" data-toggle="tab"><i
                                class="fa fa-list"></i>
                            Pending Requests ({{ count($pendingRequests) }}) </a></li>
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
                                <h3 class="card-title"><i class="fa fa-list"></i> Pending Requests</h3>
                                <div class="text-right">
                                    <a href="{{ route('user.change-forms.request') }}">
                                        <button type="button" class="btn btn-secondary"><i class="fa fa-plus-circle"></i>
                                            Request New Change Form</button>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="table1" width="100%"
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
                                            <th>DATE CHANGED</th>
                                            <th>DATE REQUESTED</th>
                                            <th>REQUESTED BY</th>
                                            <th>FORM TYPE</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pendingRequests as $form)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <a href="{{ route('user.change-forms.requested', $form->request_id) }}"
                                                        title="Click to view details">
                                                        {{ $form->reference }}
                                                    </a>
                                                </td>
                                                <td>{{ $form->client_name }}</td>
                                                <td><strong>{{ $form->bimas_br_id }}</strong></td>
                                                <td>{{ $form->client_phone }}</td>
                                                <td>{{ $form->national_id }}</td>
                                                <td>{{ $form->outpost_name }}</td>
                                                <td>{{ $form->date_changed }}</td>
                                                <td>{{ $form->date_requested }}</td>
                                                <td>{{ $form->name }}</td>
                                                <td><strong>{{ $form->form_type }}</strong>
                                                </td>
                                                <td>
                                                    <div class="margin">
                                                        <div class="btn-group">
                                                            <a href="{{ route('user.change-forms.requested', $form->request_id) }}"
                                                                title="Click to view details">
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
                                            <th>DATE CHANGED</th>
                                            <th>DATE REQUESTED</th>
                                            <th>REQUESTED BY</th>
                                            <th>STATUS</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($completedRequests as $form)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <a href="{{ route('user.change-forms.attachment', $form->request_id) }}"
                                                        title="Click to view details">
                                                        {{ $form->reference }}
                                                    </a>
                                                </td>
                                                <td>{{ $form->client_name }}</td>
                                                <td><strong>{{ $form->bimas_br_id }}</strong></td>
                                                <td>{{ $form->client_phone }}</td>
                                                <td>{{ $form->national_id }}</td>
                                                <td>{{ $form->outpost_name }}</td>
                                                <td>{{ $form->date_changed }}</td>
                                                <td>{{ $form->date_requested }}</td>
                                                <td>{{ $form->name }}</td>
                                                <td><strong>{{ $form->is_approved == 1 ? 'Approved' : 'Rejected' }}</strong>
                                                </td>
                                                <td>
                                                    <div class="margin">
                                                        <div class="btn-group">
                                                            <a href="{{ route('user.change-forms.requested', $form->request_id) }}"
                                                                title="Click to view details">
                                                                <button type="button" class="btn btn-xs btn-info"><i
                                                                        class="fa fa-bars"></i>
                                                                </button>
                                                            </a>
                                                        </div>
                                                        @if ($form->is_locked)
                                                            <div class="btn-group">
                                                                <button class="btn btn-xs btn-danger">
                                                                    <i class="fa fa-lock"></i>
                                                                </button>
                                                            </div>
                                                        @else
                                                            <div class="btn-group">
                                                                <a href="{{ route('user.change-forms.attachment', $form->request_id) }}"
                                                                    title="Click to view details">
                                                                    <button type="button"
                                                                        class="btn btn-xs btn-secondary"><i
                                                                            class="fas fa-external-link-alt"></i>
                                                                    </button>
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
