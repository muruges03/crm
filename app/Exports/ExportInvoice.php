<?php

namespace App\Exports;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use App\Models\Tax;
use App\Models\Product;
use App\Models\Patron;
use App\Models\Contact;
use App\Models\PatronContact;
use App\Models\EntityContact;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportInvoice implements FromView, WithHeadings,ShouldAutoSize
{
    use Exportable;
    // use AfterSheet;
    // public function drawings()       //WithProperties, WithDrawings
    // {
    //     $drawing = new Drawing();
    //     $drawing->setName('Logo');
    //     $drawing->setDescription('This is my logo');
    //     // $drawing->setPath(public_path('/img/logo.jpg'));
    //     $drawing->setHeight(90);
    //     $drawing->setCoordinates('B3');

    //     return $drawing;
    // }

    // public function properties(): array
    // {
    //     return [
    //         'creator'        => 'Patrick Brouwers',
    //         'lastModifiedBy' => 'Patrick Brouwers',
    //         'title'          => 'Invoices Export',
    //         'description'    => 'Latest Invoices',
    //         'subject'        => 'Invoices',
    //         'keywords'       => 'invoices,export,spreadsheet',
    //         'category'       => 'Invoices',
    //         'manager'        => 'Patrick Brouwers',
    //         'company'        => 'Maatwebsite',
    //     ];
    // }
    // public function styles(Worksheet $sheet)
    // {
    //     return [
    //         // Style the first row as bold text.
    //         1    => ['font' => ['bold' => true]],

    //         // Styling a specific cell by coordinate.
    //         'B2' => ['font' => ['italic' => true]],

    //         // Styling an entire column.
    //         'C'  => ['font' => ['size' => 16]],
    //     ];
    // }

    public function __construct($data) {
        $this->data = $data;
//        dd($this->data);
    }

    public function styles(Worksheet $sheet)
    {
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => 'FFFF0000'],
                ],
            ],
        ];
        $sheet->getStyle('A2:K1')->applyFromArray($styleArray);
        $sheet->getStyle('A1')->applyFromArray(array(
            'fill' => array(
                'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FF0000')
            )
        ));
    }

    public function registerEvents(): array
    {

        return [


            AfterSheet::class    => function(AfterSheet $event) {

                $cellRange = 'A1:K1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(18);
            },
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Invoice #',
            'Customer Name',
            'Invoice Date',
            'GST NO',
            'Due Date',
            'Order Month',
            'Product',
            'HSN Code',
            'Price',
            'Total Amount',
            'CGST',
            'SGST',
            'Remarks',
            'Status',
            'Amount'
        ];
    }

    // public function collection()
    // {
    //     // $dd=Invoice::all();

    //         // $invoice        = Invoice::all();
    //         // $toAddress      = $this->toAddress();
    //         // $fileName       = $toAddress[0]['legal_name'];
    //     // dd($invoice);

    //     return Invoice::all();
    // }
    public function view(): View
    {
        return view('exports.invoices', ['invoiceitems'=>$this->data]);
        // dd($dd);
    }

}
