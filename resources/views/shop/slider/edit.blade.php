 @extends('layouts.admin.form')

 @section('content')
     <!-- Main content -->
     <section class="content">
         <div class="container-fluid">
             <div class="card card-warning">
                 <div class="card-header">
                     <h3 class="card-title"><i class="fa fa-edit"></i> {{ $slider->title }} </h3>
                 </div>
                 <div class="card-body">
                     <form role="form" method="post" action="{{ route('shop.sliders.update', $slider->slider_id) }}"
                         accept-charset="utf-8" enctype="multipart/form-data">
                         @csrf
                         @method('PUT')
                         <div class="row">
                             <div class="col-sm-6">
                                 <div class="form-group">
                                     <label for="exampleInputText1">Slider Title</label>
                                     <input type="text" name="title" class="form-control" id="exampleInputText1"
                                         placeholder="Slider title" autocomplete="on" value="{{ $slider->title }}"
                                         required>
                                 </div>
                             </div>
                             <div class="col-sm-6">
                                 <div class="form-group">
                                     <label for="description">Slider Description</label>
                                     <input type="text" name="description" class="form-control" id="description"
                                         placeholder="Slider description" autocomplete="on"
                                         value="{{ $slider->description }}" required>
                                 </div>
                             </div>

                         </div>
                         <div class="row">
                             <div class="col-sm-4">
                                 <div class="form-group">
                                     <label for="exampleInputText1">Link Text</label>
                                     <input type="text" name="link_text" class="form-control" id="exampleInputText1"
                                         placeholder="Enter Link text" autocomplete="on" value="{{ $slider->link_text }}"
                                         required>
                                 </div>
                             </div>
                             <div class="col-sm-4">
                                 <div class="form-group">
                                     <label for="exampleInputText1">Link URL</label>
                                     <input type="text" name="link_url" class="form-control" id="exampleInputText1"
                                         placeholder="Enter Link Url" autocomplete="on" value="{{ $slider->link_url }}"
                                         required>
                                 </div>
                             </div>
                             <div class="col-sm-4">
                                 <div class="form-group">
                                     <label for="exampleInputFile">Slider Image &nbsp; <a target="_new"
                                             href="{{ asset('storage/assets/app/images/sliders/' . $slider->image) }}"><span
                                                 style="font-style: italic">View Slide Image</span></a></label>
                                     <div class="input-group">
                                         <div class="custom-file">
                                             <input type="file" name="image" class="custom-file-input"
                                                 id="exampleInputFile">
                                             <label class="custom-file-label" for="exampleInputFile">Choose
                                                 media</label>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <!-- /.card-body -->
                         <div class="modal-footer justify-content-between">
                             <button type="submit" class="btn btn-primary"> <i class="fa fa-edit"></i>
                                 Update Slider Data</button>
                         </div>
                     </form>
                 </div>
             </div>
             <!-- /.card -->
         </div>
         <!-- /.container-fluid -->
     </section>
     <!-- /.content -->
 @endsection
