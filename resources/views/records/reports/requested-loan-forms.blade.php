@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-list-alt"></i> Requested Loan Forms</h3>
            </div>
            <div class="card-body">
                <table width="100%" id="table1"
                    class="table table-sm table-bordered table-striped table-head-fixed table-responsive">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>REFERENCE</th>
                            <th>FILING TYPE</th>
                            <th>NAMES</th>
                            <th>BR ID</th>
                            <th>MOBILE</th>
                            <th>NATIONAL ID</th>
                            <th>OUTPOST</th>
                            <th>DATE REQUESTED</th>
                            <th>REQUESTED BY</th>
                            <th>FORM TYPE</th>
                            <th>DATE APPROVED</th>
                            <th>STATUS</th>
                            <th>PRODUCT NAME</th>
                            <th>PRODUCT CODE</th>
                            <th>AMOUNT</th>
                            <th>DISBURSMENT DATE</th>
                            <th>FILING LABEL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $loan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $loan->reference }}</td>
                                <td>{{ $loan->type_name }}</td>
                                <td>{{ $loan->client_name }}</td>
                                <td>{{ $loan->bimas_br_id }}</td>
                                <td>{{ $loan->client_phone }}</td>
                                <td>{{ $loan->national_id }}</td>
                                <td>{{ $loan->outpost_name }}</td>
                                <td>{{ $loan->date_requested }}</td>
                                <td>{{ $loan->name }}</td>
                                <td><strong>{{ $loan->is_original ? 'Original copy' : 'Electronic copy' }}</strong>
                                </td>
                                <td>{{ $loan->date_approved }}</td>
                                <td><strong>{{ $loan->is_approved ? 'Approved' : 'Rejected' }}</strong>
                                </td>
                                <td>{{ $loan->product_name }}</td>
                                <td>{{ $loan->product_code }}</td>
                                <td>{{ $loan->amount }}</td>
                                <td>{{ $loan->disbursment_date }}</td>
                                <td>{{ $loan->file_label . $loan->filing_number }}</td>
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
