@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="margin mb-2 text-right">
                <a href="{{ route('shop.products.create') }}">
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Motorbike </button>
                </a>
            </div>
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
                                <th>CATEGORY</th>
                                <th>PRODUCT NAME</th>
                                <th>CLIENT NAME</th>
                                <th>LOAN AMOUNT</th>
                                <th>LOAN BALANCE</th>
                                <th>DISPOSAL PRICE</th>
                                <th>BRANCH OFFICER</th>
                                <th>BRANCH</th>
                                <th>STS</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ strtoupper($product->category_name) }}</td>
                                    <td>{{ strtoupper($product->reg_no) . ' - ' . ucwords($product->product_name) }}</td>
                                    <td>{{ $product->client_id . '-' . $product->client_name }}</td>
                                    <td>Ksh {{ number_format($product->loan_amount, 2) }}</td>
                                    <td><strong>Ksh {{ number_format($product->loan_balance, 2) }}</strong></td>
                                    <td><strong>Ksh {{ number_format($product->disposal_price, 2) }}</strong></td>
                                    <td>{{ $product->user_name }}</td>
                                    <td>{{ $product->branch_name }}</td>
                                    <td>
                                        @if (Auth::user()->hasRole('admin'))
                                            @if ($product->status == 0)
                                                <form action="{{ route('shop.products.publish', $product->product_id) }}"
                                                    method="post"
                                                    onclick="return confirm('Do you really want to publish this product?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-xs btn-danger"><i
                                                            class="fa fa-times-circle"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form
                                                    action="{{ route('shop.products.unpublish', $product->product_id) }}"
                                                    method="post"
                                                    onclick="return confirm('Do you really want to unpublish this product?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-xs btn-success"><i
                                                            class="fa fa-check-circle"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            @if ($product->status == 0)
                                                <button type="button" class="btn btn-xs btn-danger"><i
                                                        class="fa fa-times-circle"></i>
                                                </button>
                                            @else
                                                <button type="buttom" class="btn btn-xs btn-success"><i
                                                        class="fa fa-check-circle"></i>
                                                </button>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <div class="margin">
                                            @if (Auth::user()->hasRole('admin') || $product->officer == Auth::user()->id)
                                                <div class="btn-group">
                                                    <a href="{{ route('shop.products.edit', $product->product_id) }}">
                                                        <button type="button" class="btn btn-xs btn-default"><i
                                                                class="fa fa-edit"></i>
                                                            Edit</button>
                                                    </a>
                                                </div>
                                            @endif
                                            <div class="btn-group">
                                                <a href="{{ route('shop.products.show', $product->product_id) }}">
                                                    <button type="button" class="btn btn-xs btn-info"><i
                                                            class="fa fa-eye"></i>
                                                        View</button>
                                                </a>
                                            </div>
                                            @if (Auth::user()->hasRole('admin'))
                                                <div class="btn-group">
                                                    <form
                                                        action="{{ route('shop.products.destroy', $product->product_id) }}"
                                                        method="post"
                                                        onclick="return confirm('Do you really want to delete this record?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-xs btn-danger"><i
                                                                class="fa fa-trash"></i>
                                                            Delete</button>
                                                    </form>
                                                </div>
                                            @endif
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
