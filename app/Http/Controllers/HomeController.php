<?php

namespace App\Http\Controllers;

use App\Invoice;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return redirect(url('/admin'));
    }

    public function home()
    {
        $invoices_info = [
            '0' => $this->invoice_info(), // معلومات كل الفواتير
            '1' => $this->invoice_info(1), // معلومات الفواتير المدفوعة
            '2' => $this->invoice_info(2), // معلومات الفواتير  الغير مدفوعة
            '3' => $this->invoice_info(3), // معلومات الفواتير المدفوعة جزئيا
        ];

        $chartJs = $this->chartJs_card_1($invoices_info);
        return view('admin.home', compact('invoices_info', 'chartJs'));
    }

    private function invoice_info($invoice_stats = 'all')
    {

        // خصائص css تستعمل في الاحصائيات
        $invoices_style = [
            '0' => ['card_bg' => 'bg-primary-gradient', 'chevron' => 'fa-arrow-circle-up', 'id_chart' => 'compositeline'],
            '1' => ['card_bg' => 'bg-success-gradient', 'chevron' => 'fa-arrow-circle-up', 'id_chart' => 'compositeline2'],
            '2' => ['card_bg' => 'bg-danger-gradient', 'chevron' => 'fa-arrow-circle-down', 'id_chart' => 'compositeline3'],
            '3' => ['card_bg' => 'bg-warning-gradient', 'chevron' => 'fa-arrow-circle-up', 'id_chart' => 'compositeline4'],
        ];

        // فواتير مدفوعة /غير مدفوعة/مدفوعة جزئيا
        if ($invoice_stats != 'all') {

            $invoices = Invoice::where('value_status', $invoice_stats)->get(); // عدد الفواتير لكل حالة

            return [
                'invoice_status' => ' فواتير ' . invoice_status()[$invoice_stats], // فواتير مدفوعة /غير مدفوعة/مدفوعة جزئيا
                'nb_invoices' => $invoices->count(), // عدد الفواتير بالنسبة لكل حالة
                'sum_total_mony' => number_format($invoices->sum('total')) . "$", // مجموع المستحقات بالنسبة لكل حالة
                'percentage' => count($invoices)>0 ? round($invoices->count() / Invoice::count() * 100)."%" : 0, // نسبة الفواتير لكل حالة
                "style" => $invoices_style[$invoice_stats], // بعض خصائص css
            ];

        }

        // كل الفواتير
        $all_invoices = Invoice::all();

        return [
            'invoice_status' => 'اجمالي الفواتير',
            'nb_invoices' => $all_invoices->count(),
            'sum_total_mony' => number_format($all_invoices->sum('total')) . "$",
            'percentage' => 100 . '%',
            "style" => $invoices_style['0'],
        ];

    }

    private function chartJs_card_1($invoices_info)
    {
        return app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels([
                'فواتير مدفوعة جزئيا',
                'فواتير غير مدفوعة',
                'فواتير مدفوعة',
            ])
            ->datasets([
                [
                    'backgroundColor' => [
                        '#ff9f43',
                        '#ff6b6b',
                        '#1dd1a1',
                    ],
                    'borderColor' => "#fff",
                    'borderWidth' => '3',
                    'data' => [
                        $invoices_info[3]['nb_invoices'],
                        $invoices_info[2]['nb_invoices'],
                        $invoices_info[1]['nb_invoices'],
                    ],
                ],
            ])
            ->options([]);
    }
}
