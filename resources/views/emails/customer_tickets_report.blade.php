<!DOCTYPE html>
<html>

<head>
    <title>Customer Tickets Report</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <style type="text/css">
        /* FONTS */
        @media screen {
            @font-face {
                font-family: 'Lato';
                font-style: normal;
                font-weight: 400;
                src: local('Lato Regular'), local('Lato-Regular'), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format('woff');
            }

            @font-face {
                font-family: 'Lato';
                font-style: normal;
                font-weight: 700;
                src: local('Lato Bold'), local('Lato-Bold'), url(https://fonts.gstatic.com/s/lato/v11/qdgUG4U09HnJwhYI-uK18wLUuEpTyoUstqEm5AMlJo4.woff) format('woff');
            }

            @font-face {
                font-family: 'Lato';
                font-style: italic;
                font-weight: 400;
                src: local('Lato Italic'), local('Lato-Italic'), url(https://fonts.gstatic.com/s/lato/v11/RYyZNoeFgb0l7W3Vu1aSWOvvDin1pK8aKteLpeZ5c0A.woff) format('woff');
            }

            @font-face {
                font-family: 'Lato';
                font-style: italic;
                font-weight: 700;
                src: local('Lato Bold Italic'), local('Lato-BoldItalic'), url(https://fonts.gstatic.com/s/lato/v11/HkF_qI1x_noxlxhrhMQYELO3LdcAZYWl9Si6vvxL-qU.woff) format('woff');
            }
        }

        /* CLIENT-SPECIFIC STYLES */
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        /* RESET STYLES */
        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            font-size: smaller;
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        /* iOS BLUE LINKS */
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* MOBILE STYLES */
        @media screen and (max-width:600px) {
            h1 {
                font-size: 32px !important;
                line-height: 32px !important;
            }
        }

        /* ANDROID CENTER FIX */
        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }
    </style>
</head>

<body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 100%;">
                    <tr>
                        <td bgcolor="#ffffff" align="left"
                            style="padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;"><strong>All CUSTOMER TICKETS</strong></p><br>
                            <table border="1" cellpadding="1" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>TICKET ID</th>
                                        <th>NAMES</th>
                                        <th>MOBILE</th>
                                        <th>RESIDENCE</th>
                                        <th>DATE</th>
                                        <th>BRANCH</th>
                                        <th>OFFICER</th>
                                        <th>CURRENT LEVEL</th>
                                        <th>CREATED AT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data['tickets_data']['all_tickets']) != 0)
                                        @foreach ($data['tickets_data']['all_tickets'] as $ticket)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $ticket->ticket_uuid }}</td>
                                                <td>{{ strtoupper($ticket->customer_name) }}</td>
                                                <td>{{ $ticket->customer_phone }}</td>
                                                <td>{{ $ticket->residence }}</td>
                                                <td>{{ $ticket->date_raised }}</td>
                                                <td>{{ $ticket->outpost_name }}</td>
                                                <td>{{ $ticket->officer_name }}</td>
                                                <td><strong>{{ $ticket->current_level }}</strong></td>
                                                <td>{{ $ticket->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10">No customer tickets found for that day</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left"
                            style="padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;"><strong>OVERDUE CUSTOMER TICKETS</strong></p><br>
                            <table border="1" cellpadding="1" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>TICKET ID</th>
                                        <th>NAMES</th>
                                        <th>MOBILE</th>
                                        <th>RESIDENCE</th>
                                        <th>DATE RAISED</th>
                                        <th>BRANCH</th>
                                        <th>OFFICER</th>
                                        <th>CURRENT LEVEL</th>
                                        <th>OVERDUE HOURS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data['tickets_data']['overdue_tickets']) != 0)
                                        @foreach ($data['tickets_data']['overdue_tickets'] as $ticket)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $ticket->ticket_uuid }}</td>
                                                <td>{{ strtoupper($ticket->customer_name) }}</td>
                                                <td>{{ $ticket->customer_phone }}</td>
                                                <td>{{ $ticket->residence }}</td>
                                                <td>{{ $ticket->date_raised }}</td>
                                                <td>{{ $ticket->outpost_name }}</td>
                                                <td>{{ $ticket->officer_name }}</td>
                                                <td><strong>{{ $ticket->current_level }}</strong></td>
                                                <td>{{ $ticket->overdue_hours - 48 }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10">No overdue customer tickets found for that day</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left"
                            style="padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;"><strong>CUSTOMER TICKETS CLOSED</strong></p><br>
                            <table border="1" cellpadding="1" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>TICKET ID</th>
                                        <th>NAMES</th>
                                        <th>MOBILE</th>
                                        <th>RESIDENCE</th>
                                        <th>DATE</th>
                                        <th>BRANCH</th>
                                        <th>OFFICER</th>
                                        <th>CURRENT LEVEL</th>
                                        <th>DATE CLOSED</th>
                                        <th>SURVEY SENT</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if (count($data['tickets_data']['closed_tickets']) != 0)
                                        @foreach ($data['tickets_data']['closed_tickets'] as $ticket)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $ticket->ticket_uuid }}</td>
                                                <td>{{ strtoupper($ticket->customer_name) }}</td>
                                                <td>{{ $ticket->customer_phone }}</td>
                                                <td>{{ $ticket->residence }}</td>
                                                <td>{{ $ticket->date_raised }}</td>
                                                <td>{{ $ticket->outpost_name }}</td>
                                                <td>{{ $ticket->officer_name }}</td>
                                                <td><strong>{{ $ticket->current_level }}</strong></td>
                                                <td>{{ $ticket->date_closed }}</td>
                                                <td>{{ $ticket->customer_sent_survey ? 'Yes' : 'Not' }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="11">No closed customer tickets found for that day</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left"
                            style="padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;"><strong>COMPLETED SURVEY RESPONSES</strong></p><br>
                            <table border="1" cellpadding="1" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>TICKET ID</th>
                                        <th>NAMES</th>
                                        <th>MOBILE</th>
                                        <th>RESIDENCE</th>
                                        <th>DATE RAISED</th>
                                        <th>BRANCH</th>
                                        <th>OFFICER</th>
                                        <th>DATE SENT</th>
                                        <th>DATE RESPONDED</th>
                                        <th>SENT BY</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data['tickets_data']['completed_surveys']) != 0)
                                        @foreach ($data['tickets_data']['completed_surveys'] as $ticket)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $ticket->ticket_uuid }}</td>
                                                <td>{{ strtoupper($ticket->customer_name) }}</td>
                                                <td>{{ $ticket->customer_phone }}</td>
                                                <td>{{ $ticket->residence }}</td>
                                                <td>{{ $ticket->date_raised }}</td>
                                                <td>{{ $ticket->outpost_name }}</td>
                                                <td>{{ $ticket->officer_name }}</td>
                                                <td>{{ $ticket->date_sent }}</td>
                                                <td>{{ $ticket->date_responded }}</td>
                                                <td>{{ $ticket->sent_by }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="11">No completed customer survey responses found for that day
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left"
                            style="padding: 0px 30px 20px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;">If you have any questions, just reply to this email—we're always happy
                                to help out.</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left"
                            style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;">Cheers,<br>Bimas Kenya ICT Team</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>

</html>
