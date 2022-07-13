<?php

use App\Http\Controllers\Dashboard\MemberController;
use App\Http\Controllers\Dashboard\MyOrderController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RequestController;
use App\Http\Controllers\Dashboard\ServiceController;
use App\Http\Controllers\Landing\LandingController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });


Route::get('detail_booking/{id}', [LandingController::class, 'detail_booking'])->name('detail.booking.landing');
Route::get('booking/{id}', [LandingController::class, 'booking'])->name('booking.landing');
Route::get('detail/{id}', [LandingController::class, 'detail'])->name('detail.landing');
Route::get('explore', [LandingController::class, 'explore'])->name('explore.landing');
Route::resource('/', LandingController::class);

Route::group(['prefix' => 'member', 'as' => 'member.', 'middleware' => ['auth:sanctum', 'verified']], function(){
    // dashboard
    Route::resource('dashboard', MemberController::class);

    // service
    Route::resource('service', ServiceController::class);

    // request
    Route::get('approve_request/{id}', [RequestController::class, 'approve'])->name('approve.request');
    Route::resource('request',RequestController::class);

    // order
    Route::get('accept/order/{order}', [MyOrderController::class, 'accept'])->name('accept.order');
    Route::get('reject/order/{order}', [MyOrderController::class, 'reject'])->name('reject.order');
    Route::resource('order', MyOrderController::class);

    // profile
    Route::get('delete-photo', [ProfileController::class, 'deletePhoto'])->name('delete.photo.profile');
    Route::resource('profile', ProfileController::class);
});
