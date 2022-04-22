<html>

<head>
  <title> Expense Claim Data | {{ config('app.name') }} </title>
  <style>
    body {
      text-align: left;
      font-size: 10px;
      font-family: "Source Sans Pro";
    }

    /** Define the margins of your page **/
    @page {
      margin: 30px 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      /* border: 1px solid black; */
    }

    .v_table{
      margin-top: 30px;
    }

    .v_table 
    td {
      border: 0px;
      text-align: left;
      padding: 15px;
    }

    th,
    td {
      border: 1px solid #ddd;
      text-align: left;
      padding: 5px 5px 5px 10px;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    header {
      position: fixed;
      top: -60px;
      left: 0px;
      right: 0px;
      height: 50px;

      /** Extra personal styles **/
      background-color: #42647F;
      color: white;
      text-align: left;
      padding-left: 10px;
      line-height: 35px;
    }

    footer {
      position: fixed;
      bottom: -30px;
      left: 0px;
      right: 0px;
      height: 50px;

      /** Extra personal styles **/
      /* background-color: #42647F	; */
      color: #42647F;
      padding-left: left;
      text-align: left;
      text-transform: italic;
      line-height: 35px;
    }

    h3 {
      background-color: grey;
      padding: 15px;
    }

    h4 {
      /* background-color: grey; */
      /* padding: 10px; */
    }
  </style>
</head>

<body>
  <!-- Define header and footer blocks before your content -->
  <footer style="font-size: 10px; font-style:italic">
    Bimas Kenya Limited &copy;
    <?php echo date("Y");?> |
    <?= ucwords('Document printed by '.ucwords(Auth::user()->name).' on '.date('F d, Y h:i:sa'))?>
  </footer>

  <!-- Wrap the content of your PDF inside a main tag -->
  <main>
    <div style="page-break-after: none;">
      <h3>BIMAS EXPENSE CLAIM FORM : {{ $user->name.', '.$user->mobile_no.', '.$user->email }} [ {{ $branch->branch_name }} | DATE : {{ date('F d, Y h:i:sa') }}] FROM {{ $date['start_date'] }} TO {{ $date['end_date'] }}</h3>
      <table>
        <thead>
          <tr>
            <th>C.N</th>
            <th>DATE/TIME</th>
            <th>ACTIVITY TYPE</th>
            <th>PURPOSE OF ACTIVITY</th>
            <th>GROUPS/CLIENTS VISITED</th>
            <th>JOURNEY FROM/TO</th>
            <th>AMOUNT SPENT</th>
            <th>AMOUNT COLLECTED</th>
            <th>T/MEANS</th>
            <th>TOTAL LOANS</th>
            <th>MB/MA</th>
            <th>DST</th>
            <th>FUEL</th>
            <th>SIGNED</th>
          </tr>
        </thead>
        <tbody>
            @php 
             $groupsExpense = 0;
             $groupsExpenseCollected = 0;

             $appraisalExpense = 0;
             $appraisalExpenseCollected = 0;

             $recoveryExpense = 0;
             $recoveryExpenseCollected = 0;
             
             $followupExpense = 0;
             $followupExpenseCollected = 0;
            @endphp
            @foreach ($expenses as $expense)
              <tr>
                  @if ($expense->activity_id == 1)
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $expense->date }}</td>
                  <td>{{ strtoupper($expense->activity_name) }}</td>
                  <td>{{ $expense->groupVisitDetails->additional_info }}</td>
                  <td>
                      @foreach ($expense->groupsVisited as $group)
                      {{ $group->group_code.' - '.$group->group_name }} ,<br>
                      @endforeach
                  </td>
                  <td>{{ $expense->groupVisitDetails->journey_from.'/Group Meeting Venue' }}</td>
                  <td><strong>Ksh {{ number_format($expense->amountSpent, 2) }}</strong></td>
                  <td><strong>Ksh {{ number_format($expense->groupVisitDetails->amount_collected, 2) }}</strong></td>
                  <td>{{ $expense->groupVisitDetails->transport_means == 0 ? 'Private ('.$expense->groupVisitDetails->motor_regno.')' : 'Public' }}</td>
                  <td>({{$expense->groupsLoans->count()}}) Ksh {{ number_format($expense->groupsLoans->sum('loan_amount'), 2) }}</td>
                  <td>{{ $expense->groupVisitDetails->mileage_before.'/'.$expense->groupVisitDetails->mileage_after }}</td>
                  <td>{{ $expense->groupVisitDetails->mileage_after - $expense->groupVisitDetails->mileage_before }}Kms</td>
                  <td>{{ $expense->groupVisitDetails->fuel_consumption }} Ltrs</td>
                  <td>{{ $expense->approver3_date }}</td>

                  @php
                    $groupsExpense +=$expense->amountSpent; 
                    $groupsExpenseCollected += $expense->groupVisitDetails->amount_collected; 
                  @endphp
                  @endif  

                  @if ($expense->activity_id == 2)
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $expense->date }}</td>
                  <td>{{ strtoupper($expense->activity_name) }}</td>
                  <td>{{ $expense->appraisalData->additional_info }}</td>
                  <td>{{ $expense->appraisalData->clients }}</td>
                  <td>{{ $expense->appraisalData->journey_from.'/'.$expense->appraisalData->venue }}</td>
                  <td><strong>Ksh {{ number_format($expense->amountSpent, 2) }}</strong></td>
                  <td><strong>Ksh {{ number_format(0, 2) }}</strong></td>
                  <td>{{ $expense->appraisalData->transport_means == 0 ? 'Private ('.$expense->appraisalData->motor_regno.')' : 'Public' }}</td>
                  <td>(0)</td>
                  <td>{{ $expense->appraisalData->mileage_before.'/'.$expense->appraisalData->mileage_after }}</td>
                  <td>{{ $expense->appraisalData->mileage_after - $expense->appraisalData->mileage_before }}Kms</td>
                  <td>{{ $expense->appraisalData->fuel_consumption }} Ltrs</td>
                  <td>{{ $expense->approver3_date }}</td>

                  @php
                    $appraisalExpense += $expense->amountSpent; 
                  @endphp
                  @endif  

                  @if ($expense->activity_id == 3)
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $expense->date }}</td>
                  <td>{{ strtoupper($expense->activity_name) }}</td>
                  <td>{{ $expense->recoveryData->additional_info }}</td>
                  <td>{{ $expense->recoveryData->client_id.' - '.$expense->recoveryData->client_name.'['.$expense->recoveryData->client_phone.']' }}</td>
                  <td>{{ $expense->recoveryData->journey_from.'/'.$expense->recoveryData->venue }}</td>
                  <td><strong>Ksh {{ number_format($expense->amountSpent, 2) }}</strong></td>
                  <td><strong>Ksh {{ number_format($expense->recoveryData->amount_collected, 2) }}</strong></td>
                  <td>{{ $expense->recoveryData->transport_means == 0 ? 'Private ('.$expense->recoveryData->motor_regno.')' : 'Public' }}</td>
                  <td>(0)</td>
                  <td>{{ $expense->recoveryData->mileage_before.'/'.$expense->recoveryData->mileage_after }}</td>
                  <td>{{ $expense->recoveryData->mileage_after - $expense->recoveryData->mileage_before }}Kms</td>
                  <td>{{ $expense->recoveryData->fuel_consumption }} Ltrs</td>
                  <td>{{ $expense->approver3_date }}</td>

                  @php
                  $recoveryExpense += $expense->amountSpent; 
                  $recoveryExpenseCollected += $expense->recoveryData->amount_collected; 
                  @endphp
                  @endif 

                  @if ($expense->activity_id == 4)
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $expense->date }}</td>
                  <td>{{ strtoupper($expense->activity_name) }}</td>
                  <td>{{ $expense->followupData->additional_info }}</td>
                  <td>{{ $expense->followupData->clients }}</td>
                  <td>{{ $expense->followupData->journey_from.'/'.$expense->followupData->venue }}</td>
                  <td><strong>Ksh {{ number_format($expense->amountSpent, 2) }}</strong></td>
                  <td><strong>Ksh {{ number_format($expense->followupData->amount_collected, 2) }}</strong></td>
                  <td>{{ $expense->followupData->transport_means == 0 ? 'Private ('.$expense->followupData->motor_regno.')' : 'Public' }}</td>
                  <td>(0)</td>
                  <td>{{ $expense->followupData->mileage_before.'/'.$expense->followupData->mileage_after }}</td>
                  <td>{{ $expense->followupData->mileage_after - $expense->followupData->mileage_before }}Kms</td>
                  <td>{{ $expense->followupData->fuel_consumption }} Ltrs</td>
                  <td>{{ $expense->approver3_date }}</td>

                  @php
                  $followupExpense +=$expense->amountSpent; 
                  $followupExpenseCollected += $expense->followupData->amount_collected; 
                  @endphp
                  @endif 
              </tr>
            @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th style="text-align: right;" colspan="6">Sub totals at at {{ date('F d, Y h:i:sa') }}</th>
            <th>KSH {{ number_format($groupsExpense + $appraisalExpense + $followupExpense + $recoveryExpense, 2) }}</th>
            <th>KSH {{ number_format($followupExpenseCollected + $groupsExpenseCollected + $recoveryExpenseCollected, 2) }}</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
        </tfoot>
      </table>

      <div class="v_table">
        <table>
          <tr>
            <td>VERIFIED BY</td>
            <td>_________________________________</td>
            <td>SIGNATURE</td>
            <td>_________________________________</td>
            <td>DATE</td>
            <td>_________________________________</td>
          </tr>
          <tr>
            <td>APPROVED BY</td>
            <td>_________________________________</td>
            <td>SIGNATURE</td>
            <td>_________________________________</td>
            <td>DATE</td>
            <td>_________________________________</td>
          </tr>
        </table>
      </div>
    </div>
  </main>
</body>

</html>