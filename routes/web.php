<?php

use App\Section;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Auth::routes();

Route::get('/', function () {
    return redirect('index');
});

Route::group(["prefix" => "admin", 'middleware' => "auth"], function () {
    Route::get('/', 'HomeController@home');

    Route::resource('sections', 'SectionController');
    Route::resource('products', 'ProductController');
    Route::resource('invoices', "InvoiceController", ['except' => ["destroy"]]);

    // delete invoice from invoices list and from archive list
    // declare this route to destroy trashed invoices also
    Route::delete('invoices/{id}', 'InvoiceController@destroy');

    // print invoice
    Route::get('printInvoice/{id}', "InvoiceController@printInvoice");

    // invoice export excel
    Route::get('export_invoices', 'InvoiceController@export_excel');

    // كل الفواتير / المدفوعة / غير المدفوعة / المدفوعة جزئيا
    Route::get('invoicesStatus/1', "InvoiceController@invoices_by_status_1");
    Route::get('invoicesStatus/2', "InvoiceController@invoices_by_status_2");
    Route::get('invoicesStatus/3', "InvoiceController@invoices_by_status_3");

    // get invoices trashed
    Route::get('invoicesArchived', "ArchiveController@index");

    // trash invoice
    Route::delete('invoices/archive/{id}', "ArchiveController@archiveInvoice");

    // restore trashed invoices
    Route::get('invoice/restore/{id}', "ArchiveController@restoreInvoice");

    Route::get('section/{id}', function ($id) {
        $section = Section::find($id);

        $products = $section->products()->pluck('product_name', 'id')->toArray();

        return response()->json(['status' => 'ok', 'products' => $products]);
    });

    // attachments
    Route::post('addAttachment', "invoiceDetailsController@addAttachment")->name('addAttachment');
    route::get('view_file/{invoice_number}/{file_id}', "invoiceDetailsController@open_file");
    route::get('download/{invoice_number}/{file_id}', "invoiceDetailsController@download_file");
    Route::delete('delete_file/{invoice_nb}/{file_id}', 'invoiceDetailsController@destroy')->name('delete_file');

    // authentification routes
    Route::resource('roles', 'RoleController');
    Route::resource('users', 'UserController');

    // report controller
    route::get('invoices_report', function () {return view('admin.reports.invoices_report');});
    route::post('invoices_report', 'ReportController@invoices_report')->name('invoices_report');

    route::get('customers_report', function () {
        $sections = Section::all()->pluck('section_name', 'id');
        return view('admin.reports.customers_report', compact('sections'));
    });
    route::post('customers_report', 'ReportController@customers_report')->name('customers_report');

    // Dashboard Notification read by invoice id /read all
    Route::get('readNotification/{invoice_id}/{created_at}', 'NotificationController@markAsRead');

});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
});

// not found route
Route::get('notFound', function () {
    return view('admin.404');
});

Route::get('/{page}', function ($q) {
    if (view()->exists($q)) {
        return view($q);
    } else {
        return redirect('notFound');
    }
});
