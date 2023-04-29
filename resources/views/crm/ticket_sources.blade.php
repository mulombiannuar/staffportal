@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="margin mb-2 text-right">
                <button type="button" data-toggle="modal" data-target="#modeAddSource" class="btn btn-primary"><i
                        class="fa fa-plus"></i> Add New Ticket Source</button>
            </div>

            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> {{ $title }}</h3>
                </div>
                <div class="card-body">
                    <table id="table1" class="table table-sm table-striped table-bordered table-head-fixed">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>SOURCE NAMES</th>
                                <th>CREATED AT</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sources as $source)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ $source->source_name }}</strong></td>
                                    <td>{{ $source->created_at }}</td>
                                    <td>
                                        <div class="margin">
                                            <div class="btn-group">
                                                <button type="button" data-toggle="modal"
                                                    data-target="#modalEditSource-{{ $source->source_id }}"
                                                    class="btn btn-xs btn-warning"><i class="fa fa-edit"></i>
                                                    Edit</button>
                                            </div>
                                            @if ($source->editable)
                                                <div class="btn-group">
                                                    <form
                                                        action="{{ route('crm.ticket-sources.destroy', $source->source_id) }}"
                                                        method="post"
                                                        onclick="return confirm('Do you really want to delete this source with all its relationships?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-xs btn-danger"><i
                                                                class="fa fa-trash"></i>
                                                            Delete</button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <!--/.modal begin -->
                                    <div class="modal fade" id="modalEditSource-{{ $source->source_id }}"
                                        style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Update Source</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('crm.ticket-sources.update', $source->source_id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="source_name">Source Name</label>
                                                                    <input type="text" name="source_name"
                                                                        class="form-control" id="source_name"
                                                                        autocomplete="off"
                                                                        placeholder="Enter source name e.g Facebook posts comment"
                                                                        autocomplete="on" value="{{ $source->source_name }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-info"><i
                                                                class="fa fa-edit"></i>
                                                            Update
                                                            Source</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!--/modal end -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!--/.modal begin -->
                    <div class="modal fade" id="modeAddSource" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add New Ticket Source</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <form action="{{ route('crm.ticket-sources.store') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="source_name">Category Name</label>
                                                    <input type="text" name="source_name" class="form-control"
                                                        id="source_name" autocomplete="off"
                                                        placeholder="Enter source name e.g Facebook post comment"
                                                        autocomplete="on" value="{{ old('source_name') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-info"><i class="fa fa-plus"></i> Add
                                            New Source</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!--/modal end -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
