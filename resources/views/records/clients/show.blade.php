@extends('layouts.admin.form')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card card-warning card-outline">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#details" data-toggle="tab"><i class="fa fa-user"></i>
                            Client Details</a></li>
                    <li class="nav-item"><a class="nav-link" href="#loan-forms" data-toggle="tab"><i
                                class="fa fa-list-alt"></i>
                            Loan Forms ({{ count($loan_forms) }})</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="details">
                        <!-- Profile -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-user"></i> Profile</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('records.clients.update', $client->client_id) }}" method="post">
                                    @method('put')
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="client_name">Client Name</label>
                                                    <input type="text" name="client_name" class="form-control"
                                                        id="name" placeholder="Enter client name" autocomplete="off"
                                                        value="{{ $client->client_name }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="client_phone">Mobile No.</label>
                                                    <input type="number" name="client_phone" class="form-control"
                                                        id="client_phone" placeholder="Mobile Number e.g 254701111700"
                                                        value="{{ $client->client_phone }}" autocomplete="off" required
                                                        onKeyPress="if(this.value.length==12) return false;" minlength="12"
                                                        maxlength="12">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="bimas_br_id">Bimas BR ID</label>
                                                    <input type="number" name="bimas_br_id" class="form-control"
                                                        id="bimas_br_id" placeholder="Enter bimas client ID e.g 0108981"
                                                        value="{{ $client->bimas_br_id }}" autocomplete="on"
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
                                                        <option class="mb-1" value="{{ $client->branch_id }}">
                                                            {{ $client->branch_name }}</option>
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
                                                        <option class="mb-1" value="{{ $client->outpost_id }}">
                                                            {{ $client->outpost_name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="national_id">National ID</label>
                                                    <input type="number" name="national_id" class="form-control"
                                                        id="national_id" placeholder="Enter National ID"
                                                        value="{{ $client->national_id }}" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="submit" class="btn btn-primary"> <i class="fa fa-user-edit"></i>
                                            Update Client Data</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.Profile -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="loan-forms">
                        <!-- documents -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-list-alt"></i> Loan Forms</h3>
                            </div>
                            <div class="card-body">
                                <table width="100%" id="table2"
                                    class="table table-sm table-bordered table-striped table-head-fixed table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>REFERENCE</th>
                                            <th>NAMES</th>
                                            <th>BR ID</th>
                                            <th>MOBILE</th>
                                            <th>NATIONAL ID</th>
                                            <th>OUTPOST</th>
                                            <th>DATE REQUESTED</th>
                                            <th>FORM TYPE</th>
                                            <th>DATE APPROVED</th>
                                            <th>STATUS</th>
                                            <th>PRODUCT CODE</th>
                                            <th>AMOUNT</th>
                                            <th>DISBURSMENT DATE</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($loan_forms as $loan)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $loan->reference }}</td>
                                                <td>{{ $loan->client_name }}</td>
                                                <td>{{ $loan->bimas_br_id }}</td>
                                                <td>{{ $loan->client_phone }}</td>
                                                <td>{{ $loan->national_id }}</td>
                                                <td>{{ $loan->outpost_name }}</td>
                                                <td>{{ $loan->date_requested }}</td>
                                                <td><strong>{{ $loan->is_original ? 'Original copy' : 'Electronic copy' }}</strong>
                                                </td>
                                                <td>{{ $loan->date_approved }}</td>
                                                <td><strong>{{ $loan->is_approved ? 'Approved' : 'Rejected' }}</strong>
                                                </td>
                                                <td>{{ $loan->product_code }}</td>
                                                <td>{{ $loan->amount }}</td>
                                                <td>{{ $loan->disbursment_date }}</td>
                                                <td>
                                                    <div class="margin">
                                                        <div class="btn-group">
                                                            <a href="{{ route('user.loan-forms.requested', $loan->request_id) }}"
                                                                title="Click to view request details">
                                                                <button type="button" class="btn btn-xs btn-secondary"><i
                                                                        class="fa fa-bars"></i>
                                                                </button>
                                                            </a>
                                                        </div>
                                                        <div class="btn-group">
                                                            <a class="btn btn-xs btn-primary" target="_new"
                                                                href="{{ route('user.loan-forms.attachment', $loan->request_id) }}"
                                                                title="Click to view requested loan form">
                                                                <i class="fa fa-external-link-alt"></i>
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
                        </div>
                        <!-- documents -->
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
        });
    </script>
@endpush
