@extends('layouts.admin.form')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card mt-2 card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-file-pdf"></i> {{ $title }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <object data="{{ asset('storage/assets/docs/' . $fuel->file) }}" type="application/pdf" width="100%"
                        height="600px">
                    </object>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
