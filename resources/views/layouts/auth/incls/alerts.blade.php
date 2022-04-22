@if(session('success'))
<div class="alert alert-success">
    <h5><i class="icon fa fa-check-circle"></i>SUCCESS! <small>{{ session('success') }} </small></h5>
</div>
@endif

@if(session('danger'))
<div class="alert alert-danger">
    <h5><i class="icon fa fa-exclamation-circle"></i> <small>{{ session('danger') }}</small></h5>
</div>
@endif

@if(session('warning'))
<div class="alert alert-warning">
    <h5><i class="icon fas fa-exclamation"></i> OOOOPS! <small> {{ session('warning') }}</small> </h5>
</div>
@endif

@if(session('status'))
<div class="alert alert-success">
    <h5><i class="icon fa fa-exclamation-circle"></i>ALERT! <small>{{ session('status') }} </small></h5>
</div>
@endif