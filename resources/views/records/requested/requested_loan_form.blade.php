@extends('layouts.admin.form')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card card-warning card-outline">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#details" data-toggle="tab"><i
                                class="fa fa-list-alt"></i>
                            Loan Form Details</a></li>

                    <li class="nav-item"><a class="nav-link" href="#approval" data-toggle="tab"><i
                                class="fa fa-user-edit"></i>
                            Approval Status</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="details">
                        <!--  Loan Form Details -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-list-alt"></i> Loan Form Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="client_name">Client Name</label>
                                                <input type="text" name="client_name" class="form-control"
                                                    value="{{ $loanRequest->client_name }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="client_phone">Mobile No.</label>
                                                <input type="number" name="client_phone" class="form-control"
                                                    value="{{ $loanRequest->client_phone }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="bimas_br_id">Bimas BR ID</label>
                                                <input type="number" name="bimas_br_id" class="form-control"
                                                    value="{{ $loanRequest->bimas_br_id }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="branch">Branch</label>
                                                <input type="text" name="branch" class="form-control"
                                                    value="{{ $loanRequest->branch_name }}" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="outposts">Outpost</label>
                                                <input type="text" name="outpost_name" class="form-control"
                                                    value="{{ $loanRequest->outpost_name }}" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="users">Officers</label>
                                                <input type="text" name="name" class="form-control"
                                                    value="{{ $loanRequest->name }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="product_name">Loan Product</label>
                                                <input type="text" name="product_name" class="form-control"
                                                    value="{{ $loanRequest->product_name }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="amount">Loan Amount</label>
                                                <input type="number" name="amount" class="form-control" i
                                                    value="{{ $loanRequest->amount }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="national_id">National ID</label>
                                                <input type="number" name="national_id" class="form-control"
                                                    value="{{ $loanRequest->national_id }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="disbursment_date">Disbursment Date</label>
                                                <input type="date" name="disbursment_date" class="form-control"
                                                    value="{{ date_format(date_create($loanRequest->disbursment_date), 'Y-m-d') }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="form_type">Form Type</label>
                                                <input type="text" name="form_type" class="form-control"
                                                    value="{{ $loanRequest->is_original ? 'Original Copy' : 'Electronic Copy' }}"
                                                    required>
                                            </div>
                                        </div>
                                        @if ($loanRequest->is_original)
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="return_date">Expected Return Date</label>
                                                    <input type="date" name="return_date" class="form-control"
                                                        id="return_date" placeholder="Return date" autocomplete="off"
                                                        value="{{ $loanRequest->return_date }}" required>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label for="officer_message">Officer message</label>
                                                <textarea class="form-control" name="officer_message" cols="4" rows="2" required>{{ $loanRequest->officer_message }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /. Loan Form Details -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="approval">
                        <!--  Loan Form Details -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-user-edit"></i> Request Approval Status</h3>
                            </div>
                            <div class="card-body">
                                <div class="card-body">
                                    @if ($approvalDetails)
                                        @if ($approvalDetails->approval_status == 1)
                                            <table class="table table-sm table-bordered table-striped">
                                                <tr>
                                                    <th>DATE REQUESTED</th>
                                                    <td>{{ $approvalDetails->date_requested }}</td>
                                                </tr>
                                                <tr>
                                                    <th>FORM TYPE</th>
                                                    <td>{{ $approvalDetails->is_original == 1 ? 'Original Copy' : 'Electronic Copy' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>OFFICER MESSAGE</th>
                                                    <td>{{ $approvalDetails->officer_message }}</td>
                                                </tr>
                                                <tr>
                                                    <th>DATE APPROVED</th>
                                                    <td>{{ $approvalDetails->date_approved }}</td>
                                                </tr>
                                                <tr>
                                                    <th>APPROVED BY</th>
                                                    <td>{{ $approvalDetails->name . ' - ' . $approvalDetails->email }}</td>
                                                </tr>
                                                <tr>
                                                    <th>RECORDS COMMENT</th>
                                                    <td>{{ $approvalDetails->approval_message }}</td>
                                                </tr>
                                                <tr>
                                                    <th>VIEWABLE DEADLINE</th>
                                                    <td>{{ $approvalDetails->viewable_deadline }}</td>
                                                </tr>
                                                <tr>
                                                    <th>IS FILE LOCKED?</th>
                                                    <td>{{ $approvalDetails->is_locked ? 'Loan Form locked' : 'Loan form viewable' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>REQUESTED FORM</th>
                                                    <td>
                                                        @if ($approvalDetails->is_locked)
                                                            <div class="btn-group">
                                                                <button class="btn btn-sm btn-danger">
                                                                    <i class="fa fa-lock"></i> File Locked
                                                                </button>
                                                            </div>
                                                        @else
                                                            <a target="_new"
                                                                href="{{ route('user.loan-forms.attachment', $approvalDetails->request_id) }}">
                                                                <button type="button" class="btn btn-sm btn-secondary"><i
                                                                        class="fas fa-external-link-alt"></i>
                                                                    View Loan Form</button>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        @else
                                            <table class="table table-sm table-bordered table-striped">
                                                <tr>
                                                    <th>DATE REQUESTED</th>
                                                    <td>{{ $approvalDetails->date_requested }}</td>
                                                </tr>
                                                <tr>
                                                    <th>OFFICER MESSAGE</th>
                                                    <td>{{ $approvalDetails->officer_message }}</td>
                                                </tr>
                                                <tr>
                                                    <th>DATE REJECTED</th>
                                                    <td>{{ $approvalDetails->date_approved }}</td>
                                                </tr>
                                                <tr>
                                                    <th>REJECTED BY</th>
                                                    <td>{{ $approvalDetails->name . ' - ' . $approvalDetails->email }}</td>
                                                </tr>
                                                <tr>
                                                    <th>REGISTRY COMMENT</th>
                                                    <td>{{ $approvalDetails->approval_message }}</td>
                                                </tr>
                                            </table>
                                        @endif
                                    @else
                                        <p class="text text-danger">Your loan form is pending approval at Records office
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /. Loan Form Details -->
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
