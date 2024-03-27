<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\ApiController;
use App\Seller;
use App\Transaction;

class SellerTransactionController extends ApiController
{
    public function index(Seller $seller)
    {
        $transactions = Transaction::select('transactions.*')
            ->join('products', 'transactions.product_id', '=', 'products.id')
            ->join('users', 'products.seller_id', '=', 'users.id')
            ->where('users.id', $seller->id)
            ->get();

    /* $transactions = $seller->products()
        ->whereHas('transactions')
        ->with('transactions')
        ->get()
        ->pluck('transactions')
        ->collapse(); */

        return $this->showAll( $transactions );
    }
}
