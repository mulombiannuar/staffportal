 @extends('layouts.admin.table')

 @section('content')
     <!-- Main content -->
     <section class="content">
         <div class="container-fluid">
             <div class="margin mb-2 text-right">
                 <a href="{{ route('shop.sliders.create') }}">
                     <button type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add New Shop Slider</button>
                 </a>
             </div>

             <div class="card card-warning">
                 <div class="card-header">
                     <h3 class="card-title"><i class="fa fa-list"></i> {{ $title }}</h3>
                 </div>
                 <div class="card-body">
                     <table width='100%' id="table1" class="table table-sm table-bordered table-hover table-head-fixed">
                         <thead>
                             <tr>
                                 <th>S.N</th>
                                 <th>SLIDER TITLE</th>
                                 <th>DESCRIPTION</th>
                                 <th>LINK TEXT</th>
                                 <th>LINK</th>
                                 <th>PUBLISH</th>
                                 <th>ACTIONS</th>
                             </tr>
                         </thead>
                         <tbody>
                             @foreach ($sliders as $slider)
                                 <tr>
                                     <td>{{ $loop->iteration }}</td>
                                     <td>{{ $slider->title }}</td>
                                     <td>{{ $slider->description }}</td>
                                     <td>{{ $slider->link_text }}</td>
                                     <td><a target="_blank"
                                             href="{{ 'http://shop.test/' . $slider->link_url }}">/{{ $slider->link_url }}</a>
                                     </td>
                                     <td>
                                         @if ($slider->status == 0)
                                             <form action="{{ route('shop.sliders.publish', $slider->slider_id) }}"
                                                 method="post"
                                                 onclick="return confirm('Do you really want to publish this slider?')">
                                                 @csrf
                                                 @method('PUT')
                                                 <button type="submit" class="btn btn-xs btn-danger"><i
                                                         class="fa fa-times-circle"></i>
                                                     Publish
                                                 </button>
                                             </form>
                                         @else
                                             <form action="{{ route('shop.sliders.unpublish', $slider->slider_id) }}"
                                                 method="post"
                                                 onclick="return confirm('Do you really want to unpublish this slider?')">
                                                 @csrf
                                                 @method('PUT')
                                                 <button type="submit" class="btn btn-xs btn-success"><i
                                                         class="fa fa-check-circle"></i>
                                                     Unpublish
                                                 </button>
                                             </form>
                                         @endif
                                     </td>
                                     <td>
                                         <div class="margin">
                                             <div class="btn-group">
                                                 <a href="{{ route('shop.sliders.edit', $slider->slider_id) }}">
                                                     <button type="button" class="btn btn-xs btn-default"><i
                                                             class="fa fa-edit"></i>
                                                         Edit</button>
                                                 </a>
                                             </div>
                                             <div class="btn-group">
                                                 <a href="{{ route('shop.sliders.show', $slider->slider_id) }}"
                                                     title="Click to view student details">
                                                     <button type="button" class="btn btn-xs btn-info"><i
                                                             class="fa fa-eye"></i>
                                                         View</button>
                                                 </a>
                                             </div>
                                             <div class="btn-group">
                                                 <form action="{{ route('shop.sliders.destroy', $slider->slider_id) }}"
                                                     method="post"
                                                     onclick="return confirm('Do you really want to delete this slider?')">
                                                     @csrf
                                                     @method('DELETE')
                                                     <button type="submit" class="btn btn-xs btn-danger"><i
                                                             class="fa fa-trash"></i>
                                                         Delete</button>
                                                 </form>
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
