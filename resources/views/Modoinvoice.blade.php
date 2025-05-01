<head>
<style>
    .pdf-container.sr .trip-details .trip-tabl.pd {
        color: #000000 !important;
        border: 1px solid gray !important;
        font-family: "Open Sans",sans-serif;
        font-size: 18px;
    }


    .pdf-container.sr .trip-tabl.pc tbody tr td {
       /* height: 10px;*/
        /padding-left: 20px;/
        font-size: 13px !important;
    }
    .pdf-container.sr .trip-tabl.pd tbody tr td {
        /height: 10px;/
        /padding-left: 20px;/
        font-size: 20px !important;
    }

    table.trip-tabl td {
        border: 1px solid gray !important;
    }
    table.trip-tab  {
        border: 1px solid gray !important;
        border-bottom: none !important;

    }
    .trip-tab td {
        border-bottom:none !important;


    }
    .trip-tabl {
        border-collapse: collapse;
        border-spacing: 0 !important;
    }
    .trip-tabl td.medium {
        width: 120px;
    }
    .trip-tabl td.small {
        width: 50px;
    }
    .trip-tabl td.large {
        width: 150px;
    }
    .trip-tabl td.xlarge {
        width: 300px;
    }
    .trip-tabl td.tiny {
        width: 30px;
    }


    /GRN Style/
    table.trip-tabl.grn{
        width: 100%;
        text-align: center;
    }
    table.trip-tabl.grn  thead tr td{
        font-size: 10px!important;
        background-color: #0c0c0c;
    }
    table.trip-tabl.grn  tbody.tbl-bdy tr td{
        font-size: 9px!important;
    }
    table.trip-tab tr {
        border-spacing: 0px;
    }
    table.trip-tab, th, td {
  border: 1px solid gray;
  border-bottom:none;
  border-top:none;
  border-collapse: collapse;
}


table tfoot tr td{
    /* text-align:right; */
    /* margin-right: 5px; */
    font-weight: 600;
    font-size: 18px;

}

.footer {
   /* position: fixed; */
   /* left: 8px; */
   /* bottom: 4px;
   width: 100%; */
}



