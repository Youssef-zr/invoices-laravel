<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Notifications\add_invoice_notification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ArchiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:أرشيف الفواتير', ['only' => 'index']);
        $this->middleware('permission:حذف فاتورة', ['only' => ['archiveInvoice', 'restoreInvoice']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::onlyTrashed()->get();
        return view('admin.invoices.invoices_archived', compact('invoices'));
    }

    // trash invoice
    public function archiveInvoice($id)
    {
        // Method two -------------------------------------
        // delete invoice with softDelete

        Invoice::findOrFail($id)->delete();

        // add notification in the dashboard
        // show notification for all users has permission to show notifications
        // not show notification for user archived invoice

        $users = User::where('id', "!=", auth()->user()->id)->get();
        $details = [
            "invoice_id" => null,
            "archive_url"=>'invoicesArchived',
            "added_by" => auth()->user()->name,
            "msg" => 'قام <span class="badge badge-pill badge-info">' . auth()->user()->name . '</span> بأرشفة فاتورة',
        ];
        Notification::send($users, new add_invoice_notification($details));

        request()->session()->flash('msgSuccess', "تم نقل الفاتورة الى الأرشيف بنجاح");
        return redirect(adminUrl("invoices"));
    }

    // restore trashed invoice
    public function restoreInvoice($id)
    {

        $invoice = Invoice::onlyTrashed()->where("id", $id)->first();

        if (empty($invoice)) {
            return redirect('notFound');
        }

        $invoice->restore();

        // add notification in the dashboard
        // show notification for all users has permission to show notifications
        // not show notification for user restore invoice from archive

        $users = User::where('id', "!=", auth()->user()->id)->get();
        $details = [
            "invoice_id" => $invoice->id,
            "archive_url"=>null,
            "added_by" => auth()->user()->name,
            "msg" => 'قام <span class="badge badge-pill badge-info">' . auth()->user()->name . '</span> باستعادة فاتورة من الأرشيف',
        ];
        Notification::send($users, new add_invoice_notification($details));

        request()->session()->flash('msgSuccess', "تم استعادة الفاتورة بنجاح");
        return redirect(adminUrl("invoices"));

    }
}
