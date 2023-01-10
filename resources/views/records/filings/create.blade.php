@extends('layouts.admin.form')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> {{ $title }}</h3>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <form action="{{ route('records.filing-labels.store') }}" method="post">
                                    <input type="hidden" name="file_type" value="{{ $filingType->type_id }}">
                                    @csrf
                                    <div class="modal-body">
                                        @for ($i = $beginningNumber; $i < $beginningNumber + $number; $i++)
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        {{-- @if ($i == 1)
                                                            <label for="file_label">File Label</label>
                                                        @endif --}}
                                                        <input type="text" name="file_label[]" class="form-control"
                                                            id="name" placeholder="Enter file label" autocomplete="on"
                                                            value="{{ $label }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        {{-- @if ($i == 1)
                                                            <label for="client_phone">File Number</label>
                                                        @endif --}}
                                                        <input type="number" name="file_number[]" class="form-control"
                                                            id="file_number" placeholder="File number"
                                                            value="{{ $i }}" autocomplete="on" required>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="submit" class="btn btn-secondary"> <i class="fa fa-user-plus"></i>
                                            Add New {{ $filingType->type_name }} Files</button>
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
