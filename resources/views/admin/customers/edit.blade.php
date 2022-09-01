@extends('layouts.admin.form')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-edit"></i>
                        Update Campaign Data
                    </h3>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <form action="{{ route('customers.campaigns.update', $campaign->campaign_id) }}"
                                    method="post">
                                    @method('PUT')
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Campaign Name</label>
                                                    <input type="text" name="campaign_name" class="form-control"
                                                        id="campaign_name" placeholder="Enter Campaign name"
                                                        autocomplete="off" value="{{ $campaign->campaign_name }}" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="start_date">Start Date</label>
                                                    <input type="date" name="start_date" class="form-control"
                                                        id="start_date" value="{{ $campaign->start_date }}"
                                                        placeholder="Select start date" autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="end_date">End Date</label>
                                                    <input type="date" name="end_date" class="form-control"
                                                        id="end_date" value="{{ $campaign->end_date }}"
                                                        placeholder="Select end date" autocomplete="on" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="target_products">Target Products</label>
                                                    <textarea class="form-control" name="target_products" id="target_products" cols="4" rows="2"
                                                        placeholder="Enter target products here" autocomplete="on" required>{{ $campaign->target_products }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="target_areas">Target Areas</label>
                                                    <textarea class="form-control" name="target_areas" id="target_areas" cols="4" rows="2"
                                                        placeholder="Enter target areas here" autocomplete="on" required>{{ $campaign->target_areas }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="submit" class="btn btn-info"> <i class="fa fa-edit"></i>
                                            Update Campaign Data</button>
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
