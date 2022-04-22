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
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <form action="{{ route('shop.products.store') }}" enctype="multipart/form-data"
                                    method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <fieldset class="border pb-3 pl-5 pr-5">
                                            <legend class="w-auto pl-2 pr-2">Product Details </legend>
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
                                                        <label for="users">Users</label>
                                                        <select name="user_id" id="users" class="form-control select2"
                                                            id="user_id" required>
                                                            <option class="mb-1" value="">
                                                                - Select Outpost First -</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="chassis_number">Chassis Number</label>
                                                        <input type="text" name="chassis_number" class="form-control"
                                                            id="start_date" value="{{ old('chassis_number') }}"
                                                            placeholder="Enter chassis number" autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="name">Product Name</label>
                                                        <input type="text" name="name" class="form-control" id="name"
                                                            value="{{ old('name') }}" placeholder="Enter product name"
                                                            autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="category">Category</label>
                                                        <select name="category" id="category" class="form-control select2"
                                                            id="category" required>
                                                            <option class="mb-1" value="">
                                                                - Select Category -</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->category_id }}">
                                                                    {{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="mileage">Mileage</label>
                                                        <input type="number" name="mileage" class="form-control"
                                                            id="mileage" value="{{ old('mileage') }}"
                                                            placeholder="Enter mileage" autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="type">Type</label>
                                                        <select name="type" id="type" class="form-control select2" id="type"
                                                            required>
                                                            <option class="mb-1" value="">
                                                                - Select Product Type -</option>
                                                            @foreach ($types as $type)
                                                                <option value="{{ $type->type_id }}">
                                                                    {{ $type->name }}
                                                                </option>
                                                            @endforeach>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="color">Color</label>
                                                        <input type="text" name="color" class="form-control" id="color"
                                                            value="{{ old('color') }}" placeholder="Enter color"
                                                            autocomplete="on" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="engine">Engine</label>
                                                        <input type="text" name="engine" class="form-control" id="engine"
                                                            value="{{ old('engine') }}"
                                                            placeholder="Enter engine details" autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="reg_no">Registration Number</label>
                                                        <input type="text" name="reg_no" class="form-control" id="reg_no"
                                                            value="{{ old('reg_no') }}"
                                                            placeholder="Enter registration number" autocomplete="on"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="condition">Condition</label>
                                                        <select name="condition" id="condition" class="form-control select2"
                                                            id="type" required>
                                                            <option class="mb-1" value="">
                                                                - Select Product condition -</option>
                                                            <option value="Brand New">Brand New</option>
                                                            <option value="Kenyan Used">Kenyan Used</option>
                                                            <option value="Foreign Used">Foreign Used</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="date_purchased">Date Of Purchase</label>
                                                        <input type="date" name="date_purchased" class="form-control"
                                                            id="date_purchased" value="{{ date('Y-m-d') }}"
                                                            placeholder="Select date purchased" autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="purchase_price">Purchase Price</label>
                                                        <input type="number" name="purchase_price" class="form-control"
                                                            id="purchase_price" value="{{ old('purchase_price') }}"
                                                            placeholder="Enter purchase price " autocomplete="on" required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="disposal_price">Disposal Price</label>
                                                        <input type="number" name="disposal_price" class="form-control"
                                                            id="disposal_price" value="{{ old('disposal_price') }}"
                                                            placeholder="Enter disposal price " autocomplete="on" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="location">Location</label>
                                                        <input type="text" name="location" class="form-control"
                                                            id="location" value="{{ old('location') }}"
                                                            placeholder="Enter location " autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="image">Image (800X500)</label>
                                                        <div class="form-group">
                                                            <input type="file" name="image" class="form-control-file"
                                                                id="image" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="additional_info">Additional Info</label>
                                                        <textarea class="form-control" name="additional_info" id="additional_info" cols="4" rows="3"
                                                            placeholder="Enter additional info" autocomplete="on"
                                                            required>{{ old('additional_info') }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset class="border pl-5 pr-5 pb-3 mt-3">
                                            <legend class="w-auto pl-2 pr-2">Client Details
                                            </legend>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="client_name">Client name</label>
                                                        <input type="text" name="client_name" class="form-control"
                                                            id="supplier" value="{{ old('client_name') }}"
                                                            placeholder="Enter client name" autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="client_id">Client ID</label>
                                                        <input type="text" name="client_id" class="form-control"
                                                            id="supplier" value="{{ old('client_id') }}"
                                                            placeholder="Enter client id" autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="mobile_no">Client Phone</label>
                                                        <input type="number" name="mobile_no" class="form-control"
                                                            id="mobile_no" value="{{ old('mobile_no') }}"
                                                            placeholder="Enter client mobile no" autocomplete="on" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="loan_amount">Loan Amount</label>
                                                        <input type="number" name="loan_amount" class="form-control"
                                                            id="loan_amount" value="{{ old('loan_amount') }}"
                                                            placeholder="Enter loan amount" autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="principal_amount">Principal Amount</label>
                                                        <input type="number" name="principal_amount" class="form-control"
                                                            id="principal_amount" value="{{ old('principal_amount') }}"
                                                            placeholder="Enter principal amount" autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="loan_balance">Loan Balance</label>
                                                        <input type="number" name="loan_balance" class="form-control"
                                                            id="loan_balance" value="{{ old('loan_balance') }}"
                                                            placeholder="Enter client loan balance" autocomplete="on"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="submit" class="btn btn-primary"> <i class="fa fa-user-plus"></i>
                                            Add New Motorbike</button>
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
