@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> {{ $title }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="datatable" width="100%" class="table table-sm table-bordered table-striped table-head-fixed">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>APPLICATION ID</th>
                                <th>CLIENT ID</th>
                                <th>LOAN ACCOUNT</th>
                                <th>CODE</th>
                                <th>APPLICATION DATE</th>
                                <th>AMOUNT</th>
                                <th>DISBURSMENT DATE</th>
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
                ajax: "{{ route('records.get-client-loans') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'application_id',
                        name: 'application_id'
                    },
                    {
                        data: 'client_id',
                        name: 'client_id'
                    },
                    {
                        data: 'account_id',
                        name: 'account_id'
                    },
                    {
                        data: 'product_id',
                        name: 'product_id'
                    },
                    {
                        data: 'application_date',
                        name: 'application_date'
                    },

                    {
                        data: 'loan_amount',
                        name: 'loan_amount'
                    },
                    {
                        data: 'disbursment_date',
                        name: 'disbursment_date'
                    },
                ]
            });
        });
    </script>
@endpush
