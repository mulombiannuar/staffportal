@extends('layouts.admin.form')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-edit"></i> {{ $title }}</h3>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <form action="{{ route('records.loan-forms.update', $loan_form->form_id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="branch_id">Branch</label>
                                                    <select name="branch" id="branch" class="form-control select2"
                                                        id="branch_id" required>
                                                        <option class="mb-1" value="{{ $loan_form->branch_id }}">
                                                            {{ $loan_form->branch_name }}</option>
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
                                                        <option class="mb-1" value="{{ $loan_form->outpost_id }}">
                                                            {{ $loan_form->outpost_name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="client_id">Clients</label>
                                                    <select name="clients" class="form-control select2" id="users"
                                                        required>
                                                        <option class="mb-1" value="{{ $loan_form->client_id }}">
                                                            {{ $loan_form->client_name }}</option>
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
                                                        <option class="mb-1" value="{{ $loan_form->product_id }}">
                                                            {{ $loan_form->product_name }}</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->product_id }}">
                                                                {{ $product->product_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
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
                                                    <select name="filing_type" class="form-control select2" id="types"
                                                        required>
                                                        <option class="mb-1" value="{{ $loan_form->type_id }}">
                                                            {{ $loan_form->type_name }}</option>
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
                                                        <option class="mb-1" value="{{ $loan_form->label_id }}">
                                                            {{ $loan_form->file_label . $loan_form->file_number }}</option>
                                                    </select>
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
                                                    <label for="loan_form">Loan Form (PDF Only)</label>
                                                    <input type="file" name="loan_form" accept=".pdf"
                                                        class="form-control">
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
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="submit" class="btn btn-secondary"> <i class="fa fa-edit"></i>
                                            Update Loan Form</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
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
