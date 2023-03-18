@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card card-warning card-outline">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#clients" data-toggle="tab"><i class="fa fa-users"></i>
                            {{ $title }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="#uploaded-excels" data-toggle="tab"><i
                                class="fa fa-list-alt"></i>
                            Uploaded Excel Data({{ count($excels) }})</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="clients">
                        <!-- Profile -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-users"></i> Active Client Loans</h3>
                            </div>
                            <div class="card-body">
                                <table width="100%" id="datatable"
                                    class="table table-sm table-bordered table-hover table-head-fixed">
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
                        <!-- /.Profile -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="uploaded-excels">
                        <!-- roles user -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-list-alt"></i> Uploaded Excel Data</h3>
                                <div class="text-right">
                                    <a href="{{ route('records.clients.create') }}">
                                        <button type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add New
                                            Client</button>
                                    </a>
                                    @if (Auth::user()->hasRole('admin'))
                                        <a href="{{ asset('storage/assets/excels/clients-data-template.xlsx') }}">
                                            <button type="button" class="btn btn-default"><i class="fa fa-download"></i>
                                                Download
                                                Template</button>
                                        </a>
                                        <button type="button" data-toggle="modal" data-target="#modalUpload"
                                            class="btn btn-secondary"><i class="fa fa-upload"></i> Upload Excel
                                            File</button>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="table1" width="100%"
                                    class="table table-sm table-bordered table-striped table-head-fixed">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>DATE UPLOADED</th>
                                            <th>RECORDS</th>
                                            <th>UPLOADED BY</th>
                                            <th>EXCEL FILE</th>
                                            <th>DISBURSMENT DATE</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($excels as $excel)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $excel->created_at }}</td>
                                                <td>{{ $excel->records_affected }}</td>
                                                <td>{{ $excel->name }}</td>
                                                <td>
                                                    <a
                                                        href="{{ asset('storage/assets/excels/' . $excel->excel_file_name) }}">
                                                        {{ $excel->excel_file_name }}
                                                    </a>
                                                </td>
                                                <td>{{ $excel->disbursment_date }}</td>
                                                <td>
                                                    <div class="margin">
                                                        <div class="btn-group">
                                                            <a href="{{ asset('storage/assets/excels/' . $excel->excel_file_name) }}"
                                                                target="_blank" title="Click to view details">
                                                                <button type="button" class="btn btn-xs btn-info"><i
                                                                        class="fa fa-eye"></i>
                                                                    View File</button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!--/.modal begin -->
                                <div class="modal fade" id="modalUpload" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Upload Excel File</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('records.clients.import-excel') }}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="registration_date">Registration Date</label>
                                                                <input type="date" name="registration_date"
                                                                    class="form-control" id="registration_date"
                                                                    placeholder="Registration date" autocomplete="off"
                                                                    value="{{ old('registration_date') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="excel_file">Excel File</label>
                                                                <input type="file" name="excel_file" accept=".xls, .xlsx"
                                                                    class="form-control" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-info"><i
                                                            class="fa fa-upload"></i>
                                                        Upload
                                                        Excel
                                                        File</button>
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
                        <!-- roles user -->
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- /.nav-tabs-custom -->
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
