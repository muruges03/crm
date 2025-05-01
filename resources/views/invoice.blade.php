<?php
use App\Helpers;
?>
<html>
<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"  crossorigin="anonymous">
{{--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">--}}
<link href="{{ env('APP_URL') }}/public/css/invoice.css" rel="stylesheet">
<link href="http://modocrm.com/css/invoice.css" rel="stylesheet">
<style>
    @media screen {
        p.bodyText {font-family:verdana, arial, sans-serif;}
    }

    @media print {
        .vendorListHeading {
            background-color: black !important;
            -webkit-print-color-adjust: exact;
        }
        .no-print {
            display: none;
        }

        .vendorListHeading th {
            color: white !important;
        }
        p.bodyText {font-family:georgia, times, serif;}
    }
    @media screen, print {
        p.bodyText {font-size:10pt}
    }
    table td, table th {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 0px solid #dee2e6 !important;
    }
</style>
</head>
<body>
<div class=" container" >
    <div class="row" >
        <div class="col-sm-12">
            @foreach($invoice as $invoices)
            <div class="">
                <div class="panel-body">
                    <div class="row" style="width: 100%;display:inline-flex;height:18%">
                        <div class="col-sm-1 top-left from" style=" width:10%;float:left">
                            <div class="ribbon ribbon-top-left" >
                                <span>INVOICE</span>
                            </div>
                        </div>
                        @foreach($fromAddress as $fromAddresses)

                        <div style="width:40%;float:left">
                            <img src="{{ env('APP_URL') }}/storage/{{$fromAddresses->logo_file}}" class="pt-3" style="margin-left:10px;margin-top:10px;" width="230" height="60">
                         </div>
                            <div style="width:10%;float:right;height:50px;">
                                <button class="no-print " style="border:gray;background-color: crimson;color:white"  onclick="window.print()"> <a  class="btn btn-sm btn-white m-b-5 p-l-5"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print</a></button>
                            </div>
                        <div class="text-right" style="width:40%;float:right">
                            <strong class=" text-110">{{$fromAddresses->legal_name}}</strong>
                            <p > {{$fromAddresses->line_1}},<br> {{$fromAddresses->line_2}}</p>
                            <p>{{$fromAddresses->city}}, {{$fromAddresses->state_name}} - {{$fromAddresses->zipcode}}</p>
                            @if(isset($fromAddresses->gstin))
                                <p style="font-weight:600">GST # : {{$fromAddresses->gstin}}</p>
                            @endif
                        </div>
                        @endforeach()
                    </div>

                    <hr >
                    <div class="row" style="width: 100%;height:14%">

                        <div style="float:left;width:60%">
                        @foreach($toAddress as $toAddresses)
                            <strong class="">{{$toAddresses->legal_name}}</strong>
                            <p>{{$toAddresses->line_1}}</p>
                            <p> {{$toAddresses->line_2}}</p>
                            <p>{{$toAddresses->landmark}} {{$toAddresses->city}}</p>
                            <p>{{$toAddresses->state_name}} - {{$toAddresses->zipcode}}</p>
                            @if(isset($toAddresses->gstin))
                            <p>GST # : <span style="font-weight:600"> {{$toAddresses->gstin}}</span></p>
                            @endif
                        @endforeach()
                        </div>


                        <div style="float:right;width:40%" >
                            <div style="text-align:left; float:left;width:40%" >
                                <p style="font-size: 18px ; font-weight: bold;">Invoice #</p>
                                <p>Invoice Date</p>
                                <p>Due Date</p>
                                <p>P.O #</p>
                            </div>
                            <div style="width:60%;float:right;text-align: right">
                                <p style="font-size: 18px ; font-weight: bold;">{{$invoices['prefix']}}{{$invoices['invoice_number']}}</p>
                                <p>{{Carbon\Carbon::parse($invoices->invoiced_at)->format('Y-m-d')}}</p>
                                <p> {{Carbon\Carbon::parse($invoices->due_at)->format('Y-m-d') }}</p>
                                <p> {{date('M  Y', strtotime($invoices->start_date)) }} @if(isset($invoices->end_date)) - {{date('M  Y', strtotime($invoices->end_date))}} @endif</p>
                            </div>
                        </div>

                    </div>

                    <div class="pt-4">
                        <table>
                            <thead style="">
                                <tr style="color: #eeeeee;background-color: black;">
                                    <th   class="text-center" style="width:4px !important;color:white !important;">#</th>
                                    <th style="width:55%">Item & Description</th>
                                    <th style="width:4%" class="text-center" >Qty</th>
                                    <th style="width:4%" class="text-center" >Price/HSN</th>
                                    @if($invoiceitem[0]['tax_id'] != null && $invoiceitem[0]['tax_name']=='GST')
                                    <th  class="text-center" style="width:9%">CGST</th>
                                    <th  class="text-center" style="width:9%">SGST</th>
                                    @endif()
                                    @if($invoiceitem[0]['tax_id'] == null )
                                        <th class="text-center" style="width:7%">CGST</th>
                                        <th class="text-center" style="width:7%">SGST</th>
                                    @endif()
                                    @if($invoiceitem[0]['tax_id'] != null && $invoiceitem[0]['tax_name']=='IGST')
                                    <th style="width:9%" class="text-center">IGST</th>
                                    @endif()
                                    <th style="width:30%" class="text-center">Total (&#8377;)</th>
                                </tr>
                            </thead>
                            <tbody style="background-color: #eee">
                                @php
                                $cgst   = 0;
                                $sgst   = 0;
                                @endphp
                                @foreach($invoiceitem as $invoiceitems)
                                <tr style="">
                                    <td  class="text-center border" style="width:4px !important;  ">{{ $loop->index+1 }}</td>
                                    <!-- <td></td> style="text-align: justify; text-justify: inter-word;"-->
                                    <td class="border" style="width:55%">{{$invoiceitems['name']}}<p style="text-align: justify; text-justify: inter-word;" > {!! nl2br(e($invoiceitems['description'])) !!}</p></td>
                                    <td class="text-center border" style="width:3%">{{$invoiceitems['quantity']}}</td>
                                    <td class="text-center border" style="width:4%">&#8377;{{formatCurrency($invoiceitems['price'])}}
                                        <p style="font-size: 12px;">({{$invoiceitems['code']}})<p>
                                    </td>
                                {{--                                    Gst Split up--}}
                                    @if($invoiceitems['tax_id'] != null && $invoiceitems['tax_name']=='GST')
                                    <td style="width:9%" class="text-center border">₹{{formatCurrency(($invoiceitems['price'] * ($invoiceitems['tax_id']/100))/2)}}<br>({{$invoiceitems['tax_id']/2}} %)</td>
                                    <td style="width:9%" class="text-center border">₹{{formatCurrency(($invoiceitems['price'] * ($invoiceitems['tax_id']/100))/2)}}<br>({{$invoiceitems['tax_id']/2}} %)</td>
                                    @endif()
                                {{--                                    GST Split up end--}}
                                {{--                                    IGST Split Up--}}
                                    @if($invoiceitems['tax_id'] == null)
                                        <td style="width:7%" class="text-center border">-</td>
                                        <td style="width:7%" class="text-center border">-</td>
                                    @endif()
                                    @if($invoiceitems['tax_id'] != null && $invoiceitems['tax_name']=='IGST')
                                        <td style="width:9%" class="text-center border">&#8377;{{formatCurrency(($invoiceitems['price'] * ($invoiceitems['tax_id']/100)))}}</td>
                                    @endif()
                                    <td style="width:30%" class="text-center border">₹ {{formatCurrency($invoiceitems['total_amount'])}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border">
                            <tr >
                                <td colspan="3" rowspan="4"><strong class="text-90">Notes </strong>  <p>@php echo $email[0]['notes']; @endphp</p></td>
                                <td class="border " colspan="2">SubTotal</td>
                                <td class="border text-right" colspan="2">&#x20B9; {{formatCurrency($invoices['untaxed_amount'], '')}}</td>
                            </tr>
                            @if(count($invoicetax) > 0)


                                @foreach($invoicetax as $value)
                                    <tr>
{{--                                            <td colspan="4"  ></td>--}}
                                        <td class="border " colspan="2">{{$value['name']}} </td>
                                        <td class="border text-right" colspan="2">&#8377; {{formatCurrency($value['amount'])}}</td>
                                    </tr>
                                @endforeach
                            @else
                                @if($invoices['invoiceTaxAmount'] != 0)
                                    <tr>
{{--                                            <td colspan="4" ></td>--}}
                                    <td class="border text-right" colspan="2">
                                        CGST ({{$invoiceitems['tax_id']/2}} %)
                                    </td>
                                    <td class="border text-right" colspan="2">
                                         &nbsp;&#8377; {{formatCurrency($invoices['invoiceTaxAmount']/2)}}
                                    </td>
                                    </tr>
                                    <tr>
{{--                                            <td colspan="4" ></td>--}}
                                    <td class="border text-right" colspan="2">
                                        SGST ({{$invoiceitems['tax_id']/2}} %)
                                    </td>
                                    <td class="border text-right" colspan="2">
                                         &nbsp;&#8377; {{formatCurrency($invoices['invoiceTaxAmount']/2)}}
                                    </td>
                                    </tr>
                                @endif()

                            @endif()
                                @if($invoices['discount_amount'] != 0)
                                <tr>
{{--                                        <td colspan="4"></td>--}}
                                    <td class="border " colspan="2"> Discount Amount</td>
                                    <td class="border text-right" colspan="2">&#8377; {{formatCurrency($invoices['discount_amount'])}}</td>
                                </tr>
                                @endif
                                <tr>
{{--                                        <td colspan="4"></td>--}}
                                    <td class="border " colspan="2"> Total Amount</td>
                                    <td class="border text-right" colspan="2">&#8377; {{formatCurrency($invoices['invoice_totalamount'])}}</td>
                                </tr>
                        </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        @endforeach()
        </div>
    </div>
    <footer class="footer" style='width:100%;text-align:center;bottom:10px; position:fixed;height:2%;  color:#969BA7'>
        <hr />
        <span style="font-size: 12px">Powered By :</span>
        <span style='font-size:12px;color:red;margin:0px!important;' > onemodo.com</span>
    </footer>
</div>
</body>
</html>
