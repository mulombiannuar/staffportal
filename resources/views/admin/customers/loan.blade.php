@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> Loan Application Details
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if (empty($loan))
                        <div class="alert alert-danger">
                            No loan data was found. Please refresh this page
                        </div>
                    @else
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>CUSTOMER DETAILS</th>
                                    <th>TRANSACTION DETAILS</th>
                                    <th>LOAN DETAILS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        Name : <strong>{{ strtoupper($loan->name) }}</strong> <br>
                                        Phone : <strong>{{ strtoupper($loan->mobile_no) }}</strong> <br>
                                        Branch : <strong>{{ strtoupper($loan->outpost_name) }}</strong> <br>
                                        ID Number : <strong>{{ strtoupper($loan->id_number) }}</strong>
                                    </td>
                                    <td>
                                        Transaction ID : <strong>{{ strtoupper('#' . $loan->loan_id) }}</strong> <br>
                                        Transaction Time : <strong>{{ strtoupper($loan->application_date) }}</strong>
                                        <br>
                                        Transaction Type : <strong>LOAN_APPLICATION</strong> <br>
                                        Status :
                                        <strong>{{ $loan->status == 1 ? 'Loan Approved' : 'Pending Approval' }}</strong>
                                    </td>
                                    <td>
                                        Product Name : <strong>{{ strtoupper($loan->product_name) }}</strong> <br>
                                        Business Line : <strong>{{ strtoupper($loan->activity) }}</strong> <br>
                                        Loan Purpose : <strong>{{ strtoupper($loan->loan_purpose) }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
                <!-- /.card-body -->
                <div class="card-footer justify-content-between">
                    @if (Auth::user()->hasRole('admin|communication'))
                        @if ($loan->status == 0)
                            <div class="margin" style="display: flex">
                                <form action="{{ route('customers.approve-loan', $loan->loan_id) }}" method="post"
                                    onclick="return confirm('Do you really want to approve this loan request?')">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>
                                        Approve Request
                                    </button>
                                </form>
                                &nbsp;
                            </div>
                        @endif
                    @endif

                    @if ($loan->status == 1)
                        <hr>
                        <h5>Officer Comment</h5>
                        <div class="margin">
                            <form action="{{ route('customers.comment-loan', $loan->loan_id) }}" method="post">
                                <input type="hidden" name="commented_by" value="{{ Auth::user()->name }}">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Officer Comment on the Request</label>
                                            <textarea name="officer_comment" placeholder="Enter Comment here" id="textaArea" class="form-control" cols="4"
                                                rows="3" required>{{ $loan->officer_comment }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i>
                                    Submit Comment
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
