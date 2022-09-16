@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> Loan Application Requests
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if (empty($loans))
                        <div class="alert alert-danger">
                            No loans data were found. Please refresh this page
                        </div>
                    @else
                        <table id="table1" class="table table-bordered table-sm table-hover table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>NAMES</th>
                                    <th>MOBILE</th>
                                    <th>ID NUMBER</th>
                                    <th>LOCATION</th>
                                    <th>PRODUCT</th>
                                    <th>AMOUNT</th>
                                    <th>BRANCH</th>
                                    <th>DATE APPLIED</th>
                                    <th>APPROVED BY</th>
                                    <th>LOAN PURPOSE</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loans as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td><strong>{{ $user->mobile_no }}</strong></td>
                                        <td>{{ $user->id_number }}</td>
                                        <td>{{ $user->location }}</td>
                                        <td>{{ $user->product_name }}</td>
                                        <td><strong>KES. {{ $user->amount }}</strong></td>
                                        <td>{{ $user->outpost_name }}</td>
                                        <td>{{ $user->application_date }}</td>
                                        <td>{{ $user->officer_name }}</td>
                                        <td>{{ $user->loan_purpose }}</td>
                                        <td>
                                            <div class="margin">
                                                <div class="btn-group">
                                                    <a href="{{ route('customers.show-loan', $user->loan_id) }}"
                                                        title="Click to view loan details">
                                                        <button type="button" class="btn btn-xs btn-warning"><i
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
                    @endif
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
