<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\BudgetController;
use App\Http\Controllers\Admin\CVPController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\GroupMeetingController;
use App\Http\Controllers\Admin\InsuranceController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\PDFController;
use App\Http\Controllers\Admin\ProcessController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Asset\DesktopController;
use App\Http\Controllers\Asset\FuelConsumptionController;
use App\Http\Controllers\Asset\LaptopController;
use App\Http\Controllers\Asset\LicenseController;
use App\Http\Controllers\Asset\ModemController;
use App\Http\Controllers\Asset\MotorController;
use App\Http\Controllers\Asset\MotorMaintenanceController;
use App\Http\Controllers\Asset\PhoneController;
use App\Http\Controllers\Asset\PowerSupplyController;
use App\Http\Controllers\Asset\PrinterController;
use App\Http\Controllers\Asset\RouterController;
use App\Http\Controllers\Asset\ScannerController;
use App\Http\Controllers\Asset\SwitchController;
use App\Http\Controllers\CRM\CRMCustomerController;
use App\Http\Controllers\CRM\CustomerTicketController;
use App\Http\Controllers\CRM\TicketCategoryController;
use App\Http\Controllers\CRM\TicketSourceController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Records\ClientChangeFormController;
use App\Http\Controllers\Records\ClientController;
use App\Http\Controllers\Records\FilingLabelController;
use App\Http\Controllers\Records\LoanFormController;
use App\Http\Controllers\Records\RequestedChangeFormController;
use App\Http\Controllers\Records\RequestedLoanFormController;
use App\Http\Controllers\Shop\CategoryController;
use App\Http\Controllers\Shop\ProductController;
use App\Http\Controllers\Shop\ShopController;
use App\Http\Controllers\Shop\SliderController;
use App\Http\Controllers\User\AppraisalController;
use App\Http\Controllers\User\FollowupController;
use App\Http\Controllers\User\GroupVisitationController;
use App\Http\Controllers\User\LoanRecoveryController;
use App\Http\Controllers\User\UserExpenseController;
use App\Models\Records\RequestedChangeForm;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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

Route::get('clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    Artisan::call('config:clear');
    return 'DONE'; //Return anything
});

Route::get('login', function () {
    return view('auth.login', ['title' => 'Login']); 
 })->middleware('token')->name('login');

Route::get('test', [TestController::class, 'index'])->middleware(['role:admin']);
Route::get('send-sms', [AdminController::class, 'sendSms']);

Route::get('/', [AdminController::class, 'getAccessToken']);
Route::get('auth/token/get', [AdminController::class, 'getAccessToken'])->name('get.token');
Route::get('auth/token/send', [AdminController::class, 'sendAccessToken'])->name('send.token');
Route::post('auth/token/verify', [AdminController::class, 'verifyAccessToken'])->name('verify.token');

