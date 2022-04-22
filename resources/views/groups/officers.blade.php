@extends('layouts.admin.table')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-users"></i> {{ $title }}</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="table1" class="table table-sm table-bordered table-striped table-head-fixed">
          <thead>
            <tr>
              <th>SN</th>
              <th>CBS Name</th>
              <th>Officer Name</th>
              <th>Branch Name</th>
              <th>Outpost</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
              @for ($i = 1; $i < 20; $i++)
              <tr role="row">
                <td>{{ $i }}</td>
                <td>BMUSYIMI</td>
                <td>BENJAMIN KILIO KILAMBO [ 254700532425]</td>
                <td>Mwingi</td>
                <td>Matuu</td>
                <td><a href="{{ route('admin.officer.groups', 'carol')}}" title="View"><button type="button"
                  class="btn btn-xs btn-info"><i class="fa fa-eye"></i>
                  View</button></a> </td>
              </tr>
              @endfor
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