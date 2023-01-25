@extends('layouts.admin.form')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning card-outline">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#loan-application" data-toggle="tab"><i
                                    class="fa fa-calendar"></i>
                                Request from Application ID</a></li>
                        <li class="nav-item"><a class="nav-link" href="#form-request" data-toggle="tab"><i
                                    class="fa fa-user"></i>
                                {{ $title }}</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane" id="form-request">
                            <!-- form -->
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fa fa-user-plus"></i> {{ $title }}</h3>
                                </div>
                                <div class="card-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <form action="{{ route('user.loan-forms.request-loan') }}" method="post">
                                                    <input type="hidden" name="branch" value="{{ $user->branch_id }}">
                                                    <input type="hidden" name="outpost" value="{{ $user->outpost_id }}">
                                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                    <input type="hidden" name="return_date" value="{{ null }}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-4 col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="client_name">Client Name</label>
                                                                    <input type="text" name="client_name"
                                                                        class="form-control" id="name"
                                                                        placeholder="Enter client name" autocomplete="off"
                                                                        value="{{ old('client_name') }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="client_phone">Mobile No.</label>
                                                                    <input type="number" name="client_phone"
                                                                        class="form-control" id="client_phone"
                                                                        placeholder="Mobile Number e.g 254701111700"
                                                                        value="{{ old('client_phone') }}" autocomplete="off"
                                                                        required
                                                                        onKeyPress="if(this.value.length==12) return false;"
                                                                        minlength="12" maxlength="12">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="bimas_br_id">Bimas BR ID</label>
                                                                    <input type="number" name="bimas_br_id"
                                                                        class="form-control" id="bimas_br_id"
                                                                        placeholder="Enter bimas client ID e.g 0108981"
                                                                        value="{{ old('bimas_br_id') }}" autocomplete="on"
                                                                        onKeyPress="if(this.value.length==7) return false;"
                                                                        minlength="7" maxlength="7" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="national_id">National ID</label>
                                                                    <input type="number" name="national_id"
                                                                        class="form-control" id="national_id"
                                                                        placeholder="Enter National ID"
                                                                        value="{{ old('national_id') }}" autocomplete="off"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="product">Loan Product</label>
                                                                    <select name="product" id="product"
                                                                        class="form-control select2" id="product"
                                                                        required>
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
                                                                    <input type="number" name="amount"
                                                                        class="form-control" id="amount"
                                                                        placeholder="Loan Amount"
                                                                        value="{{ old('amount') }}" autocomplete="off"
                                                                        required>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="disbursment_date">Disbursment Date</label>
                                                                    <input type="date" name="disbursment_date"
                                                                        class="form-control" id="name"
                                                                        placeholder="Disbursment date" autocomplete="off"
                                                                        value="{{ old('disbursment_date') }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="is_original">Loan Form Type</label>
                                                                    <select name="is_original" id="is_original"
                                                                        class="form-control select2" required>
                                                                        <option class="mb-1" value="">
                                                                            - Select Loan Form Type -</option>
                                                                        <option selected value="0">Electronic Copy
                                                                        </option>
                                                                        <option value="1">Original Copy</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="officer_message">Officer message</label>
                                                                    <textarea class="form-control" name="officer_message" id="officer_message" cols="4" rows="2"
                                                                        placeholder="Enter your message here" autocomplete="on" required></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="submit" class="btn btn-primary"> <i
                                                                class="fa fa-user-plus"></i>
                                                            Request Loan Form</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.form -->
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane active" id="loan-application">
                            <!-- loan application -->
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fa fa-calendar"></i> Request from Application ID
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('user.loan-forms.request-loan') }}" method="post">
                                        <input type="hidden" name="branch" value="{{ $user->branch_id }}">
                                        <input type="hidden" name="outpost" value="{{ $user->outpost_id }}">
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <input type="hidden" name="return_date" value="{{ null }}">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="client_id">Outpost Clients</label>
                                                        <select name="clients" class="form-control select2"
                                                            id="users2" required>
                                                            <option class="mb-1" value="">
                                                                - Select Outpost Client -</option>
                                                            @foreach ($clients as $client)
                                                                <option value="{{ $client->client_id }}">
                                                                    {{ $client->bimas_br_id . ' - ' . $client->client_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="account">Loan Account</label>
                                                        <select name="account" class="form-control select2"
                                                            id="accounts" required>
                                                            <option class="mb-1" value="">
                                                                - Select Client First -</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="product">Loan Product</label>
                                                        <input type="hidden" name="product" id="product_id">
                                                        <input type="text" class="form-control" id="prod"
                                                            placeholder="Loan product" autocomplete="off"
                                                            value="{{ old('product') }}" required readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="hidden" style="display: none">
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="client_name">Client Name</label>
                                                            <input type="text" name="client_name" class="form-control"
                                                                id="name2" placeholder="Enter client name"
                                                                autocomplete="off" value="{{ old('client_name') }}"
                                                                required readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="client_phone">Mobile No.</label>
                                                            <input type="number" name="client_phone"
                                                                class="form-control" id="phone2"
                                                                placeholder="Mobile Number e.g 254701111700"
                                                                value="{{ old('client_phone') }}" autocomplete="off"
                                                                required
                                                                onKeyPress="if(this.value.length==12) return false;"
                                                                minlength="12" maxlength="12">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="bimas_br_id">Bimas BR ID</label>
                                                            <input type="number" name="bimas_br_id" class="form-control"
                                                                id="brid2"
                                                                placeholder="Enter bimas client ID e.g 0108981"
                                                                value="{{ old('bimas_br_id') }}" autocomplete="on"
                                                                onKeyPress="if(this.value.length==7) return false;"
                                                                minlength="7" maxlength="7" required readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="national_id">National ID</label>
                                                            <input type="number" name="national_id" class="form-control"
                                                                id="nationalid2" placeholder="Enter National ID"
                                                                value="{{ old('national_id') }}" autocomplete="off"
                                                                required readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="amount">Loan Amount</label>
                                                            <input type="number" name="amount" class="form-control"
                                                                id="amount2" placeholder="Loan Amount"
                                                                value="{{ old('amount') }}" autocomplete="off" readonly
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="disbursment_date">Disbursment Date</label>
                                                            <input type="text" name="disbursment_date"
                                                                class="form-control" id="date2" readonly
                                                                placeholder="Disbursment date" autocomplete="off"
                                                                value="{{ old('disbursment_date') }}" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="is_original">Loan Form Type</label>
                                                            <select name="is_original" id="is_original"
                                                                class="form-control select2" required>
                                                                <option class="mb-1" value="">
                                                                    - Select Loan Form Type -</option>
                                                                <option selected value="0">Electronic Copy
                                                                </option>
                                                                <option value="1">Original Copy</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="payee">Payee</label>
                                                            <input type="text" name="payee" class="form-control"
                                                                id="payee" placeholder="Enter payee"
                                                                autocomplete="on" value="1" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="cheque_no">Cheque No.</label>
                                                            <input type="text" name="cheque_no" class="form-control"
                                                                id="cheque_no" placeholder="Enter payee"
                                                                autocomplete="off" value="0" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="officer_message">Officer message</label>
                                                            <textarea class="form-control" name="officer_message" id="officer_message" cols="4" rows="2"
                                                                placeholder="Enter your message here" autocomplete="on" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-warning"> <i
                                                        class="fa fa-user-plus"></i>
                                                    Submit Loan Form Request</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- loan application -->
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

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
                            $('#users3').html(data);
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
                                $('#name2').val(data.client_name);
                                $('#phone2').val(data.client_phone);
                                $('#brid2').val(data.client_id);
                                $('#nationalid2').val(data.national_id);
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
