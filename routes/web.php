<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EntitiesController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TaxsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PatronController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\TicketSystemController;

Route::get('/', function () {
    return Inertia::render('Welcome');
});
Route::match(['get', 'post'], 'register', function () {
    return redirect('/login');
});

Route::post('logout', [UserController::class, 'logout'])->name('logout');

//allow only super admin
Route::group(['middleware' => ['auth']], function () {
    //Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
    Route::get('get-engineer-data', [DashboardController::class, 'EngineerData'])->name('tickets.get-engineer-data');
    Route::get('get-datewise-data', [DashboardController::class, 'DateWiseData'])->name('tickets.get-datewise-data');

    //home
    Route::get('home', [HomeController::class, 'index'])->name('home')->middleware('auth');
    Route::get('home/{home}', [HomeController::class, 'entity'])->name('home.entity')->middleware('auth');
    Route::get('entitydata', [EntitiesController::class, 'entitydata'])->name('entitydata');

    /// Entities
    Route::get('entities', [EntitiesController::class, 'index'])->name('entities');
    Route::get('entities/logo', [EntitiesController::class, 'getLogo'])->name('entities.logo');
    Route::get('entities/create', [EntitiesController::class, 'create'])->name('entities.create');
    Route::post('entities', [EntitiesController::class, 'store'])->name('entities.store');
    Route::get('entities/{entities}/edit', [EntitiesController::class, 'edit'])->name('entities.edit');
    Route::put('entities/{entities}', [EntitiesController::class, 'update'])->name('entities.update');
    Route::get('entities/{entities}', [EntitiesController::class, 'destroy'])->name('entities.destroy');
    Route::post('entitiesimage/{entities}', [EntitiesController::class, 'updateimage'])->name('entities.updateimage');
});


