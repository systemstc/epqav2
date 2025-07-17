<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController\LoginController as CustomerLogin;
use App\Http\Controllers\AdminController\LoginController as AdminLogin;
use App\Http\Controllers\SubAdminController\LoginController as SubAdminlogin;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\SubAdminMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\RegionalOfficeController;
use App\Http\Controllers\FirmController;
use App\Http\Controllers\ApplicationController;

    // Route::get('/', function () {
    //     return view('/customer/dashboard');
    // });
// Guest Route

Route::middleware('throttle:10,1')->group(function () {
	Route::match(['get', 'post'], 'customer/register', [AuthController::class, 'register'])->name('customerregister');
	Route::match(['get', 'post'], '/', [AuthController::class, 'login'])->name('customerhome');
	Route::match(['get', 'post'], '/customer/login', [AuthController::class, 'login'])->name('customerlogin');
	Route::match(['get', 'post'], '/customer/verify', [AuthController::class, 'verify'])->name('customerverify');
	Route::match(['get', 'post'], '/customer/otplogin', [AuthController::class, 'sendOtpForLogin'])->name('customerotplogin');
	Route::post('resend-otp', [AuthController::class, 'resendOtp'])->name('resend.otp');

	Route::match(['get', 'post'], '/admin/login', [AuthController::class, 'login'])->name('adminlogin');
	Route::match(['get', 'post'], '/sub-admin/login', [AuthController::class, 'login'])->name('subadminlogin');
	Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('customerlogout');
	Route::get('password/forgot', [PasswordResetController::class, 'showForgotForm'])->name('password.forgot');
	Route::post('password/forgot', [PasswordResetController::class, 'sendResetLink']);
	Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
	Route::post('password/reset', [PasswordResetController::class, 'resetPassword'])->name('post.password.reset');
});


Route::middleware(['web'])->group(function () {
	// user route
	Route::group(['prefix' => 'customer','middleware' => UserMiddleware::class],function(){
		Route::match(['get', 'post'], '/dashboard', [CustomerLogin::class, 'dashboard'])->name('customerdashboard');
		Route::get('/firm/create', [FirmController::class, 'create'])->name('firms.create');
		Route::post('/firm/preview', [FirmController::class, 'preview'])->name('firms.preview');
		Route::post('/firm/preview-store', [FirmController::class, 'previewStore'])->name('firms.previewstore');
		Route::post('/firm', [FirmController::class, 'store'])->name('firms.store');
		Route::match(['get', 'post'], '/view-customer-applications/{id}', [ApplicationController::class, 'getApplicationDetailByUserId'])->name('customerviewapplication');
		Route::match(['get', 'post'], '/edit-customer-applications/{id}', [ApplicationController::class, 'editApplicationDetailByUserId'])->name('customereditapplication');
		Route::match(['get', 'post'], '/get-district', [ApplicationController::class, 'getDistrict'])->name('getDistrict');
		Route::match(['get', 'post'], '/get-rotc', [ApplicationController::class, 'getRotc'])->name('getDistrict');
		// routes/web.php

	});

	// sub-admin route
	Route::group(['prefix' => 'sub-admin','middleware' => SubAdminMiddleware::class],function(){
		Route::match(['get', 'post'], '/dashboard', [SubAdminlogin::class, 'dashboard'])->name('subadmindashboard');
		Route::match(['get', 'post'], 'export/{status}', [ApplicationController::class, 'export'])->name('candidates.export');
		Route::match(['get', 'post'], '/getApplications/{status}', [ApplicationController::class, 'getApplications'])->name('getApplications');
		Route::match(['get', 'post'], '/viewApplications/{id}', [ApplicationController::class, 'viewApplications'])->name('viewapplication');
		Route::match(['get', 'post'], '/applications', [ApplicationController::class, 'applications'])->name('subadminapplications');
	});


	// admin route
	Route::group(['prefix' => 'admin','middleware' => AdminMiddleware::class],function(){
		Route::match(['get', 'post'], '/dashboard', [AdminLogin::class, 'dashboard'])->name('admindashboard');
		Route::match(['get', 'post'], '/regional-office', [RegionalOfficeController::class, 'getAllRegionalOffice'])->name('getallregionaloffice');
		Route::match(['get', 'post'], '/regional-office-lazy', [RegionalOfficeController::class, 'getAllRegionalOfficeLazy'])->name('getallregionalofficelazy');
		Route::match(['get', 'post'], '/add-regional-office', [RegionalOfficeController::class, 'addRegionalOffice'])->name('addregionaloffice');
		Route::match(['get', 'post'], '/fetch-statewise-data', [AdminLogin::class, 'fetchStateWiseData'])->name('fetch.stateswise.data');
		Route::match(['get', 'post'], '/applications', [ApplicationController::class, 'applications'])->name('adminapplications');
		Route::match(['get', 'post'], '/getApplications/{status}', [ApplicationController::class, 'getApplications'])->name('getApplicationsadmin');
	});

		Route::get('/search-results', [ApplicationController::class, 'searchResults'])->name('search.results');
});

