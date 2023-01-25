@extends('layouts.admin.form')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card card-warning card-outline">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#loan-form" data-toggle="tab"><i
                                class="fa fa-upload"></i>
                            Upload New Loan Form </a></li>
                    <li class="nav-item"><a class="nav-link" href="#loan-application" data-toggle="tab"><i
                                class="fa fa-user-plus"></i>
                            Upload from Loan Application </a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="loan-form">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-user-plus"></i> {{ $title }}</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('records.loan-forms.store') }}" method="post"
                                    enctype="multipart/form-data">
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
                                                    <label for="client_id">Clients</label>
                                                    <select name="clients" class="form-control select2" id="users"
                                                        required>
                                                        <option class="mb-1" value="">
                                                            - Select Outpost First -</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="product">Loan Product</label>
                                                    <select name="product" id="product" class="form-control select2"
                                                        id="product" required>
                                                        <option class="mb-1" value="">
                                                            - Select Loan Product -</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->product_id }}">
                                                                {{ $product->product_code . ' - ' . $product->product_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="amount">Loan Amount</label>
                                                    <input type="number" name="amount" class="form-control" id="amount"
                                                        placeholder="Loan Amount" value="{{ old('amount') }}"
                                                        autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="filing_type">Filing Type</label>
                                                    <select name="filing_type" class="form-control select2" id="types"
                                                        required>
                                                        <option class="mb-1" value="">
                                                            - Select Filing Type -</option>
                                                        @foreach ($filing_types as $type)
                                                            <option value="{{ $type->type_id }}">
                                                                {{ $type->type_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="file_label">File Labels</label>
                                                    <select name="file_label" class="form-control select2" id="labels"
                                                        required>
                                                        <option class="mb-1" value="">
                                                            - Select Filing Type First -</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="client_name">Disbursment Date</label>
                                                    <input type="date" name="disbursment_date" class="form-control"
                                                        id="name" placeholder="Disbursment date" autocomplete="off"
                                                        value="{{ old('disbursment_date') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="loan_form">Loan Form (PDF Only)</label>
                                                    <input type="file" name="loan_form" accept=".pdf"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="cheque" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="client_name">Payee</label>
                                                        <input type="text" name="payee" class="form-control"
                                                            id="payee" placeholder="Enter payee" autocomplete="on"
                                                            value="1" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="client_name">Cheque No.</label>
                                                        <input type="text" name="cheque_no" class="form-control"
                                                            id="cheque_no" placeholder="Enter payee" autocomplete="off"
                                                            value="0" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="submit" class="btn btn-secondary"> <i class="fa fa-upload"></i>
                                            Upload New Loan Form</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane " id="loan-application">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-user-plus"></i> {{ $title }}</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('records.loan-forms.store') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="branch_id">Branch</label>
                                                    <select name="branch" id="branch2" class="form-control select2"
                                                        required>
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
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="outposts">Outpost</label>
                                                    <select name="outpost_id" class="form-control select2" id="outposts2"
                                                        required>
                                                        <option class="mb-1" value="">
                                                            - Select Branch First -</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="client_id">Clients</label>
                                                    <select name="clients" class="form-control select2" id="users2"
                                                        required>
                                                        <option class="mb-1" value="">
                                                            - Select Outpost First -</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="account">Loan Account</label>
                                                    <select name="account" class="form-control select2" id="accounts"
                                                        required>
                                                        <option class="mb-1" value="">
                                                            - Select Client First -</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="hidden" style="display: none">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="product">Loan Product</label>
                                                        <input type="hidden" name="product" id="product_id">
                                                        <input type="text" class="form-control" id="prod"
                                                            placeholder="Loan product" autocomplete="off"
                                                            value="{{ old('product') }}" readonly required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="amount">Loan Amount</label>
                                                        <input type="number" name="amount" class="form-control"
                                                            id="amount2" placeholder="Loan Amount" readonly
                                                            value="{{ old('amount') }}" autocomplete="off" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="client_name">Disbursment Date</label>
                                                        <input type="text" name="disbursment_date" readonly
                                                            class="form-control" id="date2"
                                                            placeholder="Disbursment date" autocomplete="off"
                                                            value="{{ old('disbursment_date') }}" required>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="filing_type">Filing Type</label>
                                                        <select name="filing_type" class="form-control select2"
                                                            id="types2" required>
                                                            <option class="mb-1" value="">
                                                                - Select Filing Type -</option>
                                                            @foreach ($filing_types as $type)
                                                                <option value="{{ $type->type_id }}">
                                                                    {{ $type->type_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="file_label">File Labels</label>
                                                        <select name="file_label" class="form-control select2"
                                                            id="labels2" required>
                                                            <option class="mb-1" value="">
                                                                - Select Filing Type First -</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="loan_form">Loan Form (PDF Only)</label>
                                                        <input type="file" name="loan_form" accept=".pdf"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="client_name">Payee</label>
                                                        <input type="text" name="payee" class="form-control"
                                                            id="payee" placeholder="Enter payee" autocomplete="on"
                                                            value="1" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="client_name">Cheque No.</label>
                                                        <input type="text" name="cheque_no" class="form-control"
                                                            id="cheque_no" placeholder="Enter payee" autocomplete="off"
                                                            value="0" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-warning"> <i class="fa fa-upload"></i>
                                                Upload New Loan Form</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
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

            $('#branch2').change(function() {
                branch_id = $('#branch2').val();
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
                            $('#outposts2').html(data);
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

            $('#outposts2').change(function() {
                outpost = $('#outposts2').val();
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
                            $('#users2').html(data);
                        },
                        error: function(xhr, desc, err) {
                            console.log(xhr);
                            //console.log("Details0: " + desc + "\nError:" + err);
                        },
                    });
                } else {
                    $('#users2').html('<p value="text text-danger">No Users Found in that Branch</p>');
                }
            });

            $('#types2').change(function() {
                type = $('#types2').val();
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
                            $('#labels2').html(data);
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
                    $('#labels2').html('<p value="text text-danger">No Filing files found</p>');
                }
            });

            $('#users2').change(function() {
                client = $('#users2').val();
                if (client != '') {
                    $.ajax({
                        url: "{{ route('get.client-accounts') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "GET",
                        data: {
                            client: client
                        },
                        success: function(data) {
                            console.log(data);
                            $('#accounts').html(data);
                        },
                        error: function(xhr, desc, err) {
                            console.log(xhr);
                            //console.log("Details0: " + desc + "\nError:" + err);
                        },
                    });
                } else {
                    $('#accounts').html('<p value="text text-danger">No Accounts Found</p>');
                }
            });

            $('#accounts').change(function() {
                account = $('#accounts').val();
                if (account != '') {
                    $.ajax({
                        url: "{{ route('get.account-details') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "GET",
                        data: {
                            account: account
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            if (data != null) {
                                $('#amount2').val(data.loan_amount);
                                $('#date2').val(data.disbursment_date);
                                $('#prod').val(data.product_id);
                                $('#product_id').val(data.pro_id);
                            }
                        },
                        error: function(xhr, desc, err) {
                            console.log(xhr);
                            //console.log("Details0: " + desc + "\nError:" + err);
                        },
                    });
                    document.getElementById("hidden").style.display = "block";
                } else {
                    $('#accounts').html('<p value="text text-danger">No Accounts Found</p>');
                }
            });
        });
    </script>
@endpush
