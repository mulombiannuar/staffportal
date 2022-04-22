@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-sm-6">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ asset('assets/images/users/' . $user->profile->user_image) }}"
                                    alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ $user->name }}</h3>

                            <p class="text-muted text-center">{{ $user->email }}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>MOBILE </b> <a class="float-right">{{ $user->mobile_no }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>D.O.B</b> <a class="float-right">{{ $user->birth_date }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>OUTPOST</b> <a class="float-right">{{ $user->outpost_name }}</a>
                                </li>
                            </ul>

                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-block"><b><i
                                        class="fa fa-edit"></i> Edit
                                    Details</b></a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-3"></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-warning card-outline">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab"><i
                                            class="fa fa-user"></i> Profile</a></li>
                                <li class="nav-item"><a class="nav-link" href="#groups" data-toggle="tab"><i
                                            class="fa fa-users"></i>
                                        Groups</a></li>
                                <li class="nav-item"><a class="nav-link" href="#transactions"
                                        data-toggle="tab"><i class="fa fa-list-alt"></i> Transactions</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="profile">
                                    <!-- Profile -->
                                    <div class="card card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fa fa-user"></i> Profile</h3>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-sm table-striped">
                                                <tr>
                                                    <th>NAME : </th>
                                                    <td>{{ $user->name }}</td>
                                                    <th>NATIONAL ID</th>
                                                    <td>{{ $user->national_id }}</td>
                                                </tr>
                                                <tr>
                                                    <th>DATE/BIRTH</th>
                                                    <td>{{ $user->birth_date }}</td>
                                                    <th>MOBILE NO : </th>
                                                    <td>{{ $user->mobile_no }}</td>
                                                </tr>
                                                <tr>
                                                    <th>EMAIL</th>
                                                    <td>{{ $user->email }}</td>
                                                    <th>GENDER : </th>
                                                    <td>{{ $user->gender }}</td>
                                                </tr>
                                                <tr>
                                                    <th>RELIGION : </th>
                                                    <td>{{ $user->religion }}</td>
                                                    <th>ADDRESS : </th>
                                                    <td>{{ $user->address }}</td>
                                                </tr>
                                                <tr>
                                                    <th>COUNTY : </th>
                                                    <td>{{ $user->county_name }}</td>
                                                    <th>SUB COUNTY : </th>
                                                    <td>{{ $user->sub_name }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.Profile -->
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="groups">
                                    <!-- documents -->
                                    <div class="card card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fa fa-users"></i> Officer Groups</h3>
                                        </div>
                                        <div class="card-body">
                                            <table id="table1"
                                                class="table table-sm table-bordered table-striped table-head-fixed">
                                                <thead>
                                                    <tr>
                                                        <th>SN</th>
                                                        <th>Group Name</th>
                                                        <th>Group Code</th>
                                                        <th>CBS Account ID</th>
                                                        <th>Branch</th>
                                                        <th>Officer</th>
                                                        <th>Date Created</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($groups as $group)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $group->GroupName }}</td>
                                                            <td>{{ $group->GroupID }}</td>
                                                            <td>{{ $group->GroupCollectionAccountID }}</td>
                                                            <td>{{ $group->branch_name }}</td>
                                                            <td>{{ $group->Officer1 }}</td>
                                                            <td>{{ $group->CreatedOn }}</td>
                                                            <td>
                                                                <div class="margin">
                                                                    <div class="btn-group">
                                                                        <a href="{{ route('admin.groups.show', $group->GroupID) }}"
                                                                            title="Click to group details">
                                                                            <button type="button"
                                                                                class="btn btn-xs btn-info"><i
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
                                    </div>
                                    <!-- documents -->
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="transactions">
                                    <!-- roles user -->
                                    <div class="card card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fa fa-list-alt"></i> Transactions</h3>
                                        </div>
                                        <div class="card-body">
                                            Transactions
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- roles user -->
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
