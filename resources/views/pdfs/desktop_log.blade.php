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
            <table cellpadding="6" border="1" cellspacing="0" style="margin-top: 10px" width="100%">
                <tr>
                    <td>Branch / Dept</td>
                    <td>{{ $branch->branch_name }}</td>
                    <td>Make / Asset Number</td>
                    <td>{{ ucwords($log->name) }}</td>
                </tr>
                <tr>
                    <td>Asset S/No</td>
                    <td>{{ $log->serial_number }}</td>
                    <td>Date of Service</td>
                    <td>{{ date_format(date_create($log->date_done), 'D, d M Y') }}</td>
                </tr>
                <tr>
                    <td>ICT Officer conducting service</td>
                    <td colspan="3">{{ strtoupper($log->action_name) }} ({{ strtolower($log->action_email) }})</td>
                </tr>
            </table>
            <table cellpadding="6" border="1" cellspacing="0" style="margin-top: 10px" width="100%">
                <tr style="background: #edf7f6">
                    <th>AREAS OF SERVICE</t>
                    <th>FINDINGS / STATUS</th>
                    <th>COMMENTS & RECOMMENDATIONS</th>
                </tr>
                <tr style="background: #edf7f6">
                    <td colspan="3">HARDWARE MAINTENANCE</td>
                </tr>
                <tr>
                    <td width="30%">
                        <strong>Hardware logs check</strong>
                        <ul>
                            <li>Check for any hardware deformity(mouse, </li>
                            <li>Blow out accumulated dust, spray the power supply </li>
                            <li>Clean the monitor,keyboard</li>
                            <li>Clean the RAM and motherboard</li>
                        </ul>
                    </td>
                    <td width="35%">{{ $log->hdw_log_status }}</td>
                    <td width="35%">{{ $log->hdw_log_comment }}</td>
                </tr>
                <tr>
                    <td width="30%">
                        <strong>Hard disk clean up</strong>
                        <ul>
                            <li>Delete temporal files, recycle bin, cache </li>
                        </ul>
                    </td>
                    <td width="35%">{{ $log->hdd_cleanup_status }}</td>
                    <td width="35%">{{ $log->hdd_cleanup_comment }}</td>
                </tr>
                <tr>
                    <td width="30%">
                        <strong>Hard disk capacity check</strong>
                        <ul>
                            <li>Check for disk space in all the drives </li>
                            <li>Uninstall and delete unused applications and icons</li>
                        </ul>
                    </td>
                    <td width="35%">{{ $log->hdd_capacity_status }}</td>
                    <td width="35%">{{ $log->hdd_capacity_comment }}</td>
                </tr>
                <tr>
                    <td width="30%">
                        <strong>Hardware tools</strong>
                        <ul>
                            <li>Run scandisk and defragment</li>
                            <li>Check for disk errors</li>
                        </ul>
                    </td>
                    <td width="35%">{{ $log->hdw_tools_status }}</td>
                    <td width="35%">{{ $log->hdw_tools_comment }}</td>
                </tr>

                <tr style="background: #edf7f6">
                    <td colspan="3">SOFTWARE MAINTENANCE</td>
                </tr>
                <tr>
                    <td width="30%">
                        <strong>Windows update</strong>
                        <ul>
                            <li>Download and install latest windows update</li>
                        </ul>
                    </td>
                    <td width="35%">{{ $log->windows_update_status }}</td>
                    <td width="35%">{{ $log->windows_update_comment }}</td>
                </tr>
                <tr>
                    <td width="30%">
                        <strong>Optimize browser</strong>
                        <ul>
                            <li>Delete cookies, caches and history file</li>
                        </ul>
                    </td>
                    <td width="35%">{{ $log->browser_status }}</td>
                    <td width="35%">{{ $log->browser_comment }}</td>
                </tr>
                <tr>
                    <td width="30%">
                        <strong>Software logs check</strong>
                        <ul>
                            <li>Check for applications windows problem(e.g. word, excel,
                                outlook)</li>
                        </ul>
                    </td>
                    <td width="35%">{{ $log->sftw_status }}</td>
                    <td width="35%">{{ $log->sftw_comment }}</td>
                </tr>
                <tr>
                    <td width="30%">
                        <strong>Antivirus updates check</strong>
                        <ul>
                            <li>Check that virus signatures have been updated</li>
                        </ul>
                    </td>
                    <td width="35%">{{ $log->antivirus_status }}</td>
                    <td width="35%">{{ $log->antivirus_comment }}</td>
                </tr>
                <tr>
                    <td width="30%">
                        <strong>Antivirus logs check</strong>
                        <ul>
                            <li>Check for any virus on the network</li>
                        </ul>
                    </td>
                    <td width="35%">{{ $log->antivirus_log }}</td>
                    <td width="35%">{{ $log->antivirus_log_comment }}</td>
                </tr>
                <tr>
                    <td width="30%">
                        <strong>Security logs check</strong>
                        <ul>
                            <li>Check for any security threat on the machine</li>
                        </ul>
                    </td>
                    <td width="35%">{{ $log->security_log }}</td>
                    <td width="35%">{{ $log->security_log_comment }}</td>
                </tr>
                <tr>
                    <td width="30%">
                        <strong>Files/folder backup</strong>
                        <ul>
                            <li>Create data backup</li>
                            <li>Ensure that the official files and folders are well filed in
                                the right procedure.</li>
                        </ul>
                    </td>
                    <td width="35%">{{ $log->backup_status }}</td>
                    <td width="35%">{{ $log->backup_comment }}</td>
                </tr>
            </table>
            <br />
            <br />

            <p style="font-weight:bold">Comments and Recommendations by ICT :-</p>
            <p style="font-family: monospace">{{ $log->supervisor_comment }}</p>
            <br>
            <p>
                SIGNATURE : ................................................................... &nbsp;&nbsp;
                DATE : ...................................................................
            </p>

            <hr>
            <p style="font-weight:bold">Confirmation by the Custodian of Machine -</p>
            <p style="font-weight:normal">Comments and Recommendations -</p>
            <p style="font-family: monospace"></p>
            <br>
            <br />
            <p>
                SIGNATURE : ................................................................... &nbsp;&nbsp;
                DATE : ...................................................................
            </p>
            <hr>

            <p style="font-weight:bold">Confirmation by ICT Manager -</p>
            <p style="font-weight:normal">Comments and Recommendations -</p>
            <p style="font-family: monospace">{{ $log->manager_comment }}</p>
            <br>
            <p>
                SIGNATURE : ................................................................... &nbsp;&nbsp;
                DATE : ...................................................................
            </p>
        </div>
    </main>
</body>

</html>
