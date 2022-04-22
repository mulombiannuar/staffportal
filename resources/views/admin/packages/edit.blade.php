@extends('layouts.admin.form')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-edit"></i> {{ $title }} :
                        {{ $product->name }}</h3>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <form action="{{ route('admin.packages.update', $packageData->staff_id) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="packages">Packages</label>
                                                    <select name="package" id="packages" class="form-control select2"
                                                        id="packages" required>
                                                        <option class="mb-1"
                                                            value=" {{ $packageData->package_id }}">
                                                            {{ $packageData->value }} [Ksh. {{ $packageData->amount }}]
                                                        </option>
                                                        @foreach ($packages as $package)
                                                            <option value="{{ $package->package_id }}">
                                                                {{ $package->value }} [Ksh. {{ $package->amount }}]
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="branch_id">Branch</label>
                                                    <input type="text" value="{{ $packageData->branch_name }}"
                                                        class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="outposts">Outpost</label>
                                                    <input type="text" value="{{ $packageData->outpost_name }}"
                                                        class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="users">Users</label>
                                                    <input type="text" value="{{ $packageData->staff_name }}"
                                                        class="form-control" readonly>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="submit" class="btn btn-primary"> <i class="fa fa-edit"></i>
                                            Update {{ ucwords($product->type) }} Data</button>
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
