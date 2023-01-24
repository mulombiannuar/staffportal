@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> {{ $title }}</h3>
                    <div class="text-right">
                        <a href="{{ route('records.loan-forms.create') }}">
                            <button type="button" class="btn btn-secondary"><i class="fa fa-plus-circle"></i> Add New
                                Loan Form</button>
                        </a>
                        <button type="button" data-toggle="modal" data-target="#modalType" class="btn btn-primary"><i
                                class="fa fa-briefcase"></i> View by Filing Type</button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="datatable" width="100%"
                        class="table table-sm table-bordered table-striped table-head-fixed">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>FILING TYPE</th>
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
                                <th>FILE NUMBER</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <!--/.modal begin -->
                    <div class="modal fade" id="modalType" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">View Forms by Filing Type</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <form action="{{ route('records.loan-forms.category') }}" method="GET">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="filing_type">Filing Type</label>
                                                    <select name="category" class="form-control select2" id="types"
                                                        required>
                                                        <option class="mb-1" value="">
                                                            - Select Filing Type -</option>
                                                        @foreach ($filing_types as $type)
                                                            <option value="{{ $type->type_id }}">
                                                                {{ $type->type_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-info"><i class="fa fa-bars"></i> View Loans
                                            Forms</button>
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
                        data: 'type_name',
                        name: 'type_name'
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
                        data: 'filing_number',
                        name: 'filing_number'
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
