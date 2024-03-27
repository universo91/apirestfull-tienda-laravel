<?php

namespace App\Http\Controllers\transaction;

use App\Http\Controllers\ApiController;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionCategoryController extends ApiController
{
    public function index(Transaction $transaction)
    {
        //las transacciones contienen productos, y los productos contienen categorias
        $categories = $transaction->product->categories;

        return $this->showAll($categories);
    }
}
