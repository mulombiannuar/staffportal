@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> {{ $title }}</h3>
                </div>
                <div class="card-body">
                    <table id="table1" class="table table-sm table-striped table-bordered table-head-fixed">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>BRANCH NAME</th>
                                <th>OUPOST NAME</th>
                                <th>OFFICE NUMBER</th>
                                <th>OFFICE EMAIL</th>
                                <th>LOCATION ADDRESS</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($branches as $branch)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ strtoupper($branch->branch_name) }}</strong></td>
                                    <td>{{ $branch->outpost_name }}</td>
                                    <td>{{ $branch->office_number }}</td>
                                    <td><strong>{{ $branch->outpost_email }}</strong></td>
                                    <td>{{ $branch->physical_location }}</td>
                                    <td>
                                        <div class="margin">
                                            <div class="btn-group">
                                                <button type="button" data-toggle="modal"
                                                    data-target="#modalEditBranch-{{ $branch->outpost_id }}"
                                                    class="btn btn-xs btn-warning"><i class="fa fa-edit"></i>
                                                    Edit</button>
                                            </div>
                                        </div>
                                    </td>
                                    <!--/.modal begin -->
                                    <div class="modal fade" id="modalEditBranch-{{ $branch->outpost_id }}"
                                        style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Update Branch</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.branches.update', $branch->outpost_id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="exampleInputText1">Branch Name</label>
                                                                    <input type="text" class="form-control"
                                                                        id="exampleInputText1" autocomplete="on"
                                                                        value="{{ $branch->outpost_name }}" readonly
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="office_number">Office Number</label>
                                                                    <input type="text" class="form-control"
                                                                        id="office_number" name="office_number"
                                                                        autocomplete="on"
                                                                        value="{{ $branch->office_number }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="outpost_email">Office Email</label>
                                                                    <input type="email" class="form-control"
                                                                        id="outpost_email" name="outpost_email"
                                                                        autocomplete="on"
                                                                        value="{{ $branch->outpost_email }}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="physical_location">Physical Address</label>
                                                                    <input type="text" class="form-control"
                                                                        id="physical_location" name="physical_location"
                                                                        autocomplete="on"
                                                                        value="{{ $branch->physical_location }}" required>
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
                                                            Branch</button>
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
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
