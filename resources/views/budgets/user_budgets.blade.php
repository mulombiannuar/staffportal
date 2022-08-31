@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> Manage {{ $title }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table1" class="table table-sm table-bordered table-striped table-head-fixed">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>OFFICER NAME</th>
                                <th>F YEAR</th>
                                <th>OUTPOST</th>
                                <th>CREATED BY</th>
                                <th>CREATED ON</th>
                                <th>VIEW</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($templates as $template)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ strtoupper($template->officer_name) }}</td>
                                    <td>{{ $template->financial_year }}</td>
                                    <td>{{ $template->outpost_name }}</td>
                                    <td>{{ ucwords($template->creator_name) }}</td>
                                    <td>{{ $template->created_at }}</td>
                                    <td>
                                        <div class="margin">
                                            <div class="btn-group">
                                                <a href="{{ $template->temp_link }}" target="_new">
                                                    <button type="button" class="btn btn-xs btn-info"><i
                                                            class="fa fa-link"></i>
                                                        View Template</button>
                                                </a>
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
