@extends('layouts.admin.form')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning card-outline">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#productImages" data-toggle="tab"><i
                                    class="fa fa-image"></i>
                                Product Images ({{ count($images) }})</a></li>
                        <li class="nav-item"><a class="nav-link" href="#productDetails" data-toggle="tab"><i
                                    class="fa fa-list-alt"></i>
                                Product Details</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="productImages">
                            <!-- Profile -->
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fa fa-plus"></i> Add Product Images</h3>
                                </div>
                                <div class="card-body">
                                    <fieldset class="border pb-3 pl-5 pr-5">
                                        <legend class="w-auto pl-2 pr-2">Add Images </legend>
                                        <form class="m-2 form-inline" action="{{ route('shop.products.save-image') }}"
                                            enctype="multipart/form-data" method="post">
                                            @csrf
                                            <div class="form-group mb-2">
                                                <input type="file" name="image" class="form-control-file" id="image"
                                                    required>
                                                <input type="hidden" name="product_id"
                                                    value="{{ $product->product_id }}" />
                                            </div>
                                            <button type="submit" class="btn btn-info mb-2"><i class="fa fa-upload"></i>
                                                Upload Image</button>
                                        </form>
                                    </fieldset>
                                    <fieldset class="border mt-5 pb-3 pl-5 pr-5">
                                        <legend class="w-auto pl-2 pr-2">Product Images </legend>
                                        @if (!empty($images))
                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <table class="table table-sm table-borderless">
                                                        <tbody>
                                                            @foreach ($images as $image)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>
                                                                        <a href="{{ asset('storage/assets/app/images/products/' . $image->image) }}"
                                                                            target="_blank">
                                                                            <img class="img-fluid product-thumbnail-img img-thumbnail"
                                                                                src="{{ asset('storage/assets/app/images/products/' . $image->image) }}"
                                                                                alt="{{ $image->image }}"
                                                                                title="{{ $image->image }}">
                                                                        </a>
                                                                        <div class="btn-group m-5">
                                                                            <form
                                                                                action="{{ route('shop.products.delete-image', $image->image_id) }}"
                                                                                method="post"
                                                                                onclick="return confirm('Do you really want to delete this image?')">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="btn btn-xs btn-danger"><i
                                                                                        class="fa fa-trash"></i>
                                                                                    Delete Image</button>
                                                                            </form>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @else
                                            <div class="alert alert-danger mt-2">
                                                You have not added any images for this product. Kindly do so
                                            </div>
                                        @endif
                                    </fieldset>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.Profile -->
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="productDetails">
                            <!-- productDetails -->
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fa fa-users"></i> Product Details </h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="modal-body">
                                        <fieldset class="border pb-3 pl-5 pr-5">
                                            <legend class="w-auto pl-2 pr-2">Product Details </legend>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <img class="img-fluid mb-5 product-img"
                                                        src="{{ asset('storage/assets/app/images/products/' . $product->images) }}"
                                                        alt="{{ $product->product_name }}"
                                                        title="{{ $product->product_name }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="branch_id">Branch</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $product->branch_name }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="outposts">Outpost</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $product->outpost_name }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="users">Users</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $product->user_name }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="chassis_number">Chassis Number</label>
                                                        <input type="text" name="chassis_number" class="form-control"
                                                            id="start_date" value="{{ $product->chassis_number }}"
                                                            placeholder="Enter chassis number" autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="name">Product Name</label>
                                                        <input type="text" name="name" class="form-control" id="name"
                                                            value="{{ $product->product_name }}"
                                                            placeholder="Enter product name" autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="category">Category</label>

                                                    </div><input type="text" class="form-control"
                                                        value="{{ $product->category_name }}">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="mileage">Mileage</label>
                                                        <input type="number" name="mileage" class="form-control"
                                                            id="mileage" value="{{ $product->mileage }}"
                                                            placeholder="Enter mileage" autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="type">Type</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $product->type_name }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="color">Color</label>
                                                        <input type="text" name="color" class="form-control" id="color"
                                                            value="{{ $product->color }}" placeholder="Enter color"
                                                            autocomplete="on" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="engine">Engine</label>
                                                        <input type="text" name="engine" class="form-control" id="engine"
                                                            value="{{ $product->engine }}"
                                                            placeholder="Enter engine details" autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="reg_no">Registration Number</label>
                                                        <input type="text" name="reg_no" class="form-control" id="reg_no"
                                                            value="{{ $product->reg_no }}"
                                                            placeholder="Enter registration number" autocomplete="on"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="condition">Condition</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $product->condition }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="date_purchased">Date Of Purchase</label>
                                                        <input type="date" name="date_purchased" class="form-control"
                                                            id="date_purchased" value="{{ $product->date_purchased }}"
                                                            placeholder="Select date purchased" autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="purchase_price">Purchase Price</label>
                                                        <input type="number" name="purchase_price" class="form-control"
                                                            id="purchase_price" value="{{ $product->purchase_price }}"
                                                            placeholder="Enter purchase price " autocomplete="on" required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="disposal_price">Disposal Price</label>
                                                        <input type="number" name="disposal_price" class="form-control"
                                                            id="disposal_price" value="{{ $product->disposal_price }}"
                                                            placeholder="Enter disposal price " autocomplete="on" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="location">Location</label>
                                                        <input type="text" name="location" class="form-control"
                                                            id="location" value="{{ $product->location }}"
                                                            placeholder="Enter location " autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="form-group">
                                                        <label for="additional_info">Additional Info</label>
                                                        <textarea class="form-control" name="additional_info" id="additional_info" cols="4" rows="3"
                                                            placeholder="Enter additional info" autocomplete="on"
                                                            required>{{ $product->additional_info }}</textarea>
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
                                                            id="supplier" value="{{ $product->client_name }}"
                                                            placeholder="Enter client name" autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="client_id">Client ID</label>
                                                        <input type="text" name="client_id" class="form-control"
                                                            id="supplier" value="{{ $product->client_id }}"
                                                            placeholder="Enter client id" autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="mobile_no">Client Phone</label>
                                                        <input type="text" name="mobile_no" class="form-control"
                                                            id="mobile_no" value="{{ $product->mobile_no }}"
                                                            placeholder="Enter client mobile no" autocomplete="on" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="loan_amount">Loan Amount</label>
                                                        <input type="number" name="loan_amount" class="form-control"
                                                            id="loan_amount" value="{{ $product->loan_amount }}"
                                                            placeholder="Enter loan amount" autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="principal_amount">Principal Amount</label>
                                                        <input type="number" name="principal_amount" class="form-control"
                                                            id="principal_amount"
                                                            value="{{ $product->principal_amount }}"
                                                            placeholder="Enter principal amount" autocomplete="on" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="loan_balance">Loan Balance</label>
                                                        <input type="number" name="loan_balance" class="form-control"
                                                            id="loan_balance" value="{{ $product->loan_balance }}"
                                                            placeholder="Enter client loan balance" autocomplete="on"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- productDetails -->
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </section>
    <!-- /.content -->
@endsection
