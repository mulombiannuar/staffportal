@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> Manage {{ $title }}
                        ({{ $products->count() }})
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
                                <th>BIDDER NAME</th>
                                <th>BID AMOUNT</th>
                                <th>BID DATE</th>
                                <th>LOCATION</th>
                                <th>BRANCH OFFICER</th>
                                <th>BRANCH</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ strtoupper($product->reg_no) . ' - ' . ucwords($product->product_name) }}</td>
                                    <td>Ksh. {{ number_format($product->loan_balance, 2) }}</td>
                                    <td>Ksh. {{ number_format($product->disposal_price, 2) }}</td>
                                    <td>{{ $product->customer_name . '-' . $product->customer_mobile }}</td>
                                    <td><strong>Ksh. {{ number_format($product->bid_amount, 2) }}</strong></td>
                                    <td>{{ $product->bid_date }}</td>
                                    <td>{{ $product->county . '-' . $product->location }}</td>
                                    <td>{{ $product->user_name }}</td>
                                    <td>{{ $product->branch_name }}</td>
                                    <td>
                                        <div class="margin">
                                            <div class="btn-group">
                                                <a href="{{ route('shop.get-order', $product->order_id) }}">
                                                    <button type="button" class="btn btn-xs btn-warning"><i
                                                            class="fa fa-bars"></i> View
                                                    </button>
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
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
