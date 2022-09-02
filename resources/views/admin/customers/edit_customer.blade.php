@extends('layouts.admin.form')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-user-edit"></i> {{ $title }}</h3>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <form action="{{ route('customers.update_customer', $customer->customer_id) }}"
                                    method="post">
                                    @method('put')
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="customer_name">Customer Name</label>
                                                    <input type="text" name="customer_name" class="form-control"
                                                        id="name" placeholder="Enter customer name" autocomplete="off"
                                                        value="{{ $customer->customer_name }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="mobile_no">Mobile No.*</label>
                                                    <input type="number" name="mobile_no" class="form-control"
                                                        id="mobile_no" placeholder="Enter Mobile Number"
                                                        value="{{ $customer->customer_phone }}" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="residence">Residence</label>
                                                    <input type="text" name="residence" class="form-control"
                                                        id="residence" placeholder="Enter residence"
                                                        value="{{ $customer->residence }}" autocomplete="on" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="branch_id">Branch</label>
                                                    <select name="branch" id="branch" class="form-control select2"
                                                        id="branch_id" required>
                                                        <option class="mb-1" value="{{ $customer->branch_id }}">
                                                            {{ $customer->branch_name }}</option>
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
                                                        <option class="mb-1" value="{{ $customer->outpost_id }}">
                                                            {{ $customer->outpost_name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="users">Users</label>
                                                    <select name="user_id" id="users" class="form-control select2"
                                                        id="user_id" required>
                                                        <option class="mb-1" value="{{ $customer->officer_id }}">
                                                            {{ $customer->officer_name }}</option>
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
                                                        value="{{ $customer->business }}" autocomplete="on" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label for="message">Message</label>
                                                    <textarea class="form-control" name="message" id="message" cols="4" rows="3"
                                                        placeholder="Enter customer message" autocomplete="on" required>{{ $customer->customer_message }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="submit" class="btn btn-primary"> <i class="fa fa-user-edit"></i>
                                            Update Customer Data</button>
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
