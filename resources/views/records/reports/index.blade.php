@extends('layouts.admin.form')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-calendar"></i> {{ $title }}</h3>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <form action="{{ route('records.reports.type') }}" method="get">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="category">Report Category</label>
                                                    <select name="category" class="form-control select2" required>
                                                        <option class="mb-1" value="">
                                                            - Select Category Type -</option>
                                                        <option value="1">Client Loan Forms</option>
                                                        <option value="2">Client Change Forms</option>
                                                        <option value="3">Requested Loan Forms</option>
                                                        <option value="4">Requested Change Forms</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="filing_type">Filing Type</label>
                                                    <select name="filing_type" class="form-control select2" required>
                                                        <option class="mb-1" value="">
                                                            - Select Filing Type -</option>
                                                        @foreach ($filing_types as $type)
                                                            <option value="{{ $type->type_id }}">
                                                                {{ $type->type_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label for="start_date">Start Date</label>
                                                    <input type="date" name="start_date" class="form-control"
                                                        placeholder="Start date" autocomplete="off"
                                                        value="{{ date('Y-m-d') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label for="end_date">End Date</label>
                                                    <input type="date" name="end_date" class="form-control"
                                                        placeholder="Start date" autocomplete="off"
                                                        value="{{ date('Y-m-d') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="submit" class="btn btn-secondary"> <i class="fa fa-user-plus"></i>
                                            View Specified Report</button>
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
