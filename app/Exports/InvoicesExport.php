<?php

namespace App\Exports;

use App\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;

class InvoicesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Invoice::select(['id','invoice_number','invoice_date','due_date','product','section_id','discount','rat_vat','value_vat','total','status','note'])->get();
    }
}
