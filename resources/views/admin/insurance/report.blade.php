@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> {{ $title }}
                        ({{ $policies->count() }}) / From {{ $date['date_issued'] }} to {{ $date['date_expired'] }}
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table1" class="table table-sm table-bordered table-head-fixed">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>P/NO</th>
                                <th>REFERENCE</th>
                                <th>STATUS</th>
                                <th>CLIENT NAME</th>
                                <th>CLIENT ID</th>
                                <th>MOBILE NO.</th>
                                <th>PRODUCT</th>
                                <th>OUTPOST</th>
                                <th>OFFICER</th>
                                <th>DATE ISSUED</th>
                                <th>EXPIRY DATE</th>
                                <th>SUM ISSUED</th>
                                <th>PREMIUM</th>
                                <th>CHEQUE NO.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($policies as $policy)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ strtoupper($policy->policy_no) }}</strong></td>
                                    <td>{{ strtoupper($policy->reference) }}</td>
                                    <td><strong>{{ $policy->status == 1 ? 'Active' : 'Expired' }}</strong></td>
                                    <td>{{ $policy->client_name }}</td>
                                    <td>{{ $policy->client_id }}</td>
                                    <td>{{ $policy->client_phone }}</td>
                                    <td>{{ $policy->product_name }}</td>
                                    <td>{{ $policy->outpost_name }}</td>
                                    <td>{{ $policy->name }}</td>
                                    <td>{{ $policy->date_issued }}</td>
                                    <td>{{ $policy->date_expired }}</td>
                                    <td>Ksh {{ number_format($policy->sum_issued, 2) }}</td>
                                    <td>Ksh {{ number_format($policy->premium, 2) }}</td>
                                    <td>{{ $policy->cheque_no }}</td>
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
