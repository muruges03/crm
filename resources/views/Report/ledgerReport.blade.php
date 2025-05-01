<?php
use App\Helpers\AppHelpers;
?>
    <!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"  crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ env('APP_URL')}}/css/pdf.css" rel="stylesheet">


    <style>
        table > thead >tr >th {
            font-size : 14px !important;

        }
        table > tbody >tr >td {
            font-size : 13px !important;

        }
        @media print {
            @page

            .no-print {
                visibility: hidden;
            }
            .table td, .table th {
                padding: 0px 3px !important;
            }
        }
    </style>
</head>
<body style=" page-break-after:always; ">
<div>
    <div class="row" style="">
        <div class="col-sm-4 px-2 py-2 ml-5">
            @if($entity[0]['logo_file']!=null)
                <img src="{{ env('APP_URL')}}/storage/{{$entity[0]['logo_file']}}" class=""  style="width:100px;">
                <br><br>
                <span style="font-weight: bold;font-size: 18px;color:#27679b">{{$entity[0]['legal_name']}}</span>
            @else
                <img src="../images/modoinfra_logo_v1-0.png" class="" width="200" height="80" style="">
            @endif
        </div>
        <div class="col-sm-5" >
            <h4 style="color:#27679b;font-weight: 600;margin-top:30px;margin-left:30px">LEDGER REPORT </h4>
            <i style="font-weight: bold;text-align:center;">Time Period:{{Carbon\Carbon::parse($input['date'][0])->format('d-M-y')}} to {{Carbon\Carbon::parse($input['date'][1])->format('d-M-y')}}</i>
        </div>
        <div class="col-sm-1" >
            <button class="no-print " style="border:gray;background-color: crimson;color:white;margin-top:40px"  onclick="window.print()"> <a  class="btn btn-sm btn-white m-b-5 p-l-5"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print</a></button>
        </div>
    </div>
    @foreach($opening_balance as $op_key=>$op_value)
        @php $opening =0; $ledger_name=''; @endphp
        @foreach($op_value as $bal)
            @php $opening =$bal['opening_amount']; $ledger_name=$bal['title']; @endphp


            {{--    {{$opening}}--}}
            <div class="col-md-12 pt-3">
                <table class="table " style="margin-bottom:0px !important">
                    <thead class="grouptable-bg border">
                    <tr class="bg text-dark" style="background-color: #27679b">
                        <th colspan="2" class="text-left " > Ledger Name : <b>{{$ledger_name}}</b></th>
                        <th colspan="2" class="text-right " >Opening Balance : &#8377; {{$opening >= 0 ? 'cr. '.AppHelpers::instance()->formatCurrency($opening) :  'dr. '.AppHelpers::instance()->formatCurrency(abs($opening)) }} </th>
                    </tr>
                    </thead>
                </table>
                <div class="" >
                    <div class="table-responsive">

                        <table class="table table-invoice" style="">
                            <thead class="bg border" style="background-color: #dd4949">
                            <tr>
                                <th class="text-left pl-2 border">#</th>
                                {{--                                <th class="text-left pl-2 border">Ref #</th>--}}
                                <th class="text-left pl-2 border" >DATE </th>
                                <th class="text-left pl-2 border">TYPE</th>
                                <th class="text-left pl-2 border">NOTES</th>
                                <th class="text-left pl-2 border">CREDIT (&#8377;)</th>
                                <th class="text-left pl-2 border">DEBIT (&#8377;)</th>
                            </tr>
                            </thead>
                            <tbody class="border">
                            @php $debittotal=0;$credittotal=0; $balanceamount=0; $closing=0;@endphp
                            @if(!empty($sum_asset))
                                @foreach($sum_asset as $key2=>$items2)
                                    @foreach($items2 as $key1=>$items1)
                                        @if($ledger_name==$key2)
                                            <tr>
                                                @php
                                                    $debittotal += $items1['debit_amount'];
                                                    $credittotal += $items1['credit_amount'];
                                                    $balanceamount = $credittotal - $debittotal;
                                                @endphp
                                                <td class="text-left pl-2 border">{{ $loop->index+1 }}</td>
                                                <td class="text-left pl-2 border">{{Carbon\Carbon::parse($items1['entry_date'])->format('d-m-Y')}}</td>
                                                <td class="text-left pl-2 border">{{$items1['notes'] ? $items1['notes'] : ''}}</td>
                                                <td class="text-left pl-2 border">{{$items1['narration'] }}</td>
                                                <td class="text-right pl-2 border"> {{$items1['credit_amount']>0 ? AppHelpers::instance()->formatCurrency($items1['credit_amount']) : '0'}}</td>
                                                <td class="text-right pl-2 border"> {{$items1['debit_amount']>0 ? AppHelpers::instance()->formatCurrency($items1['debit_amount']) : '0'}}</td>
                                            </tr>
                                        @endif()
                                    @endforeach()
                                @endforeach()
                            @endif()
                            </tbody>
                            <tfoot class="border">
                            <tr >
                                <th colspan="4" style="height:100px" class="text-right pl-2 border align-middle">Grand Total (&#8377;)</th>
                                <th colspan="1" style="height:100px" class="text-right pl-2 border align-middle"> {{$credittotal ? AppHelpers::instance()->formatCurrency($credittotal) : '0' }}</th>
                                <th colspan="1" style="height:100px" class="text-right pl-2 border align-middle"> {{$debittotal ? AppHelpers::instance()->formatCurrency($debittotal) : '0' }}</th>
                            </tr>
                            <tr style="height:100px">
                                <th colspan="4" style="height:100px" class="text-right pl-2 border align-middle">Closing Balance (&#8377;)</th>
                                @if(count($opening_balance) == 0)
                                    @php $openingbalance = 0; $closing=$balanceamount+$opening; @endphp
                                @else
                                    @php  $closing=$balanceamount+$opening; @endphp
                                @endif
                                <th colspan="1" style="height:100px" class="text-right pl-2 border align-middle"> {{$closing > 0 ? AppHelpers::instance()->formatCurrency($closing) : '0' }}</th>
                                <th colspan="1" style="height:100px" class="text-right pl-2 border align-middle"> {{$closing < 0 ? AppHelpers::instance()->formatCurrency(abs($closing)) : '0'}}</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                {{--            @endforeach()--}}
                {{--        @endif()--}}
                @endforeach()
                @endforeach()
            </div>
</div>
<footer class="footer " style='text-align:right; color:#969BA7;bottom:0px; position:fixed;'>

    <a style='font-size:12px; font-weight:600; '>Powered By:Modoinfra.com</a>
</footer>
</body>
</html>
