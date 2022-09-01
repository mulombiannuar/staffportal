@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-plus"></i> Add New Campain
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('customers.campaigns.store') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Campaign Name</label>
                                        <input type="text" name="campaign_name" class="form-control" id="campaign_name"
                                            placeholder="Enter Campaign name" autocomplete="off"
                                            value="{{ old('campaign_name') }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <input type="date" name="start_date" class="form-control" id="start_date"
                                            value="{{ date('Y-m-d') }}" placeholder="Select start date" autocomplete="on"
                                            required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <input type="date" name="end_date" class="form-control" id="end_date"
                                            value="{{ date('Y-m-d') }}" placeholder="Select end date" autocomplete="on"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="target_products">Target Products</label>
                                        <textarea class="form-control" name="target_products" id="target_products" cols="4" rows="2"
                                            placeholder="Enter target products here" autocomplete="on" required></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="target_areas">Target Areas</label>
                                        <textarea class="form-control" name="target_areas" id="target_areas" cols="4" rows="2"
                                            placeholder="Enter target areas here" autocomplete="on" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary"> <i class="fa fa-user-plus"></i>
                                Add Campaign</button>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
