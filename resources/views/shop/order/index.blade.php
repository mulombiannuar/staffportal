@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> Manage {{ $title }}
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table1" class="table table-sm table-bordered table-striped table-head-fixed">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>PRODUCT NAME</th>
                                <th>LOAN BALANCE</th>
                                <th>DISPOSAL PRICE</th>
                                <th>CLIENT NAME</th>
                                <th>LOCATION</th>
                                <th>BRANCH</th>
                                <th>CNT</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                @if (Auth::user()->hasRole('admin'))
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ strtoupper($product->data->reg_no) . ' - ' . ucwords($product->data->product_name) }}
                                        </td>
                                        <td>Ksh. {{ number_format($product->data->loan_balance, 2) }}</td>
                                        <td>Ksh. {{ number_format($product->data->disposal_price, 2) }}</td>
                                        <td>{{ $product->data->client_name . '-' . $product->data->mobile_no }}</td>
                                        <td>{{ $product->data->location }}</td>
                                        <td>{{ $product->data->branch_name }}</td>
                                        <td><strong>{{ $product->count }}</strong></td>
                                        <td>
                                            <div class="margin">
                                                <div class="btn-group">
                                                    <a href="{{ route('shop.get-product-orders', $product->product) }}">
                                                        <button type="button" class="btn btn-xs btn-warning"><i
                                                                class="fa fa-bars"></i>
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @if ($product->data->branch_id == 3)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ strtoupper($product->data->reg_no) . ' - ' . ucwords($product->data->product_name) }}
                                            </td>
                                            <td>Ksh. {{ number_format($product->data->loan_balance, 2) }}</td>
                                            <td>Ksh. {{ number_format($product->data->disposal_price, 2) }}</td>
                                            <td>{{ $product->data->client_name . '-' . $product->data->mobile_no }}</td>
                                            <td>{{ $product->data->location }}</td>
                                            <td>{{ $product->data->branch_name }}</td>
                                            <td><strong>{{ $product->count }}</strong></td>
                                            <td>
                                                <div class="margin">
                                                    <div class="btn-group">
                                                        <a
                                                            href="{{ route('shop.get-product-orders', $product->product) }}">
                                                            <button type="button" class="btn btn-xs btn-warning"><i
                                                                    class="fa fa-bars"></i>
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endif
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
