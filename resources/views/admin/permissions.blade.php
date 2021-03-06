@extends('layouts.admin.table')

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="margin mb-2 text-right">
            <button type="button" data-toggle="modal" data-target="#modalAddpermission" class="btn btn-primary"><i
                    class="fa fa-plus"></i> Add New System
                Permission</button>
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
                            <th>NAMES</th>
                            <th>DESCRIPTION</th>
                            <th>CREATED AT</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $permission->name }}</strong></td>
                            <td>{{ $permission->description }}</td>
                            <td>{{ $permission->created_at }}</td>
                            <td>
                                <div class="margin">
                                    <div class="btn-group">
                                        <button type="button" data-toggle="modal"
                                            data-target="#modalEditpermission-{{ $permission->id }}"
                                            class="btn btn-xs btn-warning"><i class="fa fa-edit"></i>
                                            Edit</button>
                                    </div>
                                    <div class="btn-group">
                                        <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="post"
                                            onclick="return confirm('Do you really want to delete this permission with all its relationships?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger"><i
                                                    class="fa fa-trash"></i>
                                                Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <!--/.modal begin -->
                            <div class="modal fade" id="modalEditpermission-{{ $permission->id }}" style="display: none;"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Update permission</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">??</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.permissions.update', $permission->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputText1">permission Name</label>
                                                            <input type="text" name="name" class="form-control"
                                                                id="exampleInputText1"
                                                                placeholder="Enter permission name e.g administrator"
                                                                autocomplete="on" value="{{ $permission->name }}" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Description</label>
                                                            <textarea name="description" id="textaArea"
                                                                class="form-control" cols="4"
                                                                rows="3">{{ $permission->description }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-info"><i class="fa fa-edit"></i>
                                                    Update
                                                    permission</button>
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
                <div class="modal fade" id="modalAddpermission" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Add New System permission</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">??</span>
                                </button>
                            </div>
                            <form action="{{ route('admin.permissions.store') }}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                           <div class="form-group">
                                               <label for="exampleInputText1">Permission Roles</label>
                                               <select name="role" id="role" class="form-control"
                                                   id="exampleFormControlSelect1" required>
                                                   <option class="mb-1" value="">
                                                       - Select Permission Role -</option>
                                                       @foreach ($roles as $role)
                                                   <option value="{{ $role->id }}">{{ ucwords($role->name) }}</option>
                                                   @endforeach
                                               </select>
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="exampleInputText1">Permission Name</label>
                                                <input type="text" name="name" class="form-control"
                                                    id="exampleInputText1" autocomplete="off"
                                                    placeholder="Enter permission name e.g branchmanager.edit.permission" autocomplete="on"
                                                    required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Description</label>
                                                <textarea name="description" id="textaArea" class="form-control"
                                                    cols="4" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-info"><i class="fa fa-plus"></i> Add
                                        New permission</button>
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