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
                                <form role="form" id="form" action="{{ route('crm.tickets.store') }}"
                                    method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="customer_name">Customer Name</label>
                                                    <input type="text" name="customer_name" class="form-control"
                                                        id="name" placeholder="Enter customer name" autocomplete="off"
                                                        value="{{ old('customer_name') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="customer_phone">Mobile No</label>
                                                    <input type="number" name="customer_phone" class="form-control"
                                                        id="customer_phone" placeholder="Enter Mobile Number"
                                                        value="{{ old('customer_phone') }}" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="residence">Residence</label>
                                                    <input type="text" name="residence" class="form-control"
                                                        id="residence" placeholder="Enter residence"
                                                        value="{{ old('residence') }}" autocomplete="on" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12">
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
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="outposts">Outpost</label>
                                                    <select name="outpost_id" class="form-control select2" id="outposts"
                                                        required>
                                                        <option class="mb-1" value="">
                                                            - Select Branch First -</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
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
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="business">Business</label>
                                                    <input type="text" name="business" class="form-control"
                                                        id="business" placeholder="Enter business activity"
                                                        value="{{ old('business') }}" autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="workflow_id">Workflow Level</label>
                                                    <select name="workflow_id" class="form-control select2" id="workflows"
                                                        required>
                                                        <option class="mb-1" value="">
                                                            - Select Wokflow Level -</option>
                                                        @foreach ($workflows as $workflow)
                                                            <option value="{{ $workflow->workflow_id }}">
                                                                {{ $workflow->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="workflow_users">Workflow Users</label>
                                                    <select name="workflow_user_id" class="form-control select2"
                                                        id="workflow_users" required>
                                                        <option class="mb-1" value="">
                                                            - Select Workflow Level First -</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="date_raised">Date Raised</label>
                                                    <input type="date" name="date_raised" class="form-control"
                                                        id="date_raised" placeholder="Enter date raised"
                                                        value="{{ date('Y-m-d') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="category">Category</label>
                                                    <select name="category" class="form-control select2" required>
                                                        <option class="mb-1" value="">
                                                            - Select Ticket Category -</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->category_id }}">
                                                                {{ $category->category_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="source">Source</label>
                                                    <select name="source" class="form-control select2" id="category"
                                                        required>
                                                        <option class="mb-1" value="">
                                                            - Select Ticket Source -</option>
                                                        @foreach ($sources as $source)
                                                            <option value="{{ $source->source_id }}">
                                                                {{ $source->source_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="message">Ticket Content</label>
                                                    <textarea class="form-control" name="message" id="message" cols="4" rows="3"
                                                        placeholder="Enter ticket content" autocomplete="on" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="submit" id="submit" disabled class="btn btn-primary"> <i
                                                class="fa fa-user-plus"></i>
                                            Submit Customer Ticket</button>
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
            $('#form').on("keyup", action);

            function action() {
                if ($('#customer_phone').val().length == 10) {
                    $('#submit').prop("disabled", false);
                } else {
                    $('#submit').prop("disabled", true);
                }
            }

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

            $('#workflows').change(function() {
                workflow = $('#workflows').val();
                if (workflow != '') {
                    $.ajax({
                        url: "{{ route('get.workflowusers') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "GET",
                        data: {
                            workflow: workflow
                        },
                        success: function(data) {
                            console.log(data);
                            $('#workflow_users').html(data);
                        },
                        error: function(xhr, desc, err) {
                            console.log(xhr);
                            //console.log("Details0: " + desc + "\nError:" + err);
                        },
                    });
                } else {
                    $('#users').html('<p value="text text-danger">No Workflow Users Found </p>');
                }
            });
        });
    </script>
@endpush