@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card card-warning card-outline">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#change-forms" data-toggle="tab"><i
                                class="fa fa-list"></i>
                            Client Change Forms ({{ $count }})</a></li>
                    <li class="nav-item"><a class="nav-link" href="#new-requests" data-toggle="tab"><i
                                class="fa fa-list"></i>
                            New User Requests ({{ count($pendingRequests) }})</a></li>
                    <li class="nav-item"><a class="nav-link" href="#completed" data-toggle="tab"><i
                                class="fa fa-list-alt"></i> Completed Requests ({{ count($completedRequests) }})</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="change-forms">
                        <!-- User requests -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-list"></i> New User Requests</h3>
                                <div class="text-right">
                                    <a href="{{ route('records.change-forms.create') }}">
                                        <button type="button" class="btn btn-secondary"><i class="fa fa-plus-circle"></i>
                                            Add New
                                            Change Form</button>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="datatable" width="100%"
                                    class="table table-sm table-bordered table-striped table-head-fixed">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>NAMES</th>
                                            <th>BR ID</th>
                                            <th>MOBILE</th>
                                            <th>NATIONAL ID</th>
                                            <th>BRANCH</th>
                                            <th>OUTPOST</th>
                                            <th>DATE CHANGED</th>
                                            <th>FILE NUMBER</th>
                                            <th>CREATED BY</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.User requests -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane " id="new-requests">
                        <!-- User requests -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-list"></i> New User Requests</h3>
                                <div class="text-right">
                                    <a href="{{ route('records.requested-change-forms.create') }}">
                                        <button type="button" class="btn btn-secondary"><i class="fa fa-plus-circle"></i>
                                            Add
                                            New Request</button>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="table1"
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
                                                    <a href="{{ route('records.requested-change-forms.show', $form->request_id) }}"
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
                                                            <a
                                                                href="{{ route('records.requested-change-forms.edit', $form->request_id) }}">
                                                                <button type="button" class="btn btn-xs btn-default"><i
                                                                        class="fa fa-edit"></i>
                                                                    Edit</button>
                                                            </a>
                                                        </div>
                                                        <div class="btn-group">
                                                            <a href="{{ route('records.requested-change-forms.show', $form->request_id) }}"
                                                                title="Click to view details">
                                                                <button type="button" class="btn btn-xs btn-info"><i
                                                                        class="fa fa-eye"></i>
                                                                    View</button>
                                                            </a>
                                                        </div>
                                                        <div class="btn-group">
                                                            <form
                                                                action="{{ route('records.requested-change-forms.destroy', $form->request_id) }}"
                                                                method="post"
                                                                onclick="return confirm('Do you really want to delete this record?')">
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
                                    class="table table-sm table-bordered table-striped table-head-fixed ">
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
                                            <th>FORM TYPE</th>
                                            <th>REQUESTED BY</th>
                                            <th>PRODUCT CODE</th>
                                            <th>AMOUNT</th>
                                            <th>DISBURSMENT DATE</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>

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
@push('scripts')
    <script>
        $(document).ready(function() {
            $("#datatable").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('records.get-change-forms') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'client_name',
                        name: 'client_name'
                    },
                    {
                        data: 'bimas_br_id',
                        name: 'bimas_br_id'
                    },
                    {
                        data: 'client_phone',
                        name: 'client_phone'
                    },
                    {
                        data: 'national_id',
                        name: 'national_id'
                    },
                    {
                        data: 'branch_name',
                        name: 'branch_name'
                    },
                    {
                        data: 'outpost_name',
                        name: 'outpost_name'
                    },
                    {
                        data: 'date_changed',
                        name: 'date_changed'
                    },
                    {
                        data: 'filing_number',
                        name: 'filing_number'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endpush
