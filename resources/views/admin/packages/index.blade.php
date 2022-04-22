@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning card-outline">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        @foreach ($products as $product)
                            <li class="nav-item"><a class="nav-link {{ $loop->first ? 'active' : '' }}"
                                    href="#product-{{ $product->product_id }}" data-toggle="tab"><i
                                        class="fa fa-list"></i>
                                    {{ $product->name }} ({{ count($product->users) }})</a></li>
                        @endforeach
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">

                        @foreach ($products as $product)
                            @if (!empty($product->users))
                                <div class="tab-pane {{ $loop->first ? 'active' : '' }}"
                                    id="product-{{ $product->product_id }}">
                                    <!-- Profile -->
                                    <div class="card card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fa fa-list"></i> Manage
                                                {{ $product->name }}</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="margin mb-2 text-right">
                                                <a href="{{ route('admin.packages.addpackage', $product->product_id) }}">
                                                    <button type="button" class="btn btn-secondary"><i
                                                            class="fa fa-plus"></i>
                                                        Add
                                                        New User to
                                                        List</button>
                                                </a>
                                                @if ($loop->first)
                                                    <button type="button" data-toggle="modal"
                                                        data-target="#modalGenerateReport" class="btn btn-primary"><i
                                                            class="fa fa-calendar"></i> Generate
                                                        CVP Data Report</button>
                                                @endif
                                            </div>

                                            <table id="table{{ $loop->iteration }}"
                                                class="table table-sm table-bordered table-striped table-head-fixed">
                                                <thead>
                                                    <tr>
                                                        <th>SN</th>
                                                        <th>STAFF NAME</th>
                                                        <th>PHONE NUMBER</th>
                                                        <th>CVP PACKAGE</th>
                                                        <th>AMOUNT</th>
                                                        <th>OUTPOST</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($product->users as $user)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $user->staff_name }}</td>
                                                            <td>{{ $user->staff_mobile }}</td>
                                                            <td><strong>{{ $user->value . ' [' . ucwords($user->type) . ']' }}</strong>
                                                            </td>
                                                            <td>Ksh {{ number_format($user->amount, 2) }}</td>
                                                            <td>{{ $user->outpost_name }}</td>
                                                            <td>
                                                                <div class="margin">
                                                                    <div class="btn-group">
                                                                        <a
                                                                            href="{{ route('admin.packages.edit', $user->staff_id) }}">
                                                                            <button type="button"
                                                                                class="btn btn-xs btn-default"><i
                                                                                    class="fa fa-edit"></i>
                                                                                Edit</button>
                                                                        </a>
                                                                    </div>
                                                                    <div class="btn-group">
                                                                        <a
                                                                            href="{{ route('admin.packages.show', $user->staff_id) }}">
                                                                            <button type="button"
                                                                                class="btn btn-xs btn-info"><i
                                                                                    class="fa fa-eye"></i>
                                                                                View</button>
                                                                        </a>
                                                                    </div>
                                                                    <div class="btn-group">
                                                                        <form
                                                                            action="{{ route('admin.packages.destroy', $user->staff_id) }}"
                                                                            method="post"
                                                                            onclick="return confirm('Do you really want to delete this record?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-xs btn-danger"><i
                                                                                    class="fa fa-trash"></i>
                                                                                Remove</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>

                                            <!--/.modal begin -->
                                            <div class="modal fade" id="modalGenerateReport" style="display: none;"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Generate CVP Data Report</h4>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('export.cvp-data') }}" method="GET">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="start_date">Date</label>
                                                                            <input type="date" name="date"
                                                                                class="form-control" id="date"
                                                                                value="{{ date('Y-m-d') }}"
                                                                                placeholder="Select Date" autocomplete="on"
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="report_type">Report Type</label>
                                                                            <select name="report_type"
                                                                                class="form-control select2"
                                                                                id="report_type" required>
                                                                                <option class="mb-1" value="">
                                                                                    - Select Report Type -</option>
                                                                                <option value="0">All CVP Packages</option>
                                                                                @foreach ($products as $product)
                                                                                    <option
                                                                                        value="{{ $product->product_id }}">
                                                                                        {{ ucwords($product->type) }}
                                                                                        Packages
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-info"><i
                                                                        class="fa fa-print"></i> Generate
                                                                    Report Now</button>
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
                                    <!-- /.Profile -->
                                </div>
                            @endif
                            <!-- /.tab-pane -->
                        @endforeach
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </section>
    <!-- /.content -->
@endsection
