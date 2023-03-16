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
                            Officers Requests ({{ count($loan_forms) }})</a></li>
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

                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="amount">Application ID</label>
                                            <input type="number" name="application_id" class="form-control"
                                                id="application_id" placeholder="Loan application_id"
                                                value="{{ $loan_form->application_id }}" autocomplete="off" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="filing_type">Filing Type</label>
                                            <input type="text" class="form-control" value="{{ $loan_form->type_name }}">
                                        </div>
                                    </div>
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
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="filing_label">Filing Label</label>
                                            <input type="text" name="filing_label" class="form-control"
                                                id="name" placeholder="filing_label" autocomplete="off"
                                                value="{{ $loan_form->file_label . $loan_form->file_number }}" required>
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
                                            <th>NAMES</th>
                                            <th>BR ID</th>
                                            <th>OUTPOST</th>
                                            <th>DATE REQUESTED</th>
                                            <th>REQUESTED BY</th>
                                            <th>PRODUCT CODE</th>
                                            <th>AMOUNT</th>
                                            <th>DISBURSMENT DATE</th>
                                            <th>VIEW</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($loan_forms as $loan)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $loan->reference }}</td>
                                                <td>{{ $loan->client_name }}</td>
                                                <td>{{ $loan->bimas_br_id }}</td>
                                                <td>{{ $loan->outpost_name }}</td>
                                                <td>{{ $loan->date_requested }}</td>
                                                <td>{{ $loan->name }}</td>
                                                <td>{{ $loan->product_code }}</td>
                                                <td>{{ $loan->amount }}</td>
                                                <td>{{ $loan->disbursment_date }}</td>
                                                <td>
                                                    <div class="margin">
                                                        <div class="btn-group">
                                                            <a href="{{ route('records.requested-forms.show', $loan->request_id) }}"
                                                                title="Click to view details">
                                                                <button type="button" class="btn btn-xs btn-info"><i
                                                                        class="fa fa-eye"></i>
                                                                    View</button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
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
