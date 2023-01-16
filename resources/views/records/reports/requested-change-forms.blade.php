@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
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
                            <th>BRANCH</th>
                            <th>OUTPOST</th>
                            <th>DATE CHANGED</th>
                            <th>DATE REQUESTED</th>
                            <th>DATE APPROVED</th>
                            <th>REQUESTED BY</th>
                            <th>FORM TYPE</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $form)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $form->reference }}</td>
                                <td>{{ $form->client_name }}</td>
                                <td><strong>{{ $form->bimas_br_id }}</strong></td>
                                <td>{{ $form->client_phone }}</td>
                                <td>{{ $form->national_id }}</td>
                                <td>{{ $form->branch_name }}</td>
                                <td>{{ $form->outpost_name }}</td>
                                <td>{{ $form->date_changed }}</td>
                                <td>{{ $form->date_requested }}</td>
                                <td>{{ $form->date_approved }}</td>
                                <td>{{ $form->name }}</td>
                                <td>{{ $form->form_type }}</td>
                                <td><strong>{{ $form->is_approved == 1 ? 'Approved' : 'Rejected' }}</strong>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </section>
    <!-- /.content -->
@endsection
