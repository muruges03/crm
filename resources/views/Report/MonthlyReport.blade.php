<!-- resources/views/reports/service-tracker.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZjb6rK2kU8bGpLeFjNfC5iHhF8OOk5Bim7u6A0l8zIT3VhC15yYoYo6f3W3s" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-rZrdXl9fI9KLnt56w3bt6pMOsGGC0kXyXhO5GxF5r5pJ2xv0da6w5jNEIaZpWl5c" crossorigin="anonymous">
    </script>
    <title>{{ $report->title ?? 'Monthly Service Tracker' }}</title>
    <style>
        @page {
            margin: 10px;
        }

        /* Reduce margins */
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }

        /* Use a PDF-safe font */
        .container {
            width: 100%;
        }

        :root {
            --primary-color: #e52525;
            --primary-light: #ff6b6b;
            --primary-dark: #c41e1e;
            --secondary-color: #2d3748;
            --secondary-light: #4a5568;
            --light-gray: #f7f9fc;
            --border-color: #e2e8f0;
            --tag-bg: #2d3748;
            --tag-border: #4a5568;
            --success-color: #38a169;
            --warning-color: #f6ad55;
            --error-color: #e53e3e;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            color: #2d3748;
            background-color: #f0f2f5;
        }

        .report-container {
            max-width: 2480px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            overflow: hidden;
        }

        .report-header {
            padding: 10px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, #ffffff 0%, #f9f9f9 100%);
            border-bottom: 1px solid var(--border-color);
        }

        .header-content {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .logo {
            max-width: 200px;
            margin-bottom: 15px;
        }

        .report-title {
            font-size: 1.2rem;
            font-weight: 600;
            text-transform: uppercase;
            margin: 10px 0;
            color: var(--secondary-color);
        }

        .report-subtitle {
            font-size: 1.6rem;
            font-weight: 600;
            text-align: center;
            padding: 0px 0px;
            margin: 0;
            background-color: var(--light-gray);
            color: var(--primary-color);
            /*border-bottom: 1px solid var(--border-color);*/
        }

        .report-info {
            padding: 20px 30px;
            background-color: white;
            border-bottom: 1px solid var(--border-color);
        }

        .personnel-list {
            margin: 10px 0;
            font-weight: 500;
        }

        .personnel-tag {
            display: inline-block;
            background-color: black;
            border: 1px solid var(--tag-border);
            border-radius: 50px;
            padding: 4px 12px;
            margin: 3px 5px 3px 0;
            font-size: 0.9rem;
            color: white;
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            transition: all 0.2s ease;
        }

        .personnel-tag:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .svg {
            height: 30px;
            cursor: pointer;
        }

        .personnel-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .personnel-section2 {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .personnel-section>.personal {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .personnel-section strong {
            min-width: 120px;
            font-weight: 600;
            color: var(--secondary-color);
        }

        .report-meta {
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 20px 30px;
            background-color: white;
        }

        .meta-row {
            display: flex;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 12px;
        }

        .meta-label {
            font-weight: 600;
            min-width: 180px;
            color: var(--secondary-color);
        }

        .meta-value {
            flex-grow: 1;
            position: relative;
            padding-left: 10px;
        }

        .meta-value::before {
            content: ":";
            position: absolute;
            left: 0;
            font-weight: 600;
        }

        .report-table-container {
            padding: 20px 30px;
            overflow-x: auto;
        }

        .report-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            overflow: hidden;
        }

        .report-table th {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--secondary-light) 100%);
            color: white;
            text-align: left;
            padding: 15px 20px;
            font-weight: 600;
            position: sticky;
            top: 0;
        }

        .report-table th:first-child {
            border-top-left-radius: 8px;
        }

        .report-table th:last-child {
            border-top-right-radius: 8px;
        }

        .report-table tr:nth-child(even) {
            background-color: var(--light-gray);
        }

        .report-table tr:hover {
            background-color: #edf2f7;
        }

        .table {
        width: 100%;
        table-layout: fixed;
        border: 0px solid #fff !important;

    }

    .table th, .table td {
        padding: 8px;
        text-align: center;
        width: 33.33%;
        word-wrap: break-word;
        border: none !important;
        vertical-align: baseline;

    }

        .report-table td {
            padding: 15px 20px;
            vertical-align: top;
            border-bottom: 1px solid var(--border-color);
        }

        .table-date {
            width: 120px;
            font-weight: 500;
            white-space: nowrap;
        }

        .table-subject {
            width: 25%;
            font-weight: 500;
        }

        .best-regards {
            padding: 20px 30px;
            background-color: white;
        }

        .signature-block {
            margin: 15px 0;
            padding: 20px;
            border-left: 4px solid var(--primary-color);
            background-color: #fafafa;
            border-radius: 0 8px 8px 0;
        }

        .signature-name {
            font-weight: 700;
            margin-bottom: 5px;
            font-size: 16px;
            color: var(--primary-color);
        }

        .flex {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .signature-title {
            font-style: italic;
            margin-bottom: 12px;
            color: var(--secondary-color);
        }

        .signature-contact {
            margin: 5px 0;
            font-size: 14px;
            color: var(--secondary-light);
            display: flex;
            align-items: center;
        }

        .signature-contact svg {
            margin-right: 8px;
            width: 16px;
            height: 16px;
        }

        .report-footer {
            padding: 7px 30px;
            text-align: center;
            font-size: 0.9rem;
            border-top: 1px solid var(--border-color);
            background-color: var(--secondary-color);
            color: #cbd5e0;
        }

        .highlight {
            color: var(--primary-light);
            font-weight: 600;
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 20px;
            text-align: center;
        }

        .empty-state-icon {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            color: #a0aec0;
        }

        .empty-state-text {
            font-size: 1.2rem;
            font-weight: 500;
            color: var(--secondary-color);
            margin-bottom: 10px;
        }

        .empty-state-subtext {
            color: #718096;
            max-width: 400px;
        }

        .status-tag {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-left: 10px;
        }

        .status-tag.open {
            background-color: #ebf8ff;
            color: #3182ce;
        }

        .status-tag.complete {
            background-color: #f0fff4;
            color: #38a169;
        }

        .status-tag.incomplete {
            background-color: #fffaf0;
            color: #dd6b20;
        }

        @media print {
            body {
                background-color: white;
                padding: 0;
            }

            .report-container {
                box-shadow: none;
                max-width: 100%;
            }

            .best-regards {
                break-inside: avoid;
            }

            .report-footer {
                position: fixed;
                bottom: 0;
                width: 100%;
            }

            .personnel-tag:hover {
                transform: none;
                box-shadow: 0 2px 4px rgb(148, 197, 234);
            }
        }


        /* Toast notification styles */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            background-color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            transform: translateY(-100px);
            opacity: 0;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            max-width: 350px;
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        .toast.success {
            border-left: 4px solid var(--success-color);
        }

        .toast.warning {
            border-left: 4px solid var(--warning-color);
        }

        .toast.error {
            border-left: 4px solid var(--error-color);
        }

        .toast-icon {
            margin-right: 12px;
        }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .toast-message {
            font-size: 0.9rem;
            color: var(--secondary-light);
        }

        .toast-close {
            background: none;
            border: none;
            color: #a0aec0;
            cursor: pointer;
            padding: 5px;
            margin-left: 10px;
        }

        /* Expandable description styles */
        .description-content {
            position: relative;
            max-height: 100px;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .description-content.expanded {
            max-height: 1000px;
        }

        .description-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 40px;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0), rgba(255, 255, 255, 1));
            display: flex;
            align-items: flex-end;
            justify-content: center;
            cursor: pointer;
        }

        .description-overlay span {
            background-color: #edf2f7;
            border-radius: 4px;
            padding: 2px 8px;
            font-size: 0.8rem;
            color: var(--secondary-color);
            margin-bottom: 5px;
        }

        .description-overlay:hover span {
            background-color: #e2e8f0;
        }

        .description-content.expanded .description-overlay {
            display: none;
        }



        .info-panel {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 1rem;
            background: #fff;
            transition: all 0.3s ease;
        }

        .info-panel:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .info-panel-header {
            background: #f8f9fa;
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
            font-weight: 600;
            color: #2c3e50;
            display: flex;
            align-items: center;
        }

        .info-panel-header i {
            margin-right: 0.5rem;
            color: #6c757d;
        }

        .info-panel-body {
            padding: 1rem;
            color: #495057;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .report-table th {
            background: #2d3748;
            color: white;
            text-align: left;
            padding: 7px 7px !important;
            font-weight: 600;
            position: sticky;
            top: 0;
        }

        .report-table td {
            padding: 7px 7px !important;
            vertical-align: top;
            border-bottom: 1px solid var(--border-color);
        }

        .best-regards {
            display: flex;
            justify-content: flex-end;
            width: 100%;
        }

        .signature-block {
            display: flex;
            justify-content: space-between;
            width: 100%;
            align-items: center;
        }

        .signature-header {
            display: flex;
            align-items: center;
            flex-grow: 1;
        }

        .signature-header p {
            margin-right: 20px;
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .signature-contact {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .signature-contact svg {
            margin-right: 5px;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</head>

<body style="width: 100vw; max-width: 2480px; margin: auto;">
    <!-- Toast notification template -->
    <div id="toast" class="toast">
        <div class="toast-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
        </div>
        <div class="toast-content">
            <div class="toast-title">Notification</div>
            <div class="toast-message">This is a notification message</div>
        </div>
        <button class="toast-close" onclick="hideToast()">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    @if (!isset($tickets) || ((is_array($tickets) || is_object($tickets)) && count($tickets) === 0))
        <div class="report-container">
            <div class="report-header">
                <img src="{{ asset('images/one_modo_logo.png') }}" alt="OneModo" class="logo">
                <div class="header-content">
                    <h1 class="report-title" style="font-size: 14px !important;">
                        {{ 'MONTHLY SERVICE TRACKER FOR ' . ($formattedDate ?? date('F Y')) }}
                    </h1>
                </div>
            </div>
            <div class="empty-state">
                <svg class="empty-state-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="empty-state-text">No data available for this period</h3>
                <p class="empty-state-subtext">There are no service records for the selected time period. Try selecting
                    a different date range or check back later.</p>
            </div>
            <div class="report-footer">
                <p>Generated on {{ date('d/m/Y') }} | OneModo Service Tracker | <span class="highlight">Delivering
                        Fanatic Service</span></p>
            </div>
        </div>
    @else
        <div class="report-container">
            <div class="report-header">
                <img src="{{ asset('images/one_modo_logo.png') }}" alt="OneModo" class="logo">
                <div class="header-content">
                    <h1 class="report-title">
                        {{ 'MONTHLY SERVICE TRACKER FOR ' . ($formattedDate ?? date('F Y')) }}
                    </h1>
                    <h2 class="report-subtitle">
                        {{ isset($tickets[0]['customer']) && isset($tickets[0]['customer']->legal_name) ? $tickets[0]['customer']->legal_name : 'N/A' }}
                    </h2>
                </div>

            </div>

            <div class="report-info">
                <div class="personnel-section">
                    <div class="personal">
                        <strong>TL's:</strong>
                        <div>
                            @if (isset($tickets) && count($tickets) > 0)
                                @php
                                    $uniquePersonnel = [];
                                    foreach ($tickets as $ticket) {
                                        if (isset($ticket['personal']) && isset($ticket['personal']['first_name'])) {
                                            $uniquePersonnel[$ticket['personal']['id']] =
                                                $ticket['personal']['first_name'];
                                        }
                                    }
                                    if (empty($uniquePersonnel)) {
                                        $uniquePersonnel = [
                                            'mohana' => 'MOHANA',
                                            'vengadesh' => 'VENGADESH',
                                            'muniyasamy' => 'MUNIYASAMY',
                                            'dineshkumar' => 'DINESHKUMAR',
                                            'praveenkumar' => 'PRAVEENKUMAR',
                                            'prabakaran' => 'PRABAKARAN',
                                            'anand' => 'ANAND BABU',
                                            'dilip' => 'DILIP KUMAR',
                                        ];
                                    }
                                @endphp
                                @foreach ($uniquePersonnel as $id => $name)
                                    <span class="personnel-tag">{{ strtoupper($name) }}</span>
                                @endforeach
                            @else
                                <span class="personnel-tag">MOHANA</span>
                                <span class="personnel-tag">VENGADESH</span>
                                <span class="personnel-tag">MUNIYASAMY</span>
                                <span class="personnel-tag">DINESHKUMAR</span>
                                <span class="personnel-tag">PRAVEENKUMAR</span>
                                <span class="personnel-tag">PRABAKARAN</span>
                                <span class="personnel-tag">ANAND BABU</span>
                                <span class="personnel-tag">DILIP KUMAR</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex">
                        <a href="{{ route('report.get-jpeg-report') }}" download="ticket-report.jpeg">
                            <svg id="download-icon" class="svg no-print" style="display: none;"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="black" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                        </a>
                        <svg onclick="window.print()" class="no-print"
                            style="display: none; height:25px; cursor: pointer;" id="print-icon"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                        </svg>
                        <a href="{{ route('report.get-pdf-report') }}">
                            <svg class="no-print" style="display: none; height:25px; cursor: pointer;" id="pdf-icon"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="black" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="personnel-section2">
                    <strong>REPORTED TO:</strong>
                    <span>CHITHRA SESHASAYEE</span>
                </div>
            </div>

            <div class="report-meta">
                <table class="table" style="border: 0px solid #fff !important;">
                    <thead style="border: 0px solid #fff !important;">
                        <tr>
                            <th style="width: 33.33%;">
                                <div class="info-panel">
                                    <div class="info-panel-header" style="background:#31c1c1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
                                            <path
                                                d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
                                            <path
                                                d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z" />
                                        </svg>
                                        REPORTED TO
                                    </div>
                                    <div class="info-panel-body">
                                        <strong> CHITHRA SESHASAYEE</strong>
                                        <p class="mb-0 mt-2 text-muted">Project Lead & Primary Contact</p>
                                    </div>
                                </div>
                            </th>
                            <th style="width: 33.33%;">
                                <div class="info-panel">
                                    <div class="info-panel-header" style="background: #ff9901">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-person-badge" viewBox="0 0 16 16">
                                            <path
                                                d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                            <path
                                                d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5v10.795a4.2 4.2 0 0 0-.776-.492C11.392 12.387 10.063 12 8 12s-3.392.387-4.224.803a4.2 4.2 0 0 0-.776.492z" />
                                        </svg>
                                        OWNER (ADMIN)
                                    </div>
                                    <div class="info-panel-body">
                                        <strong>John Doe</strong>
                                        <p class="mb-0 mt-2 text-muted">One point contact for any issues</p>
                                    </div>
                                </div>
                            </th>
                            <th style="width: 33.33%;">
                                <div class="info-panel">
                                    <div class="info-panel-header" style="background: #ffafaf">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                                            <path
                                                d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                                        </svg>
                                        FEEDBACK CALLS
                                    </div>
                                    <div class="info-panel-body">
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-success me-2">Good</span>
                                            <span>Software working good, No Issues so far</span>
                                        </div>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="report-table-container" style="padding-top: 0px !important;">
                <table class="report-table" style="margin-top: 0px !important;">
                    <thead>
                        <tr>
                            <th class="table-date">Date</th>
                            <th class="table-subject">Subject</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td class="table-date">{{ Carbon\Carbon::parse($ticket->date)->format('d-M-y') }}</td>
                                <td class="table-subject">
                                    {{ $ticket->type?->type }}
                                    @if (isset($ticket->status))
                                        @php
                                            $statusClass = '';
                                            switch ($ticket->status) {
                                                case 0:
                                                    $statusClass = 'incomplete';
                                                    break;
                                                case 1:
                                                    $statusClass = 'complete';
                                                    break;
                                            }
                                        @endphp
                                        <span class="status-tag {{ $statusClass }}">{{ $statusClass }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if (strlen(strip_tags($ticket->description)) > 150)
                                        <div class="description-content" id="desc-{{ $loop->index }}">
                                            {!! $ticket->description !!}
                                            <div class="description-overlay"
                                                onclick="expandDescription('desc-{{ $loop->index }}')">
                                                <span>Show more</span>
                                            </div>
                                        </div>
                                    @else
                                        {!! $ticket->description !!}
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 30px;">
                                    No data available for this period
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="best-regards">
                <div class="signature-block flex"
                    style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="margin-bottom: 0 !important;">Best Regards,</p>
                        <p class="signature-name">OneModo Support Team</p>
                        <p class="signature-title">Technical Support Department</p>
                    </div>
                    <div class="contact-info" style="text-align: right;">
                        <div class="signature-contact" style="display: flex; align-items: center; gap: 5px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                </path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <a href="mailto:support@onemodo.com"
                                style="text-decoration: none; color: inherit;">support@onemodo.com</a>
                        </div>
                        <div class="signature-contact"
                            style="display: flex; align-items: center; gap: 5px; margin-top: 5px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                </path>
                            </svg>
                            <a href="tel:+919876543210" style="text-decoration: none; color: inherit;">+91
                                9876543210</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="report-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <img src="{{ asset('images/one_modo_logo.png') }}" alt="OneModo" class="logo img-fluid"
                        width="120">
                    <span class="highlight">Service Tracker</span>
                </div>
            </div>

        </div>
    @endif

    <script>
        setTimeout(() => {
            document.getElementById("download-icon").style.display = "block";
            document.getElementById("pdf-icon").style.display = "block";
            document.getElementById("print-icon").style.display = "block";
        }, 1000);
    </script>
</body>

</html>
