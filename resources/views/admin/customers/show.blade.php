@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="margin mb-2 text-right">
                <a href="{{ route('customers.add_customer', $campaign->campaign_id) }}">
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add New
                        Customer</button>
                </a>
            </div>
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-customers"></i> {{ $title }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table1" class="table table-sm table-bordered table-striped table-head-fixed">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>NAMES</th>
                                <th>MOBILE</th>
                                <th>RESIDENCE</th>
                                <th>BUSINESS</th>
                                <th>MESSAGE</th>
                                <th>DATE</th>
                                <th>BRANCH</th>
                                <th>OFFICER</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ strtoupper($customer->customer_name) }}</td>
                                    <td>{{ $customer->customer_phone }}</td>
                                    <td>{{ $customer->residence }}</td>
                                    <td>{{ $customer->business }}</td>
                                    <td>{{ $customer->customer_message }}</td>
                                    <td>{{ $customer->created_at }}</td>
                                    <td>{{ $customer->branch_name }}</td>
                                    <td>{{ $customer->officer_name }}</td>
                                    <td>
                                        <div class="margin">
                                            <div class="btn-group">
                                                <a href="{{ route('customers.edit_customer', $customer->customer_id) }}">
                                                    <button type="button" class="btn btn-xs btn-default"><i
                                                            class="fa fa-edit"></i>
                                                        Edit</button>
                                                </a>
                                            </div>
                                            <div class="btn-group">
                                                <a href="{{ route('customers.show_customer', $customer->customer_id) }}"
                                                    title="Click to view customer details">
                                                    <button type="button" class="btn btn-xs btn-info"><i
                                                            class="fa fa-eye"></i>
                                                        View</button>
                                                </a>
                                            </div>
                                            <div class="btn-group">
                                                <form
                                                    action="{{ route('customers.delete_customer', $customer->customer_id) }}"
                                                    method="post"
                                                    onclick="return confirm('Do you really want to delete this customer?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-xs btn-danger"><i
                                                            class="fa fa-trash"></i>
                                                        Delete</button>
                                                </form>
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
