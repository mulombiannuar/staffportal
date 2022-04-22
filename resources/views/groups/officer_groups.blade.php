@extends('layouts.admin.table')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-list-alt"></i> {{ $title }} ({{ $groups->count() }})</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="table1" class="table table-sm table-bordered table-striped table-head-fixed">
          <thead>
            <tr>
              <th>SN</th>
              <th>Group Name</th>
              <th>Group Code</th>
              <th>CBS Account ID</th>
              <th>Branch</th>
              <th>Officer</th>
              <th>Date Created</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($groups as $group)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $group->GroupName }}</td>
              <td>{{ $group->GroupID }}</td>
              <td>{{ $group->GroupCollectionAccountID }}</td>
              <td>{{ $group->branch_name }}</td>
              <td>{{ $group->Officer1 }}</td>
              <td>{{ $group->CreatedOn }}</td>
              <td>
                <div class="margin">
                  <div class="btn-group">
                    <a href="{{ route('admin.groups.show', $group->GroupID) }}" title="Click to group details">
                      <button type="button" class="btn btn-xs btn-info"><i class="fa fa-eye"></i>
                        View</button>
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