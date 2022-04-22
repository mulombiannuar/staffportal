@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-envelope"></i> {{ $title }} ({{ count($contacts) }})
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table1" class="table table-sm table-striped table-bordered table-head-fixed " width="100%">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>NAMES</th>
                                <th>EMAIL</th>
                                <th>MOBILE</th>
                                <th>SUBJECTS</th>
                                <th>MESSAGE BODY</th>
                                <th>CONTACT DATE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contacts as $contact)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $contact->name }}</td>
                                    <td><strong>{{ $contact->email }}</strong></td>
                                    <td>{{ $contact->mobile_no }}</td>
                                    <td width="10%">{{ strtoupper($contact->subject) }}</td>
                                    <td width="80%">{{ $contact->message }}</td>
                                    <td>{{ $contact->created_at }}</td>
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
