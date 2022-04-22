@extends('layouts.admin.table')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="card card-warning card-outline">
      <div class="card-header p-2">
        <ul class="nav nav-pills">
          <li class="nav-item"><a class="nav-link active" href="#details" data-toggle="tab"><i class="fa fa-user"></i>
              Group Details</a></li>
          <li class="nav-item"><a class="nav-link" href="#members" data-toggle="tab"><i class="fa fa-list-alt"></i>
              Group Members (13)</a></li>
        </ul>
      </div><!-- /.card-header -->
      <div class="card-body">
        <div class="tab-content">
          <div class="tab-pane active" id="details">
            <!-- Profile -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title"><i class="fa fa-user"></i> Group Details</h3>
              </div>
              <div class="card-body">
                <table class="table table-sm">
                    <tr>
                      <td><em>GROUP NAME:</em></td>
                      <td>{{ $group->GroupName }}</td>
                      <td><em>GROUP CODE:</em></td>
                      <td>{{ $group->GroupID }}</td>
                      <td><em>COLLECTION ACCOUNT:</em></td>
                      <td>{{ $group->GroupCollectionAccountID }}</td>
                      <td><em>BRANCH:</em></td>
                      <td>{{ $group->branch_name }}</td>
                    </tr>
                    <tr>
                      <td><em>GROUP PRODUCT:</em></td>
                      <td>{{ $group->GroupProductID }}</td>
                      <td><em>FORMATION DATE:</em></td>
                      <td>{{ $group->FormationDate }}</td>
                      <td><em>OFFICER:</em></td>
                      <td>{{ $group->Officer1 }}</td>
                      <td><em>MEETING FREQUENCY:</em></td>
                      <td>{{ $group->MeetingFrequencyID }}</td>
                    </tr>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.Profile -->
          </div>
          <!-- /.tab-pane -->

          <div class="tab-pane" id="members">
            <!-- members -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title"><i class="fa fa-users"></i> Group Members </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="table1" class="table table-sm table-bordered table-striped table-head-fixed">
                  <thead>
                    <tr>
                      <th>SN</th>
                      <th>Client ID</th>
                      <th>Customer Name</th>
                      <th>Savings Account</th>
                      <th>Group ID</th>
                      <th>Group Name</th>
                      <th>Savings</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr role="row" class="odd">
                      <td class="" tabindex="0">6</td>
                      <td>0133469</td>
                      <td>PETER KILIO KILAMBO [ 254700532425]</td>
                      <td class="sorting_1">0174440002362</td>
                      <td>01700193</td>
                      <td>MKUYUNI SHG</td>
                      <td>1600.0000</td>
                    </tr>
                    <tr role="row" class="even">
                      <td class="" tabindex="0">5</td>
                      <td>0133468</td>
                      <td>MUSA MKALA JOSEPH [ 254702877754]</td>
                      <td class="sorting_1">0174440002361</td>
                      <td>01700193</td>
                      <td>MKUYUNI SHG</td>
                      <td>2800.0000</td>
                    </tr>
                    <tr role="row" class="odd">
                      <td class="" tabindex="0">4</td>
                      <td>0133467</td>
                      <td>STEPHEN KUMUNA MWAKIRETI [ 254701650212]</td>
                      <td class="sorting_1">0174440002360</td>
                      <td>01700193</td>
                      <td>MKUYUNI SHG</td>
                      <td>4350.0000</td>
                    </tr>
                    <tr role="row" class="even">
                      <td class="" tabindex="0">3</td>
                      <td>0133466</td>
                      <td>RAJABU RIZIGALA JUMA [ 254768602112]</td>
                      <td class="sorting_1">0174440002359</td>
                      <td>01700193</td>
                      <td>MKUYUNI SHG</td>
                      <td>2100.0000</td>
                    </tr>
                    <tr role="row" class="odd">
                      <td class="" tabindex="0">2</td>
                      <td>0133465</td>
                      <td>DALMAS NGUMBI TUMUNA [ 254741104261]</td>
                      <td class="sorting_1">0174440002358</td>
                      <td>01700193</td>
                      <td>MKUYUNI SHG</td>
                      <td>3118.4000</td>
                    </tr>
                    <tr role="row" class="even">
                      <td class="" tabindex="0">1</td>
                      <td>0133464</td>
                      <td>HENRY KYALO COSMUS [ 254792455685]</td>
                      <td class="sorting_1">0174440002357</td>
                      <td>01700193</td>
                      <td>MKUYUNI SHG</td>
                      <td>2700.0000</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- members -->
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div><!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection