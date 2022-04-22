<html>

<head>
  <title> Expense Claim Data | {{ config('app.name') }} </title>
  <style>
    body {
      text-align: left;
      font-size: 12px;
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

    th,
    td {
      border-bottom: 1px solid #ddd;
      text-align: left;
      padding: 5px 5px 5px 10px;
    }
    
    .v_table{
      margin-top: 30px;
    }

    .v_table 
    th,
    td {
      border: 0px;
      text-align: left;
      padding: 10px;
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
      <h3>BIMAS EXPENSE CLAIM FORM [{{ $expense->name }} - {{ $expense->mobile_no }} | Outpost : {{
        $expense->outpost_name }}]</h3>
      <h4 style="font-size: 18px;">{{ $expense->activity_name.' - '.$expense->date }}</h4>

      @if ($expense->activity_type == 1)
      <div>
        <table>
          <thead>
            <tr>
              <th>JOURNEY FROM : {{ $expenseData->journey_from }} TO : Group Meeting Venue</th>
              <th>DATE : {{ $expenseData->date }}</th>
              <th>FROM : {{ $expenseData->start_time }} TO : {{ $expenseData->end_time }}</th>
              <th>DISTANCE COVERED : {{ $expenseData->mileage_after - $expenseData->mileage_before }}KMS</th>
            </tr>
            <tr>
              <th>MOTORBIKE USED : {{ $expenseData->motor_regno }}</th>
              <th>MILEAGE BEFORE : {{ $expenseData->mileage_before }}Kms</th>
              <th>MILEAGE AFTER : {{ $expenseData->mileage_after }}Kms</th>
              <th>FUEL CONSUMPTION : {{ $expenseData->fuel_consumption }}Lts</th>
            </tr>
          </thead>
        </table>

        <table style="margin-top: 15px;" class="table table-sm">
          <thead>
            <tr>
              <th colspan="6">GROUPS VISITED ({{ count($expenseDataGroups) }})</th>
            </tr>
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

        <table style="margin-top: 15px;" class="table table-sm">
          <thead>
            <tr>
              <th colspan="5">LOANS APPLIED ({{ count($loans) }})</th>
            </tr>
            <tr>
              <th>S.N</th>
              <th>NAMES</th>
              <th>ClIENT ID</th>
              <th>PRODUCT</th>
              <th>LOAN</th>
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
            </tr>
            @endforeach
          </tbody>
        </table>

        @if (count($members) != 0)
        <table style="margin-top: 15px;" class="table table-sm">
          <thead>
            <tr>
              <th colspan="5">NEW MEMBERS</th>
            </tr>
            <tr>
              <th>S.N</th>
              <th>NAMES</th>
              <th>ClIENT ID</th>
              <th>MOBILE NO</th>
              <th>GROUP CODE</th>
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
            </tr>
            @endforeach
          </tbody>
        </table>
        @endif

        <table style="margin-top: 20px;" class="table table-sm">
          <thead>
            <tr>
              <th>PURPOSE OF THE ACTIVITY</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="font-size: 16px;">{{ $expenseData->additional_info }}</td>
            </tr>
          </tbody>
        </table>

        <table style="margin-top: 20px;" class="table table-sm">
          <tr>
            <td style="font: 16px bold; text-align:right">TOTAL AMOUNT SPENT : Ksh. {{
              number_format($expenseData->amount_spent, 2) }}
            </td>
            <td style="font: 16px bold; text-align:right">AMOUNT COLLECTED : Ksh. {{
              number_format($expenseData->amount_collected, 2) }}
            </td>
          </tr>
          </tbody>
        </table>

        <table style="margin-top: 20px;" class="">
          <thead>
            <tr>
              <th colspan="4">APROVALS</th>
            </tr>
            <tr>
              <th>A.N</th>
              <th>NAMES</th>
              <th>APPROVAL LEVEL</th>
              <th>STATUS</th>
              <th>DATE/TIME</th>
            </tr>
          </thead>
          <tbody>
            @if (!is_null($approvals['branch_manager']))
            <tr>
              <td>1</td>
              <td>{{ $approvals['branch_manager']->name }}</td>
              <td>Branch Manager Approval</td>
              <td>{{ $approvals['branch_manager']->approver1_status == 1? 'Approved' : 'Rejected' }}</td>
              <td>{{ $approvals['branch_manager']->approver1_date }}</td>
            </tr>
            @endif
            @if (!is_null($approvals['accountant']))
            <tr>
              <td>2</td>
              <td>{{ $approvals['accountant']->name }}</td>
              <td>Accountant Approval</td>
              <td>{{ $approvals['accountant']->approver2_status == 1? 'Approved' : 'Rejected' }}</td>
              <td>{{ $approvals['accountant']->approver2_date }}</td>
            </tr>
            @endif
            @if (!is_null($approvals['finance_manager']))
            <tr>
              <td>3</td>
              <td>{{ $approvals['finance_manager']->name }}</td>
              <td>Finance Manager Approval</td>
              <td>{{ $approvals['finance_manager']->approver3_status == 1? 'Approved' : 'Rejected' }}</td>
              <td>{{ $approvals['finance_manager']->approver3_date }}</td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
      @endif

      @if ($expense->activity_type == 2)
      <div>
        <table>
          <thead>
            <tr>
              <th>FROM : {{ $appraisalData->journey_from.' TO : '.$appraisalData->venue }}</th>
              <th>DATE : {{ $appraisalData->date }}</th>
              <th>FROM : {{ $appraisalData->start_time }} TO : {{ $appraisalData->end_time }}</th>
              <th>DISTANCE COVERED : {{ $appraisalData->mileage_after - $appraisalData->mileage_before }}KMS</th>
            </tr>
            <tr>
              <th>MOTORBIKE : {{ $appraisalData->motor_regno }}</th>
              <th>MILEAGE BEFORE : {{ $appraisalData->mileage_before }}Kms</th>
              <th>MILEAGE AFTER : {{ $appraisalData->mileage_after }}Kms</th>
              <th>FUEL CONSUMPTION : {{ $appraisalData->fuel_consumption }}Lts</th>
            </tr>
          </thead>
        </table>

        <table style="margin-top: 15px;" class="table table-sm">
          <thead>
            <tr>
              <th >GROUPS / CLIENTS APPRAISED </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ $appraisalData->clients }}</td>
            </tr>
          </tbody>
        </table>

        <table style="margin-top: 20px;" class="table table-sm">
          <thead>
            <tr>
              <th>PURPOSE OF THE ACTIVITY</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="font-size: 16px;">{{ $appraisalData->additional_info }}</td>
            </tr>
          </tbody>
        </table>

        <table style="margin-top: 20px;" class="table table-sm">
          <tr>
            <td style="font: 16px bold; text-align:right">TOTAL AMOUNT SPENT : Ksh. {{
              number_format($appraisalData->amount_spent, 2) }}
            </td>
          </tr>
          </tbody>
        </table>

        <table style="margin-top: 20px;" class="">
          <thead>
            <tr>
              <th colspan="4">APROVALS</th>
            </tr>
            <tr>
              <th>A.N</th>
              <th>NAMES</th>
              <th>APPROVAL LEVEL</th>
              <th>STATUS</th>
              <th>DATE/TIME</th>
            </tr>
          </thead>
          <tbody>
            @if (!is_null($approvals['branch_manager']))
            <tr>
              <td>1</td>
              <td>{{ $approvals['branch_manager']->name }}</td>
              <td>Branch Manager Approval</td>
              <td>{{ $approvals['branch_manager']->approver1_status == 1? 'Approved' : 'Rejected' }}</td>
              <td>{{ $approvals['branch_manager']->approver1_date }}</td>
            </tr>
            @endif
            @if (!is_null($approvals['accountant']))
            <tr>
              <td>2</td>
              <td>{{ $approvals['accountant']->name }}</td>
              <td>Accountant Approval</td>
              <td>{{ $approvals['accountant']->approver2_status == 1? 'Approved' : 'Rejected' }}</td>
              <td>{{ $approvals['accountant']->approver2_date }}</td>
            </tr>
            @endif
            @if (!is_null($approvals['finance_manager']))
            <tr>
              <td>3</td>
              <td>{{ $approvals['finance_manager']->name }}</td>
              <td>Finance Manager Approval</td>
              <td>{{ $approvals['finance_manager']->approver3_status == 1? 'Approved' : 'Rejected' }}</td>
              <td>{{ $approvals['finance_manager']->approver3_date }}</td>
            </tr>
            @endif
          </tbody>
        </table>
        
      </div>
      @endif

      @if ($expense->activity_type == 3)
      <div>
        <table>
          <thead>
            <tr>
              <th>FROM : {{ $recoveryData->journey_from }} TO : {{ $recoveryData->venue }}</th>
              <th>DATE : {{ $recoveryData->date }}</th>
              <th>FROM : {{ $recoveryData->start_time }} TO : {{ $recoveryData->end_time }}</th>
              <th>DISTANCE COVERED : {{ $recoveryData->mileage_after - $recoveryData->mileage_before }}KMS</th>
            </tr>
            <tr>
              <th>MOTORBIKE : {{ $recoveryData->motor_regno }}</th>
              <th>MILEAGE BEFORE : {{ $recoveryData->mileage_before }}Kms</th>
              <th>MILEAGE AFTER : {{ $recoveryData->mileage_after }}Kms</th>
              <th>FUEL CONSUMPTION : {{ $recoveryData->fuel_consumption }}Lts</th>
            </tr>
          </thead>
        </table>

        <table style="margin-top: 15px;" class="table table-sm">
          <thead>
            <tr>
              <th colspan="3">CLIENT DETAILS</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>CLIENT NAME: {{ $recoveryData->client_name }}</td>
              <td>CLIENT ID: {{ $recoveryData->client_id }}</td>
              <td>CLIENT PHONE: {{ $recoveryData->client_phone }}</td>
            </tr>
          </tbody>
        </table>

        <table style="margin-top: 20px;" class="table table-sm">
          <thead>
            <tr>
              <th>PURPOSE OF THE ACTIVITY</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="font-size: 16px;">{{ $recoveryData->additional_info }}</td>
            </tr>
          </tbody>
        </table>

        <table style="margin-top: 20px;" class="table table-sm">
          <tr>
            <td style="font: 16px bold; text-align:right">TOTAL AMOUNT SPENT : Ksh. {{
              number_format($recoveryData->amount_spent, 2) }}
            </td>
            <td style="font: 16px bold; text-align:right">TOTAL AMOUNT RECOVERED : Ksh. {{
              number_format($recoveryData->amount_collected, 2) }}
            </td>
          </tr>
          </tbody>
        </table>

        <table style="margin-top: 20px;" class="">
          <thead>
            <tr>
              <th colspan="4">APROVALS</th>
            </tr>
            <tr>
              <th>A.N</th>
              <th>NAMES</th>
              <th>APPROVAL LEVEL</th>
              <th>STATUS</th>
              <th>DATE/TIME</th>
            </tr>
          </thead>
          <tbody>
            @if (!is_null($approvals['branch_manager']))
            <tr>
              <td>1</td>
              <td>{{ $approvals['branch_manager']->name }}</td>
              <td>Branch Manager Approval</td>
              <td>{{ $approvals['branch_manager']->approver1_status == 1? 'Approved' : 'Rejected' }}</td>
              <td>{{ $approvals['branch_manager']->approver1_date }}</td>
            </tr>
            @endif
            @if (!is_null($approvals['accountant']))
            <tr>
              <td>2</td>
              <td>{{ $approvals['accountant']->name }}</td>
              <td>Accountant Approval</td>
              <td>{{ $approvals['accountant']->approver2_status == 1? 'Approved' : 'Rejected' }}</td>
              <td>{{ $approvals['accountant']->approver2_date }}</td>
            </tr>
            @endif
            @if (!is_null($approvals['finance_manager']))
            <tr>
              <td>3</td>
              <td>{{ $approvals['finance_manager']->name }}</td>
              <td>Finance Manager Approval</td>
              <td>{{ $approvals['finance_manager']->approver3_status == 1? 'Approved' : 'Rejected' }}</td>
              <td>{{ $approvals['finance_manager']->approver3_date }}</td>
            </tr>
            @endif
          </tbody>
        </table>
        
      </div>
      @endif

      @if ($expense->activity_type == 4)
      <div>
        <table>
          <thead>
            <tr>
              <th>FROM : {{ $followupData->journey_from.' TO : '.$followupData->venue }}</th>
              <th>DATE : {{ $followupData->date }}</th>
              <th>FROM : {{ $followupData->start_time }} TO : {{ $followupData->end_time }}</th>
              <th>DISTANCE COVERED : {{ $followupData->mileage_after - $followupData->mileage_before }}KMS</th>
            </tr>
            <tr>
              <th>MOTORBIKE : {{ $followupData->motor_regno }}</th>
              <th>MILEAGE BEFORE : {{ $followupData->mileage_before }}Kms</th>
              <th>MILEAGE AFTER : {{ $followupData->mileage_after }}Kms</th>
              <th>FUEL CONSUMPTION : {{ $followupData->fuel_consumption }}Lts</th>
            </tr>
          </thead>
        </table>

        <table style="margin-top: 15px;" class="table table-sm">
          <thead>
            <tr>
              <th >GROUPS / CLIENTS FOLLOWED UP </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ $followupData->clients }}</td>
            </tr>
          </tbody>
        </table>

        <table style="margin-top: 20px;" class="table table-sm">
          <thead>
            <tr>
              <th>PURPOSE OF THE ACTIVITY</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="font-size: 16px;">{{ $followupData->additional_info }}</td>
            </tr>
          </tbody>
        </table>

        <table style="margin-top: 20px;" class="table table-sm">
          <tr>
            <td style="font: 16px bold; text-align:right">TOTAL AMOUNT SPENT : Ksh. {{
              number_format($followupData->amount_spent, 2) }}
            </td>
			 <td style="font: 16px bold; text-align:right">AMOUNT COLLECTED : Ksh. {{
              number_format($followupData->amount_collected, 2) }}
            </td>
          </tr>
          </tbody>
        </table>

        <table style="margin-top: 20px;" class="">
          <thead>
            <tr>
              <th colspan="4">APROVALS</th>
            </tr>
            <tr>
              <th>A.N</th>
              <th>NAMES</th>
              <th>APPROVAL LEVEL</th>
              <th>STATUS</th>
              <th>DATE/TIME</th>
            </tr>
          </thead>
          <tbody>
            @if (!is_null($approvals['branch_manager']))
            <tr>
              <td>1</td>
              <td>{{ $approvals['branch_manager']->name }}</td>
              <td>Branch Manager Approval</td>
              <td>{{ $approvals['branch_manager']->approver1_status == 1? 'Approved' : 'Rejected' }}</td>
              <td>{{ $approvals['branch_manager']->approver1_date }}</td>
            </tr>
            @endif
            @if (!is_null($approvals['accountant']))
            <tr>
              <td>2</td>
              <td>{{ $approvals['accountant']->name }}</td>
              <td>Accountant Approval</td>
              <td>{{ $approvals['accountant']->approver2_status == 1? 'Approved' : 'Rejected' }}</td>
              <td>{{ $approvals['accountant']->approver2_date }}</td>
            </tr>
            @endif
            @if (!is_null($approvals['finance_manager']))
            <tr>
              <td>3</td>
              <td>{{ $approvals['finance_manager']->name }}</td>
              <td>Finance Manager Approval</td>
              <td>{{ $approvals['finance_manager']->approver3_status == 1? 'Approved' : 'Rejected' }}</td>
              <td>{{ $approvals['finance_manager']->approver3_date }}</td>
            </tr>
            @endif
          </tbody>
        </table>
        
      </div>
      @endif

      <div class="v_table">
        <table>
          <tr>
            <td>VERIFIED BY</td>
            <td>_________________________</td>
            <td>SIGNATURE</td>
            <td>_________________________</td>
            <td>DATE</td>
            <td>_________________________</td>
          </tr>
          <tr>
            <td>APPROVED BY</td>
            <td>_________________________</td>
            <td>SIGNATURE</td>
            <td>_________________________</td>
            <td>DATE</td>
            <td>_________________________</td>
          </tr>
        </table>
      </div>
    </div>
  </main>
</body>

</html>