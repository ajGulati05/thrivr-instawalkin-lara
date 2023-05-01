<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Storage;
use App\Booking;
use App\Manager;
use App\BookingPricing;
use App\Receipt;
use Carbon\Carbon;
class ReceiptPDFClass 
{
     
  protected $rowSpan=3;
  protected $booking;
  protected $manager;
  protected $bookingPricing; protected $receipt; protected $fullName;   
 
  public function __construct(Booking $booking,Manager $manager, BookingPricing $bookingPricing,Receipt $receipt,$fullName) {
      $this->booking=$booking;
      $this->manager=$manager;
      $this->bookingPricing=$bookingPricing;
      $this->receipt=$receipt;
      $this->fullName=$fullName;

    }

      
   public  function createReceipt()
    {

      $mpdf = new \Mpdf\Mpdf([
  'margin_left' => 20,
  'margin_right' => 15,
  'margin_top' => 48,
  'margin_bottom' => 25,
  'margin_header' => 10,
  'margin_footer' => 10
]);

$mpdf->SetProtection(array('print'));

if($this->receipt->duplicated==1){
$mpdf->SetWatermarkText("Duplicate");
$mpdf->showWatermarkText = true;
}
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.1;
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($this->body());
//return $mpdf->Output();
return $mpdf->Output('', 'S');

    }


 

    public function body(){


$discount='';
$tip='';
$breakdown=$this->breakdown();
if(isset($this->bookingPricing->discount_amount))
{
$discount=$this->discount();
$this->rowSpan=$this->rowSpan+1;

}

if(isset($this->bookingPricing->tip_amount))
{
$tip=$this->tip();
$this->rowSpan=$this->rowSpan+1;

}


$totalPrice=$this->booking->getBookingTotal()+$this->bookingPricing->tip_amount;
    return  $html = "<html>
<head>
<style>
body {font-family: sans-serif;
  font-size: 10pt;
}
p { margin: 0pt; }
table.items {
  border: 0.1mm solid #000000;
}
td { vertical-align: top; }
.items td {
  border-left: 0.1mm solid #000000;
  border-right: 0.1mm solid #000000;
}
table thead td { background-color: #EEEEEE;
  text-align: center;
  border: 0.1mm solid #000000;
  font-variant: small-caps;
}
.items td.blanktotal {
  background-color: #EEEEEE;
  border: 0.1mm solid #000000;
  background-color: #FFFFFF;
  border: 0mm none #000000;
  border-top: 0.1mm solid #000000;
  border-right: 0.1mm solid #000000;
}
.items td.totals {
  text-align: right;
  border: 0.1mm solid #000000;
}
.items td.cost {
  text-align: \".\" center;
}

.breakdown td.break{
  border: none;
  text-align: \".\" right;
}
</style>
</head>
<body>
<!--mpdf
<htmlpageheader name=\"myheader\">
<table width=\"100%\"><tr>
<td width=\"50%\" style=\"color:#FF7271; \"><span style=\"font-weight: bold; font-size: 14pt;\">{$this->manager->fullName}</span><br />
<span style=\"font-weight: bold; font-size: 14pt;\">{$this->manager->manager_licenses()->latest()->first()->license_number}</span><br />{$this->manager->business_name}<br />{$this->manager->profiles->address}<br />{$this->manager->profiles->city}<br />{$this->manager->profiles->postal_code}<br /><span style=\"font-family:dejavusanscondensed;\">&#9742;</span> {$this->manager->profiles->phone} </td>
<td width=\"50%\" style=\"text-align: right;\">Receipt No.<br /><span style=\"font-weight: bold; font-size: 12pt;\">{$this->booking->id}</span></td>
</tr></table>
</htmlpageheader>
<htmlpagefooter name=\"myfooter\">
<div style=\"border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; \">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>
<sethtmlpageheader name=\"myheader\" value=\"on\" show-this-page=\"1\" />
<sethtmlpagefooter name=\"myfooter\" value=\"on\" />
mpdf-->

<table width=\"50%\" style=\"font-family: serif;\" cellpadding=\"10\"><tr>
<td width=\"45%\" style=\"border: 0.1mm solid #888888; \"><span style=\"font-size: 7pt; color: #555555; font-family: sans;\">Client:</span>{$this->fullName}<br />
<span style=\"font-size: 7pt; color: #555555; font-family: sans;\">Date:</span>{$this->booking->getMassageDateWithYear()}<br /></td>

<td width=\"10%\">&nbsp;</td>
</tr></table>
<br />
<table class=\"items\" width=\"100%\" style=\"font-size: 9pt; border-collapse: collapse; \" cellpadding=\"8\">
<thead>
<tr>
<td width=\"70%\">Service</td>
<td width=\"10%\">Qty</td>

<td width=\"20%\">Amount</td>
</tr>
</thead>
<tbody>
<!-- ITEMS HERE -->
<tr>
<td align=\"center\">{$this->booking->project->description} Registered Massage Therapy</td>
<td align=\"center\">1</td>
<td class=\"totals cost\">CAD{$this->bookingPricing->amount}</td>

</tr>
<!-- END ITEMS HERE -->
<tr>

<td class=\"blanktotal\" rowspan=\"{$this->rowSpan}\"></td>
<td class=\"totals\">Subtotal</td>
<td class=\"totals cost\">CAD{$this->bookingPricing->amount}</td>
</tr>
{$discount}
<tr>
<td class=\"totals\">GST 5%</td>
<td class=\"totals cost\">CAD{$this->bookingPricing->tax_amount}</td>
</tr>
{$tip}
}
<tr>
<td class=\"totals\"><b>TOTAL</b></td>
<td class=\"totals cost\"><b>CAD{$totalPrice}</b></td>

</tr>
<tr><td></td><td></td><td rowspan=\"1\">

{$breakdown}
</td></tr>

</tbody>
</table>
<div style=\"text-align: center; font-style: italic;\">Thank you for your business!</div>

</body>
</html>
";
    }


public function breakdown(){
$paidBy2="";
if(isset($this->booking->paid_by_2)){

  $paidBy2="<tr>
<td class=\"break\">CAD{$this->bookingPricing->amount_2} via {$this->booking->paymentTypesTwo->description}</td>
</tr>";
}
$discountAmount=$this->bookingPricing->discount_amount;
     return "
<table class=\"breakdown\" width=\"100%\" style=\"font-size: 9pt; border-collapse: collapse;    border: 0px; \" cellpadding=\"8\">
<tr>
<td class=\"break\">CAD{$this->bookingPricing->amount_1} via {$this->booking->paymentTypes->description}</td>

</tr>
{ $paidBy2}

</td></table>
";
}

public function discount(){

$discountAmount=$this->bookingPricing->discount_amount;
     return "<tr>
<td class=\"totals\">Discount:</td>
<td class=\"totals cost\">CAD{$discountAmount}</td>
</tr>";
}
public function tip(){

$tip_amount=$this->bookingPricing->tip_amount;
     return "<tr>
<td class=\"totals\">Tip:</td>
<td class=\"totals cost\">CAD{$tip_amount}</td>
</tr>";
}

}
