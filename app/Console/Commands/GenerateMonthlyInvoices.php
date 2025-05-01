<?php

namespace App\Console\Commands;

use App\Models\InvoiceTax;
use Illuminate\Console\Command;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Carbon\Carbon;
use App\Helpers\AppHelpers;
use Illuminate\Support\Facades\Auth;

class GenerateMonthlyInvoices extends Command
{
    protected $signature = 'invoices:generate';
    protected $description = 'Generate invoices automatically on the 28th of each month';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get the current date
        $date = Carbon::now();
        // Ensure it's the 28th
        if ($date->day == 21) {

            $customers = \App\Models\Patron::where('entity_id', 1)->where('deleted', 0)->where('status', 1)->get(); // Adjust this based on your application logic
//            dd($customers);
            foreach ($customers as $customer) {
                $last_invoice_check = Invoice::where('entity_id', $customer->entity_id)->where('deleted', 0)->where('status', 1)->whereYear('start_date', Carbon::now()->year)
                    ->whereMonth('start_date', Carbon::now()->month)->where('patron_id', $customer['id'])->latest()->first();

                if ($last_invoice_check==null) {
                    $last_invoice = Invoice::where('entity_id', $customer->entity_id)->where('deleted', 0)->where('status', 1)
                        ->where('patron_id', $customer['id'])->latest()->first();
                    $last_invoice_item = InvoiceItem::where('entity_id', $customer->entity_id)->where('deleted', 0)->where('product_id', 1)->latest()->first();

                    if ($last_invoice['type'] == 'Monthly' && $last_invoice_item != null) {
                        $invoice_number = auto_getFinancialYear(Carbon::now(), $customer['id']);

                        Invoice::create(array(
                            'entity_id' => 1,
                            'patron_id' => $customer['id'],
                            'prefix' => 'INV-' . $last_invoice[1],
                            'invoice_number' => $invoice_number[0],
                            'order_number' => null,
                            'status' => 1,
                            'start_date' => AppHelpers::instance()->DateTimeZone(now())->startOfMonth()->toDateString(),
                            'end_date' => AppHelpers::instance()->DateTimeZone(now())->endOfMonth()->toDateString(),
                            'invoiced_at' => AppHelpers::instance()->DateTimeZone(now()),
                            'due_at' => AppHelpers::instance()->DateTimeZone(now())->addDays(5)->toDateString(),
                            'ledger_id' => $last_invoice['ledger_id'] ? $last_invoice['ledger_id'] : null,
                            'untaxed_amount' => $last_invoice['untaxed_amount'],
                            'tax_amount' => $last_invoice['tax_amount'],
                            'total_amount' => $last_invoice['total_amount'],
                            'discount_amount' => $last_invoice['discount_amount'],
                            'notes' => $last_invoice['notes'],
                            'type' => $last_invoice['type'],
                            'created' => AppHelpers::instance()->DateTimeZone(now()),
                            'created_by' => 1
                        ));

                        $invoiceid = Invoice::where('entity_id', 1)->where('deleted', '0')->where('patron_id', '=', $customer['id'])->latest()->first();
//                    Monthly Maintanence

                        $invoiceitm = new InvoiceItem;
                        if ($last_invoice_item['price'] != null && $last_invoice_item['quantity'] != null) {
                            $invoiceitm->entity_id .= 1;
                            $invoiceitm->invoice_id .= $invoiceid['id'];
                            $invoiceitm->product_id .= $last_invoice_item['product_id'];
                            $invoiceitm->description .= $last_invoice_item['description'];
                            $invoiceitm->quantity .= $last_invoice_item['quantity'];
                            $invoiceitm->price .= $last_invoice_item['price'];
                            $invoiceitm->discount_type .= $last_invoice_item['discount_type'];
                            $invoiceitm->discount_amount .= $last_invoice_item['discount_amount'];
                            if ($last_invoice_item['tax_id'] != null) $invoiceitm->tax_id .= $last_invoice_item['tax_id'];
                            else $invoiceitm->tax_id = null;
                            $invoiceitm->tax_amount .= $last_invoice_item['tax_amount'];
                            $invoiceitm->total_amount .= $last_invoice_item['total_amount'];
                            $invoiceitm->created .= AppHelpers::instance()->DateTimeZone(now());
                            $invoiceitm->created_by .= 1;
                            $invoiceitm->save();

                            if ($last_invoice_item['tax_id'] != null) {
                                $tax = auto_taxes('', '', $last_invoice_item['tax_id'], '', 1);
                                foreach ($tax as $val) {
                                    $amount = (($last_invoice_item['total_amount'] * ($val['tax_amount'] / 100)));
                                    $taxname = $val['tax_group'] . ' ' . $val['tax_amount'] . '%';
//                         dd($taxname);
                                    $invoicetax = new InvoiceTax;
                                    $invoicetax->entity_id .= 1;
                                    $invoicetax->invoice_id .= $invoiceid['id'];
                                    $invoicetax->tax_id .= $val['id'];
                                    $invoicetax->name .= $taxname;
                                    $invoicetax->amount .= $amount;
                                    $invoicetax->created .= AppHelpers::instance()->DateTimeZone(now());
                                    $invoicetax->created_by .= 1;
                                    $invoicetax->save();
                                }
                            }
                        }
                    }
                }else{
                        $this->info('Monthly invoices Already generated .');

                }
            }
                $this->info('Monthly invoices generated successfully.');
            }
        else {
                $this->info('Today is not the 28th. Skipping invoice generation.');
            }

    }
}