</style>
</head>
<body>
        <center><h3>Tax Invoice</h3><center>
        <table style="border-collapse:collapse;width: 100%;border-color: gray; " class="trip-tabl table1">
            <tr>
                <td width=50% rowspan=3 style="padding:10px">
                    <strong>VRG BLUE METAL</strong><br>
                    <span>(GRADED AGGREGATES MANUFACTURE SAND)</span><br>
                    <span>KUPPAM (PO), Aravakurichi (TK),</span><br>
                    <span>Karur - 639 111.</span><br>
                    <span>GSTIN/UIN : 33APIPT1099P1Z4</span><br>
                    <span> State Name : Tamil Nadu, Code: 33</span><br>
                    <span> E-Mail : vrgbluemetal@gmail.com</span>
                </td>
                <td width=25% >
                    Invoice No.<br>
                    <b>BM/22-23/4122</b>
                </td>
                <td width=25%>
                    Dated<br>
                    <b>03-May-22</b>
                </td>
            </tr>
            <tr>
                <td width=25%>
                    Delivery Note<br>
                    <b>BASKAR</b>
                </td>
                <td width=25%>
                    Mode/Terms of Payment<br>
                    <b>&nbsp;</b>
                </td>
            </tr>
            <tr>
                <td width=25%>
                    Supplier's Ref.<br>
                    <b>&nbsp;</b>
                </td>
                <td width=25%>
                    Other Reference(s)<br>
                    <b>&nbsp;</b>
                </td>
            </tr>
            <tr>
                <td width=50% rowspan=3 style="padding:10px">
                    <i>Consignee (Ship to)</i><br>
                    <strong>D SHANMUGAVEL ENG AND CONTRACTOR</strong><br>
                    <span>MULLAI NAGER, </span>
                    <span>SALEM - 5.</span><br>
                    <span>GSTIN/UIN  :  33AIJPS2908Q1ZO</span><br>
                    <span> State Name  :  Tamilnadu, Code : 33</span>
                </td>
                <td width=25%>
                    Buyer's Order No.<br>
                    <b>&nbsp;</b>
                </td>
                <td width=25%>
                    Dated<br>
                    <b>&nbsp;</b>
                </td>
            </tr>
            <tr>
                <td width=25%>
                    Despatch Document No.<br>
                    <b>9322</b>
                </td>
                <td width=25%>
                    Dated<br>
                    <b>6-May-22</b>
                </td>
            </tr>
            <tr>
                <td width=25%>
                    Despatched through<br>
                    <b>LORRY</b>
                </td>
                <td width=25%>
                    Destination<br>
                    <b>KALLANAI</b>
                </td>
            </tr>

            <tr>
                <td width=50% rowspan=3 style="padding:10px">
                <i>Buyer (Bill to)</i><br>
                    <strong>D SHANMUGAVEL ENG AND CONTRACTOR</strong><br>
                    <span>MULLAI NAGER, </span>
                    <span>SALEM - 5.</span><br>
                    <span>GSTIN/UIN  :  33AIJPS2908Q1ZO</span><br>
                    <span> State Name  :  Tamilnadu, Code : 33</span>

                </td>


                <td width=25%>
                   Bill of Lading/LR-RR No.<br>
                    <b></b>
                </td>
                <td width=25%>
                    Motor Vehicle No.<br>
                    <b>TN 47 B 8789</b>
                </td>
            </tr>
            <tr>
                <td width=25% height=100 colspan=2>
                    Terms of Delivery<br>
                    <b>&nbsp;</b>
                </td>
            </tr>
        </table>

        <table style="border-collapse:collapse;width: 100%;border-color: gray; " class="trip-tabl">
            <thead>
                <tr height=45>
                    <th >#</th>
                    <th>Description of Goods</th>
                    <th>HSN/SAC</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>Per</th>
                    <th>CGST</th>
                    <th>SGST</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
            @php($count=1)
                <tr height=40>
                    <td width=5% align=center>1</td>
                    <td align=center>20 MM - JALLY</td>
                    <td align=center>25171010</td>
                    <td align=center> 9.000 unit</td>
                    <td align=center>&#8377; 2,666.67</td>
                    <td align=center>unit</td>
                    <td align=center>&#8377; 600.00</td>
                    <td align=center>&#8377; 600.00</td>
                    <td align=center>&#8377; 24,000.03</td>
                </tr>
                @php($count=3)
                @php($rowempty=11)

                @for($i=$count; $i<=$rowempty; $i++)
                    <tr height=40 style="border-bottom:none  !important; border-top:none  !important">
                        <td style="border-bottom:none  !important; border-top:none  !important;"></td>
                        <td style="border-bottom:none  !important; border-top:none  !important;"></td>
                        <td style="border-bottom:none  !important; border-top:none  !important;"></td>
                        <td style="border-bottom:none  !important; border-top:none  !important;"></td>
                        <td style="border-bottom:none  !important; border-top:none  !important;"></td>
                        <td style="border-bottom:none  !important; border-top:none  !important;"></td>
                        <td style="border-bottom:none  !important; border-top:none  !important;"></td>
                        <td style="border-bottom:none  !important; border-top:none  !important;"></td>
                        <td style="border-bottom:none  !important; border-top:none  !important;"></td>
                    </tr>
                @endfor
            </tbody>
            <tfoot>
                <tr height=50>
                    <td></td>
                    <td>Total</td>
                    <td></td>
                    <td>9.000 Unit</td>
                    <td></td>
                    <td></td>
                    <td>&#8377; 600.00</td>
                    <td>&#8377; 600.00</td>
                    <td>&#8377; 24,000.03</td>
                </tr>
            </tfoot>
        </table>
        <table style="border-collapse:collapse;width: 100%;border-color: gray; margin-right:4% !important; " class="trip-tabl footer">

            <tr style=" width:100%; height:50px; text-align: left;">
                <td colspan=8 style="text-align:left !important">
                    Amount in Words<br>
                    <B>Twenty Five Thousand Two Hundred only</B><br>
                </td>
            </tr>
            <tr>

                <td WIDTH=20% align=center  rowspan=2>HSN/SAC</td>
                <td WIDTH=10% align=center rowspan=2>Taxeable Value</td>
                <td WIDTH=20% align=center  colspan=2>Central Tax</td>
                <td align=center WIDTH=20%  colspan=2>State Tax </td>
                <td WIDTH=20% align=center rowspan=2>Total</td>
            </tr>
            <tr>
                <td align=center WIDTH=10%>Rate</td>
                <td align=center WIDTH=10%>Amount</td>
                <td align=center WIDTH=10%>Rate</td>
                <td align=center WIDTH=10%>Amount</td>
            </tr>
            <tr>
                <td align=right  style="padding-right:5px;">25171010</td>
                <td WIDTH=10% align=right>&#8377; 24,200.03</td>
                <td align=center WIDTH=10%>2.5 %</td>
                <td align=right WIDTH=10%> &#8377; 600.00</td>
                <td align=center WIDTH=10% >2.5 %</td>
                <td align=right WIDTH=10%>&#8377; 600.00</td>
                <td WIDTH=20% align=right>&#8377; 1,200.00</td>

            </tr>
            <tr>
                <td align=right style="padding-right:5px;"><B>TOTAL</B></td>
                <td WIDTH=20% align=right><B>&#8377; 24,200.03</B></td>
                <td align=center WIDTH=10%></td>
                <td align=right WIDTH=10%><B>&#8377; 600.00</B></td>
                <td align=center WIDTH=10%></td>
                <td WIDTH=10% align=right><B>&#8377; 600.00</B></td>
                <td WIDTH=20% align=right><B>&#8377; 1,200.00</B></td>
            </tr>
            <tr style=" width:100%; height:40px; text-align: left;">
                <td colspan=8 style="text-align:left !important">
                    Amount in Words<br>
                    <B>Twenty Five Thousand Two Hundred only</B><br>
                </td>
            </tr>
            <tr>
                <td colspan=4 style="text-align:left !important">
                    <span style="border-bottom:1px solid gray;">Declaration</span><br>
                    <span>We declare that this invoice shows the actual price of the goods described and that all particulars are as true and correct.</span>
                </td>
                <td align=left colspan=3 style="text-align:left !important">
                    <div>
                        <span>Company Bank Details</span><br>
                        <span>Bank Name <b style="padding-left:20px"> : State Bank of India</b></span><br>
                        <span>A/C No. <b style="padding-left:39px"> : 12345689456</b></span><br>
                        <span>Branch & IFS  <b style="padding-left:8px"> : smt.karur & SBI76878</b></span><br>
                    </div>
                    <div style="position: relative; height: 65px; border: solid;   border-style: none;">
                        <div style="position: absolute;  border: solid; bottom: 0; right: 2px;  border-style: none;">
                            Authorised Signatory
                        </div>
                    </div>
                </td>
            </tr>
        </table>
</body>
