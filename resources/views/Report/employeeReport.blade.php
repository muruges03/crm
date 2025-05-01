<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }

        .container {
            max-width: 1100px;
            margin: 30px auto;
            background: #fff;
            padding: 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px 30px;
            background: linear-gradient(135deg, #27679b 0%, #1a4971 100%);
            color: white;
            border-radius: 12px 12px 0 0;
        }

        .logo {
            width: 160px;
        }

        .title {
            text-align: center;
            color: white;
            font-weight: 600;
        }

        .title h4 {
            margin-bottom: 5px;
            font-size: 22px;
            letter-spacing: 1px;
        }

        .title i {
            font-size: 14px;
            opacity: 0.9;
        }

        .print-button {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
            border-radius: 50px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .print-button:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .content-wrapper {
            padding: 30px;
        }

        .customer-info {
            background-color: #f8f9fa;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #27679b;
        }

        .customer-info h5 {
            margin: 0;
            color: #27679b;
            font-size: 16px;
            font-weight: 600;
        }

        .customer-info span {
            font-weight: 500;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #27679b;
            color: white;
            font-size: 13px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tr:nth-child(even) td {
            background-color: #f8f9fa;
        }

        tr:nth-child(odd) td {
            background-color: #ffffff;
        }

        tr:hover td {
            background-color: #eef5ff;
        }

        td {
            font-size: 14px;
            border-bottom: 1px solid #eee;
            transition: background-color 0.3s ease;
        }

        .no-data {
            color: #505253;
            font-weight: 500;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 300px;
            font-size: 18px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .no-data i {
            font-size: 60px;
            color: #27679b;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .footer {
            padding: 15px 30px;
            text-align: right;
            color: #969BA7;
            font-size: 12px;
            font-weight: 500;
            border-top: 1px solid #eee;
        }

        .footer a {
            color: #27679b;
            text-decoration: none;
        }

        .serial-number {
            font-weight: 600;
            color: #27679b;
        }

        .date-cell {
            color: #666;
        }

        .service-type {
            font-weight: 500;
            color: #27679b;
        }

        .description {
            color: #333;
            line-height: 1.5;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 500;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                background-color: white;
            }

            .container {
                box-shadow: none;
                margin: 0;
                max-width: 100%;
            }

            .header-container {
                background: #27679b !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            th {
                background-color: #27679b !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                color: white !important;
            }

            .footer {
                position: fixed;
                bottom: 0;
                width: 100%;
            }

            h4 {
                color: white;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        @if (!$tickets || count($tickets) === 0)
            <div class="header-container">
                <img src="{{ asset('images/one_modo_logo.png') }}" class="logo">
                <div class="title">
                    <h4>EMPLOYEE CONSOLIDATED REPORT</h4>
                    <i>Time Period: {{ Carbon\Carbon::parse($startDate)->format('d-M-y') }} to
                        {{ Carbon\Carbon::parse($endDate)->format('d-M-y') }}</i>
                </div>
                <button class="print-button no-print" onclick="window.print()">
                    <i class="fas fa-print"></i> Print Report
                </button>
            </div>
            <div class="content-wrapper">
                <div class="no-data">
                    <i class="fas fa-clipboard-list"></i>
                    <h4>No data available for this period</h4>
                </div>
            </div>
        @else
            <div class="header-container">
                <img src="{{ asset('images/one_modo_logo.png') }}" class="logo">
                <div class="title">
                    <h4>EMPLOYEE CONSOLIDATED REPORT</h4>
                    <i>Time Period: {{ Carbon\Carbon::parse($startDate)->format('d-M-y') }} to
                        {{ Carbon\Carbon::parse($endDate)->format('d-M-y') }}</i>
                </div>
                <button class="print-button no-print" onclick="window.print()">
                    <i class="fas fa-print"></i> Print Report
                </button>
            </div>
            <div class="content-wrapper">
                <div class="customer-info">
                    <h5>EMPLOYEE: <span>{{ $tickets[0]['personal']['first_name'] ?? 'N/A' }}</span></h5>
                </div>
                @php
    $tatOptions = [
        'Service Call',
        'Requirement',
        'Possible',
        'Not Possible',
        'Testing',
        'Deployed',
        'Done',
    ];

    $tatLevelCountsByType = [];

    foreach ($tickets as $ticket) {
        $typeName = $ticket['type']['type'];
        $tatLevel = $ticket['tat_level'];

        if (!isset($tatLevelCountsByType[$typeName])) {
            $tatLevelCountsByType[$typeName] = array_fill_keys($tatOptions, 0);
        }

        if (isset($tatLevelCountsByType[$typeName][$tatLevel])) {
            $tatLevelCountsByType[$typeName][$tatLevel]++;
        }
    }
@endphp


<table>
    <thead>
        <tr>
            <th width="8%">S.NO</th>
            <th width="20%">SERVICE TYPE</th>
            @foreach ($tatOptions as $option)
                <th>{{ $option }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($tatLevelCountsByType as $typeName => $tatCounts)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $typeName }}</td>
                @foreach ($tatOptions as $option)
                    <td style="text-align: right;">{{ $tatCounts[$option] }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

            </div>
        @endif

        <footer class="footer">
            <a href="https://modocrm.com" target="_blank">Powered By: Modocrm.com</a>
        </footer>
    </div>
</body>

</html>
