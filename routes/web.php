<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\HomeController as AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\SettingsController;

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

Route::get('/', function () {
    // return view('login');
    return redirect()->route('admin.login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/admin_login', [LoginController::class, 'admin_login'])->name('admin.login');

Route::middleware(['is_admin', 'auth'])->group(function () {

    Route::get('home', [AdminController::class, 'index'])->name('admin.home');
    Route::get('customers', [AdminController::class, 'customers'])->name('admin.customers');

    Route::get('profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('update_profile', [AdminController::class, 'update_profile'])->name('admin.update_profile');

    // Route::get('products', [AdminController::class, 'products'])->name('admin.products');
    // Route::get('add-products', [AdminController::class, 'addproducts'])->name('admin.add-products');
    // Route::get('category', [AdminController::class, 'category'])->name('admin.category');
    // Route::get('add-category', [AdminController::class, 'addcategory'])->name('admin.add-category');
    // Route::get('sub-category', [AdminController::class, 'subcategory'])->name('admin.sub-category');
    // Route::get('add-subcategory', [AdminController::class, 'subcategoryadd'])->name('admin.add-subcategory');

    Route::resource("category", CategoryController::class);
    Route::get("delete_file/{id}", [CategoryController::class, 'delete_file'])->name('cat_file.delete');

    Route::resource("sub_category", SubCategoryController::class);

    Route::resource("product", ProductController::class);
    Route::get("get_category/{id}", [ProductController::class, "get_category"])->name('get_category');
    Route::get("product_file/{id}", [ProductController::class, 'delete_file'])->name('product_file.delete');

    Route::resource("unit", UnitController::class);

    Route::resource("orders", OrderController::class);
    Route::put("update_order", [OrderController::class, 'update_order'])->name('update_order');
    Route::get("pending_orders", [OrderController::class, "pending_orders"])->name("orders.pending");
    Route::get("rejected_orders", [OrderController::class, "rejected_orders"])->name("orders.rejected");
    Route::get("completed_orders", [OrderController::class, "completed_orders"])->name("orders.completed");
    Route::get("order_invoice/{id}", [OrderController::class, "invoice"])->name("order.invoice");

    Route::resource('blog', BlogController::class)->except(['show']);

    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings/update', [SettingsController::class, 'update'])->name('settings.update');

    Route::post('getSuggestion', [SettingsController::class, 'getSuggestion'])->name('getSuggestion');


    Route::get("product_stocks", [ProductController::class, 'product_stocks'])->name('product.stocks');
    Route::post("update_stocks/{id}", [ProductController::class, 'update_stocks'])->name('product.update_stocks');



    Route::get("sliders", [AdminController::class, 'sliders'])->name('admin.sliders');
    Route::get("add_slider", [AdminController::class, 'add_slider'])->name('admin.add_slider');
    Route::post("store_slider", [AdminController::class, 'store_slider'])->name('admin.store_slider');
    Route::get("edit_slider/{id}", [AdminController::class, 'edit_slider'])->name('admin.edit_slider');
    Route::post("update_slider/{id}", [AdminController::class, 'update_slider'])->name('admin.update_slider');
    Route::post("delete_slider/{id}", [AdminController::class, 'delete_slider'])->name('admin.delete_slider');
});
