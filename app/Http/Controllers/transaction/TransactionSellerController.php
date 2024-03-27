<?php

namespace App\Http\Controllers\transaction;

use App\Http\Controllers\ApiController;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionSellerController extends ApiController
{
    public function index(Transaction $transaction)
    {
        //obtener el vendedor de una transaccion
        $seller = $transaction->product->seller;

        return $this->showOne($seller);
    }

}
