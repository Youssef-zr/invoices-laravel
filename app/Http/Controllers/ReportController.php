<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Section;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function invoices_report(Request $request)
    {

        $all_fields = $request->except(["_token", "_method"]);

        if (empty($all_fields)) { // show this line to display the page of invoices_report in the start

            return view('admin.reports.invoices_report');

        } else { // used only in the post method

            $invoice_type = $request->invoice_type;
            $start_at = null;
            $end_at = null;
            $form_invoice_number = 0;

            $query = Invoice::select('*');
            $invoices = [];
            $enter_condition = 0;

            foreach ($all_fields as $key => $value) {

                if (isset($key) and $value != null) {

                    if ($key == 'invoice_type') {

                        $query = $query->where('value_status', $value);
                        $enter_condition++;

                    } else if ($key == "start_at" and isset($all_fields['end_at']) and (strtotime($request->end_at) - strtotime($value)) >= 0) {

                        $query = $query->whereBetween('invoice_date', [$request->start_at, $request->end_at]);

                        $start_at = $request->start_at;
                        $end_at = $request->end_at;
                        $enter_condition++;

                    } else if ($key == "start_at" and !isset($all_fields['end_at'])) {

                        $start_at = $request->start_at;

                        $query = $query->where('invoice_date', ">=", date($value));
                        $enter_condition++;
                    } else if ($key == "end_at" and !isset($all_fields['start_at'])) {

                        $end_at = $request->end_at;
                        $enter_condition++;
                    } else if ($key == "invoice_number" and $key != "") {

                        $query = $query->where('invoice_number', 'like', '%' . $value . '%');
                        $form_invoice_number = 1; // اظهار form البحث برقم الفاتورة
                        $invoice_number = $value;
                        $invoices = $query->get();
                        return view('admin.reports.invoices_report', compact("invoices", 'invoice_type', "start_at", "end_at", 'form_invoice_number', 'invoice_number'));
                    }

                }
            }

            if ($enter_condition != 0) {
                $invoices = $query->get();
            }

            return view('admin.reports.invoices_report', compact(isset($invoices) ? 'invoices' : '', 'invoice_type', "start_at", "end_at", 'form_invoice_number'));

        }

    }

    public function customers_report(Request $request)
    {

        // search by form customers
        $section_id = $request->section_id;
        $product = $request->product;
        $start_at = $request->start_at;
        $end_at = $request->end_at;

        if (isset($section_id) and isset($product) and !isset($start_at) and !isset($end_at)) {
            $invoices = Invoice::where('section_id', $section_id)->where('product', '=', $product)->get();
        } else {

            $invoices = Invoice::whereBetween('invoice_date', [$start_at, $end_at])->get();
        }

        $sections = Section::all()->pluck('section_name', "id");
        return view('admin.reports.customers_report', compact('invoices', 'sections', "section_id", "product"));
    }
}
