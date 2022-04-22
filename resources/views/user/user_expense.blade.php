@extends('layouts.admin.form')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-user-plus"></i> {{ $title }}</h3>
      </div>
      <div class="card-body">
        <div class="container-fluid">
          Expense Details
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
