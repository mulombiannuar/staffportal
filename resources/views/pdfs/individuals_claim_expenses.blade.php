<html>

<head>
  <title> Expense Claim Data | {{ config('app.name') }} </title>
  <style>
    body {
      text-align: left;
      font-size: 9px;
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

    .v_table {
      margin-top: 30px;
    }

    .v_table td {
      border: 0px;
      text-align: left;
      padding: 15px;
    }

    .inner_table table,
    td,
    th {
      border: 0px;
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
    <h3>BIMAS EXPENSE CLAIM FORM [ {{ $branch->branch_name }} | DATE : {{ date('F d, Y h:i:sa') }}] FROM {{ $date['start_date'] }} TO {{ $date['end_date'] }}</h3>
    </th>
    <table>
      <thead>
        <tr>
          <th>NAMES</th>
          <th>
            <table class="inner_table">
              <tr>
                <th width="5%">DATE</th>
                <th width="8%">TYPE</th>
                <th width="15%">PURPOSE OF ACTIVITY</th>
                <th width="15%">CLIENTS VISITED</th>
                <th width="8%">JOURNEY FROM/TO</th>
                <th width="5%">SPENT</th>
                <th width="5%">CLCTED</th>
                <th width="10%">T/MEANS</th>
                <th width="10%">TOTAL LOANS</th>
                <th width="5%">MB/MA</th>
                <th width="5%">DST</th>
                <th width="4%">FUEL</th>
                <th width="5%">SIGNED</th>
              </tr>
            </table>
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
        @if (!empty($user->expenses))
        <tr>
          <td>
            {{ strtoupper($user->name) }} [{{ $user->mobile_no }}]
          </td>
          <td>
            <table>
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
                @foreach ($user->expenses as $expense)
                <tr>
                  <td width="5%">
                    {{ $expense->date }}
                  </td>
                  <td width="8%">
                    {{ strtoupper($expense->activity_name) }}
                  </td>

                  @if ($expense->activity_id == 1)
                  <td width="15%">{{ $expense->groupVisitDetails->additional_info }}</td>
                  <td width="15%">
                    @foreach ($expense->groupsVisited as $group)
                    {{ $group->group_code.' - '.$group->group_name }} ,<br>
                    @endforeach
                  </td>
                  <td width="8%">{{ $expense->groupVisitDetails->journey_from.'/Group Meeting Venue' }}</td>
                  <td width="5%"><strong>Ksh {{ number_format($expense->amountSpent, 2) }}</strong></td>
                  <td width="5%"><strong>Ksh {{ number_format($expense->groupVisitDetails->amount_collected, 2)
                      }}</strong></td>
                  <td width="10%">{{ $expense->groupVisitDetails->transport_means == 0 ? 'Private
                    ('.$expense->groupVisitDetails->motor_regno.')' : 'Public' }}</td>
                  <td width="10%">({{$expense->groupsLoans->count()}}) Ksh {{
                    number_format($expense->groupsLoans->sum('loan_amount'), 2) }}</td>
                  <td width="5%">{{
                    $expense->groupVisitDetails->mileage_before.'/'.$expense->groupVisitDetails->mileage_after }}</td>
                  <td width="5%">{{ $expense->groupVisitDetails->mileage_after -
                    $expense->groupVisitDetails->mileage_before }}Kms</td>
                  <td width="4%">{{ $expense->groupVisitDetails->fuel_consumption }} Ltrs</td>
                  <td width="5%">{{ $expense->approver3_date }}</td>

                  @php
                    $groupsExpense +=$expense->amountSpent; 
                    $groupsExpenseCollected += $expense->groupVisitDetails->amount_collected; 
                  @endphp
                  @endif

                  @if ($expense->activity_id == 2)
                  <td width="15%">{{ $expense->appraisalData->additional_info }}</td>
                  <td width="15%">{{ $expense->appraisalData->clients }}</td>
                  <td width="8%">{{ $expense->appraisalData->journey_from.'/'.$expense->appraisalData->venue }}</td>
                  <td width="5%"><strong>Ksh {{ number_format($expense->amountSpent, 2) }}</strong></td>
                  <td width="5%"><strong>Ksh {{ number_format(0, 2) }}</strong></td>
                  <td width="10%">{{ $expense->appraisalData->transport_means == 0 ? 'Private
                    ('.$expense->appraisalData->motor_regno.')' : 'Public' }}</td>
                  <td width="10%">(0)</td>
                  <td width="5%">{{ $expense->appraisalData->mileage_before.'/'.$expense->appraisalData->mileage_after
                    }}</td>
                  <td width="5%">{{ $expense->appraisalData->mileage_after - $expense->appraisalData->mileage_before
                    }}Kms</td>
                  <td width="4%">{{ $expense->appraisalData->fuel_consumption }} Ltrs</td>
                  <td width="5%">{{ $expense->approver3_date }}</td>
                  @php
                  $appraisalExpense += $expense->amountSpent; 
                  @endphp
                  @endif

                  @if ($expense->activity_id == 3)
                  <td width="15%">{{ $expense->recoveryData->additional_info }}</td>
                  <td width="15%">{{ $expense->recoveryData->client_id.' -
                    '.$expense->recoveryData->client_name.'['.$expense->recoveryData->client_phone.']' }}</td>
                  <td width="8%">{{ $expense->recoveryData->journey_from.'/'.$expense->recoveryData->venue }}</td>
                  <td width="5%"><strong>Ksh {{ number_format($expense->amountSpent, 2) }}</strong></td>
                  <td width="5%"><strong>Ksh {{ number_format($expense->recoveryData->amount_collected, 2) }}</strong>
                  </td>
                  <td width="10%">{{ $expense->recoveryData->transport_means == 0 ? 'Private
                    ('.$expense->recoveryData->motor_regno.')' : 'Public' }}</td>
                  <td width="10%">(0)</td>
                  <td width="5%">{{ $expense->recoveryData->mileage_before.'/'.$expense->recoveryData->mileage_after }}
                  </td>
                  <td width="5%">{{ $expense->recoveryData->mileage_after - $expense->recoveryData->mileage_before }}Kms
                  </td>
                  <td width="4%">{{ $expense->recoveryData->fuel_consumption }} Ltrs</td>
                  <td width="5%">{{ $expense->approver3_date }}</td>
                  
                  @php
                  $recoveryExpense += $expense->amountSpent; 
                  $recoveryExpenseCollected += $expense->recoveryData->amount_collected; 
                  @endphp
                  @endif

                  @if ($expense->activity_id == 4)
                  <td width="15%">{{ $expense->followupData->additional_info }}</td>
                  <td width="15%">{{ $expense->followupData->clients }}</td>
                  <td width="8%">{{ $expense->followupData->journey_from.'/'.$expense->followupData->venue }}</td>
                  <td width="5%"><strong>Ksh {{ number_format($expense->amountSpent, 2) }}</strong></td>
                  <td width="5%"><strong>Ksh {{ number_format($expense->followupData->amount_collected, 2) }}</strong>
                  </td>
                  <td width="10%">{{ $expense->followupData->transport_means == 0 ? 'Private
                    ('.$expense->followupData->motor_regno.')' : 'Public' }}</td>
                  <td width="10%">(0)</td>
                  <td width="5%">{{ $expense->followupData->mileage_before.'/'.$expense->followupData->mileage_after }}
                  </td>
                  <td width="5%">{{ $expense->followupData->mileage_after - $expense->followupData->mileage_before }}Kms
                  </td>
                  <td width="4%">{{ $expense->followupData->fuel_consumption }} Ltrs</td>
                  <td width="5%">{{ $expense->approver3_date }}</td>
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
                  <th style="text-align: right;" colspan="5">Sub totals at at {{ date('F d, Y h:i:sa') }}</th>
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
          </td>
        </tr>
        @endif
        @endforeach
      </tbody>
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
  </main>
</body>

</html>