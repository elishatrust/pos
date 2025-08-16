<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
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

     # Users
     Route::get('user', [UserController::class, 'list'])->name('admin-user');
     Route::get('user-view', [UserController::class, 'listView'])->name('admin-user-view');
     Route::post('user/save', [UserController::class, 'saveUser'])->name('admin-user-save');
     Route::get('user-edit/{id}', [UserController::class, 'editUser'])->name('admin-user-edit');
     Route::get('user-delete/{id}', [UserController::class, 'deleteUser'])->name('admin-user-delete');
     
     # Category
     Route::get('category', [CategoryController::class, 'list'])->name('admin-category');
     Route::get('category-view', [CategoryController::class, 'listView'])->name('admin-category-view');
     Route::post('category/save', [CategoryController::class, 'saveCategory'])->name('admin-category-save');
     Route::get('category-edit/{id}', [CategoryController::class, 'editCategory'])->name('admin-category-edit');
     Route::get('category-delete/{id}', [CategoryController::class, 'deleteCategory'])->name('admin-category-delete');

     ## Supplier
     Route::get('/supplier', [WarehouseController::class, 'list'])->name('admin-supplier');
     Route::get('/supplier-view', [WarehouseController::class, 'listView'])->name('admin-supplier-view');
     Route::post('/supplier/save', [WarehouseController::class, 'saveSupplier'])->name('admin-supplier-save');
     Route::get('/supplier-edit/{id}', [WarehouseController::class, 'editSupplier'])->name('admin-supplier-edit');
     Route::get('/supplier-delete/{id}', [WarehouseController::class, 'deleteSupplier']);

     ## Sales
     Route::get('/sales', [SalesController::class, 'list'])->name('admin-sales');
     Route::get('/sales-view', [SalesController::class, 'listView'])->name('admin-sales-view');
     Route::post('/sales/save', [SalesController::class, 'saveSales'])->name('admin-sales-save');
     Route::get('/sales-edit/{id}', [SalesController::class, 'editSales'])->name('admin-sales-edit');
     Route::get('/sales-delete/{id}', [SalesController::class, 'deleteSales'])->name('admin-sales-delete');
     Route::get('/sales-search_customer/{text}', [UserController::class,'searchCustomer'])->name('admin-sales-search_customer');

     # Product
     Route::get('product', [ProductController::class, 'list'])->name('admin-product');
     Route::get('product-view', [ProductController::class, 'listView'])->name('admin-product-view');
     Route::post('product/save', [ProductController::class, 'saveProduct'])->name('admin-product-save');
     Route::get('product-edit/{id}', [ProductController::class, 'editProduct'])->name('admin-product-edit');
     Route::get('product-delete/{id}', [ProductController::class, 'deleteProduct'])->name('admin-product-delete');

     # Expense
     Route::get('expense', [ExpenseController::class, 'list'])->name('admin-expense');
     Route::get('expense-view', [ExpenseController::class, 'listView'])->name('admin-expense-view');
     Route::post('expense/save', [ExpenseController::class, 'saveExpense'])->name('admin-expense-save');
     Route::get('expense-edit/{id}', [ExpenseController::class, 'editExpense'])->name('admin-expense-edit');
     Route::get('expense-delete/{id}', [ExpenseController::class, 'deleteExpense'])->name('admin-expense-delete');
 
     # Purchase
     Route::get('purchase', [PurchaseController::class, 'list'])->name('admin-purchase');
     Route::get('purchase-view', [PurchaseController::class, 'listView'])->name('admin-purchase-view');
     Route::post('purchase/save', [PurchaseController::class, 'savePurchase'])->name('admin-purchase-save');
     Route::get('purchase-edit/{id}', [PurchaseController::class, 'editPurchase'])->name('admin-purchase-edit');
     Route::get('purchase-delete/{id}', [PurchaseController::class, 'deletePurchase'])->name('admin-purchase-delete');

     # Purchase Details
     Route::get('purchase-details/{id}', [PurchaseController::class, 'purchaseDetails'])->name('admin-purchase-details');
     // Route::get('purchase-details-view', [PurchaseController::class, 'purchaseDetailsView1234'])->name('admin-purchase-details-view');
     Route::post('purchase-details-save', [PurchaseController::class, 'savePurchaseDetails'])->name('admin-purchase-details-save');

});
 


 Route::get('/user_data', [UserController::class, 'userData'])->name('user_data');


Route::group(['middleware'=>'user'], function(){
     Route::get('user/dashboard', [DashboardController::class, 'dashboard'])->name('user-dashboard');

});


## NORMAL USER

## Search Customer
Route::get('/search_product/{text}', [ProductController::class,'searchProduct']);


## Setting
Route::get('/setting', [SettingController::class, 'index'])->name('setting');
Route::post('/setting/save', [SettingController::class,'saveSetting'])->name('setting_save');

## Settings
Route::get('/settings', [SettingController::class,'index'])->name('settings');
Route::get('/settings-data', [SettingController::class, 'getSettings'])->name('settings-data');
Route::put('/update-settings/{id}', [SettingController::class, 'updateSettings']);
