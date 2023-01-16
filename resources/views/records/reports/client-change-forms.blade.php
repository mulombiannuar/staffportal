@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-list-alt"></i> Clients Change Forms</h3>
            </div>
            <div class="card-body">
                <table width="100%" id="table1"
                    class="table table-sm table-bordered table-striped table-head-fixed table-responsive">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>NAMES</th>
                            <th>BR ID</th>
                            <th>MOBILE</th>
                            <th>NATIONAL ID</th>
                            <th>BRANCH</th>
                            <th>OUTPOST</th>
                            <th>DATE CHANGED</th>
                            <th>FILE NUMBER</th>
                            <th>CREATED BY</th>
                            <th>CREATED AT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $form)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $form->client_name }}</td>
                                <td>{{ $form->bimas_br_id }}</td>
                                <td>{{ $form->client_phone }}</td>
                                <td>{{ $form->national_id }}</td>
                                <td>{{ $form->branch_name }}</td>
                                <td>{{ $form->outpost_name }}</td>
                                <td>{{ $form->date_changed }}</td>
                                <td>{{ $form->file_label . $form->filing_number }}</td>
                                <td>{{ $form->name }}</td>
                                <td>{{ $form->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </section>
    <!-- /.content -->
@endsection
