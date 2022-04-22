@extends('layouts.admin.dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @include('layouts.admin.incls.page-header')
        <!-- Main content -->
        <section class="content">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> Assets Dashboard</h3>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-desktop"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Assets Types</span>
                                        <span class="info-box-number">
                                            {{ $stats['types'] }}
                                        </span>
                                        <a href="{{ route('admin.assets.categories') }}" class="small-box-footer">More
                                            info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-calendar"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Maintenance Schedules</span>
                                        <span class="info-box-number">{{ $stats['logs'] }}</span>
                                        <a href="{{ route('admin.logs.index') }}" class="small-box-footer">More info <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->

                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Assets Repairs Data</span>
                                        <span class="info-box-number">{{ $stats['repairs'] }}</span>
                                        <a href="{{ route('admin.repairs.index') }}" class="small-box-footer">More info <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->

                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-success elevation-1"><i
                                            class="fas fa-shopping-cart"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Branch Assets</span>
                                        <span class="info-box-number">760</span>
                                        <a href="#" class="small-box-footer">More info <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->

                        </div>

                    </div><!-- /.container-fluid -->
                </div>
            </div>
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-motorcycle"></i> Motors Maintenance</h3>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-danger elevation-1"><i
                                            class="fa fa-motorcycle"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text b">Motors
                                            ({{ $stats['motors'] }})</span>
                                        <a href="{{ route('admin.assets.show', 'motors') }}" class="small-box-footer">More
                                            info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-primary elevation-1"><i
                                            class="fas fa-credit-card"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Driving Licenses ({{ $stats['licenses'] }})</span>
                                        <a href="{{ route('admin.licenses.index') }}" class="small-box-footer">More info
                                            <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->

                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-success elevation-1"><i
                                            class="fas fa-calendar"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Maintenances ({{ $stats['motors_logs'] }})</span>
                                        <a href="{{ route('admin.motor-logs.index') }}" class="small-box-footer">More
                                            info
                                            <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->

                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-warning elevation-1"><i
                                            class="fas fa-ambulance"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Insurance Data (12)</span>
                                        <a href="#" class="small-box-footer">More info
                                            <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->

                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-list"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Fuels Consumptions
                                            ({{ $stats['fuels'] }})</span>
                                        <a href="{{ route('admin.fuels.index') }}" class="small-box-footer">More info
                                            <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->

                        </div>

                    </div><!-- /.container-fluid -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
