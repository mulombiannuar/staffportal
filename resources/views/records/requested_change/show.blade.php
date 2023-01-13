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
                    <li class="nav-item"><a class="nav-link" href="#client" data-toggle="tab"><i class="fa fa-user"></i>
                            Client Availability</a></li>

                    <li class="nav-item"><a class="nav-link" href="#change-form" data-toggle="tab"><i
                                class="fa fa-briefcase"></i>
                            Change Form Availability</a></li>

                    <li class="nav-item"><a class="nav-link" href="#approval" data-toggle="tab"><i
                                class="fa fa-user-edit"></i>
                            Request Approval</a></li>
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
                                <form action="{{ route('records.requested-change-forms.update', $form->request_id) }}"
                                    method="post">
                                    @method('put')
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="client_name">Client Name</label>
                                                    <input type="text" name="client_name" class="form-control"
                                                        id="name" placeholder="Enter client name" autocomplete="off"
                                                        value="{{ $form->client_name }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="client_phone">Mobile No.</label>
                                                    <input type="number" name="client_phone" class="form-control"
                                                        id="client_phone" placeholder="Mobile Number e.g 254701111700"
                                                        value="{{ $form->client_phone }}" autocomplete="off" required
                                                        onKeyPress="if(this.value.length==12) return false;" minlength="12"
                                                        maxlength="12">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="bimas_br_id">Bimas BR ID</label>
                                                    <input type="number" name="bimas_br_id" class="form-control"
                                                        id="bimas_br_id" placeholder="Enter bimas client ID e.g 0108981"
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
                                                    <select name="branch" id="branch" class="form-control select2"
                                                        id="branch_id" required>
                                                        <option class="mb-1" value="{{ $form->branch_id }}">
                                                            {{ $form->branch_name }}</option>
                                                        @foreach ($branches as $branch)
                                                            <option value="{{ $branch->branch_id }}">
                                                                {{ $branch->branch_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="outposts">Outpost</label>
                                                    <select name="outpost" class="form-control select2" id="outposts"
                                                        required>
                                                        <option class="mb-1" value="{{ $form->outpost_id }}">
                                                            {{ $form->outpost_name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="users">Officers</label>
                                                    <select name="user_id" id="users" class="form-control select2"
                                                        id="user_id" required>
                                                        <option class="mb-1" value="{{ $form->requested_by }}">
                                                            {{ $form->name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="national_id">National ID</label>
                                                    <input type="number" name="national_id" class="form-control"
                                                        id="national_id" placeholder="Enter National ID"
                                                        value="{{ $form->national_id }}" autocomplete="off" required>
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
                                                    <select name="is_original" id="is_original"
                                                        class="form-control select2" required>
                                                        <option class="mb-1" value="{{ $form->is_original }}">
                                                            {{ $form->is_original ? 'Original Copy' : 'Electronic Copy' }}
                                                        </option>
                                                        <option selected value="0">Electronic Copy</option>
                                                        <option value="1">Original Copy</option>
                                                    </select>
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
                                    <div class="modal-footer justify-content-between">
                                        <button type="submit" class="btn btn-secondary"> <i class="fa fa-user-edit"></i>
                                            Update Change Form Request</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /. Loan Form Details -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="client">
                        <!-- documents -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-user"></i> Client Availability</h3>
                            </div>
                            <div class="card-body">
                                <h5>Requested Client</h5>
                                <hr>
                                <div class="row mb-4">
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label for="client_name">Client Name</label>
                                            <input type="text" class="form-control" value="{{ $form->client_name }}"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label for="client_phone">Mobile No.</label>
                                            <input type="number" class="form-control" value="{{ $form->client_phone }}"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label for="bimas_br_id">Bimas BR ID</label>
                                            <input type="number" class="form-control" value="{{ $form->bimas_br_id }}"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label for="outpost_name">Branch</label>
                                            <input type="text" class="form-control" value="{{ $form->outpost_name }}"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                                <h5>Existing Client
                                    @if ($client)
                                        <button class="btn btn-xs btn-success"><i class="fa fa-check-circle"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-xs btn-danger"><i class="fa fa-times-circle"></i>
                                        </button>
                                    @endif
                                </h5>
                                <hr>
                                @if ($client)
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label for="client_name">Client Name</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $client->client_name }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label for="client_phone">Mobile No.</label>
                                                <input type="number" class="form-control"
                                                    value="{{ $client->client_phone }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label for="bimas_br_id">Bimas BR ID</label>
                                                <input type="number" class="form-control"
                                                    value="{{ $client->bimas_br_id }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label for="outpost_name">Branch</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $client->outpost_name }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <a target="_new" href="{{ route('records.clients.show', $client->client_id) }}">
                                        <button type="button" class="btn btn-sm btn-success"><i
                                                class="fas fa-external-link-alt"></i>
                                            View Client Details</button>
                                    </a>
                                @else
                                    <p class="text text-danger">Client does not exist.
                                        <a target="_new"
                                            href="{{ route('records.clients.change-request', $form->request_id) }}">
                                            <button type="button" class="btn btn-sm btn-danger"><i
                                                    class="fa fa-user-plus"></i>
                                                Create this Client here</button>
                                        </a>
                                    </p>
                                @endif
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- documents -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="change-form">
                        <!-- documents -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-briefcase"></i> Loan Form Availability</h3>
                            </div>
                            <div class="card-body">
                                <h5>Requested Change Form</h5>
                                <hr>
                                <div class="row mb-4">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="date_changed">Date Changed</label>
                                            <input type="date" name="date_changed" class="form-control"
                                                id="date_changed" placeholder="date changed" autocomplete="off"
                                                value="{{ $form->date_changed }}" required>
                                        </div>
                                    </div>
                                </div>
                                <h5>Existing Change Form
                                    @if ($requested_form)
                                        <button class="btn btn-xs btn-success"><i class="fa fa-check-circle"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-xs btn-danger"><i class="fa fa-times-circle"></i>
                                        </button>
                                    @endif
                                </h5>
                                <hr>
                                @if ($requested_form)
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="date_changed">Date Changed</label>
                                                <input type="date" name="date_changed" class="form-control"
                                                    id="date_changed" placeholder="date changed" autocomplete="off"
                                                    value="{{ $requested_form->date_changed }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <a target="_new"
                                        href="{{ route('records.change-forms.show', $requested_form->form_id) }}">
                                        <button type="button" class="btn btn-sm btn-success"><i
                                                class="fas fa-external-link-alt"></i>
                                            View Form Details</button>
                                    </a>
                                @else
                                    <p class="text text-danger">Change form does not exist.
                                    <form action="{{ route('records.change-forms.add-form') }}" method="get">
                                        <input type="hidden" name="client_id" value="{{ $form->bimas_br_id }}">
                                        <input type="hidden" name="request_id" value="{{ $form->request_id }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-upload"></i>
                                            Upload this Change Form</button>
                                    </form>
                                    </p>
                                @endif
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- documents -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="approval">
                        <!--  Loan Form Details -->
                        {{-- <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-user-edit"></i> Request Approval :
                                    {{ $loanRequest->reference }}</h3>
                            </div>
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
                                                <td>{{ $loanRequest->is_original == 1 ? 'Original Copy' : 'Electronic Copy' }}
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
                                                    <a target="_new"
                                                        href="{{ route('user.loan-forms.attachment', $approvalDetails->request_id) }}">
                                                        <button type="button" class="btn btn-sm btn-secondary"><i
                                                                class="fas fa-external-link-alt"></i>
                                                            View Loan Form</button>
                                                    </a>
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
                                                <th>RECORDS COMMENT</th>
                                                <td>{{ $approvalDetails->approval_message }}</td>
                                            </tr>
                                        </table>
                                    @endif
                                @else
                                    <form action="{{ route('records.requested-forms.approve') }}" method="post">
                                        <input type="hidden" name="request_id" value="{{ $loanRequest->request_id }}">
                                        <input type="hidden" name="loan_form_id"
                                            value="{{ $loan_form ? $loan_form->form_id : null }}">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="approval_status">Approval Status</label>
                                                        <select name="approval_status" id="approval_status"
                                                            class="form-control select2" required>
                                                            <option class="mb-1" value="">
                                                                - Select Approval Status -</option>
                                                            @if ($loan_form)
                                                                <option value="1">Approve Request</option>
                                                            @endif
                                                            <option value="0">Reject Request</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="approval_message">Approval Message</label>
                                                        <textarea class="form-control" name="approval_message" id="approval_message" cols="4" rows="2"
                                                            placeholder="Enter your message here" autocomplete="on" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="submit" class="btn btn-secondary"> <i
                                                    class="fa fa-user-edit"></i>
                                                Submit Approval Status</button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                            <!-- /.card-body -->
                        </div> --}}
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
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#branch').change(function() {
                branch_id = $('#branch').val();
                if (branch_id != '') {
                    $.ajax({
                        url: "{{ route('get.outposts') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        data: {
                            branch_id: branch_id
                        },
                        success: function(data) {
                            console.log(data);
                            $('#outposts').html(data);
                        },
                        error: function(xhr, desc, err) {
                            console.log(xhr);
                            //console.log("Details0: " + desc + "\nError:" + err);
                        },
                    });
                } else {
                    $('#outposts').html('<option value="">Select Branch</option>');
                }
            });

            $('#outposts').change(function() {
                outpost = $('#outposts').val();
                if (outpost != '') {
                    $.ajax({
                        url: "{{ route('get.ousers') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "GET",
                        data: {
                            outpost: outpost
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