Route::get('home', [AdminController::class, 'index'])->name('home')->middleware(['auth']);
Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard')->middleware(['auth']);
Route::post('get-sub-counties', [AdminController::class, 'fetchSubCounties'])->name('get.subcounties');
Route::post('get-outposts', [AdminController::class, 'fetchBranchOutposts'])->name('get.outposts');
Route::get('get-users', [AdminController::class, 'fetchBranchUsers'])->name('get.users');
Route::get('get-ousers', [AdminController::class, 'fetchOutpostUsers'])->name('get.ousers');
Route::get('get-oclients', [AdminController::class, 'fetchOutpostClients'])->name('get.oclients');
Route::get('get-filing-files', [LoanFormController::class, 'fetchFilingLabelsByType'])->name('get.filing-files');
Route::get('get-client-accounts', [LoanFormController::class, 'fetchClientAccounts'])->name('get.client-accounts');
Route::get('get-account-details', [LoanFormController::class, 'getAccountDetails'])->name('get.account-details');
Route::get('get-phoneusers', [AdminController::class, 'fetchOutpostPhones'])->name('get.phoneusers');
Route::get('get-modemusers', [AdminController::class, 'fetchOutpostModems'])->name('get.modemusers');
Route::get('get-workflowusers', [CustomerTicketController::class, 'fetchWorkflowUsers'])->name('get.workflowusers');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('test', [TestController::class, 'index'])->middleware(['role:admin']);
    Route::get('messages', [MessageController::class, 'index'])->name('messages.index')->middleware(['role:admin']);
    Route::get('audit-trails', [AdminController::class, 'auditTrail'])->name('audit.index')->middleware(['role:admin']);
    Route::get('branches', [AdminController::class, 'branches'])->name('branches.index')->middleware(['role:admin|communication']);
    Route::put('branches/{id}', [AdminController::class, 'updateBranch'])->name('branches.update')->middleware(['role:admin|communication']);
   

    /// Users management
    Route::put('users/activate/{user}',  [UserController::class, 'activateUser'])->name('users.activate')->middleware(['role:admin']);
    Route::put('users/deactivate/{user}',  [UserController::class, 'deactivateUser'])->name('users.deactivate')->middleware(['role:admin']);
    Route:: resource('users', UserController::class)->middleware(['role:admin']);

    /// Roles management
    Route::get('roles/{id}/permissions', [RoleController::class, 'rolePermissions'])->name('roles.permissions')->middleware(['role:admin']);
    Route::get('roles/management', [RoleController::class, 'rolesManagement'])->name('roles.management')->middleware(['role:admin']);
    Route::get('roles/users', [RoleController::class, 'usersRolesManagement'])->name('roles.users')->middleware(['role:admin']);
    Route::post('roles/user', [RoleController::class, 'storeUserRole'])->name('roles.storerole')->middleware(['role:admin']);
    Route::delete('roles/user/{id}', [RoleController::class, 'deleteUserRole'])->name('roles.deleterole')->middleware(['role:admin']);
    Route::get('roles/user/{id}', [RoleController::class, 'userRoles'])->name('roles.user')->middleware(['role:admin']);
    Route:: resource('roles', RoleController::class, ['except' => ['create', 'edit', 'show']])->middleware(['role:admin']);

    Route::get('permissions', [RoleController::class, 'permissionsManagement'])->name('permissions')->middleware(['role:admin']);
    Route::post('permissions/store', [RoleController::class, 'storePermission'])->name('permissions.store')->middleware(['role:admin']);
    Route::delete('permissions/{id}', [RoleController::class, 'destroyPermission'])->name('permissions.destroy')->middleware(['role:admin']);
    Route::put('permissions/{id}', [RoleController::class, 'updatePermission'])->name('permissions.update')->middleware(['role:admin']);

    /// Groups management
    Route::get('groups', [GroupController::class, 'index'])->name('groups.index');
    Route::get('groups/officers', [GroupController::class, 'officers'])->name('groups.officers');
    Route::get('officer/groups/{id}', [GroupController::class, 'officerGroups'])->name('officer.groups');
    Route::get('groups/{id}', [GroupController::class, 'show'])->name('groups.show');

    /// Assets Management
    Route::get('assets/categories', [AssetController::class, 'categories'])->name('assets.categories')->middleware(['role:admin|motor maintenance']);
    Route::get('assets', [AssetController::class, 'index'])->name('assets.index')->middleware(['role:admin|motor maintenance']);
    Route::get('assets/{id}', [AssetController::class, 'show'])->name('assets.show')->middleware(['role:admin|motor maintenance']);
    Route::post('assets/assign', [AssetController::class, 'assignAsset'])->name('assets.assign')->middleware(['role:admin|motor maintenance']);
    Route::delete('assets/{id}', [AssetController::class, 'deleteAssignment'])->name('assets.delete')->middleware(['role:admin|motor maintenance']);
    Route::put('assets/{id}', [AssetController::class, 'updateAssignment'])->name('assets.update')->middleware(['role:admin|motor maintenance']);

    Route::get('repairs', [AssetController::class, 'repairsData'])->name('repairs.index')->middleware(['role:admin']);
    Route::post('repairs/save', [AssetController::class, 'saveRepairData'])->name('repairs.save')->middleware(['role:admin']);
    Route::delete('repairs/{id}', [AssetController::class, 'deleteRepairData'])->name('repairs.delete')->middleware(['role:admin']);
    Route::put('repairs/{id}', [AssetController::class, 'updateRepairData'])->name('repairs.update')->middleware(['role:admin']);

    Route::get('logs', [AssetController::class, 'maintenanceLogs'])->name('logs.index')->middleware(['role:admin']);
    Route::post('logs/save', [AssetController::class, 'saveMaintenanceLogData'])->name('logs.save')->middleware(['role:admin']);
    Route::delete('logs/{id}', [AssetController::class, 'deleteMaintenanceLogData'])->name('logs.delete')->middleware(['role:admin']);
    Route::put('logs/{id}', [AssetController::class, 'updateMaintenanceLogData'])->name('logs.update')->middleware(['role:admin']);
    Route::put('logs/comment/{id}', [AssetController::class, 'commentMaintenanceLogData'])->name('logs.comment')->middleware(['role:admin']);
    Route::get('logs/show/log_id={log_id}&product_id={product_id}', [AssetController::class, 'showMaintenanceLogData'])->name('logs.show')->middleware(['role:admin']);
    Route::get('logs/{id}/edit', [AssetController::class, 'editMaintenanceLogData'])->name('logs.edit')->middleware(['role:admin']);
    Route::get('logs/add/product_id={product_id}&asset_id={asset_id}', [AssetController::class, 'addMaintenanceLogData'])->name('logs.add')->middleware(['role:admin']);

    Route:: resource('desktops', DesktopController::class, ['except' => ['index']])->middleware(['role:admin']);
    Route:: resource('laptops', LaptopController::class, ['except' => ['index']])->middleware(['role:admin']);
    Route:: resource('phones', PhoneController::class, ['except' => ['index']])->middleware(['role:admin']);
    Route:: resource('modems', ModemController::class, ['except' => ['index']])->middleware(['role:admin']);
    Route:: resource('motors', MotorController::class, ['except' => ['index']])->middleware(['role:admin|motor maintenance']);
    Route:: resource('printers', PrinterController::class, ['except' => ['index']])->middleware(['role:admin']);
    Route:: resource('routers', RouterController::class, ['except' => ['index']])->middleware(['role:admin']);
    Route:: resource('scanners', ScannerController::class, ['except' => ['index']])->middleware(['role:admin']);
    Route:: resource('switches', SwitchController::class, ['except' => ['index']])->middleware(['role:admin']);
    Route:: resource('ups', PowerSupplyController::class, ['except' => ['index']])->middleware(['role:admin']);

    Route:: resource('licenses', LicenseController::class, ['except' => ['create', 'show', 'edit']]);
    Route:: resource('fuels', FuelConsumptionController::class, ['except' => ['create', 'edit']]);
    
    Route::put('motor-logs/save/{log_id}', [MotorMaintenanceController::class, 'saveService'])->name('motor-logs.save')->middleware(['role:admin|motor maintenance']);
    Route::put('motor-logs/approve/{log_id}', [MotorMaintenanceController::class, 'approveBooking'])->name('motor-logs.approve')->middleware(['role:admin|motor maintenance']);
    Route::get('motor-logs/book/asset_id={asset_id}&service=maintenance', [MotorMaintenanceController::class, 'book'])->name('motor-logs.book')->middleware(['role:admin|motor maintenance']);
    Route:: resource('motor-logs', MotorMaintenanceController::class, ['except' => ['create']]);
    
    Route::put('insurances/renew/{id}', [InsuranceController::class, 'renew'])->name('insurances.renew')->middleware(['role:admin']);
    Route::get('insurances/renew/{id}', [InsuranceController::class, 'renewPolicy'])->name('insurances.renew-policy')->middleware(['role:admin']);
    Route::get('insurances/report', [InsuranceController::class, 'insuranceReport'])->name('insurances.report')->middleware(['role:admin']);
    Route:: resource('insurances', InsuranceController::class);

    Route::get('system-processes', [ProcessController::class, 'systemProcesses'])->name('processes.index')->middleware(['role:admin']);
    Route::post('processes/policy-expiration-status', [ProcessController::class, 'policyExpirationStatus'])->name('processes.policyexpirationstatus')->middleware(['role:admin']);
    
    Route::get('packages/data', [CVPController::class, 'packages'])->name('packages.data')->middleware(['role:admin']);
    Route::post('packages/store-package', [CVPController::class, 'storePackage'])->name('packages.storepackage')->middleware(['role:admin']);
    Route::put('packages/update/{id}', [CVPController::class, 'updatePackage'])->name('packages.updatepackage')->middleware(['role:admin']);
    Route::delete('packages/delete/{id}', [CVPController::class, 'destroyPackage'])->name('packages.deletepackage')->middleware(['role:admin']);
    Route::get('packages/add/{id}/product', [CVPController::class, 'create'])->name('packages.addpackage')->middleware(['role:admin']);
    Route:: resource('packages', CVPController::class, ['except' => ['create']])->middleware(['role:admin']);

    ///Budgets
    Route:: resource('budgets', BudgetController::class, ['except' => ['show']])->middleware(['role:admin|finance']);
    
});

