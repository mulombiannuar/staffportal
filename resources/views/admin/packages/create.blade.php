@extends('layouts.admin.form')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-user-plus"></i> {{ $title }} :
                        {{ $product->name }}</h3>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <form action="{{ route('admin.packages.store') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="packages">Packages</label>
                                                    <select name="package" id="packages" class="form-control select2"
                                                        id="packages" required>
                                                        <option class="mb-1" value="">
                                                            - Select {{ ucwords($product->type) }} -</option>
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
                                                    <input type="hidden" name="product"
                                                        value="{{ $product->product_id }}">
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
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="outposts">Outpost</label>
                                                    <select name="outpost_id" class="form-control select2" id="outposts"
                                                        required>
                                                        <option class="mb-1" value="">
                                                            - Select Branch First -</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
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
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="submit" class="btn btn-primary"> <i class="fa fa-user-plus"></i>
                                            Add User to {{ ucwords($product->type) }} List</button>
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
    @if ($product->product_id == 1 || $product->product_id == 3)
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
    @endif

    @if ($product->product_id == 2 || $product->product_id == 4)
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
    @endif

    @if ($product->product_id == 5)
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
                            url: "{{ route('get.modemusers') }}",
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
    @endif
@endpush
