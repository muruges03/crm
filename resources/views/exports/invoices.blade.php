
<?php
use App\Helpers;
?>
<!DOCTYPE html>
<html >
    <head>
        <meta charset="utf-8">
        <style>
             th {
                font: 20px bold;
            }
        </style>

    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th><strong>#</strong></th>
                    <th><strong>INVOICE #</strong></th>
                    <th><strong>INVOICE DATE</strong></th>
                    <th><strong>CUSTOMER NAME</strong></th>
                    <th><strong>GST NO</strong></th>
                    <th><strong>DUE DATE</strong></th>
                    <th><strong>PRODUCT</strong></th>
                    <th><strong>HSN CODE</strong></th>
                    <th><strong>PRICE</strong></th>
                    <th><strong>AMOUNT</strong></th>
                    <th><strong>CGST</strong></th>
                    <th><strong>SGST</strong></th>
                    <th><strong>STATUS</strong></th>
                    <th><strong>TOTAL AMOUNT</strong></th>
                    <th><strong>ORDER MONTH</strong></th>
                    <th><strong>REMARKS</strong></th>
                </tr>
            </thead>
            <tbody>
            @foreach($invoiceitems as $key=>$items)
                @if($items['cancel_status']==0)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$items['prefix']}}{{ $items['invoice_number'] }}</td>
                    <td>{{ date('d/m/Y', strtotime($items['invoiced_at'])) }}</td>
                    <td>{{ $items['legal_name'] }}</td>
                    <td>{{ $items['gstin'] }}</td>
                    <td>{{ date('d/m/Y', strtotime($items['due_at'])) }}</td>
                    <td>{{$items['product']}}</td>
                    <td>{{$items['code']}}</td>
                    <td> {{formatCurrency($items['price']) }}</td>
                    <td> {{formatCurrency($items['linetotalamount']) }}</td>
                    <td> {{formatCurrency($items['tax_amount']/2) }}</td>
                    <td> {{formatCurrency($items['tax_amount']/2) }}</td>
                    <td> {{'Draft' }}</td>
                    <td> {{formatCurrency($items['grand_total']) }}</td>
                    <td> {{date('M  Y', strtotime($items['start_date'])) }} @if(isset($items['end_date'])) - {{date('M  Y', strtotime($items['end_date']))}} @endif</td>
                    <td></td>
                </tr>
                @endif

            @endforeach


            </tbody>
        </table>

        <table>

            <thead>
            <tr>
                <th colspan="16" style="background-color: #27679b;color:white;font-size: 24px"> CANCELED INVOICE</th>
            </tr>
            <tr>
                <th><strong>#</strong></th>
                <th><strong>INVOICE #</strong></th>
                <th><strong>INVOICE DATE</strong></th>
                <th><strong>CUSTOMER NAME</strong></th>
                <th><strong>GST NO</strong></th>
                <th><strong>DUE DATE</strong></th>
                <th><strong>PRODUCT</strong></th>
                <th><strong>HSN CODE</strong></th>
                <th><strong>PRICE</strong></th>
                <th><strong>AMOUNT</strong></th>
                <th><strong>CGST</strong></th>
                <th><strong>SGST</strong></th>
                <th><strong>STATUS</strong></th>
                <th><strong>TOTAL AMOUNT</strong></th>
                <th><strong>ORDER MONTH</strong></th>
                <th><strong>REMARKS</strong></th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoiceitems as $key=>$items)
                @if($items['cancel_status']==1)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$items['prefix']}}{{ $items['invoice_number'] }}</td>
                        <td>{{ date('d/m/Y', strtotime($items['invoiced_at'])) }}</td>
                        <td>{{ $items['legal_name'] }}</td>
                        <td>{{ $items['gstin'] }}</td>
                        <td>{{ date('d/m/Y', strtotime($items['due_at'])) }}</td>
                        <td>{{$items['product']}}</td>
                        <td>{{$items['code']}}</td>
                        <td> {{formatCurrency($items['price']) }}</td>
                        <td> {{formatCurrency($items['linetotalamount']) }}</td>
                        <td> {{formatCurrency($items['tax_amount']/2) }}</td>
                        <td> {{formatCurrency($items['tax_amount']/2) }}</td>
                        <td> {{'Draft' }}</td>
                        <td> {{formatCurrency($items['grand_total']) }}</td>
                        <td> {{date('M  Y', strtotime($items['start_date'])) }} @if(isset($items['end_date'])) - {{date('M  Y', strtotime($items['end_date']))}} @endif</td>
                        <td></td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </body>
</html>