Route::middleware(['auth'])->prefix('user')->name('user.')->group(function(){
    Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::put('update/profile', [UserController::class, 'updateProfile'])->name('update-profile');
    Route::put('password/{user}', [UserController::class, 'passwordChange'])->name('password.change');
    Route::get('password', [UserController::class, 'password'])->name('password');

    /// User groups
    Route::get('groups', [GroupController::class, 'userGroups'])->name('groups');
    Route::get('groups/{id}', [GroupController::class, 'show'])->name('groups.show');

    /// User expenses
    Route::get('expenses/claims', [UserExpenseController::class, 'claimExpenses'])->name('expenses.claims')->middleware(['role:admin|finance']);
    Route::get('expenses/transactions', [UserExpenseController::class, 'transactions'])->name('expenses.transactions')->middleware(['role:admin|finance']);
    Route::put('expenses/claims/{id}', [UserExpenseController::class, 'payExpense'])->name('expenses.claims.pay')->middleware(['role:admin|finance']);


    /// Appraisals
    Route:: resource('appraisals', AppraisalController::class, ['except' => ['index', 'create','show', 'edit']]);

    /// Loan Recoveries
    Route:: resource('loan-recoveries', LoanRecoveryController::class, ['except' => ['index', 'create','show', 'edit']]);

    /// Loan Recoveries
    Route:: resource('followups', FollowupController::class, ['except' => ['index', 'create','show', 'edit']]);
    
    
    Route:: resource('expenses', UserExpenseController::class, ['except' => ['create', 'edit']]);
    Route::put('expenses/approve/{id}', [UserExpenseController::class, 'approveExpense'])->name('expenses.approve')->middleware(['role:admin|branch manager|accountant|finance manager']);
    Route::put('expenses/reject/{id}', [UserExpenseController::class, 'rejectExpense'])->name('expenses.reject')->middleware(['role:admin|branch manager|accountant|finance manager']);;


    /// Group meetings
    Route:: resource('meetings', GroupMeetingController::class, ['except' => ['create','show', 'edit']]);
    Route::get('meetings/groups', [GroupMeetingController::class, 'userGroupMeetings'])->name('meetings.groups');

    /// Group visitation
    Route:: resource('group-visits', GroupVisitationController::class, ['except' => ['index', 'create','show', 'edit']]);
    Route::post('group-visits/save-loan', [GroupVisitationController::class, 'saveClientLoan'])->name('group-visits.save-loan');
    Route::put('group-visits/update-loan/{id}', [GroupVisitationController::class, 'updateClientLoan'])->name('group-visits.update-loan');
    Route::delete('group-visits/delete-loan/{id}', [GroupVisitationController::class, 'deleteClientLoan'])->name('group-visits.delete-loan');
   
    Route::post('group-visits/save-member', [GroupVisitationController::class, 'saveMember'])->name('group-visits.save-member');
    Route::put('group-visits/update-member/{id}', [GroupVisitationController::class, 'updateMember'])->name('group-visits.update-member');
    Route::delete('group-visits/delete-member/{id}', [GroupVisitationController::class, 'deleteMember'])->name('group-visits.delete-member');
    Route::get('group-visits/files/{id}', [GroupVisitationController::class, 'filePreview'])->name('group-visits.file');
    
    /// Budgets
    Route::get('budgets', [UserController::class, 'budgets'])->name('budgets');

    /// Devices
    Route::get('assets', [UserController::class, 'assets'])->name('assets');
    Route::get('assets/{id}', [UserController::class, 'motor'])->name('motors');

    /// Motorbike booking
    Route::get('motor-logs/book/asset_id={asset_id}&service=maintenance', [MotorMaintenanceController::class, 'book'])->name('motor-logs.book');
    Route:: resource('motor-logs', MotorMaintenanceController::class, ['except' => ['create']]);
    
    // records forms
    Route::get('change-forms/attachment/{id}', [RequestedChangeFormController::class, 'viewRequestedChangeForm'])->name('change-forms.attachment');
    Route::get('change-forms/request', [RequestedChangeFormController::class, 'requestChangeForm'])->name('change-forms.request');
    Route::post('change-forms/request', [RequestedChangeFormController::class, 'store'])->name('change-forms.request-change');
    Route::get('change-forms/{id}', [RequestedChangeFormController::class, 'requestedChangeForm'])->name('change-forms.requested');
    Route::get('change-forms', [RequestedChangeFormController::class, 'userRequestedChangeForms'])->name('change-forms.view');
   
    Route::get('loan-forms/attachment/{id}', [RequestedLoanFormController::class, 'viewRequestedLoanForm'])->name('loan-forms.attachment');
    Route::get('loan-forms/request', [RequestedLoanFormController::class, 'requestLoanForm'])->name('loan-forms.request');
    Route::get('loan-forms/{id}', [RequestedLoanFormController::class, 'requestedLoanForm'])->name('loan-forms.requested');
    Route::post('loan-forms/request', [RequestedLoanFormController::class, 'store'])->name('loan-forms.request-loan');
    Route::get('loan-forms', [RequestedLoanFormController::class, 'userRequestedLoanForms'])->name('loan-forms.view');
});

