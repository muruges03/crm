<?php
use App\Helpers\AppHelpers;
?>
    <!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"  crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ env('APP_URL'); }}/css/pdf.css" rel="stylesheet">

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
    <div class="row" >
        <div class="col-sm-4 px-2 py-2">

            @if($entity[0]['logo_file']!=null)
                <img src="{{ env('APP_URL')}}/storage/{{$entity[0]['logo_file']}}" class=""  style="width:200px;">
                <p style="color:#063583;font-size: 20px;font-weight: bold">{{$entity[0]['legal_name']}}</p>
            @else
                <img src="../images/modoinfra_logo_v1-0.png" class="" width="200" height="80" style="">
            @endif
        </div>
        <div class="col-sm-4" >
            <div class="text-90 text-600" style="text-align:start; ">
                Date : {{Carbon\Carbon::parse($input['date'][0])->format('d-m-Y')}} to {{Carbon\Carbon::parse($input['date'][1])->format('d-m-Y')}}
            </div>
            {{--            <button class="no-print " style="border:gray;background-color: crimson;color:white"  onclick="window.print()"> <a  class="btn btn-sm btn-white m-b-5 p-l-5"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print</a></button>--}}
        </div>
        <div class="col-sm-3">
            <div style="text-align:center; color:#000; font-weight:600; font-size:25px;width:300px;height:50px; margin-top:10px; padding:0px 0px;align-items:end" class="rounded-pill shadow-lg bg-info">
                <span>Payment Report</span>
            </div>

        </div>
        <div class="col-sm-1" >
            <button class="no-print " style="border:gray;background-color: crimson;color:white;margin-top:40px"  onclick="window.print()"> <a  class="btn btn-sm btn-white m-b-5 p-l-5"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print</a></button>
        </div>
    </div>

   @php $grand_total=0;$trans_amount=0;@endphp


{{--        @foreach($itemvalue->groupBy('payment_type') as $keys1=>$itemvalue1)--}}
            <div class="col-md-12 pt-3">
                <div class="">
                    <div class="table-responsive">

                        <table class="table table-invoice"  >
                            <thead class="bg">
                            <tr class="border">
                                <th style="padding:5px !important;" class="text-center border">#</th>
                                <th   class="text-center border">Payment Date</th>
                                <th colspan="2" class="text-center border">Vendor Name </th>
                                <th colspan="2" class="text-center border">Total Amount</th>
                                <th colspan="2" class="text-center border">Paid Amount</th>
                                {{--                                <th  class="text-center border">Balance Amount</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @php $sub_total=0; @endphp

                            @foreach($payment as $keyvalue=>$paymentitem)

                                <tr>
                                    <td class="text-center border">{{ $loop->index+1 }}</td>
                                    <td class="text-center border">{{Carbon\Carbon::parse($paymentitem['payment_date'])->format('d-M-Y')}}</td>
                                    <td colspan="2" class="text-center border">{{ $paymentitem['legal_name']}}</td>
                                    <td colspan="2" class="text-center border">&#8377; {{ AppHelpers::instance()->formatCurrency($paymentitem['total_amount'])}}</td>
                                    <td colspan="2" class="text-center border">&#8377; {{ AppHelpers::instance()->formatCurrency($paymentitem['paid_amount'])}}</td>
                                    {{--                                <td class="text-center border">{{ $paymentitem['balance_due']}}</td>--}}
                                </tr>
                                @php $sub_total+=$paymentitem['paid_amount'];$grand_total+=$paymentitem['paid_amount'];@endphp
                            @endforeach()


                            <tr class="">
                                <th colspan=7 class="border" style="text-align:end">Total </th>
                                <td style="text-align:end"  class="border bg"> &#8377; {{ AppHelpers::instance()->formatCurrency($sub_total)}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    <table class="table ">
        <tbody class="">
        <tr>

        </tr>
        </tbody>
    </table>
    <table class="table">
        <thead>
        <tr class="border">
            <th colspan="1" class="text-right border " style="text-align:right">Grand Total  </th>
            <th colspan="1" class="text-right border bg" style="text-align:right"> &#8377; {{ AppHelpers::instance()->formatCurrency($grand_total)}}</th>

        </tr>
        </thead>
    </table>

</div>
</body>
</html>
