@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> Manage Records Loan Forms</h3>
                    <div class="text-right">
                        <a href="{{ route('records.loan-forms.create') }}">
                            <button type="button" class="btn btn-secondary"><i class="fa fa-plus-circle"></i> Add New
                                Loan Form</button>
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="datatable" width="100%"
                        class="table table-responsive table-sm table-bordered table-striped table-head-fixed">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>NAMES</th>
                                <th>BR ID</th>
                                <th>MOBILE</th>
                                <th>NATIONAL ID</th>
                                <th>BRANCH</th>
                                <th>OUTPOST</th>
                                <th>PRODUCT</th>
                                <th>CODE</th>
                                <th>AMOUNT</th>
                                <th>DISBURSMENT DATE</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>

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
@push('scripts')
    <script>
        $(document).ready(function() {
            $("#datatable").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('records.loan-forms.get-loan-forms') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'client_name',
                        name: 'client_name'
                    },
                    {
                        data: 'bimas_br_id',
                        name: 'bimas_br_id'
                    },
                    {
                        data: 'client_phone',
                        name: 'client_phone'
                    },
                    {
                        data: 'national_id',
                        name: 'national_id'
                    },
                    {
                        data: 'branch_name',
                        name: 'branch_name'
                    },
                    {
                        data: 'outpost_name',
                        name: 'outpost_name'
                    },
                    {
                        data: 'product_name',
                        name: 'product_name'
                    },
                    {
                        data: 'product_code',
                        name: 'product_code'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'disbursment_date',
                        name: 'disbursment_date'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endpush
