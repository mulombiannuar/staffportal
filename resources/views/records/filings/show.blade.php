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
                                    class="fa fa-edit"></i>
                                Update File Details</a></li>

                        <li class="nav-item"><a class="nav-link" target="_blank"
                                href="{{ route('records.filing-labels.sticker', $file->label_id) }}"><i
                                    class="fa fa-print"></i>
                                Print File Sticker</a></li>
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
                                    <table id="table1" width="100%"
                                        class="table table-sm table-bordered table-hover table-head-fixed ">
                                        <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>NAMES</th>
                                                <th>BR ID</th>
                                                <th>MOBILE</th>
                                                <th>NATIONAL ID</th>
                                                <th>BRANCH</th>
                                                <th>OUTPOST</th>
                                                @if ($file->file_type == 7)
                                                    <th>DATE CHANGED</th>
                                                    <th>VIEW LOAN</th>
                                                @else
                                                    <th>PRODUCT</th>
                                                    <th>AMOUNT</th>
                                                    <th>DISBURSMENT DATE</th>
                                                    <th>VIEW LOAN</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($loan_forms as $form)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $form->client_name }}</td>
                                                    <td>{{ $form->bimas_br_id }}</td>
                                                    <td>{{ $form->client_phone }}</td>
                                                    <td>{{ $form->national_id }}</td>
                                                    <td>{{ $form->branch_name }}</td>
                                                    <td>{{ $form->outpost_name }}</td>
                                                    @if ($file->file_type == 7)
                                                        <td>{{ $form->date_changed }}</td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="{{ route('records.change-forms.show', $form->form_id) }}"
                                                                    title="Click to view details">
                                                                    <button type="button" class="btn btn-xs btn-info"><i
                                                                            class="fa fa-eye"></i>
                                                                        View</button>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    @else
                                                        <td>{{ $form->product_name }}</td>
                                                        <td>{{ $form->amount }}</td>
                                                        <td>{{ $form->disbursment_date }}</td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="{{ route('records.loan-forms.show', $form->form_id) }}"
                                                                    title="Click to view details">
                                                                    <button type="button" class="btn btn-xs btn-info"><i
                                                                            class="fa fa-eye"></i>
                                                                        View</button>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
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