Route::middleware(['auth'])->prefix('export')->name('export.')->group(function(){
    Route::get('user-expense/{id}', [PDFController::class, 'userExpense'])->name('user-expense');
    Route::get('claim-expense', [PDFController::class, 'claimExpenses'])->name('claim-expense')->middleware(['role:admin|branch manager|accountant|finance manager']);;
    Route::get('cvp-data', [PDFController::class, 'cvpData'])->name('cvp-data')->middleware(['role:admin|branch manager|accountant|finance manager']);;
    Route::get('logs/show/log_id={log_id}&product_id={product_id}', [PDFController::class, 'showMaintenanceLogData'])->name('logs.show')->middleware(['role:admin|motor maintenance']);

});

Route::middleware(['auth'])->prefix('shop')->name('shop.')->group(function(){
    Route::get('/', [ShopController::class, 'index'])->name('index');
    Route:: resource('categories', CategoryController::class, ['except' => ['create', 'edit', 'show']])->middleware(['role:admin']);
    
    Route::post('products/save-image', [ProductController::class, 'saveProductImage'])->name('products.save-image')->middleware(['role:admin|bimas staff|branch manager']);
    Route::delete('products/delete/{id}', [ProductController::class, 'deleteProductImage'])->name('products.delete-image')->middleware(['role:admin|bimas staff|branch manager']);
    Route::put('products/publish/{product}',  [ProductController::class, 'publishProduct'])->name('products.publish')->middleware(['role:admin']);
    Route::put('products/unpublish/{product}',  [ProductController::class, 'unPublishProduct'])->name('products.unpublish')->middleware(['role:admin']);
    Route:: resource('products', ProductController::class)->middleware(['role:admin|bimas staff|branch manager']);

    Route::put('sliders/publish/{slider}',  [SliderController::class, 'publishSlider'])->name('sliders.publish')->middleware(['role:admin']);
    Route::put('sliders/unpublish/{slider}',  [SliderController::class, 'unPublishSlider'])->name('sliders.unpublish')->middleware(['role:admin']);
    Route:: resource('sliders', SliderController::class)->middleware(['role:admin']);

    Route::get('messages', [ShopController::class, 'messages'])->name('messages');
    Route::get('orders', [ShopController::class, 'orders'])->name('orders');
    Route::get('orders/{id}', [ShopController::class, 'getOrderById'])->name('get-order');
    Route::get('orders/products/{product}', [ShopController::class, 'ordersByProductId'])->name('get-product-orders');

    Route::get('users', [ShopController::class, 'users'])->name('users');

});

