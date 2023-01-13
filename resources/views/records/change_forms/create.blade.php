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
                                <form action="{{ route('records.change-forms.store') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-4">
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
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="outposts">Outpost</label>
                                                    <select name="outpost_id" class="form-control select2" id="outposts"
                                                        required>
                                                        <option class="mb-1" value="">
                                                            - Select Branch First -</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="client_id">Clients</label>
                                                    <select name="clients" class="form-control select2" id="users"
                                                        required>
                                                        <option class="mb-1" value="">
                                                            - Select Outpost First -</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="file_label">Filing Type</label>
                                                    <select name="file_label" class="form-control select2" required>
                                                        <option class="mb-1" value="">
                                                            - Select File Label -</option>
                                                        @foreach ($filing_labels as $label)
                                                            <option value="{{ $label->label_id }}">
                                                                {{ $label->file_label . $label->file_number }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="date_changed">Date Changed</label>
                                                    <input type="date" name="date_changed" class="form-control"
                                                        id="date_changed" placeholder="date changed" autocomplete="off"
                                                        value="{{ old('date_changed') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="change_form">Change Form (PDF Only)</label>
                                                    <input type="file" name="change_form" accept=".pdf"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="submit" class="btn btn-secondary"> <i class="fa fa-user-plus"></i>
                                            Add New Change Form</button>
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
        });
    </script>
@endpush
