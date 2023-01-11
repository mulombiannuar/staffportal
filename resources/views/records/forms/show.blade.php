@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card card-warning card-outline">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#loan-form" data-toggle="tab"><i
                                class="fa fa-list-alt"></i>
                            Loan Form Attachment</a></li>
                    <li class="nav-item"><a class="nav-link" href="#details" data-toggle="tab"><i class="fa fa-edit"></i>
                            Loan Form Details</a></li>
                    <li class="nav-item"><a class="nav-link" href="#requests" data-toggle="tab"><i class="fa fa-users"></i>
                            Officers Requests (34)</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="loan-form">
                        <!-- Profile -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-list-alt"></i> Loan Form Attachment</h3>
                            </div>
                            <div class="card-body">
                                <object data="{{ asset('storage/assets/loans/' . $loan_form->file_name) }}"
                                    type="application/pdf" width="100%" height="600px">
                                </object>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.Profile -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="details">
                        <!-- documents -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-edit"></i> Loan Form Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="branch_id">Branch</label>
                                            <input type="text" class="form-control"
                                                value="{{ $loan_form->branch_name }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="outposts">Outpost</label>
                                            <input type="text" class="form-control"
                                                value="{{ $loan_form->outpost_name }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="client_id">Client</label>
                                            <input type="text" class="form-control"
                                                value="{{ $loan_form->client_name }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="product">Loan Product</label>
                                            <input type="text" class="form-control"
                                                value="{{ $loan_form->product_name }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="amount">Loan Amount</label>
                                            <input type="number" name="amount" class="form-control" id="amount"
                                                placeholder="Loan Amount" value="{{ $loan_form->amount }}"
                                                autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="filing_type">Filing Type</label>
                                            <input type="text" class="form-control" value="{{ $loan_form->type_name }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="file_label">File Labels</label>
                                            <input type="text" class="form-control"
                                                value="{{ $loan_form->file_label . $loan_form->file_number }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="client_name">Disbursment Date</label>
                                            <input type="date" name="disbursment_date" class="form-control"
                                                id="name" placeholder="Disbursment date" autocomplete="off"
                                                value="{{ $loan_form->disbursment_date }}" required>
                                        </div>
                                    </div>

                                    @if ($loan_form->type_id == 5)
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="client_name">Payee</label>
                                                <input type="text" name="payee" class="form-control" id="payee"
                                                    placeholder="Enter payee" autocomplete="on"
                                                    value="{{ $loan_form->payee }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="client_name">Cheque No.</label>
                                                <input type="text" name="cheque_no" class="form-control"
                                                    id="cheque_no" placeholder="Enter payee" autocomplete="off"
                                                    value="{{ $loan_form->cheque_no }}" required>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- documents -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="requests">
                        <!-- Profile -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-users"></i> Officers Requests</h3>
                            </div>
                            <div class="card-body">
                                <table id="table1" class="table table-sm table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>REFERENCE</th>
                                            <th>REQUESTED BY</th>
                                            <th>BRANCH</th>
                                            <th>OUTPOST</th>
                                            <th>DATE REQUESTED</th>
                                            <th>MESSAGE</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <!-- /.card-body -->
                        </div>
                        <!-- /.Profile -->
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- /.nav-tabs-custom -->
    </section>
    <!-- /.content -->
@endsection
