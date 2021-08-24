<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Exports\invoicesExport;
use App\Invoice;
use App\InvoiceDetails;
use App\Notifications\add_invoice_notification;
use App\Product;
use App\Section;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:قائمة الفواتير', ['only' => 'index']);
        $this->middleware('permission:الفواتير المدفوعة', ['only' => 'invoices_by_status_1']);
        $this->middleware('permission:الفواتير الغير مدفوعة', ['only' => 'invoices_by_status_2']);
        $this->middleware('permission:الفواتير المدفوعة جزئيا', ['only' => 'invoices_by_status_3']);

        $this->middleware('permission:اضافة فاتورة', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل الفاتورة', ['only' => ['edit', 'update']]);
        $this->middleware('permission:عرض فاتورة', ['only' => 'show']);
        $this->middleware('permission:تصدير Excel', ['only' => 'export_excel']);
        $this->middleware('permission:حذف فاتورة', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $invoices = Invoice::orderBy('id', 'desc')->get();

        return view('admin.invoices.index', compact('invoices'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function invoices_by_status_1()
    {

        $invoices = Invoice::where("value_status", 1)->orderBy('id', 'desc')->get();
        return view('admin.invoices.index', compact('invoices'));

    }

    public function invoices_by_status_2()
    {

        $invoices = Invoice::where("value_status", 2)->orderBy('id', 'desc')->get();
        return view('admin.invoices.index', compact('invoices'));

    }

    public function invoices_by_status_3()
    {

        $invoices = Invoice::where("value_status", 3)->orderBy('id', 'desc')->get();
        return view('admin.invoices.index', compact('invoices'));

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

        $rules = [
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
            "attachments" => "nullable|mimes:pdf,jpg,jpeg,png,gif",
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

        $data = $this->validate($request, $rules, [], $niceNames);

        // except attachment from invoice array
        $data = Arr::except($data, ['attachments']);

        // status of invoice
        $data['status'] = 'غير مدفوعة';
        $data['value_status'] = 2;

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
        $details->payment_date = null;
        $details->save();

        // add attachments pdf/image
        if ($request->hasFile('attachments')) {

            $image = $request->File('attachments');
            $file_name = Carbon::now()->timestamp . '-' . $image->getClientOriginalName();

            // store file in directory (storage/images)
            $image->move(public_path('Attachments/' . $invoice->invoice_number . '/'), $file_name);

            $Attachment = new Attachment();
            $Attachment->invoice_id = $invoice->id;
            $Attachment->file_name = $file_name;
            $Attachment->invoice_number = $invoice->invoice_number;
            $Attachment->create_by = $invoice->user;
            $Attachment->save();

        }

        // send notification email to my email
        // $user = auth()->user();
        // Notification::send($user,new newInvoice($invoice->id,$user->name));

        // add notification in the dashboard
        // show notification for all users has permission to show notifications
        // not show notification for user added the invoice

        $users = User::where('id', "!=", auth()->user()->id)->get();
        $details = [
            "invoice_id" => $invoice->id,
            "archive_url"=>null,
            "added_by" => auth()->user()->name,
            "msg" => 'قام <span class="badge badge-pill badge-info">' . auth()->user()->name . '</span> باضافة فاتورة جديدة ',
        ];
        Notification::send($users, new add_invoice_notification($details));

        $request->session()->flash('msgSuccess', 'تم اضافة الفاتورة بنجاح');
        return redirect(adminUrl('invoicesStatus/2'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice_details = InvoiceDetails::where("id_invoice", $id)->orderBy('id', "desc")->get();
        $Attachments = Attachment::where("invoice_id", $id)->orderBy('id', "desc")->get();

        return view('admin.invoices.invoiceDetails', compact('invoice', 'invoice_details', 'Attachments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        $editMode = "yes";
        $sections = Section::all()->pluck('section_name', 'id');
        $products = Product::where("section_id", $invoice->section_id)->get()->pluck('product_name');

        return view('admin.invoices.edit', compact('sections', "products", 'invoice', "editMode"));
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
        // dd($request->all());

        $rules = [
            'invoice_number' => 'nullable',
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
            "payment_date" => 'nullable|string',
            'note' => 'nullable|string|max:500',
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
            'payment_date' => 'تاريخ الدفع',
            'note' => 'الملاحظات',
        ];

        $data = $this->validate($request, $rules, [], $niceNames);

        // Exception of the invoice number because I created a file with that number in the attachments Storage
        // not change the number
        Arr::except($data, ['invoice_number']);

        // invoice_status() return status from helper file
        $stats = $request->value_status;
        $data["status"] = invoice_status()[$stats];
        $data["value_status"] = $stats;

        // update invoice
        $invoice->fill($data)->save();

        // update invoice details table
        // history invoice details table (invoices_details)
        $details = new InvoiceDetails();
        $details->id_invoice = $invoice->id;
        $details->invoice_number = $invoice->invoice_number;
        $details->product = $invoice->product;
        $details->section_id = $invoice->section_id;
        $details->status = $data['status'];
        $details->value_status = $data['value_status'];
        $details->note = $invoice->note;
        $details->user = auth()->user()->name;
        $details->payment_date = $invoice->payment_date;
        $details->save();

        // add notification in the dashboard
        // show notification for all users has permission to show notifications
        // not show notification for user added update invoice

        $users = User::where('id', "!=", auth()->user()->id)->get();
        $details = [
            "invoice_id" => $invoice->id,
            "archive_url"=>null,
            "added_by" => auth()->user()->name,
            "msg" => 'قام <span class="badge badge-pill badge-info">' . auth()->user()->name . '</span> بتعديل فاتورة',
        ];
        Notification::send($users, new add_invoice_notification($details));

        $request->session()->flash('msgSuccess', "تم تعديل الفاتورة بنجاح");
        return redirect(adminUrl("invoices/" . $invoice->id));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // remove invoice from archive list and from normal list of invoices
        $invoice = Invoice::withTrashed()->where('id', $id)->first();

        // Method one -------------------------------------
        // delete  invoice with attachment no restore

        // check if has minimal one file to delete the folder parent in the attachments storage directory
        $attachment = Attachment::where('invoice_id', $invoice->id)->first();

        if (!empty($attachment->invoice_id)) {
            Storage::disk('public_uploads')->deleteDirectory($invoice->invoice_number);
        }
        $invoice->forceDelete();

        // ------------------------------------------------

        request()->session()->flash('msgSuccess', "تم حذف الفاتورة بنجاح");
        return back();
    }

    // print invoice pdf
    public function printInvoice($id)
    {
        $invoice = Invoice::findOrFail($id);

        return view('admin.invoices.print', compact('invoice'));
    }

    public function export_excel()
    {
        return Excel::download(new invoicesExport, 'قائمة_الفواتير.xlsx');
    }

}
