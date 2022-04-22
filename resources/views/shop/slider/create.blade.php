 @extends('layouts.admin.form')

 @section('content')
     <!-- Main content -->
     <section class="content">
         <div class="container-fluid">
             <div class="card card-warning">
                 <div class="card-header">
                     <h3 class="card-title"><i class="fa fa-plus"></i> {{ $title }}</h3>
                 </div>
                 <div class="card-body">
                     <div class="container-fluid">
                         <div class="row">
                             <div class="col-sm-12">
                                 <form role="form" method="post" action="{{ route('shop.sliders.store') }}"
                                     accept-charset="utf-8" enctype="multipart/form-data">
                                     @csrf
                                     <div class="card-body">
                                         <div class="row">
                                             <div class="col-sm-6">
                                                 <div class="form-group">
                                                     <label for="title">Slider Title</label>
                                                     <input type="text" name="title" class="form-control" id="title"
                                                         placeholder="Slider title" autocomplete="on"
                                                         value="{{ old('title') }}" required>
                                                 </div>
                                             </div>
                                             <div class="col-sm-6">
                                                 <div class="form-group">
                                                     <label for="description">Slider Description</label>
                                                     <input type="text" name="description" class="form-control"
                                                         id="description" placeholder="Slider description" autocomplete="on"
                                                         value="{{ old('description') }}" required>
                                                 </div>
                                             </div>
                                         </div>

                                         <div class="row">
                                             <div class="col-sm-4">
                                                 <div class="form-group">
                                                     <label for="link_text">Link Text</label>
                                                     <input type="text" name="link_text" class="form-control"
                                                         id="link_text" placeholder="Enter Link text" autocomplete="on"
                                                         value="{{ old('link_text') }}" required>
                                                 </div>
                                             </div>
                                             <div class="col-sm-4">
                                                 <div class="form-group">
                                                     <label for="link_url">Link URL</label>
                                                     <input type="text" name="link_url" class="form-control" id="link_url"
                                                         placeholder="Enter Link Url" autocomplete="on"
                                                         value="{{ old('link_url') }}" required>
                                                 </div>
                                             </div>
                                             <div class="col-sm-4">
                                                 <div class="form-group">
                                                     <label for="exampleInputFile">Slider Image (1399X800)</label>
                                                     <div class="input-group">
                                                         <div class="custom-file">
                                                             <input type="file" name="image" class="custom-file-input"
                                                                 id="exampleInputFile" required>
                                                             <label class="custom-file-label" for="exampleInputFile">Choose
                                                                 media</label>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>

                                     </div>
                                     <!-- /.card-body -->
                                     <div class="modal-footer justify-content-between">
                                         <button type="submit" class="btn btn-primary"> <i class="fa fa-user-plus"></i>
                                             Add New Shop Slider</button>
                                     </div>
                                 </form>
                             </div>
                         </div>
                     </div>
                 </div>
                 <!-- /.card-body -->
                 <!-- /.card-body -->
             </div>
             <!-- /.card -->
         </div>
         <!-- /.container-fluid -->
     </section>
     <!-- /.content -->
 @endsection
