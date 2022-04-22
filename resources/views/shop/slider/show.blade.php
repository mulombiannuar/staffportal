 @extends('layouts.admin.table')

 @section('content')
     <!-- Main content -->
     <section class="content">
         <div class="container-fluid">
             <div class="card card-warning">
                 <div class="card-header">
                     <h3 class="card-title"><i class="fa fa-list"></i> {{ $slider->title }}</h3>
                 </div>
                 <div class="card-body">
                     <div class="col-12 col-md-12 mb-10">
                         <h4 class="lead">Slider Image</h4>
                         <div class="about-thumbnail">
                             <img width="600px" title="{{ $slider->title }}"
                                 src="{{ asset('storage/assets/app/images/sliders/' . $slider->image) }}"
                                 alt="{{ $slider->title }}">
                         </div>
                     </div>
                     <hr>
                     <div class="col-12 col-md-12 mb-20">
                         <h4 class="lead">Slider Title</h4>
                         {!! $slider->title !!}
                     </div>
                     <hr>
                     <div class="col-12 col-md-12 mb-20">
                         <h4 class="lead">Slider Description</h4>
                         {{ $slider->description }}
                     </div>
                     <hr>
                     <div class="col-12 col-md-12 mb-20">
                         <h4 class="lead">Button Text</h4>
                         {{ $slider->link_text }}
                     </div>
                     <hr>
                     <div class="col-12 col-md-12 mb-20">
                         <h4 class="lead">Link Url</h4>
                         <a target="_blank"
                             href="{{ 'http://shop.test/' . $slider->link_url }}">{{ $slider->link_url }}</a>
                     </div>
                 </div>
                 <!-- /.card-body -->
             </div>
             <!-- /.card -->
         </div>
         <!-- /.container-fluid -->
     </section>
     <!-- /.content -->
 @endsection
