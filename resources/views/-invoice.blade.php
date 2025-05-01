<?php
use App\Helpers;
?>
<!DOCTYPE html>
<html>
    <head>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"  crossorigin="anonymous">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<!-- <link href="{{ env('APP_URL'); }}/public/css/invoice.css" rel="stylesheet"> -->
<link href="http://modocrm.com/css/invoice.css" rel="stylesheet">

</head>
<body >
<div class="container" >

            @foreach($invoice as $invoices)
                <div >
                    <div class="ribbon ribbon-top-left" style="">
                        <span>INVOICE</span>
                    </div>

                    @foreach($fromAddress as $fromAddresses)
                    <div style="width:100%;height:140px !important;">
                        <div style="float:left; margin-left:8%; margin-top:4%">
                            <!-- <img src="" width="250" height="50"> -->
                            <!-- <img src="{{ env('APP_URL'); }}/storage/public/{{$fromAddresses->logo_file;}}" class="pt-3" style="margin-left:50px;margin-top:10px;" width="300" height="80"> -->
                        </div>
                        <table   style="width:50%; float:right;text-align:end;">
                            <tr>
                                <td style="font-weight:600; font-size:14px">{{$fromAddresses->legal_name}}</h6>
                            </tr>
                            <tr>
                                <td > {{$fromAddresses->line_1}}</td>
                            </tr>
                            <tr>
                                <td> {{$fromAddresses->line_2}}</td>
                            </tr>
                            <tr>
                                <td>{{$fromAddresses->city}}</td>
                            </tr>
                            <tr>
                                <td> {{$fromAddresses->state_name}} - {{$fromAddresses->zipcode}}</td>
                            </tr>
                            <tr>
                            @if(isset($fromAddresses->gstin))
                                <td style="font-weight:600">GST # : {{$fromAddresses->gstin}}</td>
                            @endif
                            </tr>

                        </table>

                    </div>
                    @endforeach()
                </div>
                    <hr>
                    <div style="width:100%;height:200px;">
                        <table class=" " style="width:50%; float:left;">
                            <thead>
                                <tr>
                                    <th style="font-weight:600; font-size:16px; padding:5px 0;text-align:left;">Bill To</th>
                                </tr>
                            </thead>
                            <tbody >

                            @foreach($toAddress as $toAddresses)
                                <tr >
                                    <td style="padding:0 10px;">{{$toAddresses->legal_name}}</td>
                                </tr>
                                <tr >
                                    <td style="padding:0 10px;">{{$toAddresses->line_1}}@if(isset($toAddresses->line_2)) {{$toAddresses->line_2}} @endif</td>
                                </tr>
                                <tr >
                                    <td style="padding:0 10px;">{{$toAddresses->landmark}}</td>
                                </tr>
                                <tr >
                                    <td style="padding:0 10px;">{{$toAddresses->city}}</td>
                                </tr>
                                <tr >
                                    <td style="padding:0 10px;">{{$toAddresses->state_name}} - {{$toAddresses->zipcode}}</td>
                                </tr>
                                <tr>
                                    @if(isset($toAddresses->gstin))
                                        <td style="padding:0 10px;">GST # : <span style="font-weight:600"> {{$toAddresses->gstin}}</span></td>
                                    @endif
                                </tr>
                            @endforeach()
                            </tbody>
                        </table>

                        <table style="float:right;text-align:end; width:32%">
                            <thead>
                                <tr>
                                    <th style="font-weight:600; font-size:16px; text-align:start; ">Invoice Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align:start;">Invoice #</td>
                                    <td>{{$invoices['prefix']}}-{{$invoices['invoice_number']}}</td>
                                </tr>
                                <tr>
                                    <td style="text-align:start;">Invoice Date</td>
                                    <td>{{Carbon\Carbon::parse($invoices->invoiced_at)->format('Y-m-d')}}</td>
                                </tr>
                                <tr>
                                    <td style="text-align:start;">Due Date</td>
                                    <td> {{Carbon\Carbon::parse($invoices->due_at)->format('Y-m-d') }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align:start;">P.O #</td>
                                    <td>{{date('M  Y', strtotime($invoices->start_date)) }} @if(isset($invoices->end_date)) - {{date('M  Y', strtotime($invoices->end_date))}} @endif</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                        <div class="row table-row "  >
                        <table class="table table-striped rounded-lg" >
                            <thead class=" text-white" style="background-color:#000;opacity:0.91; display: table-row-group;" >
                                <tr style="">
                                    <th class="text-center" style="width:4px !important; " >#</th>
                                    <th style="width:51%">Item & Description</th>
                                    <th class="text-center" style="width:4%">Qty</th>
                                    <th class="text-center" style="width:12%">Price (&#8377;)</th>
                                    <th class="text-center" style="width:11%">CGST (&#8377;)</th>
                                    <th class="text-center" style="width:11%">SGST (&#8377;)</th>
                                    <th class="text-center" style="width:22%">Total (&#8377;)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $cgst   = 0;
                                    $sgst   = 0;
                                @endphp
                                @foreach($invoiceitem as $invoiceitems)
                                    <tr style="">
                                        <td class="text-center" style="width:4px !important;  ">{{ $loop->index+1 }}</td>

                                        <td>{{$invoiceitems['name']}}<p style="text-align: justify; text-justify: inter-word;" > {!! nl2br(e($invoiceitems['description'])) !!}</p></td>
                                        <td class="text-center">{{$invoiceitems['quantity']}}</td>
                                        <td class="text-center">{{formatCurrency($invoiceitems['price'])}}</td>
                                        @if($invoiceitems['tax_id'] != 0)
                                        <td style="width:9%" class="text-center">{{formatCurrency(($invoiceitems['price'] * ($invoiceitems['tax_id']/100))/2)}}<br>({{$invoiceitems['tax_id']/2}} %)</td>
                                        <td style="width:9%" class="text-center">{{formatCurrency(($invoiceitems['price'] * ($invoiceitems['tax_id']/100))/2)}}<br>({{$invoiceitems['tax_id']/2}} %)</td>
                                        @else
                                        <td style="width:9%" class="text-center">-</td>
                                        <td style="width:9%" class="text-center">-</td>
                                        @endif()
                                        <td style="width:23%" class="text-center">{{formatCurrency($invoiceitems['total_amount'])}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <hr>
                    <div style="padding:5px 20px !important;">
                        <div class="text-grey text-90 " style="width:50%; float:left;">
                            <b >Notes </b>
                            <p>Bank Name - ICICI BANK<br> ACCOUNT NAME - MODOMINES<br> ACCOUNT NUMBER - 278005000665<br> IFSC CODE - ICIC0002780<br>BANK BRANCH - JAGANATHAPURAM</p>
                        </div>
                        <table  style="float:right; width:30%; margin-left:10%">
                            <tfoot >
                                <tr>
                                    <td> SubTotal (&nbsp;&#8377;)</td>
                                    <td >   {{formatCurrency($invoices['untaxed_amount'], '')}}</td>
                                </tr>
                                @if(count($invoicetax) > 0)
                                <tr>
                                    @foreach($invoicetax as $value)
                                    <td>{{$value['name']}} <span class="ml-4 pl-2" > &nbsp;&#8377; {{formatCurrency($value['amount'])}}</span></td>
                                    @endforeach
                                @else
                                    @if($invoices['invoiceTaxAmount'] != 0)
                                    <tr>
                                        <td>CGST ({{$invoiceitems['tax_id']/2}} %) (&nbsp;&#8377;)</td>
                                        <td> {{formatCurrency($invoices['invoiceTaxAmount']/2)}}</td>
                                    </tr>
                                    <tr>
                                        <td>SGST ({{$invoiceitems['tax_id']/2}} %) (&nbsp;&#8377;) </td>
                                        <td> {{formatCurrency($invoices['invoiceTaxAmount']/2)}}</td>
                                    </tr>
                                    @endif()
                                </tr>
                                @endif()
                                @if($invoices['discount_amount'] != 0)
                                <tr>
                                    <td> Discount Amount (&nbsp;&#8377;)</td>
                                    <td> {{formatCurrency($invoices['discount_amount'])}}</td>
                                </tr>
                                @endif()
                                <tr>
                                    <td>  Total Amount (&nbsp;&#8377;)</td>
                                    <td> {{formatCurrency($invoices['invoice_totalamount'])}}</td>
                                </tr>

                            </tfoot>
                        </table>
                    </div>

            @endforeach()
        </div>

</body>
</html>

<style>
    p{
        margin:0px !important;
    }


@import url(https://fonts.googleapis.com/css?family=Lato:700);

.ribbon {
    width: 130px;
    height: 130px;
    overflow: hidden;
    position: absolute;
}

.ribbon::before,
.ribbon::after {
    position: absolute;
    z-index: -1;
    content: '';
    display: block;
    border: 5px solid #da5b5b;
}

.ribbon span {
    position: absolute;
    display: block;
    width: 225px;
    padding: 10px 0;
    background-color: #B30F0F;
    box-shadow: 0 5px 10px rgba(0, 0, 0, .1);
    color: #fff;
    font: 700 18px/1 'Lato', sans-serif;
    text-shadow: 0 1px 1px rgba(0, 0, 0, .2);
    text-transform: uppercase;
    text-align: center;
}

/* top left*/
.ribbon-top-left {
    top: -10px;
    left: -10px;
}

.ribbon-top-left::before,
.ribbon-top-left::after {
    border-top-color: transparent;
    border-left-color: transparent;
}

.ribbon-top-left::before {
    top: 10px;
    right: 22px;
}

.ribbon-top-left::after {
    bottom: 12px;
    left: 0px;
}

.ribbon-top-left span {
    right: -25px;
    top: 30px;
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg);
}
</style>