Route::group(['middleware' => ['auth']], function () {

    //user
    Route::get('user', [UserController::class, 'index'])->name('user');
    Route::get('user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('user', [UserController::class, 'store'])->name('user.store');
    Route::get('user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::post('userimage/{userimage}', [UserController::class, 'updateimage'])->name('user.updateimage');
    // Route::put('userss/{user}', [UsersController::class, 'updates']);
    // Users
    Route::get('users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UsersController::class, 'update'])->name('users.update');


    Route::get('/import',  [SettingsController::class, 'import'])->name('settings.import');
    Route::post('/lead/import',  [SettingsController::class, 'importdata']);

    //settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings');
    Route::get('settings/create', [SettingsController::class, 'create'])->name('settings.create');
    Route::post('settings/ltcreate', [SettingsController::class, 'leadtypestore'])->name('settings.leadtypestore');
    Route::post('settings/lscreate', [SettingsController::class, 'leadstagestore'])->name('settings.leadstagestore');
    Route::put('/settings/leadtypeupdate', [SettingsController::class, 'leadtypeupdate']);
    Route::put('/settings/leadstageupdate', [SettingsController::class, 'leadstageupdate']);
    Route::get('leadtypedelete/{leadtypedelete}', [SettingsController::class, 'leadtypedestroy'])->name('leadtype.destroy');
    Route::get('leadstagedelete/{leadstagedelete}', [SettingsController::class, 'leadstagedestroy'])->name('leadstage.destroy');
    //Lead
    Route::get('lead', [LeadController::class, 'index'])->name('lead');
    Route::get('lead/create', [LeadController::class, 'create'])->name('lead.create');
    Route::post('lead/store', [LeadController::class, 'store'])->name('lead.store');
    Route::get('lead/{leads}/edit', [LeadController::class, 'edit'])->name('lead.edit');
    Route::get('lead/{leads}/show', [LeadController::class, 'show'])->name('lead.show');
    Route::put('lead/{leads}', [LeadController::class, 'update'])->name('lead.update');
    Route::get('lead/{updatestatus}', [LeadController::class, 'updatestatus'])->name('lead.status');
    Route::delete('lead/{id}', [LeadController::class, 'destroy'])->name('lead.destroy');

    //Personnel
    Route::get('personnel', [PersonnelController::class, 'index'])->name('personnel');
    Route::get('personnel/create', [PersonnelController::class, 'create'])->name('personnel.create');
    Route::post('personnel/store', [PersonnelController::class, 'store'])->name('personnel.store');
    Route::get('personnel/{personnel}/edit', [PersonnelController::class, 'edit'])->name('personnel.edit');
    Route::post('/personnel/update', [PersonnelController::class, 'update'])->name('personnel.update');
    Route::delete('/personnel/{pid}/{cid}', [PersonnelController::class, 'delete'])->name('personnel.destroy');

    //Permissions
    Route::get('permissions', [PermissionsController::class, 'index'])->name('permissions');
    Route::get('permissions/create', [PermissionsController::class, 'create'])->name('permissions.create');
    Route::get('permissions/{permission}/edit', [PermissionsController::class, 'edit'])->name('permissions.edit');
    Route::post('permissions', [PermissionsController::class, 'store'])->name('permissions.store');
    Route::post('permissions/{permission}/update', [PermissionsController::class, 'update'])->name('permissions.update');
    Route::get('permissions/{permission}', [PermissionsController::class, 'destroy'])->name('permissions.destroy');

    //Roles
    Route::get('roles', [RolesController::class, 'index'])->name('roles');
    Route::get('roles/create', [RolesController::class, 'create'])->name('roles.create');
    Route::get('roles/{role}/edit', [RolesController::class, 'edit'])->name('roles.edit');
    Route::post('roles', [RolesController::class, 'store'])->name('roles.store');
    Route::post('roles/{role}/update', [RolesController::class, 'update'])->name('roles.update');
    Route::delete('roles/{role}', [RolesController::class, 'destroy'])->name('roles.destroy');

    //invoice
    Route::get('invoice', [InvoiceController::class, 'index'])->name('invoice');
    Route::get('invoice/create', [InvoiceController::class, 'create'])->name('invoice.create');
    Route::post('invoicestore', [InvoiceController::class, 'store'])->name('invoice.store');
    Route::get('invoice/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoice.edit');
    Route::post('invoiceupdate', [InvoiceController::class, 'update'])->name('invoice.update');
    Route::get('invoice/{invoices}', [InvoiceController::class, 'destroy'])->name('invoice.destroy');
    Route::get('invoicepdf/{invoices}', [InvoiceController::class, 'invoicePdf'])->name('invoice.invoicePdf');
    // Route::get('invoicepaids/{paidstatus}', [InvoiceController::class, 'paidstatus'])->name('invoice.paidstatus');
    Route::get('rowdelete/{rowdelete}', [InvoiceController::class, 'rowdelete'])->name('invoice.rowdelete');
    Route::get('invoicemail/{mail}', [InvoiceController::class, 'invoicemail'])->name('invoice.mail');
    Route::post('invoicepaids', [InvoiceController::class, 'paidstatus'])->name('invoicepaids');
    //excel
    Route::get('invoiceexport', [InvoiceController::class, 'invoiceexport'])->name('invoice.export');
    //Product
    Route::get('product', [ProductController::class, 'index'])->name('product');
    Route::get('product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('product', [ProductController::class, 'store'])->name('product.store');
    Route::get('product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('product/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::get('product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

    //tax
    Route::get('tax', [TaxsController::class, 'index'])->name('tax');
    Route::get('tax/create', [TaxsController::class, 'create'])->name('tax.create');
    Route::get('tax/{tax}/edit', [TaxsController::class, 'edit'])->name('tax.edit');
    Route::post('tax/store', [TaxsController::class, 'store'])->name('tax.store');
    Route::put('tax/update', [TaxsController::class, 'update'])->name('tax.update');
    Route::get('tax/{tax}', [TaxsController::class, 'destroy'])->name('tax.destroy');
    //tax parent get
    Route::get('/taxparent/{taxtype}', [TaxsController::class, 'taxparent'])->name('taxparent');
    // Patron
    Route::get('patron', [PatronController::class, 'index'])->name('patron');
    Route::get('patron/create', [PatronController::class, 'create'])->name('patron.create');
    Route::post('patron', [PatronController::class, 'store'])->name('patron.store');
    Route::post('/patronpopup', [PatronController::class, 'patronstore'])->name('patronpopup.patronstore');
    Route::post('patron/{patron}', [PatronController::class, 'address'])->name('patron.address');
    Route::get('patron/{patron}/edit', [PatronController::class, 'edit'])->name('patron.edit');
    Route::put('patron/{patron}', [PatronController::class, 'update'])->name('patron.update');
    Route::get('patron/{patron}', [PatronController::class, 'destroy'])->name('patron.destroy');
    Route::get('patronaddress/{patronaddress}', [PatronController::class, 'addressome'])->name('patronaddress');
    Route::put('addressupdate/{addressupdate}', [PatronController::class, 'addressupdate'])->name('patron.addressupdate');

    //account
    Route::get('accounts', [AccountController::class, 'index'])->name('accounts');
    Route::post('paid_status/{paid}', [InvoiceController::class, 'paidstatus'])->name('invoice.paidstatus');
    Route::post('cancel_status/{paid}', [InvoiceController::class, 'cancelStatus'])->name('invoice.cancelStatus');
    Route::post('updateStatus', [\App\Http\Controllers\LeaveController::class, 'updateStatus'])->name('leaves.updateStatus');


    Route::get('bulkmailsend', [InvoiceController::class, 'BulkInvoiceMail'])->name('invoice.bulkmailsend');

    Route::get('report/getLedger', [\App\Http\Controllers\ReportController::class, 'getLedger'])->name('getLedger');
    Route::get('report/getPatron', [\App\Http\Controllers\ReportController::class, 'getPatron'])->name('getPatron');
    Route::get('report/getPaymentReport', [\App\Http\Controllers\ReportController::class, 'PaymentReport'])->name('getPaymentReport');
    Route::get('report/get-ticket-report', [\App\Http\Controllers\ReportController::class, 'MonthlyReport'])->name('report.get-ticket-report');
    Route::get('report/get-customer-report', [\App\Http\Controllers\ReportController::class, 'customerReport'])->name('report.get-customer-report');
    Route::get('report/get-employee-report', [\App\Http\Controllers\ReportController::class, 'employeeReport'])->name('report.get-employee-report');
    Route::get('report/generate-report-image', [\App\Http\Controllers\ReportController::class, 'downloadReportJpeg'])->name('report.get-jpeg-report');
    Route::get('report/generate-report-pdf', [\App\Http\Controllers\ReportController::class, 'downloadReportpdf'])->name('report.get-pdf-report');
    Route::get('get_expense/getref_no', [\App\Http\Controllers\ExpenseController::class, 'getrefNo'])->name('expense.getrefNo');
    //Lead
    //    Route::get('attendance', [\App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance');
    //    Route::get('accounts/create', [LeadController::class, 'create'])->name('accounts.create');
    Route::post('attendance/store', [\App\Http\Controllers\AttendanceController::class, 'store'])->name('attendance.store');
    Route::post('attendance/employeeLoginToCheckIn', [\App\Http\Controllers\AttendanceController::class, 'employeeLoginToCheckIn'])->name('attendance.employeeLoginToCheckIn');
    Route::post('attendance/employeeLoginToCheckOut', [\App\Http\Controllers\AttendanceController::class, 'employeeLoginToCheckOut'])->name('attendance.employeeLoginToCheckOut');
    //    Route::get('attendance/{attendances}/edit', [\App\Http\Controllers\AttendanceController::class, 'edit'])->name('attendance.edit');
    //    Route::get('accounts/{accounts}/show', [LeadController::class, 'show'])->name('accounts.show');
    //    Route::put('accounts/{accounts}', [LeadController::class, 'update'])->name('accounts.update');
    //    Route::get('accounts/{updatestatus}', [LeadController::class, 'updatestatus'])->name('accounts.status');
    Route::delete('attendance/{id}', [\App\Http\Controllers\AttendanceController::class, 'destroy'])->name('attendance.destroy');
    //    Route::get('accounts', [LeadController::class, 'index1'])->name('accounts');
    //    Route::get('accounts/create', [LeadController::class, 'create'])->name('accounts.create');
    //    Route::post('accounts/store', [LeadController::class, 'store'])->name('accounts.store');
    //    Route::get('accounts/{accounts}/edit', [LeadController::class, 'edit'])->name('accounts.edit');
    //    Route::get('accounts/{accounts}/show', [LeadController::class, 'show'])->name('accounts.show');
    //    Route::put('accounts/{accounts}', [LeadController::class, 'update'])->name('accounts.update');
    //    Route::get('accounts/{updatestatus}', [LeadController::class, 'updatestatus'])->name('accounts.status');
    //    Route::delete('accounts/{id}', [LeadController::class, 'destroy'])->name('accounts.destroy');

    Route::post('/supportType', [TicketSystemController::class, 'storeSupportType']);
    Route::post('/addGroup', [TicketSystemController::class, 'addGroup']);
    Route::post('/supportSystem', [TicketSystemController::class, 'store']);

    Route::get('/supportSystem/{id}/edit', [TicketSystemController::class, 'edit'])->name('supportSystem.edit');
    Route::put('/supportSystem/{id}', [TicketSystemController::class, 'update'])->name('supportSystem.update');
    Route::delete('/supportSystem/{id}', [TicketSystemController::class, 'destroy'])->name('supportSystem.destroy');
    Route::put('/supportSystem-tat/{id}', [TicketSystemController::class, 'tatChange'])->name('supportSystem.level');
    Route::get('api/support-tickets', [SupportTicketController::class, 'SupportTicket']);
    Route::resource('support',SupportTicketController::class)->middleware('can:menu_support');
    Route::resources([
        'accounts'                   => \App\Http\Controllers\AccountsController::class,
        'accountType'              => \App\Http\Controllers\AccountTypeController::class,
        'ledger'                   => \App\Http\Controllers\LedgerController::class,
        'defaultSetting'            => \App\Http\Controllers\DefaultSettingController::class,
        'report'                    => \App\Http\Controllers\ReportController::class,
        'expense'                   => \App\Http\Controllers\ExpenseController::class,
        'payment'                   => \App\Http\Controllers\PaymentController::class,
        'attendance'                => \App\Http\Controllers\AttendanceController::class,
        'leave'                     => \App\Http\Controllers\LeaveController::class,
        //        'journal'                   =>
        //        'journal'                   =>
    ]);

    Route::get('/bulk_invoice/generate', function () {
        if (auth()->check()) {
            \Illuminate\Support\Facades\Artisan::call('invoices:generate');
            return 'Invoice Generated successfully!';
        }
        return abort(403, 'Unauthorized');
    })->name('invoice.generate');
    Route::get('/download-invoices', [InvoiceController::class, 'downloadInvoices'])->name('invoice.downloadInvoices');


});
