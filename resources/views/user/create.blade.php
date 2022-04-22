@extends('layouts.admin.form')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-user-plus"></i> {{ $title }}</h3>
      </div>
      <div class="card-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <form role="form" method="post" action="{{ route('admin.users.store') }}" accept-charset="utf-8">
                @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4 col-sm-12">
                      <div class="form-group">
                        <label for="email">Email*</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter email"
                          autocomplete="off" value="{{ old('email') }}" required>
                      </div>
                    </div>

                    <div class="col-md-4 col-sm-12">
                      <div class="form-group">
                        <label for="name">User Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter name"
                          autocomplete="off" value="{{ old('name') }}" required>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                      <div class="form-group">
                        <label for="national_id">National ID*</label>
                        <input type="number" name="national_id" class="form-control" id="national_id"
                          placeholder="Enter national id" autocomplete="off" value="{{ old('national_id') }}" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4 col-sm-12">
                      <div class="form-group">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-control select2" id="gender" required>
                          <option class="mb-1" value="">
                            - Select Gender -</option>
                          <option value="male">Male</option>
                          <option value="female">Female</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                      <div class="form-group">
                        <label for="birth_date">Date of Birth</label>
                        <input type="date" name="birth_date" class="form-control" id="date" placeholder="Date of Birth"
                          value="{{ old('birth_date') }}" autocomplete="off" required>
                      </div>
                    </div>

                    <div class="col-md-4 col-sm-12">
                      <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" class="form-control" id="address" placeholder="Postal address"
                          value="{{ old('address') }}" autocomplete="on" required>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4 col-sm-12">
                      <div class="form-group">
                        <label for="mobile_no">Mobile No.*</label>
                        <input type="number" name="mobile_no" class="form-control" id="mobile_no"
                          placeholder="Enter Mobile Number" value="{{ old('mobile_no') }}" autocomplete="off" required>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                      <div class="form-group">
                        <label for="county">County</label>
                        <select name="county" id="county" class="form-control select2" id="county" required>
                          <option class="mb-1" value="">
                            - Select County -</option>
                          @foreach ($counties as $county)
                          <option value="{{ $county->county_id }}">
                            {{ $county->county_name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                      <div class="form-group">
                        <label for="sub_county">Sub County</label>
                        <select name="sub_county" class="form-control select2" id="subs" required>
                          <option class="mb-1" value="">
                            - Select County First -</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4 col-sm-12">
                      <div class="form-group">
                        <label for="religion">Religion</label>
                        <select name="religion" class="form-control select2" id="religion" required>
                          <option class="mb-1" value="">
                            - Select Religion -</option>
                          <option value="Christian">Christian</option>
                          <option value="Islamist">Islamist</option>
                          <option value="Budhist">Budhist</option>
                          <option value="Pagan">Pagan</option>
                          <option value="Others">Others</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                      <div class="form-group">
                        <label for="branch">Branches</label>
                        <select name="branch_id" id="branch" class="form-control select2" id="county" required>
                          <option class="mb-1" value="">
                            - Select Branch -</option>
                          @foreach ($branches as $branch)
                          <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}
                          </option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                      <div class="form-group">
                        <label for="outposts">Outpost</label>
                        <select name="outpost_id" class="form-control select2" id="outposts" required>
                          <option class="mb-1" value="">
                            - Select Branch First -</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="modal-footer justify-content-between">
                  <button type="submit" class="btn btn-primary"> <i class="fa fa-user-plus"></i>
                    Add New User</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@push('scripts')
<script>
  $(document).ready(function () {
    $('#county').change(function () {
      county = $('#county').val();
      if (county != '') {
        $.ajax({
          url: "{{ route('get.subcounties') }}",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          data: {
            county: county
          },
          success: function (data) {
            console.log(data);
            $('#subs').html(data);
          },
          error: function (xhr, desc, err) {
            console.log(xhr);
            //console.log("Details0: " + desc + "\nError:" + err);
          },
        });
      } else {
        $('#subs').html('<option value="">Select Sub County</option>');
      }
    });

    $('#branch').change(function () {
      branch_id = $('#branch').val();
      if (branch_id != '') {
        $.ajax({
          url: "{{ route('get.outposts') }}",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          data: {
            branch_id: branch_id
          },
          success: function (data) {
            console.log(data);
            $('#outposts').html(data);
          },
          error: function (xhr, desc, err) {
            console.log(xhr);
            //console.log("Details0: " + desc + "\nError:" + err);
          },
        });
      } else {
        $('#outposts').html('<option value="">Select Branch</option>');
      }
    });
  });
</script>
@endpush