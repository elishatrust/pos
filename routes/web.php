<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;



Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('welcome');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/reset-password', [LoginController::class, 'resetPassword'])->name('reset-password');
Route::get('/profile', [LoginController::class, 'profile'])->name('profile');


# FOR SUPER USER
Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {

     # Dashboard
     Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('admin-dashboard');
     
     # Category
     Route::get('category', [CategoryController::class, 'list'])->name('admin-category');
     Route::get('category-view', [CategoryController::class, 'listView'])->name('admin-category-view');
     Route::post('category/save', [CategoryController::class, 'saveCategory'])->name('admin-category-save');
     Route::get('category-edit/{id}', [CategoryController::class, 'editCategory'])->name('admin-category-edit');
     Route::get('category-delete/{id}', [CategoryController::class, 'deleteCategory'])->name('admin-category-delete');

     # Product
     Route::get('product', [ProductController::class, 'list'])->name('admin-product');
     Route::get('product-view', [ProductController::class, 'listView'])->name('admin-product-view');
     Route::post('product/save', [ProductController::class, 'saveProduct'])->name('admin-product-save');
     Route::get('product-edit/{id}', [ProductController::class, 'editProduct'])->name('admin-product-edit');
     Route::get('product-delete/{id}', [ProductController::class, 'deleteProduct'])->name('admin-product-delete');

     # Users
     Route::get('user', [UserController::class, 'list'])->name('admin-user');
     Route::get('user-view', [UserController::class, 'listView'])->name('admin-user-view');
     Route::post('user/save', [UserController::class, 'saveUser'])->name('admin-user-save');
     Route::get('user-edit/{id}', [UserController::class, 'editUser'])->name('admin-user-edit');
     Route::get('user-delete/{id}', [UserController::class, 'deleteUser'])->name('admin-user-delete');
 });
 


 Route::get('/user_data', [UserController::class, 'userData'])->name('user_data');


Route::group(['middleware'=>'user'], function(){
     Route::get('user/dashboard', [DashboardController::class, 'dashboard'])->name('user-dashboard');

});


## NORMAL USER

## Search Customer
Route::get('/search_customer/{text}', [UserController::class,'searchCustomer']);
Route::get('/search_product/{text}', [ProductController::class,'searchProduct']);


## Setting
Route::get('/setting', [SettingController::class, 'index'])->name('setting');
Route::post('/setting/save', [SettingController::class,'saveSetting'])->name('setting_save');

## Category
// Route::get('/category', [CategoryController::class, 'list'])->name('category');
// Route::get('/category-view', [CategoryController::class, 'listView'])->name('category_view');
// Route::post('/category/save', [CategoryController::class, 'saveCategory'])->name('category_save');
// Route::get('/category_edit/{id}', [CategoryController::class, 'editCategory']);
// Route::get('/category_delete/{id}', [CategoryController::class, 'deleteCategory']);

## Warehouse
Route::get('/warehouse', [WarehouseController::class, 'list'])->name('warehouse');
Route::get('/warehouse-view', [WarehouseController::class, 'listView'])->name('warehouse_view');
Route::post('/warehouse/save', [WarehouseController::class, 'saveWarehouse'])->name('warehouse_save');
Route::get('/warehouse_edit/{id}', [WarehouseController::class, 'editWarehouse']);
Route::get('/warehouse_delete/{id}', [WarehouseController::class, 'deleteWarehouse']);


## Sales
Route::get('/sales', [SalesController::class, 'list'])->name('sales');
Route::get('/sales-view', [SalesController::class, 'listView'])->name('sales_view');
Route::post('/save-sales', [SalesController::class, 'saveSales'])->name('save_sales');






## Settings
Route::get('/settings', [SettingController::class,'index'])->name('settings');
Route::get('/settings-data', [SettingController::class, 'getSettings'])->name('settings-data');
Route::put('/update-settings/{id}', [SettingController::class, 'updateSettings']);
