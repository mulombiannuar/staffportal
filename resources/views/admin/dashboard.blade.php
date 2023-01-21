@extends('layouts.admin.dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @include('layouts.admin.incls.page-header')
        <!-- Main content -->
        <section class="content">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> Dashboard Items</h3>
                </div>
                <div class="card-body">
                    <div class="container-fluid">

                        @if (Auth::user()->hasRole('admin'))
                            <!-- ADMIN ROLE Small boxes (Stat box) -->
                            <div class="row">
                                <div class="col-lg-3 col-6 col-sm-12">
                                    <!-- small box -->
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3>{{ $stats['messages'] }}</h3>

                                            <p>Messages</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-envelope"></i>
                                        </div>
                                        <a href="{{ route('admin.messages.index') }}" class="small-box-footer">More info <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-6 col-sm-12">
                                    <!-- small box -->
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3>{{ $stats['trails'] }}</h3>

                                            <p>Audit Trails</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-stats-bars"></i>
                                        </div>
                                        <a href="{{ route('admin.audit.index') }}" class="small-box-footer">More info <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-6 col-sm-12">
                                    <!-- small box -->
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3>{{ $stats['users'] }}</h3>

                                            <p>User Registrations</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-person-add"></i>
                                        </div>
                                        <a href="{{ route('admin.users.index') }}" class="small-box-footer">More info <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-6 col-sm-12">
                                    <!-- small box -->
                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <h3>{{ $stats['roles'] }}</h3>

                                            <p>User Roles</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-pie-graph"></i>
                                        </div>
                                        <a href="{{ route('admin.roles.index') }}" class="small-box-footer">More info <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-6 col-sm-12">
                                    <!-- small box -->
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <p>Budget Templates</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <a href="{{ route('admin.budgets.index') }}" class="small-box-footer">More info <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-6 col-sm-12">
                                    <!-- small box -->
                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <p>Customers Module</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <a href="{{ route('customers.campaigns.index') }}" class="small-box-footer">More
                                            info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6 col-sm-12">
                                    <!-- small box -->
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <p>Assets Management</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-mobile"></i>
                                        </div>
                                        <a href="{{ route('admin.assets.index') }}" class="small-box-footer">More info <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->

                                <div class="col-lg-3 col-6 col-sm-12">
                                    <!-- small box -->
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <p>Bidding Shop</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-motorcycle"></i>
                                        </div>
                                        <a href="{{ route('shop.products.index') }}" class="small-box-footer">More info <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-6 col-sm-12">
                                    <!-- small box -->
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <p>Staff CVP Data</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <a href="{{ route('admin.packages.index') }}" class="small-box-footer">More info <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-6 col-sm-12">
                                    <!-- small box -->
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <p>Insurance Policies</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-list-alt"></i>
                                        </div>
                                        <a href="{{ route('admin.insurances.index') }}" class="small-box-footer">More info
                                            <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-6 col-sm-12">
                                    <!-- small box -->
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <p>Claim Expenses</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-list-alt"></i>
                                        </div>
                                        <a href="{{ route('user.expenses.claims') }}" class="small-box-footer">More info <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-6 col-sm-12">
                                    <!-- small box -->
                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <p>Branch Customers</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <a href="{{ route('customers.branch_customers') }}" class="small-box-footer">More
                                            info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-6 col-sm-12">
                                    <!-- small box -->
                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <p>Records Dashboard</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <a href="{{ route('records.index') }}" class="small-box-footer">More
                                            info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                            </div>
                            <!-- /.row -->
                        @else
                            <div class="row">
                                <div class="col-lg-3 col-6 col-sm-12">
                                    <!-- small box -->
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <p>Assigned Assets</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-mobile"></i>
                                        </div>
                                        <a href="{{ route('user.assets') }}" class="small-box-footer">More info <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-6 col-sm-12">
                                    <!-- small box -->
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <p>Budget Templates</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <a href="{{ route('user.budgets') }}" class="small-box-footer">More info <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-6 col-sm-12">
                                    <!-- small box -->
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <p>Bidding Shop</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-motorcycle"></i>
                                        </div>
                                        <a href="{{ route('shop.products.index') }}" class="small-box-footer">More info
                                            <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-6 col-sm-12">
                                    <!-- small box -->
                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <p>Branch Customers</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <a href="{{ route('customers.branch_customers') }}" class="small-box-footer">More
                                            info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-6 col-sm-12">
                                    <!-- small box -->
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <p>User Guide</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-book"></i>
                                        </div>
                                        <a href="https://drive.google.com/file/d/1FMjmZ6QIQXSSK75os4_PnQywkf7ZErTe/view?usp=sharing"
                                            target="_blank" class="small-box-footer">More info <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-6 col-sm-12">
                                    <!-- small box -->
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <p>Loan Forms</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-list-alt"></i>
                                        </div>
                                        <a href="{{ route('user.loan-forms.view') }}" class="small-box-footer">More info
                                            <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-6 col-sm-12">
                                    <!-- small box -->
                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <p>Change Details Forms</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <a href="{{ route('user.change-forms.view') }}" class="small-box-footer">More
                                            info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                            </div>
                        @endif
                    </div><!-- /.container-fluid -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
