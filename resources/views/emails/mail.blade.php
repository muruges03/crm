<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Email Receipt</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style type="text/css">
  /**
   * Google webfonts. Recommended to include the .woff version for cross-client compatibility.
   */
  @media screen {
    @font-face {
      font-family: 'Source Sans Pro';
      font-style: normal;
      font-weight: 400;
      src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format('woff');
    }

    @font-face {
      font-family: 'Source Sans Pro';
      font-style: normal;
      font-weight: 700;
      src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/toadOcfmlt9b38dHJxOBGFkQc6VGVFSmCnC_l7QZG60.woff) format('woff');
    }
  }
  /**
   * Avoid browser level font resizing.
   * 1. Windows Mobile
   * 2. iOS / OSX
   */
  body,
  table,
  td,
  a {
    -ms-text-size-adjust: 100%; /* 1 */
    -webkit-text-size-adjust: 100%; /* 2 */
  }

  /**
   * Remove extra space added to tables and cells in Outlook.
   */
  table,
  td {
    mso-table-rspace: 0pt;
    mso-table-lspace: 0pt;
  }

  /**
   * Better fluid images in Internet Explorer.
   */
  img {
    -ms-interpolation-mode: bicubic;
  }

  /**
   * Remove blue links for iOS devices.
   */
  a[x-apple-data-detectors] {
    font-family: inherit !important;
    font-size: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
    color: inherit !important;
    text-decoration: none !important;
  }

  /**
   * Fix centering issues in Android 4.4.
   */
  div[style*="margin: 16px 0;"] {
    margin: 0 !important;
  }

  body {
    width: 100% !important;
    height: 100% !important;
    padding: 0 !important;
    margin: 0 !important;
  }

  /**
   * Collapse table borders to avoid space between cells.
   */
  table {
    border-collapse: collapse !important;
  }

  a {
    color: #1a82e2;
  }

  img {
    height: auto;
    line-height: 100%;
    text-decoration: none;
    border: 0;
    outline: none;
  }
  </style>

</head>
<body >
    @foreach($invoice as $invoices)
  <!-- start body -->
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <!-- start logo -->
    <tr>
      <td align="center">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
          <tr>
            <td align="center" valign="top" style="padding: 35px 25px 5px 10px;">
              <a href="#"  style="display: inline-block;">
                <img src="https://modomines.com/wp-content/uploads/2020/11/modo_v3.jpg" alt="Logo" border="0" width="100" style="display: block; width: 45%; height:50%;">
              </a>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- start hero -->
    @php  //echo $email[0]['name']; @endphp
    <!-- end hero -->

    <!-- end logo -->
    <tr>
        <td align="center" >
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
            <tr
            ><td align="left" bgcolor="#ffffff" style="padding: 16px 14px 0; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; border-top: 3px solid #d4dadf;">
            <h1 style="margin: 0; font-size: 22px; font-weight: 700; letter-spacing: -1px; line-height: 48px;">Hello {{strtoupper($toAddress[0]['legal_name'])}},</h1>
        </td>
        </table>
    </td></tr>
         <!-- start receipt table -->
          <tr>
            <td align="center" bgcolor="#ffffff" style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <tr style="color:white;" bgcolor="#4889a7">
                  <td align="left"  width="60%" style="padding: 12px;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;  "><strong>Invoice #</strong></td>
                  <td align="left"  width="40%" style="padding: 12px;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;"><strong> {{$invoices['prefix']}}{{$invoices['invoice_number']}}</strong></td>
                </tr>
                <tr>
                  <td align="left" width="60%" style="padding: 6px 12px;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">Invoice Date</td>
                  <td align="left" width="40%" style="padding: 6px 12px;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">{{Carbon\Carbon::parse($invoices->invoiced_at)->format('d-M-Y')}}</td>
                </tr>
                <tr>
                  <td align="left" width="60%" style="padding: 6px 12px;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">Due Date</td>
                  <td align="left" width="40%" style="padding: 6px 12px;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">{{Carbon\Carbon::parse($invoices->due_at)->format('d-M-Y') }}</td>
                </tr>
{{--                <tr>--}}
{{--                  <td align="left" width="60%" style="padding: 6px 12px;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">GST </td>--}}
{{--                  <td align="left" width="40%" style="padding: 6px 12px;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;"> {{$invoices->invoiceTaxAmount }}</td>--}}
{{--                </tr>--}}
                <tr>
                  <td align="left" width="60%" style="padding: 6px 12px;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">{{ $invoices->type}} Maintenance Charges</td>
                  <td align="left" width="40%" style="padding: 6px 12px;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;"> {{ $invoices->untaxed_amount}}</td>
                </tr>
                <tr>
                  <td align="left" width="60%" style="padding: 12px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-top: 2px dashed #4889a7; border-bottom: 2px dashed #4889a7;"><strong>Total {{ $invoices->type}} Charges</strong></td>
                  <td align="left" width="40%" style="padding: 12px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-top: 2px dashed #4889a7; border-bottom: 2px dashed #4889a7;"><strong>&#8377;  {{$invoices['invoice_totalamount']}}</strong></td>
                </tr>
                <tr>
                  <td  style="padding: 10px;" colspan="2">
                  <p ><font color="#aaaaaa">	Questions? Visit our support site at <a href="https://modomines.com/contact/">https://modomines.com/contact/</a> or contact us at <a href="chithra@onemodo.com">chithra@onemodo.com</a> </font></p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <!-- end reeipt table -->

    <!-- start footer -->
    @php  //echo $email[0]['notes']; @endphp
    <!-- end footer style="padding: 12px 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; color: #666;"-->

  </table>
    <div style="color:black;padding-left: 25px;" >
        <p style="margin: 0;"><b><font color="#de310b">OneModo</font> Technologies </b></p>

        7A 7th Floor, Century Plaza,<br>
        Anna Salai, Thiru Vi Ka Kudiyiruppu,<br>
        Teynampet, Chennai - 600 018.<br>
        <a href="https://www.onemodo.com" target="_blank">https://www.onemodo.com</a><br><br>
        <p style="font-style: italic;"><u>Disclaimer:</u></p>
        <p style="font-style: italic;">If you have received this e-mail in error, please notify the sender immediately, delete the e-mail from your computer and do not copy, forward or disclose it to anyone else.</p>
      <p style="font-style: italic;">The information in this email constitutes the proprietary information of OneModo Technologies Private Limited, and should be accessed only by the individual to whom it is addressed. The content in this email, including any attachments may not be used, copied or disclosed, in any form, without the explicit consent of OneModo Technologies Private Limited.  OneModo Technologies Private Limited is not responsible for any damages caused by your unauthorised use of the materials in this Email</p>
    </div>

  @endforeach()
  <!-- end body -->


</body>
</html>
