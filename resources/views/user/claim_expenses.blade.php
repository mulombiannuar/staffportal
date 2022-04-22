@extends('layouts.admin.table')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-list"></i> Unpaid Claim Expenses </h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="table1" class="table table-sm table-bordered table-striped table-head-fixed">
          <thead>
            <tr>
              <th>S.N</th>
              <th>DATE</th>
              <th>EXPENSE TYPE</th>
              <th>NAMES</th>
              <th>BRANCH</th>
              <th>AMOUNT SPENT</th>
              <th>APPROVAL</th>
              <th>PAY</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($expenses as $expense)
              @if ($expense->paid == 0)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $expense->date }}</td>
                <td>{{ $expense->activity_name }}</td>
                <td>{{ $expense->name }}</td>
                <td>{{ strtoupper($expense->branch_name) }}</td>
                <td><strong>Ksh {{ number_format($expense->amountSpent, 2) }}</strong></td>
                <td>{{ $expense->approvalStatus }} </td>
                <td>
                  <div class="margin">
                    <div class="btn-group">
                      <a href="{{ route('user.group-visits.file', $expense->expense_id)}}" target="_blank"
                        title="Click to view expense receipt details">
                        <button type="button" class="btn btn-xs btn-default"><i class="fa fa-file-pdf"></i>
                          View File</button>
                      </a>
                    </div>
                    <div class="btn-group">
                      <a href="{{ route('export.user-expense', $expense->expense_id)}}" target="_blank"
                        title="Click to view expense details">
                        <button type="button" class="btn btn-xs btn-info"><i class="fa fa-print"></i>
                          Print Claim</button>
                      </a>
                    </div>
                    <div class="btn-group">
                      <form action="{{ route('user.expenses.claims.pay', $expense->expense_id) }}" method="post"
                        onclick="return confirm('Do you really want to mark expense activity as paid?')">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-plus"></i>
                          Pay Claim</button>
                      </form>
                    
                    </div>
                  </div>
                </td>
              </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection