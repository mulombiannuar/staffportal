@extends('layouts.admin.form')

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
                                <form action="{{ route('admin.assets.assign') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
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
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="outposts">Outpost</label>
                                                    <select name="outpost_id" class="form-control select2" id="outposts"
                                                        required>
                                                        <option class="mb-1" value="">
                                                            - Select Branch First -</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="users">Outposts Loan Requests</label>
                                                    <select name="user_id" id="users" class="form-control select2"
                                                        id="user_id" required>
                                                        <option class="mb-1" value="">
                                                            - Select Outpost First -</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="message">Additional Info</label>
                                                    <textarea class="form-control" name="message" id="message" cols="4" rows="2"
                                                        placeholder="Enter additional info" autocomplete="on" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="submit" class="btn btn-primary"> <i class="fa fa-user-plus"></i>
                                            Give Access Rights</button>
                                    </div>
                                </form>

                                <table id="table2" class="table table-sm table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>PREVIOUS USER</th>
                                            <th>CURRENT USER</th>
                                            <th>ASSIGNED BY</th>
                                            <th>DATE ASSIGNED</th>
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
                        url: "{{ route('get.oclients') }}",
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

            $('#types').change(function() {
                type = $('#types').val();
                if (type != '') {
                    $.ajax({
                        url: "{{ route('get.filing-files') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "GET",
                        data: {
                            type: type
                        },
                        success: function(data) {
                            console.log(data);
                            $('#labels').html(data);
                        },
                        error: function(xhr, desc, err) {
                            console.log(xhr);
                            //console.log("Details0: " + desc + "\nError:" + err);
                        },
                    });
                    if (type == 5) {
                        document.getElementById("cheque").style.display = "block";
                    }
                } else {
                    $('#labels').html('<p value="text text-danger">No Filing files found</p>');
                }
            });
        });
    </script>
@endpush
