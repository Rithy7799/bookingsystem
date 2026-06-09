<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingandContactController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Models\Booking;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportsExportController;
use App\Http\Controllers\TrainsectionController;

Route::get('/testform', function(){
    return view('Frontend.testform');
});

Route::post('/store-test',[BookingController::class,'store_test']);

Route::get('/', [BookingController::class, 'FormRegister'])->name('form');
Route::post('/Store', [BookingController::class, 'Store'])->name('store.booking');
Route::get('/alert', [BookingController::class,'alert'])->name('alert.register');


Route::get('/Login', [AuthController::class, 'FormLogin'])->name('login');
Route::post('/LoginTo', [AuthController::class, 'Login'])->name('loginprocess');

Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('User')->group(function () {
            Route::get('/List', [UserController::class, 'List'])->name('list.user');
            Route::get('/Create', [UserController::class, 'Create'])->name('create.user');
            Route::post('/Store', [UserController::class, 'Store'])->name('store.user');
            Route::delete('/Delete/{id}', [UserController::class, 'delete'])->name('delete.user');
        });


        Route::get('/Admin', [IndexController::class, 'Dashboard'])->name('dashboard');
        Route::post('/filter-data', [IndexController::class, 'filterData'])->name('filter.data');

        Route::prefix('Customer')->group(function () {
            Route::get('/List', [CustomerController::class, 'List'])->name('list.customer');
            Route::get('/Create', [CustomerController::class, 'Create'])->name('create.customer');
            Route::post('/Store', [CustomerController::class, 'Store'])->name('store.customer');
            Route::get('/FormUpdate', [CustomerController::class, 'UpdateForm'])->name('formupdate.customer');
            Route::post('/Update', [CustomerController::class, 'Update'])->name('update.customer');
            Route::get('/View/{id}', [CustomerController::class, 'View'])->name('view.customer');
        });

        Route::prefix('Service')->group(function () {
            Route::get('/List', [ServiceController::class, 'List'])->name('list.service');
            Route::get('/Create', [ServiceController::class, 'Create'])->name('create.service');
            Route::post('/Store', [ServiceController::class, 'Store'])->name('store.service');
            Route::get('/FormUpdate/{id}', [ServiceController::class, 'FormUpdate'])->name('formupdate.service');
            Route::post('/Update/{id}', [ServiceController::class, 'Update'])->name('update.service');
            Route::delete('/Delete/{id}', [ServiceController::class, 'Delete'])->name('delete.service');
        });

        Route::prefix('Booking')->group(function () {
            Route::get('/List', [BookingController::class, 'List'])->name('list.booking');
            Route::get('/Create', [BookingController::class, 'Create'])->name('create.booking');
            Route::get('/FormUpdate/{id}', [BookingController::class, 'FormUpdate'])->name('formupdate.booking');
            Route::put('/Update/{id}', [BookingController::class, 'Update'])->name('update.booking');
            Route::get('/View/{id}', [BookingController::class, 'View'])->name('view.booking');
            Route::get('/Delete/{id}',[BookingController::class,'delete'])->name('delete.booking');

        });

        Route::prefix('Product')->group(function () {
            Route::get('/list', [ProductController::class, 'list'])->name('list.product');
            Route::get('/add', [ProductController::class, 'add'])->name('add.product');
            Route::post('/store', [ProductController::class, 'store'])->name('store.product');
            Route::get('Product/Select/{product}', [ProductController::class, 'select'])->name('select.product');
            Route::put('Product/Update/{product}', [ProductController::class, 'update'])->name('update.product');
            Route::get('/View/{id}', [ProductController::class, 'View'])->name('view.product');
            Route::delete('/products/{product}', [ProductController::class, 'delete'])->name('delete.product'); 

        });

        Route::prefix('BookingandContact')->group(function(){
            Route::get('/list',[BookingandContactController::class, 'list'])->name('bookingandcontact.list');
            Route::get('/add',[BookingandContactController::class, 'add'])->name('bookingandcontact.add');
            Route::post('/store',[BookingandContactController::class, 'store'])->name('bookingandcontact.store');
            Route::get('/select/{id}',[BookingandContactController::class, 'select'])->name('bookingandcontact.select');
            Route::post('/update',[BookingandContactController::class, 'update'])->name('bookingandcontact.update');
            Route::delete('/delete',[BookingandContactController::class, 'delete'])->name('bookingandcontact.delete');

        });

        Route::prefix('Branch')->group(function () {
            Route::get('/List', [BranchController::class, 'List'])->name('list.branch');
            Route::get('/Create', [BranchController::class, 'Create'])->name('create.branch');
            Route::post('/Store', [BranchController::class, 'Store'])->name('store.branch');
            Route::get('/FormUpdate/{id}', [BranchController::class, 'FormUpdate'])->name('formupdate.branch');
            Route::post('/Update/{id}', [BranchController::class, 'Update'])->name('update.branch');
            Route::delete('/Delete/{id}', [BranchController::class, 'Delete'])->name('delete.branch');
        });

            Route::get('/Report', [ReportController::class, 'Report'])->name('reports.index');
            Route::get('/Export',[ReportsExportController::class, 'Export'])->name('reports.export');
            Route::get('/PrintReport',[ReportController::class, 'Print'])->name('print.report');
            Route::get('/Logout', [AuthController::class, 'Logout'])->name('logout');
});
