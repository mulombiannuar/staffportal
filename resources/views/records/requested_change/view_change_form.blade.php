@extends('layouts.admin.form')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-file-pdf"></i> {{ $title }}</h3>
                </div>
                <div class="card-body">
                    <object data="{{ asset('storage/assets/change-forms/' . $change_form->file_name) }}"
                        type="application/pdf" width="100%" height="800px">
                    </object>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