Route::middleware(['auth'])->prefix('customers')->name('customers.')->group(function(){
    Route:: resource('campaigns', CustomerController::class)->middleware(['role:admin|communication']);

    Route::get('add&campaign={campaign_id}', [CustomerController::class, 'addCustomer'])->name('add_customer')->middleware(['role:admin|communication']);
    Route::post('save-customer', [CustomerController::class, 'saveCustomer'])->name('save_customer');
    Route::get('edit/{id}', [CustomerController::class, 'editCustomer'])->name('edit_customer')->middleware(['role:admin|communication']);
    Route::get('show/{id}', [CustomerController::class, 'showCustomer'])->name('show_customer');
    Route::put('update-customer/{id}', [CustomerController::class, 'updateCustomer'])->name('update_customer')->middleware(['role:admin|communication']);
    Route::delete('delete-customer/{id}', [CustomerController::class, 'deleteCustomer'])->name('delete_customer')->middleware(['role:admin|communication']);
    Route::put('save-officer-message/{id}', [CustomerController::class, 'saveOfficerMessage'])->name('save_officer_message');
    Route::put('save-admin-message/{id}', [CustomerController::class, 'saveAdminMessage'])->name('save_admin_message');
    Route::get('branch', [CustomerController::class, 'branchCustomers'])->name('branch_customers');
    Route::get('add-customer', [CustomerController::class, 'addBranchCustomer'])->name('branch_customers.add');
    
    Route::get('contacts', [CustomerController::class, 'contacts'])->name('contacts')->middleware(['role:admin|communication']);
    Route::get('loans', [CustomerController::class, 'loans'])->name('loans');
    Route::get('loans/{id}', [CustomerController::class, 'showLoan'])->where('id', '[0-9]+')->name('show-loan');
    Route::put('loans/{id}', [CustomerController::class, 'approveLoan'])->where('id', '[0-9]+')->name('approve-loan');
    Route::put('comment-loan/{id}', [CustomerController::class, 'commentLoan'])->where('id', '[0-9]+')->name('comment-loan');

});

