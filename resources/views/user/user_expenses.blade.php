@extends('layouts.admin.table')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="margin mb-2 text-right">
      <button type="button" data-toggle="modal" data-target="#modalAddExpense" class="btn btn-primary"><i
          class="fa fa-plus"></i> Generate New Expense</button>
    </div>
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-list"></i>Expenses Management ({{ $expenses->count() }})</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="table1" class="table table-sm table-bordered table-hover table-head-fixed">
          <thead>
            <tr>
              <th>S.N</th>
              <th>DATE</th>
              <th>EXPENSE TYPE</th>
              <th>NAMES</th>
              <th>BRANCH</th>
              <th>FILE</th>
              <th>AMOUNT SPENT</th>
              <th>APPROVAL</th>
              <th>ACTIONS</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($expenses as $expense)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $expense->date }}</td>
              <td>{{ $expense->activity_name }}</td>
              <td>{{ $expense->name }}</td>
              <td>{{ strtoupper($expense->branch_name) }}</td>
              <td>
                <a href="{{ route('user.group-visits.file', $expense->expense_id)}}" target="_blank">
                  <em>View File</em>
                </a>
              </td>
              <td><strong>Ksh {{ number_format($expense->amountSpent, 2) }}</strong></td>
              <td>{{ $expense->approvalStatus }} </td>
              <td>
                <div class="margin">
                  <div class="btn-group">
                    <a href="{{ route('user.expenses.show', $expense->expense_id) }}"
                      title="Click to view expense details">
                      <button type="button" class="btn btn-xs btn-info"><i class="fa fa-eye"></i>
                        View</button>
                    </a>
                  </div>
                  @if (is_null($expense->approver1) && $expense->user_id == Auth::user()->id)
                  <div class="btn-group">
                    <button type="button" data-toggle="modal" data-target="#modalEditExpense-{{ $expense->expense_id }}"
                      class="btn btn-xs btn-warning"><i class="fa fa-edit"></i>
                      Edit</button>
                  </div>

                  <div class="btn-group">
                    <form action="{{ route('user.expenses.destroy', $expense->expense_id) }}" method="post"
                      onclick="return confirm('Do you really want to delete this expense activity?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i>
                        Delete</button>
                    </form>
                  </div>
                  @endif
                </div>
              </td>
            </tr>
            <!--/.modal begin -->
            <div class="modal fade" id="modalEditExpense-{{ $expense->expense_id }}" style="display: none;"
              aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Update Expense Activity</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <form action="{{ route('user.expenses.update', $expense->expense_id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="activity_type">Expense Type*</label>
                            <select disabled name="activity_type" id="activity_type" class="form-control select2"
                              required>
                              <option class="mb-1" value="{{ $expense->activity_id }}">
                                {{ $expense->activity_name }}</option>
                              @foreach ($activities as $activity)
                              <option value="{{ $activity->activity_id }}">{{ $activity->activity_name }}
                              </option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="date">Expense Date</label>
                            <input type="date" name="date" class="form-control" id="date" value="{{ $expense->date }}"
                              placeholder="Select Expense Date" autocomplete="on" required>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-info"><i class="fa fa-edit"></i> Update Expense Data</button>
                    </div>
                  </form>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!--/modal end -->
            @endforeach
          </tbody>
        </table>
        <!--/.modal begin -->
        <div class="modal fade" id="modalAddExpense" style="display: none;" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Add New Expense</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <form action="{{ route('user.expenses.store') }}" method="post">
                @csrf
                <div class="modal-body">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="activity_type">Expense Type*</label>
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="outpost_id" value="{{ Auth::user()->profile->outpost }}">
                        <select name="activity_type" id="activity_type" class="form-control select2" required>
                          <option class="mb-1" value="">
                            - Select Expense Type -</option>
                          @foreach ($activities as $activity)
                          <option value="{{ $activity->activity_id }}">{{ $activity->activity_name }}
                          </option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="date">Expense Date</label>
                        <input type="date" name="date" class="form-control" id="date" value="{{ date('Y-m-d') }}"
                          placeholder="Select Expense Date" autocomplete="on" required>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-info"><i class="fa fa-plus"></i> Generate Expense Now</button>
                </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!--/modal end -->
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection