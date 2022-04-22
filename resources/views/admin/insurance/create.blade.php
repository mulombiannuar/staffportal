@extends('layouts.admin.form')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-user-plus"></i> {{ $title }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.insurances.store') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="client_name">Client Name</label>
                                        <input type="text" name="client_name" class="form-control" id="client_name"
                                            value="{{ old('user_name') }}" placeholder="Enter client name"
                                            autocomplete="on" required>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="client_phone">Client Phone</label>
                                        <input type="number" name="client_phone" class="form-control" id="client_phone"
                                            value="{{ old('mobile_no') }}" placeholder="Enter client phone"
                                            autocomplete="on" required>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="client_id">Client ID</label>
                                        <input type="number" name="client_id" class="form-control" id="client_id"
                                            value="{{ old('national_id') }}" placeholder="Enter client phone"
                                            autocomplete="on" required>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="client_kra">Client KRA</label>
                                        <input type="text" name="client_kra" class="form-control" id="client_kra"
                                            value="{{ old('client_kra') }}" placeholder="Enter client kra"
                                            autocomplete="on" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="product">Product</label>
                                        <select name="product" id="product" class="form-control select2" id="product"
                                            required>
                                            <option class="mb-1" value="">
                                                - Select Product -</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->product_id }}">
                                                    {{ $product->product_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="branch_id">Branch</label>
                                        <select name="branch" id="branch" class="form-control select2" id="branch_id"
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
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="outposts">Outpost</label>
                                        <select name="outpost_id" class="form-control select2" id="outposts" required>
                                            <option class="mb-1" value="">
                                                - Select Branch First -</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="users">Users</label>
                                        <select name="user_id" id="users" class="form-control select2" required>
                                            <option class="mb-1" value="">
                                                - Select Outpost First -</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="date_issued">Date Issued</label>
                                        <input type="date" name="date_issued" class="form-control" id="date_issued"
                                            value="{{ date('Y-m-d') }}" placeholder="Select date issued"
                                            autocomplete="on" required>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="date_expired">Expiry Date</label>
                                        <input type="date" name="date_expired" class="form-control" id="date_expired"
                                            value="{{ date('Y-m-d') }}" placeholder="Select date expiring"
                                            autocomplete="on" required>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="sum_issued">Sum Issued</label>
                                        <input type="number" name="sum_issued" class="form-control" id="sum_issued"
                                            value="{{ old('sum_issued') }}" placeholder="Enter sum issued"
                                            autocomplete="on" required>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="premium">Premium</label>
                                        <input type="number" name="premium" class="form-control" id="premium"
                                            value="{{ old('premium') }}" placeholder="Enter premium" autocomplete="on"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="cheque_no">Cheque No.</label>
                                        <input type="number" name="cheque_no" class="form-control" id="cheque_no"
                                            value="{{ old('cheque_no') }}" placeholder="Enter cheque no"
                                            autocomplete="on" required>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="reference">Motor Reg No</label>
                                        <input type="text" name="reference" class="form-control" id="reference"
                                            value="{{ old('reference') }}" placeholder="Enter reference"
                                            autocomplete="on" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="company">Company</label>
                                        <select name="company" id="company" class="form-control select2" id="company"
                                            required>
                                            <option class="mb-1" value="">
                                                - Select Company -</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->co_id }}">
                                                    {{ $company->company_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary"> <i class="fa fa-user-plus"></i>
                                Save Insurance Data</button>
                        </div>
                    </form>
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
