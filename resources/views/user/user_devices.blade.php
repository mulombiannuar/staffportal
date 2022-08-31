@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-warning card-outline">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#phones" data-toggle="tab"><i
                                            class="fa fa-phone"></i> Mobile Phones</a></li>
                                <li class="nav-item"><a class="nav-link" href="#laptops" data-toggle="tab"><i
                                            class="fa fa-laptop"></i>
                                        Laptops</a></li>
                                <li class="nav-item"><a class="nav-link" href="#desktops" data-toggle="tab"><i
                                            class="fa fa-desktop"></i> Desktops</a></li>
                                <li class="nav-item"><a class="nav-link" href="#motorbikes" data-toggle="tab"><i
                                            class="fa fa-motorcycle"></i> Motorbikes</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="phones">
                                    <!-- Profile -->
                                    <div class="card card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fa fa-phone"></i> Mobile Phones</h3>
                                        </div>
                                        <div class="card-body">
                                            Mobile Phones
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.Profile -->
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="laptops">
                                    <!-- documents -->
                                    <div class="card card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fa fa-laptop"></i> Laptops</h3>
                                        </div>
                                        <div class="card-body">
                                            Laptops
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- documents -->
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="desktops">
                                    <!-- roles user -->
                                    <div class="card card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fa fa-desktop"></i> Transactions</h3>
                                        </div>
                                        <div class="card-body">
                                            Desktops
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- roles user -->
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="motorbikes">
                                    <!-- roles user -->
                                    <div class="card card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fa fa-motorbike"></i> Motorbikes</h3>
                                        </div>
                                        <div class="card-body">
                                            Motorbikes
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
