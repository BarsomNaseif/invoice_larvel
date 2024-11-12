<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Models\Invoice;
use Illuminate\Container\Attributes\Auth;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\sectionsController;
use App\Http\Controllers\productsController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
Route::get('/', function () {
    return view('auth.login');
});
Route::get('/dashboard',[ HomeController::class, 'index'])->middleware('auth', 'verified');
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
  
});
require __DIR__.'/auth.php';
//Route::get('sections', [sectionsController::class, 'index']);
Route::resource('sections', SectionsController::class);
Route::resource('product',  productsController::class);
Route::resource('invoice',  InvoiceController::class);
Route::get('/section/{id}', [InvoiceController::class, 'getproducts']);

Route::get('/InvoicesDetails/{id}', [InvoiceController::class, 'edit']);

Route::get('download/{invoice_number}/{file_name}', [InvoiceController::class, 'get_file']);

Route::get('View_file/{invoice_number}/{file_name}', [InvoiceController::class, 'open_file']);

Route::post('delete_file', [InvoicesDetailsController::class, 'destroy'])->name('delete_file');

Route::get('/edit_invoice/{id}', [InvoiceController::class, 'edit']);

Route::get('/Status_show/{id}', [InvoiceController::class, 'show'])->name('Status_show');

Route::post('/Status_Update/{id}', [InvoiceController::class, 'Status_Update'])->name('Status_Update');

Route::resource('Archive', 'InvoiceAchiveController');

Route::get('Invoice_Paid',[InvoiceController::class, 'Invoice_Paid']);

Route::get('Invoice_UnPaid',[InvoiceController::class, 'Invoice_UnPaid']);

Route::get('Invoice_Partial',[InvoiceController::class, 'Invoice_Partial']);

Route::get('Print_invoice/{id}',[InvoiceController::class, 'Print_invoice']);

Route::get('export_invoices', [InvoiceController::class, 'export']);
Route::get('/{page}', [AdminController::class, 'index']);