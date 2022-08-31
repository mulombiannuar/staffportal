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
                                            <table id="table1"
                                                class="table table-sm table-bordered table-striped table-head-fixed">
                                                <thead>
                                                    <tr>
                                                        <th>SN</th>
                                                        <th>PHONE NAME</th>
                                                        <th>S/NUMBER</th>
                                                        <th>P/NUMBER</th>
                                                        <th>PUK NO.</th>
                                                        <th>USER</th>
                                                        <th>OUTPOST</th>
                                                        <th>DATE ASSIGNED</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($devices['phones'] as $asset)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ strtoupper($asset->device_name) }}</td>
                                                            <td>{{ $asset->serial_number }}</td>
                                                            <td>{{ $asset->phone_number }}</td>
                                                            <td>{{ $asset->puk_1 }}</td>
                                                            <td>{{ $asset->name }}</td>
                                                            <td>{{ $asset->outpost_name }}</td>
                                                            <td>{{ date_format(date_create($asset->date_assigned), 'D, d M Y') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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
                                            <div class="card-body">
                                                <table class="table table-sm table-bordered table-striped table-head-fixed">
                                                    <thead>
                                                        <tr>
                                                            <th>SN</th>
                                                            <th>PHONE NAME</th>
                                                            <th>S/NUMBER</th>
                                                            <th>S/MODEL</th>
                                                            <th>O/SYSTEM</th>
                                                            <th>USER</th>
                                                            <th>OUTPOST</th>
                                                            <th>DATE ASSIGNED</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($devices['laptops'] as $asset)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ strtoupper($asset->device_name) }}</td>
                                                                <td>{{ $asset->serial_number }}</td>
                                                                <td>{{ $asset->model }}</td>
                                                                <td>{{ $asset->operating_system }}</td>
                                                                <td>{{ $asset->name }}</td>
                                                                <td>{{ $asset->outpost_name }}</td>
                                                                <td>{{ date_format(date_create($asset->date_assigned), 'D, d M Y') }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
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
                                            <div class="card-body">
                                                <table class="table table-sm table-bordered table-striped table-head-fixed">
                                                    <thead>
                                                        <tr>
                                                            <th>SN</th>
                                                            <th>PHONE NAME</th>
                                                            <th>S/NUMBER</th>
                                                            <th>S/MODEL</th>
                                                            <th>O/SYSTEM</th>
                                                            <th>USER</th>
                                                            <th>OUTPOST</th>
                                                            <th>DATE ASSIGNED</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($devices['desktops'] as $asset)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ strtoupper($asset->device_name) }}</td>
                                                                <td>{{ $asset->serial_number }}</td>
                                                                <td>{{ $asset->model }}</td>
                                                                <td>{{ $asset->operating_system }}</td>
                                                                <td>{{ $asset->name }}</td>
                                                                <td>{{ $asset->outpost_name }}</td>
                                                                <td>{{ date_format(date_create($asset->date_assigned), 'D, d M Y') }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
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
                                            <table class="table table-sm table-bordered table-striped table-head-fixed">
                                                <thead>
                                                    <tr>
                                                        <th>SN</th>
                                                        <th>TYPE</th>
                                                        <th>NAME</th>
                                                        <th>CHASSIS NUMBER</th>
                                                        <th>MODEL</th>
                                                        <th>REG NO</th>
                                                        <th>USER</th>
                                                        <th>OUTPOST</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($devices['motors'] as $asset)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ strtoupper($asset->type) }}</td>
                                                            <td>{{ strtoupper($asset->device_name) }}</td>
                                                            <td>{{ $asset->chassis_number }}</td>
                                                            <td>{{ $asset->model }}</td>
                                                            <td>{{ $asset->reg_no }}</td>
                                                            <td>{{ $asset->name }}</td>
                                                            <td>{{ $asset->outpost_name }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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
