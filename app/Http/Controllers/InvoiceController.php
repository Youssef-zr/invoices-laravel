<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Invoice;
use App\InvoiceDetails;
use App\Section;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'الفواتير';
        return view('admin.invoices.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'الفاتورة';
        $sections = Section::all()->pluck('section_name', 'id');

        return view('admin.invoices.create', compact('title', 'sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $ruels = [
            'invoice_number' => 'required|string|unique:invoices,invoice_number',
            'invoice_date' => 'required|string',
            'due_date' => 'required|string',
            'section_id' => 'required|integer',
            'product' => 'required|string',
            'amount_collection' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'amount_commission' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'discount' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'rat_vat' => 'required|integer',
            'value_vat' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'total' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'note' => 'nullable|string|max:500',
            "attachments" => "nullable|image|mimes:pdf,jpg,jpeg,png,gif",
        ];

        $niceNames = [
            'invoice_number' => 'رقم الفاتورة',
            'invoice_date' => 'تاريخ الفاتورة',
            'due_date' => 'تاريخ الاستحقاق',
            'section_id' => 'القسم',
            'product' => 'المنتج',
            'amount_collection' => 'مبلغ التحصيل',
            'amount_commission' => 'مبلغ العمولة',
            'discount' => 'الخصم',
            'rat_vat' => 'نسبة ضريبة القيمة المضافة',
            'value_vat' => 'قيمة ضريبة القيمة المضافة',
            'total' => 'الاجمالي شامل الضريبة',
            'note' => 'الملاحظات',
            "attachments" => 'المرفقات',
        ];

        $data = $this->validate($request, $ruels, [], $niceNames);

        // except attachment from invoice array
        $data = Arr::except($data, ['attachments']);

        // status of invoice
        $data['status'] = 'غير مدفوعة';
        $data['value_status'] = 2;

        // set the current date of add
        $date = Carbon::now();
        $data['payment_date'] = $date->toDateString();

        // user add invoice
        $data["user"] = auth()->user()->name;
        $invoice = new Invoice();

        // store the invoice and stored to a variable
        $invoice->fill($data)->save();

        // history invoice details table (invoices_details)
        $details = new InvoiceDetails();
        $details->id_invoice = $invoice->id;
        $details->invoice_number = $invoice->invoice_number;
        $details->product = $invoice->product;
        $details->section_id = $invoice->section_id;
        $details->status = 'غير مدفوعة';
        $details->value_status = 2;
        $details->note = $invoice->note;
        $details->user = $invoice->user;
        $details->save();

        // add attachments pdf/image
        if ($request->hasFile('attachments')) {

            $image = $request->file('attachments');
            $file_name = Carbon::now()->timestamp . '-' . $image->getClientOriginalName();

            // store file in directory (storage/images)
            $path = $image->move('storage/images/', $file_name);

            $Attachment = new Attachment();
            $Attachment->invoice_id = $invoice->id;
            $Attachment->file_name = $path;
            $Attachment->invoice_number = $invoice->invoice_number;
            $Attachment->create_by = $invoice->user;
            $Attachment->save();
        }

        $request->session()->flash('msgSuccess', 'تم اضافة الفاتورة بنجاح');
        return redirect(adminUrl('invoices'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
