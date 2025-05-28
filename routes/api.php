<?php

use App\Http\Controllers\AddressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\UnitController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('forgotPassword', [ApiController::class, 'forgotPwd']);

Route::post('confirmOTP', [ApiController::class, 'checkOTP']);
Route::post('updatePassword', [ApiController::class, 'updatePwd']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("units", [UnitController::class, 'getUnits'])->name('get_units');

Route::get('categories', [ApiController::class, 'categories']);
Route::get("sub_categories/{slug}", [ApiController::class, 'sub_categories']);

Route::get('search', [ApiController::class, 'search']);

Route::get("top_categories", [ApiController::class, 'top_categories']);
Route::get("category_products", [ApiController::class, 'category_products']);
Route::get("unique_units", [ApiController::class, 'uniqueUnits']);
Route::get("products", [ApiController::class, 'products']);
Route::get("products/{id}", [ApiController::class, 'productById']);
Route::get("related_products/{product}", [ApiController::class, 'relatedProducts']);
Route::get("featured_products", [ApiController::class, 'featured_products']);
Route::get("best_sellers", [ApiController::class, 'best_sellers']);
Route::get("deal-of-week", [ApiController::class, 'dealOfWeek']);
Route::get("latest_blog", [ApiController::class, "latestBlog"]);

Route::post('contact', [ApiController::class, 'contact']);

Route::post('send_message', [ApiController::class, 'send_message']);

Route::post('login', [UserAuthController::class, 'login']);
Route::post('register', [UserAuthController::class, 'register']);
Route::post('forgot-password', [UserAuthController::class, 'forgotPassword']);
Route::post('masterLogin', [ApiController::class, 'masterLogin']);
Route::post('addAdmin', [ApiController::class, 'addAdmin']);
// Route::post('reset-password', [UserAuthController::class, 'resetPassword']);

Route::post('sliders', [ApiController::class, 'sliders']);
Route::post('setting', [ApiController::class, 'setting']);

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::post('me', [UserAuthController::class, 'me']);
    Route::post('address', [AddressController::class, 'store']);
    Route::post('address/{address}', [AddressController::class, 'update']);
    Route::post('addresses', [AddressController::class, 'addresses']);
    Route::post('get_address', [AddressController::class, 'show']);
    Route::post('delete_address/{address}', [AddressController::class, 'destroy']);
    Route::post('make_default/{address}', [AddressController::class, 'makeDefault']);
    Route::post('profile_update/{id?}', [ApiController::class, 'profile_update']);
    Route::post('userImageUpdate', [ApiController::class, 'userImageUpdate']);

    Route::post('order', [ApiController::class, 'storeOrder']);
    Route::post('get-orders', [ApiController::class, 'getOrders']);
    Route::post('order-details/{order_id}', [ApiController::class, 'orderDetails']);
});
