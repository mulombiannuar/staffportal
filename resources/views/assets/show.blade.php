@extends('layouts.admin.table')

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-list-alt"></i> {{ $title }} ({{ $categories->count() }})</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="table1" class="table table-sm table-bordered table-hover table-head-fixed">
                    <thead>
                      <tr>
                        <th>SN</th>
                        <th>Category Name</th>
                        <th>Count</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                     @foreach ($categories as $category)
                         <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ strtoupper($category->asset_name) }}</td>
                            <td>15</td>
                            <td>
                              <div class="btn-group">
                                <a href="{{ route('admin.assets.show', strtolower($category->asset_name)) }}"
                                    title="Click asset category items">
                                    <button type="button" class="btn btn-sm btn-warning"><i class="fa fa-plus"></i>
                                        View Items</button>
                                </a>
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