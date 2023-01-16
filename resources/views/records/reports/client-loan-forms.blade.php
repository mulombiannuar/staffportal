@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-list-alt"></i> Clients Loan Forms</h3>
            </div>
            <div class="card-body">
                <table width="100%" id="table1"
                    class="table table-sm table-bordered table-striped table-head-fixed table-responsive">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>FILING TYPE</th>
                            <th>NAMES</th>
                            <th>BR ID</th>
                            <th>MOBILE</th>
                            <th>NATIONAL ID</th>
                            <th>BRANCH</th>
                            <th>OUTPOST</th>
                            <th>PRODUCT</th>
                            <th>CODE</th>
                            <th>AMOUNT</th>
                            <th>CHEQUE NO</th>
                            <th>DATE DISBURSED</th>
                            <th>FILE NUMBER</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $loan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $loan->type_name }}</td>
                                <td>{{ $loan->client_name }}</td>
                                <td>{{ $loan->bimas_br_id }}</td>
                                <td>{{ $loan->client_phone }}</td>
                                <td>{{ $loan->national_id }}</td>
                                <td>{{ $loan->branch_name }}</td>
                                <td>{{ $loan->outpost_name }}</td>
                                <td>{{ $loan->product_name }}</td>
                                <td>{{ $loan->product_code }}</td>
                                <td>{{ $loan->amount }}</td>
                                <td>{{ $loan->cheque_no }}</td>
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
