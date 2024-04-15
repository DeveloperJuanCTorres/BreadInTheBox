<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Livewire\ShoppingCart;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Livewire\CreateOrder;
use App\Http\Livewire\PaymentOrder;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\suscriptionController;
use App\Http\Livewire\Suscription;

Route::get('/',[FrontendController::class,'home'])->name('home');
Route::get('/about-us',[FrontendController::class,'about'])->name('about');
Route::get('/contact-us',[FrontendController::class,'contact'])->name('contact');
Route::get('/questions',[FrontendController::class,'questions'])->name('questions');
Route::get('/order-online',[FrontendController::class,'orden'])->name('orden');
Route::get('/monthly-specialty-breads',[FrontendController::class,'monthlySpecialtyBreads'])->name('monthly.specialty');
Route::get('/product/{product}',[ProductController::class,'show'])->name('products.show');
Route::get('/shopping-cart', ShoppingCart::class)->name('shopping-cart');
Route::get('/terms-and-condition',[AdminController::class,'conditions'])->name('conditions');
Route::post('/menssage',[AdminController::class,'menssage'])->name('menssage');
Route::post('/add-pack',[AdminController::class,'addPack'])->name('addPack');

Route::middleware(['auth'])->group(function(){
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/create', CreateOrder::class)->name('orders.create');
    Route::get('orders/{transaction}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('orders/{transaction}/payment', PaymentOrder::class)->name('orders.payment');
    Route::get('orders-thanks/{transaction}', [OrderController::class, 'thanks'])->name('orders.thanks');
    Route::post('topay', [OrderController::class, 'pay'])->name('orders.pay');
    //suscriptions
    Route::get('suscriptions', Suscription::class)->name('suscription.index');
    Route::get('suscriptions/{transaction}', [suscriptionController::class, 'show'])->name('suscription.show');
    Route::get('suscription/{transaction}/edit',[suscriptionController::class,'edit'])->name('suscription.edit');
    Route::get('suscription-create/{product}', [suscriptionController::class, 'create'])->name('suscription.create');
    Route::get('suscription-cart', [suscriptionController::class, 'cart'])->name('suscription.cart');
    Route::post('register-card', [suscriptionController::class, 'registerCard'])->name('register-card');
    Route::post('remove-card',[suscriptionController::class,'removeCard'])->name('removeCard');
    //respuestas
    Route::get('thanks',[suscriptionController::class,'thanks'])->name('thanks');
    Route::get('sorry',[suscriptionController::class,'sorry'])->name('sorry');
});





