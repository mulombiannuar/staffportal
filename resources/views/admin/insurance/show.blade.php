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
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="client_name">Client Name</label>
                                    <input type="text" name="client_name" class="form-control" id="client_name"
                                        value="{{ $policy->client_name }}" placeholder="Enter client name"
                                        autocomplete="on" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="client_phone">Client Phone</label>
                                    <input type="number" name="client_phone" class="form-control" id="client_phone"
                                        value="{{ $policy->client_phone }}" placeholder="Enter client phone"
                                        autocomplete="on" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="client_id">Client ID</label>
                                    <input type="number" name="client_id" class="form-control" id="client_id"
                                        value="{{ $policy->client_id }}" placeholder="Enter client phone"
                                        autocomplete="on" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="client_kra">Client KRA</label>
                                    <input type="text" name="client_kra" class="form-control" id="client_kra"
                                        value="{{ $policy->client_kra }}" placeholder="Enter client kra" autocomplete="on"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="product">Product</label>
                                    <input type="text" name="product" class="form-control" id="product"
                                        value="{{ $policy->product_name }}" placeholder="Enter product name"
                                        autocomplete="on" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="branch_id">Branch</label>
                                    <input type="text" name="branch" class="form-control" id="branch"
                                        value="{{ $policy->branch_name }}" placeholder="Enter branch name"
                                        autocomplete="on" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="outpost_id">Outpost</label>
                                    <input type="text" name="outpost_id" class="form-control" id="outpost_id"
                                        value="{{ $policy->outpost_name }}" placeholder="Enter outpost name"
                                        autocomplete="on" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="users">Officer</label>
                                    <input type="text" name="officer" class="form-control" id="officer"
                                        value="{{ $policy->name }}" placeholder="Enter officer name" autocomplete="on"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="date_issued">Date Issued</label>
                                    <input type="date" name="date_issued" class="form-control" id="date_issued"
                                        value="{{ $policy->date_issued }}" placeholder="Select date issued"
                                        autocomplete="on" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="date_expired">Expiry Date</label>
                                    <input type="date" name="date_expired" class="form-control" id="date_expired"
                                        value="{{ $policy->date_expired }}" placeholder="Select date expiring"
                                        autocomplete="on" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="sum_issued">Sum Issued</label>
                                    <input type="number" name="sum_issued" class="form-control" id="sum_issued"
                                        value="{{ $policy->sum_issued }}" placeholder="Enter sum issued"
                                        autocomplete="on" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="premium">Premium</label>
                                    <input type="number" name="premium" class="form-control" id="premium"
                                        value="{{ $policy->premium }}" placeholder="Enter premium" autocomplete="on"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="cheque_no">Cheque No.</label>
                                    <input type="number" name="cheque_no" class="form-control" id="cheque_no"
                                        value="{{ $policy->cheque_no }}" placeholder="Enter cheque no" autocomplete="on"
                                        required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="reference">Motor Reg No</label>
                                    <input type="text" name="reference" class="form-control" id="reference"
                                        value="{{ $policy->reference }}" placeholder="Enter reference" autocomplete="on"
                                        required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="company">Company</label>
                                    <input type="text" name="company_name" class="form-control" id="company_name"
                                        value="{{ $policy->company_name }}" placeholder="Enter company_name"
                                        autocomplete="on" required>
                                </div>
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
