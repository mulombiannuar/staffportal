@extends('layouts.admin.form')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="card card-warning card-outline">
      <div class="card-header p-2">
        <ul class="nav nav-pills">
          <li class="nav-item"><a class="nav-link active" href="#details" data-toggle="tab"><i class="fa fa-user"></i>
              Group Visit Details</a></li>
          <li class="nav-item"><a class="nav-link" href="#loans" data-toggle="tab"><i class="fa fa-list"></i>
              Loans Applied ({{ count($loans) }})</a></li>
          <li class="nav-item"><a class="nav-link" href="#members" data-toggle="tab"><i class="fa fa-list-alt"></i>
              New Group Members ({{ count($members) }})</a></li>
          <li class="nav-item"><a class="nav-link" href="#approvals" data-toggle="tab"><i class="fa fa-briefcase"></i>
              Expense Approval </a></li>
        </ul>
      </div><!-- /.card-header -->
      <div class="card-body">
        <div class="tab-content">
          <div class="tab-pane active" id="details">
            <!-- Profile -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title"><i class="fa fa-user"></i> Group Visit Details</h3>
              </div>
              <div class="card-body">
                @if ($expenseData)
                <form role="form" method="post" action="{{ route('user.group-visits.update', $expenseData->visit_id) }}"
                  enctype="multipart/form-data" accept-charset="utf-8">
                  @csrf
                  @method('PUT')
                  <div class="card-body">
                    <div class="row">
                      @if ($expenseData->user_id == Auth::user()->id)
                      <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                          <label for="groups">Select Groups</label>
                          <select name="groups[]" class="form-control select2"
                            data-placeholder="- Select Groups Visited -" multiple="multiple">
                            <option class="mb-1" value="">
                            </option>
                            @foreach ($meetings as $meeting)
                            <option value="{{ $meeting->meeting_id }}">
                              {{ $meeting->group_code. ' - '.$meeting->group_name }}</option>
                            @endforeach
                          </select>
                          <p style="font-weight: bold;" class="text text-success">
                            SELECTED GROUPS* :
                            @foreach ($expenseDataGroups as $group)
                            {{ $group->group_code }},
                            @endforeach
                          </p>
                        </div>
                      </div>
                      @else
                      <label for="groups">Groups Visited</label>
                      <table class="table table-sm table-hover">
                        <thead>
                          <tr>
                            <th>G.N</th>
                            <th>Group Code</th>
                            <th>Group Name</th>
                            <th>Meeting Frequency</th>
                            <th>Venue of Meeting</th>
                            <th>Meeting Day</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($expenseDataGroups as $group)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $group->group_code }}</td>
                            <td>{{ $group->group_name }}</td>
                            <td>{{ $group->frequency }}</td>
                            <td>{{ $group->place }}</td>
                            <td>{{ $group->day }}</td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                      @endif
                    </div>
                    <div class="row">
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="amount_collected">Amount Collected</label>
                          <input type="number" name="amount_collected" class="form-control" id="amount_collected"
                            placeholder="Enter amount collected" value="{{ $expenseData->amount_collected }}"
                            autocomplete="on" required>
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="journey_from">Journey From</label>
                          <input type="text" name="journey_from" class="form-control" id="journey_from"
                            placeholder="Enter starting point" value="{{ $expenseData->journey_from }}"
                            autocomplete="on" required>
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="starting_time">Starting Time</label>
                          <input type="time" name="starting_time" class="form-control" id="starting_time"
                            placeholder="Enter starting time" value="{{ $expenseData->start_time }}" autocomplete="on"
                            required>
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="ending_time">Ending Time</label>
                          <input type="time" name="ending_time" class="form-control" id="ending_time"
                            placeholder="Enter ending time" value="{{ $expenseData->end_time }}" autocomplete="on"
                            required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="date">Date of Visit</label>
                          <input type="date" name="date" class="form-control" id="date" placeholder="Date of Visit"
                            value="{{ $expenseData->date }}" autocomplete="off" required>
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="transport_means">Transport Means</label>
                          <input disabled type="text" class="form-control" id="transport_means"
                            placeholder="transport_means"
                            value="{{ $expenseData->transport_means == 1? 'Public' : 'Private' }} Transport"
                            autocomplete="off" required>
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="amount_spent">Amount Spent</label>
                          <input type="number" name="amount_spent" class="form-control" id="amount_spent"
                            placeholder="Enter total amount spent" autocomplete="off"
                            value="{{ $expenseData->amount_spent }}" required>
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="attachment">Attachment</label>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" name="attachment" class="custom-file-input" id="attachment">
                              <label class="custom-file-label" for="attachment">Choose
                                PDF file</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    @if ($expenseData->transport_means == 0)
                    <div class="row">
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="motor_regno">Motorbike Regno</label>
                          <input type="text" name="motor_regno" class="form-control" id="motor_regno"
                            placeholder="Motorbike Regno" value="{{ $expenseData->motor_regno  }}" autocomplete="on">
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="mileage_before">Mileage Before</label>
                          <input type="number" name="mileage_before" class="form-control" id="mileage_before"
                            placeholder="Enter Mileage before" min="0" step="0.01"
                            value="{{ $expenseData->mileage_before }}" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="mileage_after">Mileage After</label>
                          <input type="number" name="mileage_after" class="form-control" id="mileage_after"
                            placeholder="Enter Mileage after" min="0" step="0.01"
                            value="{{ $expenseData->mileage_after }}" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="fuel_consumption">Fuel Consumption (Ltrs)</label>
                          <input type="number" name="fuel_consumption" class="form-control" id="fuel_consumption"
                            placeholder="Enter Fuel consumption" min="0" step="0.01"
                            value="{{ $expenseData->fuel_consumption }}" autocomplete="off">
                        </div>
                      </div>
                    </div>
                    @endif

                    <div class="row">
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="loans_applied">No. of Loans Applied</label>
                          <input type="number" name="loans_applied" class="form-control" id="loans_applied"
                            placeholder="Enter no of loans applied" value="{{ $expenseData->loans_applied }}"
                            autocomplete="off" required>
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="new_members">New Members</label>
                          <input type="number" name="new_members" class="form-control" id="new_members"
                            placeholder="Enter no of new members" value="{{ $expenseData->new_members }}"
                            autocomplete="off" required>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="additional_info">Purpose of the Activity</label>
                          <textarea placeholder="Enter purpose of the Activity" name="additional_info"
                            id="additional_info" class="form-control" cols="2" required
                            rows="3">{{ $expenseData->additional_info }}</textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                  @if (is_null($expense->approver1) && Auth::user()->id == $expenseData->user_id)
                  <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-edit"></i>
                      Update Group Visit Data</button>

                  </div>
                  @endif
                </form>
                @if (is_null($expense->approver1) && Auth::user()->id == $expenseData->user_id)
                <div class="modal-footer justify-content-between">
                  <div class="btn-group">
                    <form action="{{ route('user.group-visits.destroy', $expenseData->visit_id) }}" method="post"
                      onclick="return confirm('Do you really want to delete this Group visitation data?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>
                        Delete Group Visit Data</button>
                    </form>
                  </div>
                </div>
                @endif
                @if (!is_null($expense->approver3) && !is_null($expense->approver1) && !is_null($expense->approver2))
                <div class="modal-footer justify-content-between">
                  <a href="{{ route('export.user-expense', $expense->expense_id)}}" target="_blank">
                    <button class="btn btn-success"> <i class="fa fa-file-pdf"></i>
                      Export Expense to PDF</button>
                  </a>
                </div>
                @endif
                @else
                <form role="form" method="post" action="{{ route('user.group-visits.store') }}"
                  enctype="multipart/form-data" accept-charset="utf-8">
                  @csrf
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                          <label for="county">Select Groups</label>
                          <input type="hidden" name="expense_id" value="{{ $expense->expense_id }}">
                          <select name="groups[]" class="form-control select2"
                            data-placeholder="- Select Groups Visited -" multiple="multiple" required>
                            <option class="mb-1" value="">
                            </option>
                            @foreach ($meetings as $meeting)
                            <option value="{{ $meeting->meeting_id }}">
                              {{ $meeting->group_code. ' - '.$meeting->group_name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="amount_collected">Amount Collected</label>
                          <input type="number" name="amount_collected" class="form-control" id="amount_collected"
                            placeholder="Enter amount collected" value="{{ old('amount_collected') }}" autocomplete="on"
                            required>
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="journey_from">Journey From</label>
                          <input type="text" name="journey_from" class="form-control" id="journey_from"
                            placeholder="Enter starting point" value="{{ old('journey_from') }}" autocomplete="on"
                            required>
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="starting_time">Starting Time</label>
                          <input type="time" name="starting_time" class="form-control" id="starting_time"
                            placeholder="Enter starting time" value="{{ old('start_time') }}" autocomplete="on"
                            required>
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="ending_time">Ending Time</label>
                          <input type="time" name="ending_time" class="form-control" id="ending_time"
                            placeholder="Enter ending time" value="{{ old('end_time') }}" autocomplete="on" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="date">Date of Visit</label>
                          <input type="date" name="date" class="form-control" id="date" placeholder="Date of Visit"
                            value="{{ date('Y-m-d') }}" autocomplete="off" required>
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="transport_means">Transport Means</label>
                          <select name="transport_means" id="transport_means" onchange="showDiv(this)"
                            class="form-control" required>
                            <option class="mb-1" value="">
                              - Select Transport Means -</option>
                            <option value="1">Public Transport</option>
                            <option value="0">Private Transport</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="amount_spent">Amount Spent</label>
                          <input type="number" name="amount_spent" class="form-control" id="amount_spent"
                            placeholder="Enter total amount spent" autocomplete="off" value="{{ old('amount_spent') }}"
                            required>
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="attachment">Attachment</label>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" name="attachment" class="custom-file-input" id="attachment">
                              <label class="custom-file-label" for="attachment">Choose
                                PDF file</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row" id="hidden_div" style="display: none;">
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="motor_regno">Motorbike Regno</label>
                          <input type="text" name="motor_regno" class="form-control" id="motor_regno"
                            placeholder="Motorbike Regno" value="{{ old('motor_regno') }}" autocomplete="on">
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="mileage_before">Mileage Before</label>
                          <input type="number" name="mileage_before" class="form-control" id="mileage_before"
                            placeholder="Enter Mileage before" min="0" step="0.01" value="{{ old('mileage_before') }}"
                            autocomplete="off">
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="mileage_after">Mileage After</label>
                          <input type="number" name="mileage_after" class="form-control" id="mileage_after"
                            placeholder="Enter Mileage after" min="0" step="0.01" value="{{ old('mileage_after') }}"
                            autocomplete="off">
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="fuel_consumption">Fuel Consumption (Ltrs)</label>
                          <input type="number" name="fuel_consumption" class="form-control" id="fuel_consumption"
                            placeholder="Enter Fuel consumption" min="0" step="0.01"
                            value="{{ old('fuel_consumption') }}" autocomplete="off">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="loans_applied">No. of Loans Applied</label>
                          <input type="number" name="loans_applied" class="form-control" id="loans_applied"
                            placeholder="Enter no of loans applied" value="{{ old('loans_applied') }}"
                            autocomplete="off" required>
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label for="new_members">New Members</label>
                          <input type="number" name="new_members" class="form-control" id="new_members"
                            placeholder="Enter no of new members" value="{{ old('new_members') }}" autocomplete="off"
                            required>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="additional_info">Purpose of the Activity</label>
                          <textarea placeholder="Enter purpose of the group visit" name="additional_info"
                            id="additional_info" class="form-control" required cols="2"
                            rows="3">{{ old('additional_info')}}</textarea>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-plus"></i>
                      Save Group Visit Data</button>
                  </div>

                  <!-- /.card-body -->
                </form>
                @endif
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.Profile -->
          </div>
          <!-- /.tab-pane -->

          <div class="tab-pane" id="loans">
            <!-- members -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title"><i class="fa fa-list"></i> New Loans applied </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                @if (empty($expenseData))
                <div class="alert alert-danger">
                  This group visitation expense contains empty details. Please update before adding new loans applied
                </div>
                @else
                @if (is_null($expense->approver1) && Auth::user()->id == $expenseData->user_id)
                <form role="form" method="post" action="{{ route('user.group-visits.save-loan') }}"
                  accept-charset="utf-8">
                  @csrf
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label for="county">Select Member</label>
                          <input type="hidden" name="visit_id"
                            value="{{ !empty($expenseData)? $expenseData->visit_id : '0'}}">
                          <select name="client" id="client" class="form-control select2" id="client" required>
                            <option class="mb-1" value="">
                              - Select Member -</option>
                            <option value="0089810%STEPHEN KUMUNA MWAKIRETI">0089810-STEPHEN KUMUNA MWAKIRETI</option>
                            <option value="0133468%MUSA MKALA JOSEPH">0133468-MUSA MKALA JOSEPH</option>
                            {{-- @foreach ($members as $member)
                            <option value="{{ $member->ClientID }}">
                              {{ $member->ClientID. ' - '.$member->ClientName }}</option>
                            @endforeach --}}
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="loan_product">Loan Product Applied</label>
                          <input type="text" name="loan_product" class="form-control" id="loan_product"
                            placeholder="Enter loan product" value="{{ old('loan_product') }}" autocomplete="on"
                            required>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="loan_amount">Loan Amount</label>
                          <input type="number" name="loan_amount" class="form-control" id="loan_amount"
                            placeholder="Enter loan amount" autocomplete="off" value="{{ old('loan_amount') }}"
                            required>
                        </div>
                      </div>
                    </div>

                  </div>
                  <!-- /.card-body -->
                  <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-plus"></i>
                      Save Member Loan</button>
                  </div>
                </form>
                @endif
                <table class="table table-sm table-striped table-bordered mt-5">
                  <thead>
                    <tr>
                      <th>S.N</th>
                      <th>NAMES</th>
                      <th>ClIENT ID</th>
                      <th>PRODUCT</th>
                      <th>LOAN</th>
                      <th>CREATED AT</th>
                      <th>ACTIONS</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($loans as $loan)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td><strong>{{ $loan->client_name }}</strong></td>
                      <td>{{ $loan->client_id }}</td>
                      <td>{{ $loan->loan_product }}</td>
                      <td>Ksh {{ number_format($loan->loan_amount, 2) }}</td>
                      <td>{{ $loan->created_at }}</td>

                      @if (is_null($expense->approver1) && Auth::user()->id == $expenseData->user_id)
                      <td>
                        <div class="margin">
                          <div class="btn-group">
                            <button type="button" data-toggle="modal" data-target="#modalEditloan-{{ $loan->loan_id }}"
                              class="btn btn-xs btn-warning"><i class="fa fa-edit"></i>
                              Edit</button>
                          </div>
                          <div class="btn-group">
                            <form action="{{ route('user.group-visits.delete-loan', $loan->loan_id) }}" method="post"
                              onclick="return confirm('Do you really want to delete this client loan')">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i>
                                Delete</button>
                            </form>
                          </div>

                        </div>
                      </td>
                      <!--/.modal begin -->
                      <div class="modal fade" id="modalEditloan-{{ $loan->loan_id }}" style="display: none;"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Update Loan</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                              </button>
                            </div>
                            <form action="{{ route('user.group-visits.update-loan', $loan->loan_id) }}" method="post">
                              @csrf
                              @method('PUT')
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-sm-12">
                                    <div class="form-group">
                                      <label for="client_name">Client Name</label>
                                      <input type="text" class="form-control" id="client_name" disabled
                                        autocomplete="on" value="{{ $loan->client_id.' '.$loan->client_name }}"
                                        required>
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-sm-6">
                                    <div class="form-group">
                                      <label for="loan_product">Loan Product Applied</label>
                                      <input type="text" name="loan_product" class="form-control" id="loan_product"
                                        placeholder="Enter loan product" value="{{ $loan->loan_product }}"
                                        autocomplete="on" required>
                                    </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="form-group">
                                      <label for="loan_amount">Loan Amount</label>
                                      <input type="number" name="loan_amount" class="form-control" id="loan_amount"
                                        placeholder="Enter loan amount" autocomplete="off"
                                        value="{{ $loan->loan_amount }}" required>
                                    </div>
                                  </div>
                                </div>

                              </div>
                              <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info"><i class="fa fa-edit"></i>
                                  Update
                                  Loan</button>
                              </div>
                            </form>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                      <!--/modal end -->
                      @endif
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                @endif
              </div>
              <!-- /.card-body -->
            </div>
            <!-- members -->
          </div>
          <!-- /.tab-pane -->

          <div class="tab-pane" id="members">
            <!-- members -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title"><i class="fa fa-users"></i> New Group Members </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                @if (empty($expenseData))
                <div class="alert alert-danger">
                  This group visitation expense contains empty details. Please update before adding new members
                </div>
                @else
                @if (is_null($expense->approver1) && Auth::user()->id == $expenseData->user_id)
                <form role="form" method="post" action="{{ route('user.group-visits.save-member') }}"
                  accept-charset="utf-8">
                  @csrf
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="client_id">Client ID</label>
                          <input type="hidden" name="visit_id"
                            value="{{ !empty($expenseData)? $expenseData->visit_id : '0'}}">
                          <input type="hidden" name="activity_type" value="{{ $expense->activity_type}}">
                          <input type="number" name="client_id" class="form-control" id="client_id"
                            placeholder="Enter client ID" autocomplete="on" value="{{ old('client_id') }}" required>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="client_name">Name</label>
                          <input type="text" name="client_name" class="form-control" id="client_name"
                            placeholder="Enter client name" value="{{ old('name') }}" autocomplete="on" required>
                        </div>
                      </div>

                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="group_code">Group Code</label>
                          <select name="group_code" class="form-control select2"
                            data-placeholder="- Select Client Group -" required>
                            <option class="mb-1" value="">
                            </option>
                            @foreach ($meetings as $meeting)
                            <option value="{{ $meeting->group_code }}">
                              {{ $meeting->group_code. ' - '.$meeting->group_name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="client_phone">Mobile Number</label>
                          <input type="text" name="client_phone" class="form-control" id="mobile_no"
                            placeholder="Enter client mobile number" autocomplete="off"
                            value="{{ old('client_phone') }}" required>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-plus"></i>
                      Save Member</button>
                  </div>
                </form>
                @endif
                <table class="table table-sm table-striped table-bordered mt-5">
                  <thead>
                    <tr>
                      <th>S.N</th>
                      <th>NAMES</th>
                      <th>ClIENT ID</th>
                      <th>MOBILE NUMBER</th>
                      <th>GROUP CODE</th>
                      <th>ACTIONS</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($members as $member)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td><strong>{{ $member->client_name }}</strong></td>
                      <td>{{ $member->client_id }}</td>
                      <td>{{ $member->client_phone }}</td>
                      <td>{{ $member->group_code }}</td>

                      @if (is_null($expense->approver1) && Auth::user()->id == $expenseData->user_id)
                      <td>
                        <div class="margin">
                          <div class="btn-group">
                            <button type="button" data-toggle="modal"
                              data-target="#modalEditmember-{{ $member->member_id }}" class="btn btn-xs btn-warning"><i
                                class="fa fa-edit"></i>
                              Edit</button>
                          </div>
                          <div class="btn-group">
                            <form action="{{ route('user.group-visits.delete-member', $member->member_id) }}"
                              method="post" onclick="return confirm('Do you really want to delete this client member')">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i>
                                Delete</button>
                            </form>
                          </div>

                        </div>
                      </td>
                      <!--/.modal begin -->
                      <div class="modal fade" id="modalEditmember-{{ $member->member_id }}" style="display: none;"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Update member</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                              </button>
                            </div>
                            <form action="{{ route('user.group-visits.update-member', $member->member_id) }}"
                              method="post">
                              @csrf
                              @method('PUT')
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-sm-6">
                                    <div class="form-group">
                                      <label for="client_name">Client Name</label>
                                      <input type="text" name="client_name" class="form-control" id="client_name"
                                        autocomplete="on" value="{{ $member->client_name }}" required>
                                    </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="form-group">
                                      <label for="client_id">Client ID</label>
                                      <input type="number" name="client_id" class="form-control" id="client_id"
                                        placeholder="Enter client ID" autocomplete="on" value="{{ $member->client_id }}"
                                        required>
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-sm-6">
                                    <div class="form-group">
                                      <label for="group_code">Group Code</label>
                                      <select name="group_code" class="form-control select2" required>
                                        <option class="mb-1" value="{{ $member->group_code }}">
                                          {{ $member->group_code }}
                                        </option>
                                        @foreach ($meetings as $meeting)
                                        <option value="{{ $meeting->group_code }}">
                                          {{ $meeting->group_code. ' - '.$meeting->group_name }}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="form-group">
                                      <label for="client_phone">Mobile Number</label>
                                      <input type="text" name="client_phone" class="form-control" id="mobile_no"
                                        placeholder="Enter client mobile number" autocomplete="off"
                                        value="{{ $member->client_phone }}" required>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info"><i class="fa fa-edit"></i>
                                  Update
                                  member</button>
                              </div>
                            </form>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                      <!--/modal end -->
                      @endif
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                @endif
              </div>
              <!-- /.card-body -->
            </div>
            <!-- members -->
          </div>
          <!-- /.tab-pane -->

          <div class="tab-pane" id="approvals">
            <!-- members -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title"><i class="fa fa-briefcase"></i> Expense Approvals </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                @if (empty($expenseData))
                <div class="alert alert-danger">
                  This group visitation expense contains empty details. Please update so for approval
                </div>
                @else
                <table class="table table-sm table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>S.N</th>
                      <th>NAMES</th>
                      <th>BRANCH</th>
                      <th>EMAIL</th>
                      <th>APPROVAL LEVEL</th>
                      <th>STATUS</th>
                      <th>COMMENT</th>
                      <th>TIME</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if (!is_null($approvals['branch_manager']))
                    <tr>
                      <td>1</td>
                      <td>{{ $approvals['branch_manager']->name }}</td>
                      <td>{{ $approvals['branch_manager']->branch_name }}</td>
                      <td>{{ $approvals['branch_manager']->email }}</td>
                      <td>Branch Manager Approval</td>
                      <td>{{ $approvals['branch_manager']->approver1_status == 1? 'Approved' : 'Rejected' }}</td>
                      <td>{{ $approvals['branch_manager']->approver1_msg }}</td>
                      <td>{{ $approvals['branch_manager']->approver1_date }}</td>
                    </tr>
                    @endif
                    @if (!is_null($approvals['accountant']))
                    <tr>
                      <td>2</td>
                      <td>{{ $approvals['accountant']->name }}</td>
                      <td>{{ $approvals['accountant']->branch_name }}</td>
                      <td>{{ $approvals['accountant']->email }}</td>
                      <td>Accountant Approval</td>
                      <td>{{ $approvals['accountant']->approver2_status == 1? 'Approved' : 'Rejected' }}</td>
                      <td>{{ $approvals['accountant']->approver2_msg }}</td>
                      <td>{{ $approvals['accountant']->approver2_date }}</td>
                    </tr>
                    @endif
                    @if (!is_null($approvals['finance_manager']))
                    <tr>
                      <td>3</td>
                      <td>{{ $approvals['finance_manager']->name }}</td>
                      <td>{{ $approvals['finance_manager']->branch_name }}</td>
                      <td>{{ $approvals['finance_manager']->email }}</td>
                      <td>Finance Manager Approval</td>
                      <td>{{ $approvals['finance_manager']->approver3_status == 1? 'Approved' : 'Rejected' }}</td>
                      <td>{{ $approvals['finance_manager']->approver3_msg }}</td>
                      <td>{{ $approvals['finance_manager']->approver3_date }}</td>
                    </tr>
                    @endif
                  </tbody>
                </table>

                @if (is_null($expense->approver1))
                <!-- .Branch manager approval -->
                @if (Auth::user()->hasRole('branch manager'))
                <form class="mt-2" role="form" method="post"
                  action="{{ route('user.expenses.approve', $expense->expense_id) }}" accept-charset="utf-8">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="approval_level" value="Branch Manager">
                  <div class="card-body">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label for="comment">Approval Comment</label>
                        <textarea name="comment" id="comment" class="form-control" cols="4" rows="3" required
                          placeholder="Enter your comment here ">{{ old('comment') }}</textarea>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-plus"></i>
                      Approve Transaction</button>
                  </div>
                </form>
                @endif
                @endif

                @if (is_null($expense->approver2) && !is_null($expense->approver1))
                <!-- .Accountant manager approval -->
                @if (Auth::user()->hasRole('accountant'))
                      <div class="mt-5 card card-warning card-outline">
                        <div class="card-header p-2">
                          <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#approve" data-toggle="tab"><i
                                  class="fa fa-user"></i>
                                Approve Transaction</a></li>
                            <li class="nav-item"><a class="nav-link" href="#reject" data-toggle="tab"><i
                                  class="fa fa-list-alt"></i>
                                Reject Transaction</a></li>
                          </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                          <div class="tab-content">
                            <div class="tab-pane active" id="approve">
                              <form role="form" method="post"
                                action="{{ route('user.expenses.approve', $expense->expense_id) }}"
                                accept-charset="utf-8">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="approval_level" value="Accountant">
                                <div class="card-body">
                                  <div class="col-sm-12">
                                    <div class="form-group">
                                      <label for="comment">Approval Comment</label>
                                      <textarea name="comment" id="comment" class="form-control" cols="4" rows="3"
                                        required placeholder="Enter your comment here ">{{ old('comment') }}</textarea>
                                    </div>
                                  </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="modal-footer justify-content-between">
                                  <button type="submit" class="btn btn-primary"> <i class="fa fa-plus"></i>
                                    Approve Transaction</button>
                                </div>
                              </form>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="reject">
                              <form role="form" method="post"
                                action="{{ route('user.expenses.reject', $expense->expense_id) }}"
                                accept-charset="utf-8">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="approval_level" value="Accountant">
                                <div class="card-body">
                                  <div class="col-sm-12">
                                    <div class="form-group">
                                      <label for="comment">Rejection Comment</label>
                                      <textarea name="comment" id="comment" class="form-control" cols="4" rows="3"
                                        required placeholder="Enter your comment here ">{{ old('comment') }}</textarea>
                                    </div>
                                  </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="modal-footer justify-content-between">
                                  <button type="submit" class="btn btn-danger"> <i class="fa fa-plus"></i>
                                    Reject Transaction</button>
                                </div>
                              </form>
                            </div>
                            <!-- /.tab-pane -->
                          </div>
                          <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                      @endif
                @endif

                @if (is_null($expense->approver3) && !is_null($expense->approver1) && !is_null($expense->approver2))
                <!-- .Finance manager approval -->
                @if (Auth::user()->hasRole('finance manager'))
                <div class="mt-5 card card-warning card-outline">
                  <div class="card-header p-2">
                    <ul class="nav nav-pills">
                      <li class="nav-item"><a class="nav-link active" href="#approve" data-toggle="tab"><i
                            class="fa fa-user"></i>
                          Approve Transaction</a></li>
                      <li class="nav-item"><a class="nav-link" href="#reject" data-toggle="tab"><i
                            class="fa fa-list-alt"></i>
                          Reject Transaction</a></li>
                    </ul>
                  </div><!-- /.card-header -->
                  <div class="card-body">
                    <div class="tab-content">
                      <div class="tab-pane active" id="approve">
                        <form role="form" method="post"
                          action="{{ route('user.expenses.approve', $expense->expense_id) }}" accept-charset="utf-8">
                          @csrf
                          @method('PUT')
                          <input type="hidden" name="approval_level" value="Finance Manager">
                          <div class="card-body">
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="comment">Approval Comment</label>
                                <textarea name="comment" id="comment" class="form-control" cols="4" rows="3" required
                                  placeholder="Enter your comment here ">{{ old('comment') }}</textarea>
                              </div>
                            </div>
                          </div>
                          <!-- /.card-body -->
                          <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary"> <i class="fa fa-plus"></i>
                              Approve Transaction</button>
                          </div>
                        </form>
                      </div>
                      <!-- /.tab-pane -->

                      <div class="tab-pane" id="reject">
                        <form role="form" method="post"
                          action="{{ route('user.expenses.reject', $expense->expense_id) }}" accept-charset="utf-8">
                          @csrf
                          @method('PUT')
                          <input type="hidden" name="approval_level" value="Finance Manager">
                          <div class="card-body">
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="comment">Rejection Comment</label>
                                <textarea name="comment" id="comment" class="form-control" cols="4" rows="3" required
                                  placeholder="Enter your comment here ">{{ old('comment') }}</textarea>
                              </div>
                            </div>
                          </div>
                          <!-- /.card-body -->
                          <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-danger"> <i class="fa fa-plus"></i>
                              Reject Transaction</button>
                          </div>
                        </form>
                      </div>
                      <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                  </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
                @endif
                @endif
                @endif
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
</section>
<!-- /.content -->
@endsection
@push('scripts')
<script>
  function showDiv(select) {
    if (select.value == 0) {
      //window.alert('Hello world') ;  
      document.getElementById('hidden_div').style.display = "flex";
    } else {
      document.getElementById('hidden_div').style.display = "none";
    }
  } 
</script>
@endpush