<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;



Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('welcome');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/reset-password', [LoginController::class, 'resetPassword'])->name('reset-password');
Route::get('/profile', [LoginController::class, 'profile'])->name('profile');


## Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

## User
Route::get('/user_role', [UserController::class, 'userRole'])->name('user_role');
Route::get('/user', [UserController::class, 'list'])->name('user');
Route::get('/user-view', [UserController::class, 'listView'])->name('user_view');
Route::post('/user/save', [UserController::class, 'saveUser'])->name('user_save');
Route::get('/user_edit/{id}', [UserController::class, 'editUser']);
Route::get('/user_delete/{id}', [UserController::class, 'deleteUser']);

## Category
Route::get('/category', [CategoryController::class, 'list'])->name('category');
Route::get('/category-view', [CategoryController::class, 'listView'])->name('category_view');
Route::post('/category/save', [CategoryController::class, 'saveCategory'])->name('category_save');
Route::get('/category_edit/{id}', [CategoryController::class, 'editCategory']);
Route::get('/category_delete/{id}', [CategoryController::class, 'deleteCategory']);

## Warehouse
Route::get('/warehouse', [WarehouseController::class, 'list'])->name('warehouse');
Route::get('/warehouse-view', [WarehouseController::class, 'listView'])->name('warehouse_view');
Route::post('/warehouse/save', [WarehouseController::class, 'saveWarehouse'])->name('warehouse_save');
Route::get('/warehouse_edit/{id}', [WarehouseController::class, 'editWarehouse']);
Route::get('/warehouse_delete/{id}', [WarehouseController::class, 'deleteWarehouse']);

## Product
Route::get('/product', [ProductController::class, 'list'])->name('product');
Route::get('/product-view', [ProductController::class, 'listView'])->name('product_view');
Route::post('/product/save', [ProductController::class, 'saveProduct'])->name('product_save');
Route::get('/product_edit/{id}', [ProductController::class, 'editProduct']);
Route::get('/product_delete/{id}', [ProductController::class, 'deleteProduct']);

## Settings
Route::get('/settings', [SettingController::class,'index'])->name('settings');
Route::get('/settings-data', [SettingController::class, 'getSettings'])->name('settings-data');
Route::put('/update-settings/{id}', [SettingController::class, 'updateSettings']);