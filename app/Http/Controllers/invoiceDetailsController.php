<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceDetails;
use App\Attachment;
use Illuminate\Http\Request;

class invoiceDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Invoice $invoice,$id)
    {
        $invoice = $invoice::findOrFail($id);
        $invoice_details = InvoiceDetails::where("id_invoice",$id)->get();
        $Attachments = Attachment::where("invoice_id",$id)->get();

        return view('admin.invoices.invoiceDetails',compact('invoice','invoice_details','Attachments'));
    }

    public function attachmentDelete($invoice,$file)
    {
        
        $invoice = Invoice::find($invoice);

        $Attachments = Attachment::find($file)->where('invoice_id',$file)->get();


        foreach ($Attachments as $Attachment) {

            $file_path = 'Attachmentsd/'.$Attachment->invoice_number.'/'.$Attachment->file_name;
            if(file_exists(public_path($file_path))){
                
            }
            // $Attachment->delete();
        }

        request()->session()->flash('msgSuccess', 'تم حذف المرفق بنجاح');
        return redirect(adminUrl('invoices'));

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
