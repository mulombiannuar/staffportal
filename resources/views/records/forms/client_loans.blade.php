@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card card-warning card-outline">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#loans" data-toggle="tab"><i class="fa fa-users"></i>
                            Active Client Loans</a></li>
                    <li class="nav-item"><a class="nav-link" href="#uploaded-excels" data-toggle="tab"><i
                                class="fa fa-list-alt"></i>
                            Uploaded Excel Data({{ count($excels) }})</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="loans">
                        <!-- Profile -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-users"></i> Active Client Loans</h3>
                            </div>
                            <div class="card-body">
                                <table id="datatable" width="100%"
                                    class="table table-sm table-bordered table-striped table-head-fixed">
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
                        <!-- /.Profile -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="uploaded-excels">
                        <!-- roles user -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-list-alt"></i> Uploaded Excel Data</h3>
                                @if (Auth::user()->hasRole('admin'))
                                    <div class="text-right">
                                        <a href="{{ asset('storage/assets/excels/client-loans-templates.xlsx') }}">
                                            <button type="button" class="btn btn-default"><i class="fa fa-download"></i>
                                                Download Excel
                                                Template</button>
                                        </a>
                                        <button type="button" data-toggle="modal" data-target="#modalUpload"
                                            class="btn btn-secondary"><i class="fa fa-upload"></i> Upload Excel
                                            File</button>
                                    </div>
                                @endif
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
                                            <form action="{{ route('records.loan-forms.import-excel') }}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="disbursment_date">Disbursment Date</label>
                                                                <input type="date" name="disbursment_date"
                                                                    class="form-control" id="disbursment_date"
                                                                    placeholder="Disbursment date" autocomplete="off"
                                                                    value="{{ old('disbursment_date') }}" required>
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
                                                    <button type="submit" class="btn btn-info"><i class="fa fa-upload"></i>
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
