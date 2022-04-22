 @extends('layouts.auth.auth')

 @section('content')
 <div class="card">
     <div class="card-body login-card-body">
         <div class="alert alert-danger">
             <h5><i class="icon fa fa-exclamation-circle"></i> <small>You must verify your email before
                     proceeding. Please check a verification link in your email address</small></h5>
         </div>
         <form action=" {{ route('verification.send') }}" method="post">
             @csrf
             <div class="row">
                 <!-- /.col -->
                 <div class="col-12">
                     <button type="submit" class="btn btn-primary btn-block">Send Email</button>
                 </div>
                 <!-- /.col -->
             </div>
         </form>
     </div>
     <!-- /.login-card-body -->
 </div>
 @endsection