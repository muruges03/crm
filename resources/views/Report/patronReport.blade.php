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
        @media print {
            .no-print {
                visibility: hidden;
            }
        }
    </style>
</head>
<body style=" page-break-after:always; ">
<div>
    <div class="row" style="height:100px !important;">
        <div class="col-sm-4 px-2 py-2">
            <img src="{{ env('APP_URL')}}/storage/{{$entity[0]['logo_file']}}" style="width:100px">
        </div>
        <div class="col-sm-4" >
            <div class="text-90 text-600" style="text-align:start; padding-top:20px; padding-top:50px">
                Date : {{Carbon\Carbon::parse($input['date'][0])->format('d-m-Y')}} to {{Carbon\Carbon::parse($input['date'][1])->format('d-m-Y')}}
            </div>
            {{--            <button class="no-print " style="border:gray;background-color: crimson;color:white"  onclick="window.print()"> <a  class="btn btn-sm btn-white m-b-5 p-l-5"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print</a></button>--}}
        </div>
        <div class="col-sm-3">
            <div style="text-align:center; color:#000; font-weight:600; font-size:25px;width:300px;height:50px; margin-top:10px; padding:0px 0px;align-items:end" class="rounded-pill shadow-lg bg-info">
                <span>Patron Report</span>
            </div>

        </div>
        <div class="col-sm-1" >
            <button class="no-print " style="border:gray;background-color: crimson;color:white;margin-top:40px"  onclick="window.print()"> <a  class="btn btn-sm btn-white m-b-5 p-l-5"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print</a></button>
        </div>
    </div>
    <div class="col-md-12 pt-3">

        @php $openingbalance=0; $prefix=null; @endphp

        <div class="" >
            <div class="table-responsive " style="page-break-after:always;">
                <table class="table table-striped" style="">
                    <thead class="bg border">
                    <tr>
                        <th class="text-center border">#</th>
                        <th class="text-center border">Name Of Customer</th>
                        <th class="text-center border" >Opening (&#8377;) </th>
                        <th class="text-center border">Credit (&#8377;)</th>
                        <th class="text-center border">Debit (&#8377;)</th>
                    </tr>
                    </thead>
                    <tbody class="border">
                    @php $balanceamount=0; $credittotal=0; $debittotal=0;$debitSum=0;$creditSum=0;$balanceSum=0; @endphp
                    @foreach($getValue as $keyPatron => $patronItems)
                        @if($patronItems['legal_name']!=null)
                        <tr>
                            <td class="text-center border">{{ $loop->index+1 }}</td>
                            <td class="text-center border">{{$patronItems['legal_name']}}</td>
                            <td class="text-center border">{{ $patronItems['opening']}}</td>
                            <td class="text-center border">{{ $patronItems['credit_amount']}}</td>
                            <td class="text-center border">{{ $patronItems['debit_amount']}}</td>
                        </tr>
                            @php $creditSum+=$patronItems['credit_amount']; $debitSum+=$patronItems['debit_amount'];@endphp

                        @endif
                    @endforeach()
                    </tbody>
                    <tfoot class="border">
                    <tr>
                        <th colspan="3" class="text-right border align-middle">Total</th>
                        <th colspan="1" style="height:100px" class="text-center border align-middle"> &#8377; {{$creditSum ? AppHelpers::instance()->formatCurrency($creditSum) : '0' }}</th>
                        <th colspan="1" style="height:100px" class="text-center border align-middle"> &#8377; {{$debitSum > 0 ? AppHelpers::instance()->formatCurrency($debitSum) : '0'}}</th>
                        {{--                                <th colspan="1" class="text-center border align-middle"> &#8377; {{ AppHelpers::instance()->formatCurrency($balanceamount)}}</th>--}}
                    </tr>
{{--                    <tr >--}}
{{--                        @if($opening[0]['opening'] == 0)--}}
{{--                            @php $opening[0]['opening'] =0; $closing=$balanceSum+$opening[0]['opening']; @endphp--}}
{{--                        @else--}}
{{--                            @php  $closing=$balanceSum+$opening[0]['opening']; @endphp--}}
{{--                        @endif--}}
{{--                        <th colspan="4" style="height:100px" class="text-right border align-middle">Closing Amount</th>--}}
{{--                        <th colspan="1" style="height:100px" class="text-center border align-middle">&#8377; {{$closing > 0 ? AppHelpers::instance()->formatCurrency($closing) : '0' }}</th>--}}
{{--                        <th colspan="1" style="height:100px" class="text-center border align-middle">&#8377; {{$closing < 0 ? AppHelpers::instance()->formatCurrency(abs($closing)) : '0'}}</th>--}}
{{--                    </tr>--}}
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
</body>
</html>
