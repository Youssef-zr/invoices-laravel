<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceDetails;
use App\Attachment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class invoiceDetailsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:اضافة مرفق', ['only' => 'addAttachment']); 
        $this->middleware('permission:حذف مرفق', ['only' => 'destroy']); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($invoice_id,$file_id)
    {
        $Attachment = Attachment::findOrFail($file_id);

        $file = $Attachment->invoice_number.'/'.$Attachment->file_name;

        // file system storage public_upload
        if(Storage::disk("public_uploads")->exists($file)){
            Storage::disk('public_uploads')->delete($file);
        }

        $Attachment->delete();

        request()->session()->flash('msgSuccess', 'تم حذف المرفق بنجاح');
        return back();
    }

    // download file
    public function download_file($invoice_nb,$file_name)
    {
        $contents = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_nb.'/'.$file_name);
        return response()->download($contents);
    }
    
    // open file show
    public function open_file($invoice_nb,$file_name)
    {
        $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_nb.'/'.$file_name);
        return response()->file($files);
    }

    // add new attachment
    public function addAttachment(Request $request)
    {

        $rules = [
            "attachment" => 'required|mimes:pdf,jpg,jpeg,png,gif'
        ];

        $niceNames = [
            "attachment" => 'المرفق',
        ];
        
        $msg = [
            'attachment' => 'صيغة المرفق يجب ان تكون pdf, jpg, jpeg, png, gif'
        ];

        $this->validate($request,$rules,$msg,$niceNames);

        $file = $request->File('attachment');
        $file_name =  Carbon::now()->timestamp . '-' . $file->getClientOriginalName();
        
        $invoice_number = $request->invoice_number;
        $invoice_id = $request->invoice_id;
        $create_by = auth()->user()->name;
        
        $data = [];
        $data['file_name'] = $file_name;
        $data['invoice_number'] = $invoice_number;
        $data['invoice_id'] = $invoice_id;
        $data['create_by'] = $create_by;
     
        $attachment = new Attachment();
        $attachment->fill($data)->save();

        // store file
        $file->move(public_path('Attachments/'.$invoice_number.'/'), $file_name);

        request()->session()->flash('msgSuccess', 'تم اضافة المرفق بنجاح');
        return back();
        
    }
}
