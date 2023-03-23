@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="margin mb-2 text-right">
                <button type="button" data-toggle="modal" data-target="#modeAddCategory" class="btn btn-primary"><i
                        class="fa fa-plus"></i> Add New Ticket Category</button>
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
                                <th>CATEGORY NAMES</th>
                                <th>MESSAGE TEMPLATES</th>
                                <th>CNT</th>
                                {{-- <th>CREATED AT</th> --}}
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ $category->category_name }}</strong></td>
                                    <td>{{ $category->message_template }}</td>
                                    <td>{{ $category->count }}</td>
                                    {{-- <td>{{ $category->created_at }}</td> --}}
                                    <td>
                                        <div class="margin">
                                            <div class="btn-group">
                                                <a href="{{ route('crm.ticket-categories.show', $category->category_id) }}"
                                                    title="Click to view ticket details">
                                                    <button type="button" class="btn btn-xs btn-secondary"><i
                                                            class="fa fa-bars"></i>
                                                        View Tickets</button>
                                                </a>
                                            </div>

                                            <div class="btn-group">
                                                <button type="button" data-toggle="modal"
                                                    data-target="#modalEditcategory-{{ $category->category_id }}"
                                                    class="btn btn-xs btn-warning"><i class="fa fa-edit"></i>
                                                    Edit</button>
                                            </div>
                                            @if ($category->editable)
                                                @if ($category->count == 0)
                                                    <div class="btn-group">
                                                        <form
                                                            action="{{ route('crm.ticket-categories.destroy', $category->category_id) }}"
                                                            method="post"
                                                            onclick="return confirm('Do you really want to delete this category with all its relationships?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-xs btn-danger"><i
                                                                    class="fa fa-trash"></i>
                                                                Delete</button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <button disabled type="submit"
                                                        title="Cannot delete this category since it has active tickets"
                                                        class="btn btn-xs btn-danger"><i class="fa fa-trash"></i>
                                                        Delete</button>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                    <!--/.modal begin -->
                                    <div class="modal fade" id="modalEditcategory-{{ $category->category_id }}"
                                        style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Update Category</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form
                                                    action="{{ route('crm.ticket-categories.update', $category->category_id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="category_name">Category Name</label>
                                                                    <input type="text" name="category_name"
                                                                        class="form-control" id="category_name"
                                                                        autocomplete="off"
                                                                        placeholder="Enter category name e.g Clients complaints"
                                                                        autocomplete="on"
                                                                        {{ !$category->editable ? 'readonly' : '' }}
                                                                        value="{{ $category->category_name }}" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="message_template">Description</label>
                                                                    <textarea name="message_template" id="message_template" class="form-control" cols="4" rows="3">{{ $category->message_template }}</textarea>
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
                                                            Category</button>
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
                    <div class="modal fade" id="modeAddCategory" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add New Ticket category</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <form action="{{ route('crm.ticket-categories.store') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="category_name">Category Name</label>
                                                    <input type="text" name="category_name" class="form-control"
                                                        id="category_name" autocomplete="off"
                                                        placeholder="Enter category name e.g Clients complaints"
                                                        autocomplete="on" value="{{ old('category_name') }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="message_template">Category Message Template</label>
                                                    <textarea name="message_template" id="message_template" placeholder="Enter message template to be send to customers"
                                                        class="form-control" cols="4" rows="3">{{ old('message_template') }} </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-info"><i class="fa fa-plus"></i> Add
                                            New Category</button>
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
