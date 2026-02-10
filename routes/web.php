<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\{DashboardController, FrontController};
use App\Http\Controllers\Settings\{UserController, RoleController, AccessController, PermissionController};
use App\Http\Controllers\Custom\{BookController, BookCategoryController, AuthorController, PublisherController, AgencyController, SupplierController, ReceivingController, ReceiverController, IssuanceController, ReportsController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();

Route::get('/signup', [FrontController::class, 'signup'])->name('signup');
Route::post('/submit_registration', [FrontController::class, 'submit_registration'])->name('submit-registration');

Route::group(['middleware' => 'admin'], function (){

    Route::get('/', [FrontController::class, 'home'])->name('home');
    Route::get('/privacy-policy/', [FrontController::class, 'privacy_policy'])->name('privacy-policy');
    Route::post('/contact-us', [FrontController::class, 'contact_us'])->name('contact-us');
    Route::get('/search', [FrontController::class, 'search'])->name('search');

    Route::get('/search-result',[FrontController::class, 'seach_result'])->name('search.result');



    // BOOK MANAGENMENT

    Route::group(['prefix' => 'books', 'as' => 'books.'], function () {
        // BOOKS
        Route::resource('/', BookController::class)->parameters(['' => 'book'])->except(['show']);
        Route::post('/single-delete', [BookController::class, 'single_delete'])->name('single-delete');
        Route::post('/multiple-delete', [BookController::class, 'multiple_delete'])->name('multiple-delete');
        Route::post('/single-restore', [BookController::class, 'single_restore'])->name('single-restore');
        Route::post('/multiple-restore', [BookController::class, 'multiple_restore'])->name('multiple-restore');
        Route::get('info/{info}', [BookController::class, 'show'])->name('show');
        Route::get('stock-card/{id}', [BookController::class, 'stock_card'])->name('stock-card');

        // CATEGORIES
        Route::resource('categories', BookCategoryController::class);
        Route::post('categories/single-delete', [BookCategoryController::class, 'single_delete'])->name('categories.single-delete');
        Route::post('categories/multiple-delete', [BookCategoryController::class, 'multiple_delete'])->name('categories.multiple-delete');
        Route::post('categories/single-restore', [BookCategoryController::class, 'single_restore'])->name('categories.single-restore');
        Route::post('categories/multiple-restore', [BookCategoryController::class, 'multiple_restore'])->name('categories.multiple-restore');

        // AUTHORS
        Route::resource('authors', AuthorController::class);
        Route::post('authors/single-delete', [AuthorController::class, 'single_delete'])->name('authors.single-delete');
        Route::post('authors/multiple-delete', [AuthorController::class, 'multiple_delete'])->name('authors.multiple-delete');
        Route::post('authors/single-restore', [AuthorController::class, 'single_restore'])->name('authors.single-restore');
        Route::post('authors/multiple-restore', [AuthorController::class, 'multiple_restore'])->name('authors.multiple-restore');

        // PUBLISHERS
        Route::resource('publishers', PublisherController::class);
        Route::post('publishers/single-delete', [PublisherController::class, 'single_delete'])->name('publishers.single-delete');
        Route::post('publishers/multiple-delete', [PublisherController::class, 'multiple_delete'])->name('publishers.multiple-delete');
        Route::post('publishers/single-restore', [PublisherController::class, 'single_restore'])->name('publishers.single-restore');
        Route::post('publishers/multiple-restore', [PublisherController::class, 'multiple_restore'])->name('publishers.multiple-restore');

        // AGENCIES
        Route::resource('agencies', AgencyController::class);
        Route::post('agencies/single-delete', [AgencyController::class, 'single_delete'])->name('agencies.single-delete');
        Route::post('agencies/multiple-delete', [AgencyController::class, 'multiple_delete'])->name('agencies.multiple-delete');
        Route::post('agencies/single-restore', [AgencyController::class, 'single_restore'])->name('agencies.single-restore');
        Route::post('agencies/multiple-restore', [AgencyController::class, 'multiple_restore'])->name('agencies.multiple-restore');
    });
    
    

    // RECEIVING

    Route::group(['prefix' => 'receiving', 'as' => 'receiving.'], function () {
        // TRANSACTIONS
        Route::resource('transactions', ReceivingController::class)->except('show');
        Route::post('transactions/single-delete', [ReceivingController::class, 'single_delete'])->name('transactions.single-delete');
        Route::post('transactions/multiple-delete', [ReceivingController::class, 'multiple_delete'])->name('transactions.multiple-delete');
        Route::post('transactions/single-restore', [ReceivingController::class, 'single_restore'])->name('transactions.single-restore');
        Route::post('transactions/multiple-restore', [ReceivingController::class, 'multiple_restore'])->name('transactions.multiple-restore');
        Route::post('transactions/single-post', [ReceivingController::class, 'single_post'])->name('transactions.single-post');
        Route::get('transactions/search-item', [ReceivingController::class, 'search_item'])->name('transactions.search-item');
        Route::get('transactions/show', [ReceivingController::class, 'show'])->name('transactions.show');
        // Route::get('transactions/{transaction}', [ReceivingController::class, 'show'])->name('transactions.show');
        
        // SUPPLIERS
        Route::resource('suppliers', SupplierController::class);
        Route::post('suppliers/single-delete', [SupplierController::class, 'single_delete'])->name('suppliers.single-delete');
        Route::post('suppliers/multiple-delete', [SupplierController::class, 'multiple_delete'])->name('suppliers.multiple-delete');
        Route::post('suppliers/single-restore', [SupplierController::class, 'single_restore'])->name('suppliers.single-restore');
        Route::post('suppliers/multiple-restore', [SupplierController::class, 'multiple_restore'])->name('suppliers.multiple-restore');
    });
    


    // ISSUANCE

    Route::group(['prefix' => 'issuance', 'as' => 'issuance.'], function () {
        // TRANSACTIONS
        Route::resource('transactions', IssuanceController::class)->except('show');
        Route::post('transactions/single-delete', [IssuanceController::class, 'single_delete'])->name('transactions.single-delete');
        Route::post('transactions/multiple-delete', [IssuanceController::class, 'multiple_delete'])->name('transactions.multiple-delete');
        Route::post('transactions/single-restore', [IssuanceController::class, 'single_restore'])->name('transactions.single-restore');
        Route::post('transactions/multiple-restore', [IssuanceController::class, 'multiple_restore'])->name('transactions.multiple-restore');
        Route::post('transactions/single-post', [IssuanceController::class, 'single_post'])->name('transactions.single-post');
        Route::get('transactions/search-item', [IssuanceController::class, 'search_item'])->name('transactions.search-item');
        Route::get('transactions/show', [IssuanceController::class, 'show'])->name('transactions.show');
        // Route::get('transactions/{transaction}', [IssuanceController::class, 'show'])->name('transactions.show');
        
        // RECEIVERS
        Route::resource('receivers', ReceiverController::class);
        Route::post('receivers/single-delete', [ReceiverController::class, 'single_delete'])->name('receivers.single-delete');
        Route::post('receivers/multiple-delete', [ReceiverController::class, 'multiple_delete'])->name('receivers.multiple-delete');
        Route::post('receivers/single-restore', [ReceiverController::class, 'single_restore'])->name('receivers.single-restore');
        Route::post('receivers/multiple-restore', [ReceiverController::class, 'multiple_restore'])->name('receivers.multiple-restore');
    });
    
    

    // ACCOUNTS MANAGENMENT

    Route::group(['prefix' => 'accounts', 'as' => 'accounts.'], function () {
        // USERS
        Route::resource('users', UserController::class);
        Route::post('users/single-delete', [UserController::class, 'single_delete'])->name('users.single-delete');
        Route::post('users/multiple-delete', [UserController::class, 'multiple_delete'])->name('users.multiple-delete');
        Route::post('users/single-restore', [UserController::class, 'single_restore'])->name('users.single-restore');
        Route::post('users/multiple-restore', [UserController::class, 'multiple_restore'])->name('users.multiple-restore');

        Route::get('user/edit-profile', [UserController::class, 'edit_profile'])->name('users.edit-profile');
        Route::post('user/update-profile', [UserController::class, 'update_profile'])->name('users.update-profile');
        Route::post('user/update-email', [UserController::class, 'update_email'])->name('users.update-email');
        Route::post('user/update-password', [UserController::class, 'update_password'])->name('users.update-password');
        Route::post('user/update-avatar', [UserController::class, 'update_avatar'])->name('users.update-avatar');
        
        // ROLES
        Route::resource('roles', RoleController::class);
        Route::post('roles/single-delete', [RoleController::class, 'single_delete'])->name('roles.single-delete');
        Route::post('roles/multiple-delete', [RoleController::class, 'multiple_delete'])->name('roles.multiple-delete');
        Route::post('roles/single-restore', [RoleController::class, 'single_restore'])->name('roles.single-restore');
        Route::post('roles/multiple-restore', [RoleController::class, 'multiple_restore'])->name('roles.multiple-restore');

        // ACCESS
        Route::resource('/access', AccessController::class);
        Route::post('/roles_and_permissions/update', [AccessController::class, 'update_roles_and_permissions'])->name('role-permission.update');

        // PERMISSION
        if (env('APP_DEBUG') == "true") {
            Route::resource('/permissions', PermissionController::class)->except(['destroy']);
            Route::post('permission/single-delete', [PermissionController::class, 'single_delete'])->name('permissions.single-delete');
            Route::post('permission/multiple-delete', [PermissionController::class, 'multiple_delete'])->name('permissions.multiple-delete');
            Route::post('permission/single-restore', [PermissionController::class, 'single_restore'])->name('permissions.single-restore');
            Route::post('permission/multiple-restore', [PermissionController::class, 'multiple_restore'])->name('permissions.multiple-restore');
            // Route::get('/permission-search/', [PermissionController::class, 'search'])->name('permission.search');
            // Route::post('/permission/destroy', [PermissionController::class, 'destroy'])->name('permission.destroy');
            // Route::get('/permission/restore/{id}', [PermissionController::class, 'restore'])->name('permission.restore');
            // Route::post('permission/delete', [PermissionController::class, 'delete'])->name('permission.delete');
        }
    });

    

    // REPORTS

    Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {
        
        Route::get('issuance', [ReportsController::class, 'issuance'])->name('issuance');
        Route::get('receiving', [ReportsController::class, 'receiving'])->name('receiving');
        Route::get('stock-card', [ReportsController::class, 'stock_card'])->name('stock-card');
        // Route::get('stock-card/{id}', [ReportsController::class, 'stock_card'])->name('stock-card');
        Route::get('inventory', [ReportsController::class, 'inventory'])->name('inventory');
        Route::get('users', [ReportsController::class, 'users'])->name('users');
        Route::get('audit-trail', [ReportsController::class, 'audit_trail'])->name('audit-trail');
        Route::get('books', [ReportsController::class, 'books'])->name('books');
    });

});