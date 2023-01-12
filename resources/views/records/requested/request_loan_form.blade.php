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
                                <form action="{{ route('user.loan-forms.request-loan') }}" method="post">
                                    <input type="hidden" name="branch" value="{{ $user->branch_id }}">
                                    <input type="hidden" name="outpost" value="{{ $user->outpost_id }}">
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="client_name">Client Name</label>
                                                    <input type="text" name="client_name" class="form-control"
                                                        id="name" placeholder="Enter client name" autocomplete="off"
                                                        value="{{ old('client_name') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="client_phone">Mobile No.</label>
                                                    <input type="number" name="client_phone" class="form-control"
                                                        id="client_phone" placeholder="Mobile Number e.g 254701111700"
                                                        value="{{ old('client_phone') }}" autocomplete="off" required
                                                        onKeyPress="if(this.value.length==12) return false;" minlength="12"
                                                        maxlength="12">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="bimas_br_id">Bimas BR ID</label>
                                                    <input type="number" name="bimas_br_id" class="form-control"
                                                        id="bimas_br_id" placeholder="Enter bimas client ID e.g 0108981"
                                                        value="{{ old('bimas_br_id') }}" autocomplete="on"
                                                        onKeyPress="if(this.value.length==7) return false;" minlength="7"
                                                        maxlength="7" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="national_id">National ID</label>
                                                    <input type="number" name="national_id" class="form-control"
                                                        id="national_id" placeholder="Enter National ID"
                                                        value="{{ old('national_id') }}" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="product">Loan Product</label>
                                                    <select name="product" id="product" class="form-control select2"
                                                        id="product" required>
                                                        <option class="mb-1" value="">
                                                            - Select Loan Product -</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->product_id }}">
                                                                {{ $product->product_code . ' - ' . $product->product_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="amount">Loan Amount</label>
                                                    <input type="number" name="amount" class="form-control" id="amount"
                                                        placeholder="Loan Amount" value="{{ old('amount') }}"
                                                        autocomplete="off" required>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="disbursment_date">Disbursment Date</label>
                                                    <input type="date" name="disbursment_date" class="form-control"
                                                        id="name" placeholder="Disbursment date" autocomplete="off"
                                                        value="{{ old('disbursment_date') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label for="officer_message">Officer message</label>
                                                    <textarea class="form-control" name="officer_message" id="officer_message" cols="4" rows="2"
                                                        placeholder="Enter your message here" autocomplete="on" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="submit" class="btn btn-primary"> <i class="fa fa-user-plus"></i>
                                            Request Loan Form</button>
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
