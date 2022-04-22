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
          <div class="card card-warning card-outline">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#details" data-toggle="tab"><i
                      class="fa fa-user"></i>
                    Appraisal Details</a></li>
                <li class="nav-item"><a class="nav-link" href="#approvals" data-toggle="tab"><i
                      class="fa fa-briefcase"></i>
                    Approvals</a></li>
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane active" id="details">
                  <!-- Profile -->
                  <div class="card card-warning">
                    <div class="card-header">
                      <h3 class="card-title"><i class="fa fa-user"></i> Appraisal Details</h3>
                    </div>
                    <div class="card-body">
                      <div class="container-fluid">
                        @if (!empty($appraisalData))
                        <form role="form" method="post"
                          action="{{ route('user.appraisals.update', $appraisalData->appraisal_id) }}"
                          enctype="multipart/form-data" accept-charset="utf-8">
                          @csrf
                          @method('PUT')
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                  <label for="clients">Groups/Clients Appraised</label>
                                  <textarea placeholder="Enter group/clients being appraised separated by commas"
                                    name="clients" id="clients" class="form-control" required cols="2"
                                    rows="2">{{ $appraisalData->clients }}</textarea>
                                </div>
                              </div>
                              <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                  <label for="additional_info">Purpose of the Appraisal</label>
                                  <textarea placeholder="Enter detailed purpose of this activity" name="additional_info"
                                    id="additional_info" class="form-control" required cols="2"
                                    rows="2">{{ $appraisalData->additional_info }}</textarea>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                  <label for="journey_from">Journey From</label>
                                  <input type="text" name="journey_from" class="form-control" id="journey_from"
                                    placeholder="Enter starting point" value="{{ $appraisalData->journey_from }}"
                                    autocomplete="on" required>
                                </div>
                              </div>
                              <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                  <label for="venue">Client Location</label>
                                  <input type="text" name="venue" class="form-control" id="venue"
                                    placeholder="Enter venue of appraisal" value="{{ $appraisalData->venue }}"
                                    autocomplete="on" required>
                                </div>
                              </div>
                              <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                  <label for="starting_time">Starting Time</label>
                                  <input type="time" name="starting_time" class="form-control" id="starting_time"
                                    placeholder="Enter starting time" value="{{ $appraisalData->start_time }}"
                                    autocomplete="on" required>
                                </div>
                              </div>
                              <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                  <label for="ending_time">Ending Time</label>
                                  <input type="time" name="ending_time" class="form-control" id="ending_time"
                                    placeholder="Enter ending time" value="{{ $appraisalData->end_time }}"
                                    autocomplete="on" required>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                  <label for="date">Date of Visit</label>
                                  <input type="date" name="date" class="form-control" id="date"
                                    placeholder="Date of Visit" value="{{ $appraisalData->date }}" autocomplete="off"
                                    required>
                                </div>
                              </div>
                              <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                  <label for="transport_means">Transport Means</label>
                                  <input disabled type="text" class="form-control" id="transport_means"
                                    placeholder="transport_means"
                                    value="{{ $appraisalData->transport_means == 1? 'Public' : 'Private' }} Transport"
                                    autocomplete="off" required>
                                </div>
                              </div>
                              <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                  <label for="amount_spent">Amount Spent</label>
                                  <input type="number" name="amount_spent" class="form-control" id="amount_spent"
                                    placeholder="Enter total amount spent" autocomplete="off"
                                    value="{{ $appraisalData->amount_spent }}" required>
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
                            @if ($appraisalData->transport_means == 0)
                            <div class="row">
                              <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                  <label for="motor_regno">Motorbike Regno</label>
                                  <input type="text" name="motor_regno" class="form-control" id="motor_regno"
                                    placeholder="Motorbike Regno" value="{{ $appraisalData->motor_regno }}"
                                    autocomplete="on">
                                </div>
                              </div>
                              <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                  <label for="mileage_before">Mileage Before</label>
                                  <input type="number" name="mileage_before" class="form-control" id="mileage_before"
                                    placeholder="Enter Mileage before" min="0" step="0.01"
                                    value="{{ $appraisalData->mileage_before }}" autocomplete="off">
                                </div>
                              </div>
                              <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                  <label for="mileage_after">Mileage After</label>
                                  <input type="number" name="mileage_after" class="form-control" id="mileage_after"
                                    placeholder="Enter Mileage after" min="0" step="0.01"
                                    value="{{ $appraisalData->mileage_after }}" autocomplete="off">
                                </div>
                              </div>
                              <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                  <label for="fuel_consumption">Fuel Consumption (Ltrs)</label>
                                  <input type="number" name="fuel_consumption" class="form-control"
                                    id="fuel_consumption" placeholder="Enter Fuel consumption" min="0" step="0.01"
                                    value="{{ $appraisalData->fuel_consumption }}" autocomplete="off">
                                </div>
                              </div>
                            </div>
                            @endif
                          </div>
                          @if (is_null($expense->approver1) && Auth::user()->id == $appraisalData->user_id)
                          <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary"> <i class="fa fa-edit"></i>
                              Update Appraisal Data</button>
                          </div>
                          @endif
                          <!-- /.card-body -->
                        </form>
                        @if (is_null($expense->approver1) && Auth::user()->id == $appraisalData->user_id)
                        <div class="modal-footer justify-content-between">
                          <div class="btn-group">
                            <form action="{{ route('user.appraisals.destroy', $appraisalData->appraisal_id) }}"
                              method="post"
                              onclick="return confirm('Do you really want to delete this appraisal data?')">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>
                                Delete Appraisal Data</button>
                            </form>
                          </div>
                        </div>
                        @endif
                        @if (!is_null($expense->approver3) && !is_null($expense->approver1) &&
                        !is_null($expense->approver2))
                        <div class="modal-footer justify-content-between">
                          <a href="{{ route('export.user-expense', $expense->expense_id)}}" target="_blank">
                            <button class="btn btn-success"> <i class="fa fa-file-pdf"></i>
                              Export Expense to PDF</button>
                          </a>
                        </div>
                        @endif
                        @else
                        <form role="form" method="post" action="{{ route('user.appraisals.store') }}"
                          enctype="multipart/form-data" accept-charset="utf-8">
                          @csrf
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                  <label for="clients">Groups/Clients Appraised</label>
                                  <input type="hidden" name="expense_id" value="{{ $expense->expense_id }}">
                                  <textarea placeholder="Enter group/clients being appraised separated by commas"
                                    name="clients" id="clients" class="form-control" required cols="2"
                                    rows="2">{{ old('clients')}}</textarea>
                                </div>
                              </div>
                              <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                  <label for="additional_info">Purpose of the Appraisal</label>
                                  <textarea placeholder="Enter detailed purpose of this activity" name="additional_info"
                                    id="additional_info" class="form-control" required cols="2"
                                    rows="2">{{ old('additional_info')}}</textarea>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                  <label for="journey_from">Journey From</label>
                                  <input type="text" name="journey_from" class="form-control" id="journey_from"
                                    placeholder="Enter starting point" value="{{ old('journey_from') }}"
                                    autocomplete="on" required>
                                </div>
                              </div>
                              <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                  <label for="venue">Client Location</label>
                                  <input type="text" name="venue" class="form-control" id="venue"
                                    placeholder="Enter venue of appraisal" value="{{ old('venue') }}" autocomplete="on"
                                    required>
                                </div>
                              </div>
                              <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                  <label for="starting_time">Starting Time</label>
                                  <input type="time" name="starting_time" class="form-control" id="starting_time"
                                    placeholder="Enter starting time" value="{{ old('starting_time') }}"
                                    autocomplete="on" required>
                                </div>
                              </div>
                              <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                  <label for="ending_time">Ending Time</label>
                                  <input type="time" name="ending_time" class="form-control" id="ending_time"
                                    placeholder="Enter ending time" value="{{ old('ending_time') }}" autocomplete="on"
                                    required>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                  <label for="date">Date of Visit</label>
                                  <input type="date" name="date" class="form-control" id="date"
                                    placeholder="Date of Visit" value="{{ date('Y-m-d') }}" autocomplete="off" required>
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
                                    placeholder="Enter total amount spent" autocomplete="off"
                                    value="{{ old('amount_spent') }}" required>
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
                                    placeholder="Enter Mileage before" min="0" step="0.01"
                                    value="{{ old('mileage_before') }}" autocomplete="off">
                                </div>
                              </div>
                              <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                  <label for="mileage_after">Mileage After</label>
                                  <input type="number" name="mileage_after" class="form-control" id="mileage_after"
                                    placeholder="Enter Mileage after" min="0" step="0.01"
                                    value="{{ old('mileage_after') }}" autocomplete="off">
                                </div>
                              </div>
                              <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                  <label for="fuel_consumption">Fuel Consumption (Ltrs)</label>
                                  <input type="number" name="fuel_consumption" class="form-control"
                                    id="fuel_consumption" placeholder="Enter Fuel consumption" min="0" step="0.01"
                                    value="{{ old('fuel_consumption') }}" autocomplete="off">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary"> <i class="fa fa-plus"></i>
                              Save Appraisal Data</button>
                          </div>
                          <!-- /.card-body -->
                        </form>
                        @endif
                      </div>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.Profile -->
                </div>
                <!-- /.tab-pane -->

                <div class="tab-pane" id="approvals">
                  <!-- approvals -->
                  <div class="card card-warning">
                    <div class="card-header">
                      <h3 class="card-title"><i class="fa fa-briefcase"></i> Expense Approvals </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      @if (empty($appraisalData))
                      <div class="alert alert-danger">
                        This expense contains empty details. Please update so for approval
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

                      @if (is_null($expense->approver3) && !is_null($expense->approver1) &&
                      !is_null($expense->approver2))
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
                                action="{{ route('user.expenses.approve', $expense->expense_id) }}"
                                accept-charset="utf-8">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="approval_level" value="Finance Manager">
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
                                <input type="hidden" name="approval_level" value="Finance Manager">
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
                      @endif
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- approvals -->
                </div>
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->
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