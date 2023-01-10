@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning card-outline">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#loan-forms" data-toggle="tab"><i
                                    class="fa fa-list"></i>
                                File Loan Forms</a></li>
                        <li class="nav-item"><a class="nav-link " href="#details" data-toggle="tab"><i
                                    class="fa fa-bars"></i>
                                File Details</a></li>

                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="loan-forms">
                            <!-- documents -->
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fa fa-list"></i> File Loan Forms</h3>
                                </div>
                                <div class="card-body">
                                    <table id="table1"
                                        class="table table-sm table-bordered table-hover table-head-fixed table-responsive">
                                        <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>NAMES</th>
                                                <th>BR ID</th>
                                                <th>MOBILE</th>
                                                <th>NATIONAL ID</th>
                                                <th>BRANCH</th>
                                                <th>OUTPOST</th>
                                                <th>PRODUCT</th>
                                                <th>AMOUNT</th>
                                                <th>DISBURSMENT DATE</th>
                                                <th>VIEW LOAN</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- documents -->
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane " id="details">
                            <!-- Details -->
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fa fa-bars"></i>
                                        {{ $file->file_label . $file->file_number }}</h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('records.filing-labels.update', $file->label_id) }}"
                                        method="post">
                                        <input type="hidden" name="label_id" value="{{ $file->label_id }}">
                                        @method('PUT')
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="file_label">File Label</label>
                                                        <input type="text" name="file_label" class="form-control"
                                                            id="name" placeholder="Enter file label" autocomplete="on"
                                                            value="{{ $file->file_label }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="client_phone">File Number</label>
                                                        <input type="number" name="file_number" class="form-control"
                                                            id="file_number" placeholder="File number"
                                                            value="{{ $file->file_number }}" autocomplete="on" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="submit" class="btn btn-secondary"> <i class="fa fa-edit"></i>
                                                Update File Details</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.Details -->
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
