@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card card-warning card-outline">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#change-form" data-toggle="tab"><i
                                class="fa fa-list-alt"></i>
                            Change Form Attachment</a></li>
                    <li class="nav-item"><a class="nav-link" href="#details" data-toggle="tab"><i class="fa fa-edit"></i>
                            Change Form Details</a></li>
                    <li class="nav-item"><a class="nav-link" href="#requests" data-toggle="tab"><i class="fa fa-users"></i>
                            Officers Requests ({{ count($change_forms) }})</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="change-form">
                        <!-- Profile -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-list-alt"></i> Change Form Attachment</h3>
                            </div>
                            <div class="card-body">
                                <object data="{{ asset('storage/assets/change-forms/' . $change_form->file_name) }}"
                                    type="application/pdf" width="100%" height="600px">
                                </object>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.Profile -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="details">
                        <!-- documents -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-edit"></i> form Form Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="branch_id">Branch</label>
                                            <input type="text" class="form-control"
                                                value="{{ $change_form->branch_name }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="outposts">Outpost</label>
                                            <input type="text" class="form-control"
                                                value="{{ $change_form->outpost_name }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="client_id">Client</label>
                                            <input type="text" class="form-control"
                                                value="{{ $change_form->client_name }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="file_label">File Labels</label>
                                            <input type="text" class="form-control"
                                                value="{{ $change_form->file_label . $change_form->file_number }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="date_changed">Date Changed</label>
                                            <input type="date" name="date_changed" class="form-control" id="date_changed"
                                                placeholder="date changed" autocomplete="off"
                                                value="{{ $change_form->date_changed }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- documents -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="requests">
                        <!-- Profile -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-users"></i> Officers Requests</h3>
                            </div>
                            <div class="card-body">
                                <table id="table1" class="table table-sm table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>REFERENCE</th>
                                            <th>NAMES</th>
                                            <th>BR ID</th>
                                            <th>OUTPOST</th>
                                            <th>DATE REQUESTED</th>
                                            <th>REQUESTED BY</th>
                                            <th>PRODUCT CODE</th>
                                            <th>AMOUNT</th>
                                            <th>DISBURSMENT DATE</th>
                                            <th>VIEW</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($change_forms as $form)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $form->reference }}</td>
                                                <td>{{ $form->client_name }}</td>
                                                <td>{{ $form->bimas_br_id }}</td>
                                                <td>{{ $form->outpost_name }}</td>
                                                <td>{{ $form->date_requested }}</td>
                                                <td>{{ $form->name }}</td>
                                                <td>{{ $form->product_code }}</td>
                                                <td>{{ $form->amount }}</td>
                                                <td>{{ $form->disbursment_date }}</td>
                                                <td>
                                                    <div class="margin">
                                                        <div class="btn-group">
                                                            <a href="{{ route('records.requested-forms.show', $form->request_id) }}"
                                                                title="Click to view details">
                                                                <button type="button" class="btn btn-xs btn-info"><i
                                                                        class="fa fa-eye"></i>
                                                                    View</button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <!-- /.card-body -->
                        </div>
                        <!-- /.Profile -->
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- /.nav-tabs-custom -->
    </section>
    <!-- /.content -->
@endsection
