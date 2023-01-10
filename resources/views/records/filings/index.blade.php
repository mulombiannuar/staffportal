@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card card-warning card-outline">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    @foreach ($filing_types as $type)
                        <li class="nav-item"><a class="nav-link {{ $loop->iteration == 1 ? 'active' : '' }}"
                                href="#tab-{{ $type->type_id }}" data-toggle="tab"><i class="fa fa-list-alt"></i>
                                {{ $type->type_name }} ({{ $type->count }})</a></li>
                    @endforeach
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    @foreach ($filing_types as $type)
                        <div class="tab-pane {{ $loop->iteration == 1 ? 'active' : '' }}" id="tab-{{ $type->type_id }}">
                            <!-- Tab content -->
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fa fa-list-alt"></i> {{ $type->type_name }} Files</h3>
                                    <div class="text-right">
                                        <button type="button" data-toggle="modal"
                                            data-target="#modalAddLabels-{{ $type->type_id }}"
                                            class="btn btn-sm btn-secondary"><i class="fa fa-plus-circle"></i> Add New
                                            Record File</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="table{{ $loop->iteration }}"
                                        class="table table-sm table-bordered table-hover table-head-fixed">
                                        <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>FILING TYPE</th>
                                                <th>FILE LABEL</th>
                                                <th>FORMS COUNT</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($type->labels as $label)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ strtoupper($type->type_name) }}</td>
                                                    <td><strong>{{ $label->file_label . $label->file_number }}</strong>
                                                    </td>
                                                    <td>{{ $label->count }}</td>
                                                    <td>
                                                        <div class="margin">
                                                            <div class="btn-group">
                                                                <a
                                                                    href="{{ route('records.filing-labels.show', $label->label_id) }}">
                                                                    <button type="button" class="btn btn-xs btn-info"><i
                                                                            class="fa fa-bars"></i>
                                                                        View File</button>
                                                                </a>
                                                            </div>
                                                            <div class="btn-group">
                                                                <form
                                                                    action="{{ route('records.filing-labels.destroy', $label->label_id) }}"
                                                                    method="post"
                                                                    onclick="return confirm('Do you really want to delete this file? Note that you wont be able to delete if it contains loan forms')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-xs btn-danger"
                                                                        @if ($label->count > 0) disabled @endif><i
                                                                            class="fa fa-trash"></i>
                                                                        Delete File</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.Tab content -->

                            <!--/.modal begin -->
                            <div class="modal fade" id="modalAddLabels-{{ $type->type_id }}" style="display: none;"
                                aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Add Files : {{ $type->type_name }}</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('records.filing-labels.create') }}" method="GET">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="start_date">File Label</label>
                                                            <input type="hidden" name="file_type"
                                                                value="{{ $type->type_id }}">
                                                            <input type="text" name="label" class="form-control"
                                                                id="label" placeholder="File label e.g CASH"
                                                                autocomplete="on" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="start_date">Number of Files</label>
                                                            <input type="number" name="number" class="form-control"
                                                                id="number" placeholder="Number of files e.g 30"
                                                                autocomplete="on" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-secondary"><i
                                                        class="fa fa-plus-circle"></i>
                                                    Proceed to Add</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!--/modal end -->
                        </div>
                        <!-- /.tab-pane -->
                    @endforeach
                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- /.nav-tabs-custom -->
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
