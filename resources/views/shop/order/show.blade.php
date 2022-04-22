@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-bars"></i> Bidding Order - {{ $product->bid_number }}

                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-hover table-bordered">
                        <tbody>
                            <tr>
                                <td>Bidder Customer Name</td>
                                <th>{{ $product->customer_name . ' - ' . $product->customer_mobile }}</th>
                            </tr>
                            <tr>
                                <td>Location</td>
                                <th>{{ $product->location . ' - ' . $product->city . ', ' . $product->county }} County
                                </th>
                            </tr>
                            <tr>
                                <td>Bidding Amount & Date</td>
                                <th>KSH. {{ number_format($product->bid_amount, 2) . ' , ' . $product->bid_date }}
                                </th>
                            </tr>
                            <tr>
                                <td>Product Details</td>
                                <th>{{ strtoupper($product->category_name) .
                                    ' - ' .
                                    strtoupper($product->reg_no) .
                                    ' - ' .
                                    ucwords($product->product_name) }}
                                </th>
                            </tr>
                            <tr>
                                <td>Disposal Price</td>
                                <th>KSH. {{ number_format($product->disposal_price, 2) }}
                                </th>
                            </tr>
                            <tr>
                                <td>Loan Amount & Loan Balance</td>
                                <th>Ksh. {{ number_format($product->loan_amount, 2) }} | Ksh.
                                    {{ number_format($product->loan_balance, 2) }}
                                </th>
                            </tr>
                            <tr>
                                <td>Branch Officer Details</td>
                                <th>{{ $product->branch_name . ' - ' . $product->user_name }}
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer justify-content-between">
                    @if ($product->order_chosen == 0)
                        <form action="#" method="post" onclick="return confirm('Do you really want to choose this bid?')">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger"><i class="fa fa-times-circle"></i> Choose
                                This Bidding
                            </button>
                        </form>
                    @else
                        <form action="#" method="post" onclick="return confirm('Do you really want to unchoose bid?')">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> UnChoose
                                This Bidding
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
