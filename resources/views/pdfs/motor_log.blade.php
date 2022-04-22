<html>

<head>
    <title> {{ $title }} | {{ config('app.name') }} </title>
    <style>
        body {
            text-align: left;
            font-size: 11px;
            font-family: "Source Sans Pro";
        }

        table {
            width: 100%;
            border-collapse: collapse;
            /* border: 1px solid black; */
        }

        th,
            {
            border: 1px solid #ddd;
            text-align: left;
            padding: 5px 5px 5px 10px;
        }


        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

    </style>
</head>

<body>
    <header>
        <div style="text-align: left; font-size: 12px; margin: 5px; ">
            <img src="./assets/images/header-image.jpg" width="100%">
        </div>
    </header>

    <!-- Wrap the content of your PDF inside a main tag -->
    <main>
        <div style="page-break-after: none;" style="margin-top: 10px;">
            <h2>Asset Details</h2>
            <table cellpadding="6" border="1" cellspacing="0" style="margin-top: 10px" width="100%">
                <tr>
                    <td>Branch / Dept</td>
                    <td>{{ $branch->branch_name }}</td>
                    <td>Make / Asset Number</td>
                    <td>{{ ucwords($log->name . ' - ' . $log->model) }}</td>
                </tr>
                <tr>
                    <td>Asset R/No</td>
                    <td>{{ $log->reg_no }}</td>
                    <td>Date of Service</td>
                    <td>{{ date_format(date_create($log->service_date), 'D, d M Y') }}</td>
                </tr>
                <tr>
                    <td>Bimas Officer conducting service</td>
                    <td colspan="3">{{ strtoupper($log->servicer_name) }} ({{ strtolower($log->servicer_email) }})
                    </td>
                </tr>
            </table>

            <br />
            <h2>Booking Details</h2>
            <table cellpadding="6" border="1" cellspacing="0" style="margin-top: 10px" width="100%">
                <thead>
                    <tr>
                        <td>REFERENCE</td>
                        <td>ASSET NAME</td>
                        <td>BOOKED DATE</td>
                        <td>USER</td>
                        <td>TYPE</td>
                        <td>STATUS</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $log->reference }}</td>
                        <td>{{ $log->name . ' - ' . $log->reg_no }}</td>
                        <td>{{ date_format(date_create($log->date), 'D, d M Y') }}</td>
                        <td>{{ $log->booker_name }}</td>
                        <td>{{ $log->type }}</td>
                        <td>{{ $approval }}</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <h2>Services Performed</h2>
            @if (!is_null($log->approved_by))
                <table cellpadding="6" border="1" cellspacing="0" style="margin-top: 10px" width="100%">
                    <thead>
                        <tr>
                            <td>DATE APPROVED</td>
                            <td>DATE BOOKED </td>
                            <td>APPROVED BY</td>
                            <td>APPROVER MESSAGE</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ date_format(date_create($log->date_approved), 'D, d M Y') }}</td>
                            <td>{{ date_format(date_create($log->date), 'D, d M Y') }}</td>
                            <td>{{ $log->approver_name }}</td>
                            <td>{{ $log->approval_message }}</td>
                        </tr>
                    </tbody>
                </table>
            @endif

            <br>
            <p style="font-weight:bold">Comments and Recommendations by Officer :-</p>
            <p style="font-family: monospace">{{ $log->additional_info }}</p>
            <br>
            <p>
                SIGNATURE : ................................................................... &nbsp;&nbsp;
                DATE : ...................................................................
            </p>

            <hr>

            <p style="font-weight:bold">Confirmation by HR & Admin Manager</p>
            <p style="font-weight:normal">Comments and Recommendations -</p>
            <p style="font-family: monospace">&nbsp;</p>
            <br>
            <p>
                SIGNATURE : ................................................................... &nbsp;&nbsp;
                DATE : ...................................................................
            </p>
        </div>
    </main>
</body>

</html>
