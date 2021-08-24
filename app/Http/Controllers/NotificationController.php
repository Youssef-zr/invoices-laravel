<?php

namespace App\Http\Controllers;

use App\Invoice;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:الاشعارات', ['only' => 'markAsRead']);
    }

    public function markAsRead($invoice_id, $created_at)
    {

        if ($invoice_id == 'all' and $created_at == "all") { // read all notifications

            $allNotifications = auth()->user()->unreadNotifications;
            if (!empty($allNotifications)) {
                $allNotifications->markAsRead();
            }

            return redirect(adminUrl('invoices'));

        } else { // read only one notification by invoice_id
            $notification = auth()->user()->unreadNotifications->where('created_at', $created_at);

            $notification->markAsRead();

            if ($invoice_id == "invoicesArchived") {
                return redirect(adminUrl('invoicesArchived'));
            } else {

                $invoice = Invoice::find($invoice_id);
                if ($invoice != null) {
                    return redirect(adminUrl('invoices/' . $invoice->id));
                } else {
                    return redirect('notFound');
                }

            }
        }
    }
}
