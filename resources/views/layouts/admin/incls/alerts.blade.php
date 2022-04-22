<div class="container-fluid">
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        @foreach ($errors->all() as $error)
               <ul>
                   <li> {{ $error }}</li>
               </ul>
         @endforeach
    </div>
    @endif
</div>

@push('scripts')
    @if(session('success'))
        <script>
            swal({
                title: "Good job!",
                text: "{{ session('success') }}",
                icon: "success",
                button: "Ooooh Yes!",
            });
        </script>
    @endif

    @if(session('danger'))
        <script>
            swal({
                title: "Oooooops!",
                text: "{{ session('danger') }}",
                icon: "warning",
                button: "Ooooh Yes!",
            });
        </script>
    @endif

    @if(session('warning'))
        <script>
            swal({
                title: "Oooooops!",
                text: "{{ session('warning') }}",
                icon: "warning",
                button: "Ooooh Yes!",
            });
        </script>
    @endif

@endpush    