@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-users"></i> {{ $title }}</h3>
                    <div class="margin text-right">
                        <a href="{{ route('records.clients.create') }}">
                            <button type="button" class="btn btn-secondary"><i class="fa fa-plus"></i> Add New
                                Records Client</button>
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table width="100%" id="datatable" class="table table-sm table-bordered table-hover table-head-fixed">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>NAMES</th>
                                <th>BR ID</th>
                                <th>MOBILE</th>
                                <th>NATIONAL ID</th>
                                <th>BRANCH</th>
                                <th>OUTPOST</th>
                                {{-- <th>ACTIONS</th> --}}
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
                ajax: "{{ route('records.clients.get-clients') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name',
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
                    // {
                    //     data: 'action',
                    //     name: 'action',
                    //     orderable: false,
                    //     searchable: false
                    // },
                ]
            });
        });
    </script>
@endpush