Route::middleware(['auth', 'role:admin|records|operations'])->prefix('records')->name('records.')->group(function(){
    Route::get('dashboard', [LoanFormController::class, 'dashboard'])->name('index');
    Route::get('get-client-loans', [LoanFormController::class, 'getLoanClientLoans'])->name('get-client-loans');
    Route::get('client-loans', [LoanFormController::class, 'clientLoans'])->name('client-loans');
    Route::get('uploaded-forms', [LoanFormController::class, 'uploadedLoanForms'])->name('uploaded.loan-forms');

    Route::get('clients/get-clients', [ClientController::class, 'getClients'])->name('clients.get-clients');
    Route::get('clients/request/{id}', [ClientController::class, 'createClientUsingLoanRequest'])->name('clients.loan-request');
    Route::get('clients/change-request/{id}', [ClientController::class, 'createClientUsingChangeFormRequest'])->name('clients.change-request');
    Route::post('clients/import-excel', [ClientController::class, 'importExcelClients'])->name('clients.import-excel');
    Route:: resource('clients', ClientController::class);
    
    Route::get('loan-forms/category', [LoanFormController::class, 'loanCategory'])->name('loan-forms.category');
    Route::get('loan-forms/products', [LoanFormController::class, 'loanProducts'])->name('loan-forms.products');
    Route::get('loan-forms/get-loan-forms', [LoanFormController::class, 'getLoanForms'])->name('loan-forms.get-loan-forms');
    Route::get('loan-forms/filing-type/{id}', [LoanFormController::class, 'getLoanFormsByFilingType'])->name('loan-forms.filing-type');
    Route::get('loan-forms/add', [LoanFormController::class, 'createLoanFormUsingLoanRequest'])->name('loan-forms.add-form');
    Route::post('loan-forms/import-excel', [LoanFormController::class, 'importExcelLoans'])->name('loan-forms.import-excel');
    Route:: resource('loan-forms', LoanFormController::class);

    Route::get('filing-labels/sticker/{id}', [FilingLabelController::class, 'fileSticker'])->name('filing-labels.sticker');
    Route::get('filing-labels/stickers/{type}', [FilingLabelController::class, 'fileStickers'])->name('filing-labels.stickers');
    Route:: resource('filing-labels', FilingLabelController::class)->except('edit');
   
    Route::get('get-outpost-requests', [RequestedLoanFormController::class, 'fetchOutpostRequests'])->name('get-outpost-requests');
    Route::get('get-completed-requests', [RequestedLoanFormController::class, 'getCompletedRequests'])->name('get-completed-requests');
    Route::post('requested-forms/approve', [RequestedLoanFormController::class, 'approveRequest'])->name('requested-forms.approve');
    Route:: resource('requested-forms', RequestedLoanFormController::class);

    Route::get('get-change-forms', [ClientChangeFormController::class, 'getChangeForms'])->name('get-change-forms');
    Route::post('requested-change-forms/approve', [RequestedChangeFormController::class, 'approveRequest'])->name('requested-change-forms.approve');
    Route:: resource('requested-change-forms', RequestedChangeFormController::class)->except('index');
    Route::get('change-forms/add', [ClientChangeFormController::class, 'createChangeFormUsingOfficerRequest'])->name('change-forms.add-form');
    Route:: resource('change-forms', ClientChangeFormController::class);

    Route::get('reports', [LoanFormController::class, 'recordsReports'])->name('reports.index');
    Route::get('reports/type', [LoanFormController::class, 'reportType'])->name('reports.type');
});

Route::middleware(['auth'])->prefix('crm')->name('crm.')->group(function(){
    Route::get('workflows', [CRMCustomerController::class, 'workflows'])->name('workflows.index')->middleware(['role:admin|communication']);
    Route:: resource('customers', CRMCustomerController::class, ['except' => ['create', 'store']])->middleware(['role:admin|communication']);
    Route:: resource('ticket-categories', TicketCategoryController::class, ['except' => ['create', 'edit', 'show']])->middleware(['role:admin|communication']);
    Route:: resource('ticket-sources', TicketSourceController::class, ['except' => ['create', 'edit', 'show']])->middleware(['role:admin|communication']);
    Route:: resource('tickets', CustomerTicketController::class)->middleware(['role:admin|communication']);
   
});