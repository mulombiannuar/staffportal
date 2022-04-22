@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="margin mb-2 text-right">
                <button type="button" data-toggle="modal" data-target="#modalAddPackage" class="btn btn-primary"><i
                        class="fa fa-plus"></i> Add New CVP Package</button>
            </div>

            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> {{ $title }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table1" class="table table-sm table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>PRODUCT NAME</th>
                                <th>VALUE</th>
                                <th>AMOUNT</th>
                                <th>CREATED BY</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $package)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $package->name }}</td>
                                    <td>{{ $package->value }}</td>
                                    <td><strong>Ksh {{ number_format($package->amount, 2) }}</strong></td>
                                    <td>{{ strtoupper($package->user_name) }}</td>
                                    <td>
                                        <div class="margin">
                                            <div class="btn-group">
                                                <button type="button" data-toggle="modal"
                                                    data-target="#modalEditpackage-{{ $package->package_id }}"
                                                    class="btn btn-xs btn-warning"><i class="fa fa-edit"></i>
                                                    Edit</button>
                                            </div>
                                            <div class="btn-group">
                                                <form
                                                    action="{{ route('admin.packages.deletepackage', $package->package_id) }}"
                                                    method="post"
                                                    onclick="return confirm('Do you really want to delete this package?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-xs btn-danger"><i
                                                            class="fa fa-trash"></i>
                                                        Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <!--/.modal begin -->
                                    <div class="modal fade" id="modalEditpackage-{{ $package->package_id }}"
                                        style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Update package</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form
                                                    action="{{ route('admin.packages.updatepackage', $package->package_id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="product">Product</label>
                                                                    <select name="product" id="product"
                                                                        class="form-control select2" id="product_id"
                                                                        required>
                                                                        <option selected class="mb-1"
                                                                            value="{{ $package->product }}">
                                                                            {{ $package->name }}</option>
                                                                        @foreach ($products as $product)
                                                                            <option value="{{ $product->product_id }}">
                                                                                {{ $product->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="value">CVP Value</label>
                                                                    <input type="text" name="value" class="form-control"
                                                                        id="value" autocomplete="off"
                                                                        placeholder="Enter CVP Value e.g 2GB"
                                                                        value="{{ $package->value }}" autocomplete="on"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="amount">CVP Price</label>
                                                                    <input type="text" name="amount" class="form-control"
                                                                        id="amount" autocomplete="off"
                                                                        value="{{ $package->amount }}"
                                                                        placeholder="Enter CVP Price amount"
                                                                        autocomplete="on" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-info"><i
                                                                class="fa fa-edit"></i>
                                                            Update
                                                            package</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!--/modal end -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!--/.modal begin -->
                    <div class="modal fade" id="modalAddPackage" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add New CVP Package</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <form action="{{ route('admin.packages.storepackage') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="product">Product</label>
                                                    <select name="product" id="product" class="form-control select2"
                                                        id="product_id" required>
                                                        <option class="mb-1" value="">
                                                            - Select Product -</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->product_id }}">
                                                                {{ $product->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="value">CVP Value</label>
                                                    <input type="text" name="value" class="form-control" id="value"
                                                        autocomplete="off" placeholder="Enter CVP Value e.g 2GB"
                                                        autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="amount">CVP Price</label>
                                                    <input type="text" name="amount" class="form-control" id="amount"
                                                        autocomplete="off" placeholder="Enter CVP Price amount"
                                                        autocomplete="on" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-info"><i class="fa fa-plus"></i> Add
                                            New Package</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!--/modal end -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
