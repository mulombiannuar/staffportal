@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="margin mb-2 text-right">
                <button type="button" data-toggle="modal" data-target="#modalGenerateReport" class="btn btn-primary"><i
                        class="fa fa-plus"></i> Generate Transactions Report</button>
            </div>
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> Transactions ({{ $expenses->count() }})</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table1" class="table table-sm table-bordered table-striped table-head-fixed">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>DATE</th>
                                <th>EXPENSE TYPE</th>
                                <th>NAMES</th>
                                <th>BRANCH</th>
                                <th>AMOUNT SPENT</th>
                                <th>APPROVAL</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expenses as $expense)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $expense->date }}</td>
                                    <td>{{ $expense->activity_name }}</td>
                                    <td>{{ $expense->name }}</td>
                                    <td>{{ strtoupper($expense->branch_name) }}</td>
                                    <td><strong>Ksh {{ number_format($expense->amountSpent, 2) }}</strong></td>
                                    <td>{{ $expense->approvalStatus }} </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('user.expenses.show', $expense->expense_id) }}"
                                                title="Click to view expense details">
                                                <button type="button" class="btn btn-xs btn-info"><i
                                                        class="fa fa-eye"></i>
                                                    View</button>
                                            </a>
                                        </div>

                                        @if ($expense->paid == 1)
                                            <button type="button" class="btn btn-xs btn-success"><i
                                                    class="fa fa-check-circle"></i>
                                                Claim Paid</button>
                                        @else
                                            <button type="button" class="btn btn-xs btn-danger"><i
                                                    class="fa fa-times-circle"></i>
                                                Not Paid</button>
                                        @endif
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
                                    <h4 class="modal-title">Generate Claim Report</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <form action="{{ route('export.claim-expense') }}" method="GET">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="start_date">Start Date</label>
                                                    <input type="date" name="start_date" class="form-control"
                                                        id="start_date" value="{{ date('Y-m-d') }}"
                                                        placeholder="Select Expense Start Date" autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="end_date">End Date</label>
                                                    <input type="date" name="end_date" class="form-control" id="end_date"
                                                        value="{{ date('Y-m-d') }}" placeholder="Select Expense End Date"
                                                        autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="report_type">Report Type</label>
                                                    <select name="report_type" class="form-control select2" id="report_type"
                                                        required>
                                                        <option class="mb-1" value="">
                                                            - Select Report Type -</option>
                                                        <option value="1">Individuals Summary Report</option>
                                                        <option value="2">Branch Summary Report</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="branch_id">Branch</label>
                                                    <select name="branch" id="branch" class="form-control select2"
                                                        id="branch_id" required>
                                                        <option class="mb-1" value="">
                                                            - Select Branch -</option>
                                                        @foreach ($branches as $branch)
                                                            <option value="{{ $branch->branch_id }}">
                                                                {{ $branch->branch_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label for="users">Users</label>
                                                    <select name="user_id" id="users" class="form-control select2"
                                                        id="user_id" required>
                                                        <option class="mb-1" value="">
                                                            - Select Branch First -</option>
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

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#branch').change(function() {
                branch = $('#branch').val();
                if (branch != '') {
                    $.ajax({
                        url: "{{ route('get.users') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "GET",
                        data: {
                            branch: branch
                        },
                        success: function(data) {
                            console.log(data);
                            $('#users').html(data);
                        },
                        error: function(xhr, desc, err) {
                            console.log(xhr);
                            //console.log("Details0: " + desc + "\nError:" + err);
                        },
                    });
                } else {
                    $('#users').html('<p value="text text-danger">No Users Found in that Branch</p>');
                }
            });
        });
    </script>
@endpush
