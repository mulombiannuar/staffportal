@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> {{ $title }}
                        ({{ $policies->count() }})
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="right">
                        <button type="button" data-toggle="modal" data-target="#modalGenerateReport"
                            class="btn btn-success"><i class="fa fa-calendar"></i> Filter
                            Insurance
                            Policies</button>

                        <a href="{{ route('admin.insurances.create') }}">
                            <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add New
                                Insurance
                                Policy</button>
                        </a>
                    </div>
                    <br>
                    <table id="table1" class="table table-sm table-striped table-bordered table-head-fixed">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>P/NO</th>
                                <th>REFERENCE</th>
                                <th>STATUS</th>
                                <th>CLIENT NAME</th>
                                <th>MOBILE NO.</th>
                                <th>PRODUCT</th>
                                <th>OUTPOST</th>
                                <th>OFFICER</th>
                                <th>DATE ISSUED</th>
                                <th>EXPIRY DATE</th>
                                <th>SUM ISSUED</th>
                                <th>PREMIUM</th>
                                <th>CHEQUE NO.</th>
                                <th>ACTION</th>
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
                                    <td>{{ $policy->client_phone }}</td>
                                    <td>{{ $policy->product_name }}</td>
                                    <td>{{ $policy->outpost_name }}</td>
                                    <td>{{ $policy->name }}</td>
                                    <td>{{ $policy->date_issued }}</td>
                                    <td>{{ $policy->date_expired }}</td>
                                    <td>Ksh {{ number_format($policy->sum_issued, 2) }}</td>
                                    <td>Ksh {{ number_format($policy->premium, 2) }}</td>
                                    <td>{{ $policy->cheque_no }}</td>
                                    <td>
                                        <div class="margin">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.insurances.edit', $policy->policy_id) }}">
                                                    <button type="button" class="btn btn-xs btn-default"><i
                                                            class="fa fa-edit"></i>
                                                        Edit</button>
                                                </a>
                                            </div>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.insurances.show', $policy->policy_id) }}">
                                                    <button type="button" class="btn btn-xs btn-info"><i
                                                            class="fa fa-eye"></i>
                                                        View</button>
                                                </a>
                                            </div>
                                            <div class="btn-group">
                                                <a
                                                    href="{{ route('admin.insurances.renew-policy', $policy->policy_id) }}">
                                                    <button type="button" class="btn btn-xs btn-primary"><i
                                                            class="fa fa-bars"></i>
                                                        Renew</button>
                                                </a>
                                            </div>
                                            <div class="btn-group">
                                                <form
                                                    action="{{ route('admin.insurances.destroy', $policy->policy_id) }}"
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
                    <!--/.modal begin -->
                    <div class="modal fade" id="modalGenerateReport" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Generate Insurance Report</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <form action="{{ route('admin.insurances.report') }}" method="GET">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="date_issued">Date Issued</label>
                                                    <input type="date" name="date_issued" class="form-control"
                                                        id="date_issued" value="{{ date('Y-m-d') }}"
                                                        placeholder="Select date issued" autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="date_expired">Expiry Date</label>
                                                    <input type="date" name="date_expired" class="form-control"
                                                        id="date_expired" value="{{ date('Y-m-d') }}"
                                                        placeholder="Select date expiring" autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="report_type">Report Type</label>
                                                    <select name="report_type" class="form-control select2" id="report_type"
                                                        required>
                                                        <option class="mb-1" value="">
                                                            - Select Report Type -</option>
                                                        <option value="all">All Insurance Policies</option>
                                                        <option value="1">Active Insurance Policies</option>
                                                        <option value="0">Expired Insurance Policies</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-info"><i class="fa fa-print"></i> Generate
                                            Report Now</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!--/modal end -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
