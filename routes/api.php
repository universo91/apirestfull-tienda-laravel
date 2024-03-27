<?php

use App\Http\Controllers\buyer\BuyerSellerController;
use App\Http\Controllers\transaction\TransactionCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Con una sola linea, cramos 7 rutas.
// Por medio del tercer parametro, indicaremos algunos filtros, donde le diremos que solo solo se creen rutas para los metodos
// index y show, es decir que el vendedor(buyer) solo tenga acceso al index y show.
Route::resource('buyers', 'buyer\BuyerController', ['only' => ['index', 'show']]);
Route::resource('buyers.transactions', 'buyer\BuyerTransactionController', ['only' => ['index']]);
Route::resource('buyers.products', 'buyer\BuyerProductController', ['only' => ['index']]);
Route::resource('buyers.sellers', 'buyer\BuyerSellerController', ['only' => ['index']]);
Route::resource('buyers.categories', 'buyer\BuyerCategoryController', ['only' => ['index']]);

//Categories
Route::resource('categories', 'category\CategoryController', ['except' => ['create', 'edit']]);
Route::resource('categories.products', 'category\CategoryController', ['except' => ['index']]);
Route::resource('categories.sellers', 'category\CategorySellerController', ['only' => ['index']]);
Route::resource('categories.transactions', 'category\CategoryTransactionController', ['only' => ['index']]);
Route::resource('categories.buyers', 'category\CategoryBuyerController', ['only' => ['index']]);

//Products
Route::resource('products', 'product\ProductController', ['only' => ['index', 'show']]);

//Transactions
Route::resource('transactions', 'transaction\TransactionController', ['only' => ['index', 'show']]);
Route::resource('transactions.categories', 'transaction\TransactionCategoryController', ['only' => ['index', 'show']]);
Route::resource('transactions.sellers', 'transaction\TransactionSellerController', ['only' => ['index']]);

//Sellers
Route::resource('sellers', 'seller\SellerController', ['only' => ['index', 'show']]);
Route::resource('sellers.transactions', 'seller\SellerTransactionController', ['only' => ['index']]);
Route::resource('sellers.categories', 'seller\SellerCategoryController', ['only' => ['index']]);
Route::resource('sellers.buyers', 'seller\SellerBuyerController', ['only' => ['index']]);
Route::resource('sellers.products', 'seller\SellerProductController', ['except' => ['create','edit', 'show']]);

//Users
Route::resource('users', 'user\UserController', ['except' => ['create', 'edit']]);
