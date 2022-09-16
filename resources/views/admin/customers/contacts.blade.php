@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> {{ $title }}
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if (empty($contacts))
                        <div class="alert alert-danger">
                            No contacts data were found. Please refresh this page
                        </div>
                    @else
                        <table id="table1" class="table table-sm table-striped table-bordered table-head-fixed "
                            width="100%">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>NAMES</th>
                                    <th>SUBJECTS</th>
                                    <th>MESSAGE BODY</th>
                                    <th>EMAIL</th>
                                    <th>DATE</th>
                                    <th>RESPONDED</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contacts as $contact)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $contact->name . '-' . $contact->mobile_no }}</td>
                                        <td>{{ strtoupper($contact->subject) }}</td>
                                        <td>{{ $contact->message }}</td>
                                        <td><strong>{{ $contact->email }}</strong></td>
                                        <td>{{ $contact->date }}</td>
                                        <td>
                                            @if ($contact->bimas_responded == 0)
                                                Not responded
                                            @else
                                                Responded
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
