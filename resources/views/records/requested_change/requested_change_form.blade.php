@extends('layouts.admin.form')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card card-warning card-outline">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#details" data-toggle="tab"><i
                                class="fa fa-list-alt"></i>
                            Change Form Details</a></li>

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
                                <h3 class="card-title"><i class="fa fa-list-alt"></i> Change Form Details</h3>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="client_name">Client Name</label>
                                            <input type="text" name="client_name" class="form-control" id="name"
                                                placeholder="Enter client name" autocomplete="off"
                                                value="{{ $form->client_name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="client_phone">Mobile No.</label>
                                            <input type="number" name="client_phone" class="form-control" id="client_phone"
                                                placeholder="Mobile Number e.g 254701111700"
                                                value="{{ $form->client_phone }}" autocomplete="off" required
                                                onKeyPress="if(this.value.length==12) return false;" minlength="12"
                                                maxlength="12">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="bimas_br_id">Bimas BR ID</label>
                                            <input type="number" name="bimas_br_id" class="form-control" id="bimas_br_id"
                                                placeholder="Enter bimas client ID e.g 0108981"
                                                value="{{ $form->bimas_br_id }}" autocomplete="on"
                                                onKeyPress="if(this.value.length==7) return false;" minlength="7"
                                                maxlength="7" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="branch_id">Branch</label>
                                            <input type="text" name="branch" class="form-control" id="branch"
                                                placeholder="Enter client branch" autocomplete="off"
                                                value="{{ $form->branch_name }}" required>

                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="outposts">Outpost</label>
                                            <input type="text" name="outpost_name" class="form-control" id="outpost_name"
                                                placeholder="Enter client outpost_name" autocomplete="off"
                                                value="{{ $form->outpost_name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="users">Officer</label>
                                            <input type="text" name="name" class="form-control" id="outpost_name"
                                                placeholder="Enter client name" autocomplete="off"
                                                value="{{ $form->name }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="national_id">National ID</label>
                                            <input type="number" name="national_id" class="form-control" id="national_id"
                                                placeholder="Enter National ID" value="{{ $form->national_id }}"
                                                autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="date_changed">Date Changed</label>
                                            <input type="date" name="date_changed" class="form-control"
                                                id="date_changed" placeholder="date changed" autocomplete="off"
                                                value="{{ $form->date_changed }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="is_original">Change Form Type</label>
                                            <input type="text" name="is_original" class="form-control"
                                                id="date_changed" autocomplete="off"
                                                value="{{ $form->is_original ? 'Original Copy' : 'Electronic Copy' }}"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    @if ($form->is_original)
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="return_date">Expected Return Date</label>
                                                <input type="date" name="return_date" class="form-control"
                                                    id="return_date" placeholder="Return date" autocomplete="off"
                                                    value="{{ $form->return_date }}" required>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label for="officer_message">Officer message</label>
                                            <textarea class="form-control" name="officer_message" id="officer_message" cols="4" rows="2"
                                                placeholder="Enter your message here" autocomplete="on" required>{{ $form->officer_message }}</textarea>
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
                                <h3 class="card-title"><i class="fa fa-user-edit"></i> Request Approval :
                                    {{ $form->reference }}</h3>
                            </div>
                            <div class="card-body">
                                @if (!is_null($form->is_approved))
                                    @if ($form->is_approved == 1)
                                        <table class="table table-sm table-bordered table-striped">
                                            <tr>
                                                <th>DATE REQUESTED</th>
                                                <td>{{ $form->date_requested }}</td>
                                            </tr>
                                            <tr>
                                                <th>FORM TYPE</th>
                                                <td>{{ $form->is_original == 1 ? 'Original Copy' : 'Electronic Copy' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>OFFICER MESSAGE</th>
                                                <td>{{ $form->officer_message }}</td>
                                            </tr>
                                            <tr>
                                                <th>DATE APPROVED</th>
                                                <td>{{ $form->date_approved }}</td>
                                            </tr>
                                            <tr>
                                                <th>APPROVED BY</th>
                                                <td>{{ $form->name . ' - ' . $form->email }}</td>
                                            </tr>
                                            <tr>
                                                <th>RECORDS COMMENT</th>
                                                <td>{{ $form->approval_message }}</td>
                                            </tr>
                                            <tr>
                                                <th>VIEWABLE DEADLINE</th>
                                                <td>{{ $form->viewable_deadline }}</td>
                                            </tr>
                                            <tr>
                                                <th>IS FILE LOCKED?</th>
                                                <td>{{ $form->is_locked ? 'Loan Form locked' : 'Loan form viewable' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>REQUESTED FORM</th>
                                                <td>
                                                    @if ($form->is_locked)
                                                        <button type="button" class="btn btn-sm btn-danger"><i
                                                                class="fas fa-exclamation-circle"></i>
                                                            Form Locked</button>
                                                    @else
                                                        <a target="_new"
                                                            href="{{ route('user.change-forms.attachment', $form->request_id) }}">
                                                            <button type="button" class="btn btn-sm btn-secondary"><i
                                                                    class="fas fa-external-link-alt"></i>
                                                                View Change Form</button>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    @endif
                                    @if ($form->is_approved == 0)
                                        <table class="table table-sm table-bordered table-striped">
                                            <tr>
                                                <th>DATE REQUESTED</th>
                                                <td>{{ $form->date_requested }}</td>
                                            </tr>
                                            <tr>
                                                <th>OFFICER MESSAGE</th>
                                                <td>{{ $form->officer_message }}</td>
                                            </tr>
                                            <tr>
                                                <th>DATE REJECTED</th>
                                                <td>{{ $form->date_approved }}</td>
                                            </tr>
                                            <tr>
                                                <th>REJECTED BY</th>
                                                <td>{{ $form->name . ' - ' . $form->email }}</td>
                                            </tr>
                                            <tr>
                                                <th>RECORDS COMMENT</th>
                                                <td>{{ $form->approval_message }}</td>
                                            </tr>
                                        </table>
                                    @endif
                                @else
                                    <p class="text text-danger">Your form request is awaiting approval</p>
                                @endif
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
