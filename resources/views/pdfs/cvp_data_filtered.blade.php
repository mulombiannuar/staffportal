<html>

<head>
    <title> {{ $title }} | {{ config('app.name') }} </title>
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
            padding: 5px;
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
        <?php echo date('Y'); ?> |
        <?= ucwords('Document printed by ' . ucwords(Auth::user()->name) . ' on ' . date('F d, Y h:i:sa')) ?>
    </footer>

    <!-- Wrap the content of your PDF inside a main tag -->
    <main>
        <div>
            <h3>BIMAS KENYA CVP PACKAGE DATA |
                DATE : {{ $attrbts['date'] }} </h3>
            </th>
            <table style="margin-top: 10px;">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>STAFF NAME</th>
                        <th>PHONE NUMBER</th>
                        <th>CVP PACKAGE</th>
                        <th>AMOUNT</th>
                        <th>OUTPOST</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalUserAmount = 0;
                    @endphp
                    @if ($attrbts['type'] == 0)
                        @foreach ($products as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->staff_name }}</td>
                                <td>{{ $user->staff_mobile }}</td>
                                <td><strong>{{ $user->value . ' [' . ucwords($user->type) . ']' }}</strong>
                                </td>
                                <td>Ksh {{ number_format($user->amount, 2) }}</td>
                                <td>{{ $user->outpost_name }}</td>
                            </tr>
                            @php
                                $totalUserAmount += $user->amount;
                            @endphp
                        @endforeach
                    @else
                        @foreach ($products as $user)
                            @if ($user->product == $attrbts['type'])
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->staff_name }}</td>
                                    <td>{{ $user->staff_mobile }}</td>
                                    <td><strong>{{ $user->value . ' [' . ucwords($user->type) . ']' }}</strong>
                                    </td>
                                    <td>Ksh {{ number_format($user->amount, 2) }}</td>
                                    <td>{{ $user->outpost_name }}</td>
                                </tr>
                                @php
                                    $totalUserAmount += $user->amount;
                                @endphp
                            @endif
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th style="text-align: right" colspan="4">TOTAL</th>
                        <th style="text-align: left" colspan="2">Ksh {{ number_format($totalUserAmount, 2) }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
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
