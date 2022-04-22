@extends('layouts.admin.table')

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-envelope"></i> {{ $title }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="table1" class="table table-sm table-striped table-bordered table-head-fixed " width="100%">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>LOGGED DATE</th>
                            <th>RECIPIENT</th>
                            <th width="40%">MESSAGE BODY</th>
                            <th>MOBILE NUMBER</th>
                            <th>TYPE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($messages as $message)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $message->logged_date}}</td>
                            <td>{{ $message->recipient_name}}</td>
                            <td>{{ $message->message_body}}</td>
                            <td>{{ $message->recipient_no}}</td>
                            <td>{{ $message->message_type}}</td>
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