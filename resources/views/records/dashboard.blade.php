@extends('layouts.admin.dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @include('layouts.admin.incls.page-header')
        <!-- Main content -->
        <section class="content">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> Records Dashboard</h3>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-users"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Records Clients</span>
                                        <span class="info-box-number">
                                            {{ $clients }}
                                        </span>
                                        <a href="{{ route('records.clients.index') }}" class="small-box-footer">More
                                            info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-users"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Active Clients Loans</span>
                                        <span class="info-box-number">{{ $loans }}</span>
                                        <a href="{{ route('records.client-loans') }}" class="small-box-footer">More
                                            info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            @if (Auth::user()->hasRole('admin|records'))
                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-danger elevation-1"><i
                                                class="fas fa-calendar"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Clients Change Forms</span>
                                            <span class="info-box-number">{{ $change_forms }}</span>
                                            <a href="{{ route('records.change-forms.index') }}"
                                                class="small-box-footer">More
                                                info <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                            @endif

                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Clients Loan Forms</span>
                                        <span class="info-box-number">{{ $loan_forms }}</span>
                                        <a href="{{ route('records.loan-forms.index') }}" class="small-box-footer">More info
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
                                            class="fas fa-briefcase"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">
                                            @if (Auth::user()->hasRole('admin|records'))
                                                Records Files
                                            @else
                                                Records Batches
                                            @endif
                                        </span>
                                        <span class="info-box-number">{{ $filing_labels }}</span>
                                        <a href="{{ route('records.filing-labels.index') }}" class="small-box-footer">More
                                            info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->

                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-success elevation-1"><i
                                            class="fas fa-list-alt"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Requested Loan Forms</span>
                                        <span class="info-box-number">{{ $requested_loan }}</span>
                                        <a href="{{ route('records.requested-forms.index') }}"
                                            class="small-box-footer">More
                                            info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            @if (Auth::user()->hasRole('admin|records'))
                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-warning elevation-1"><i
                                                class="fas fa-book"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Requested Change Forms</span>
                                            <span class="info-box-number">{{ $requested_change }}</span>
                                            <a href="{{ route('records.change-forms.index') }}#new-requests"
                                                class="small-box-footer">More
                                                info
                                                <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                            @endif
                            <!-- /.col -->
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-list"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Loan Products</span>
                                        <span class="info-box-number">{{ $products }}</span>
                                        <a href="{{ route('records.loan-forms.products') }}" class="small-box-footer">More
                                            info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-calendar"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Records Reports</span>
                                        <span class="info-box-number">
                                            4
                                        </span>
                                        <a href="{{ route('records.reports.index') }}" class="small-box-footer">More
                                            info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-secondary elevation-1"><i
                                            class="fas fa-file-pdf"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Uploaded Loan Files</span>
                                        <span class="info-box-number">{{ $loan_files }}</span>
                                        <a href="{{ route('records.uploaded.loan-forms') }}"
                                            class="small-box-footer">More
                                            info
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
