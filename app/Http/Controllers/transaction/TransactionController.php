<?php

namespace App\Http\Controllers\transaction;

use App\Http\Controllers\ApiController;
use App\Transaction;

class TransactionController extends ApiController
{
    public function index()
    {
        $transactions = Transaction::all();
        return $this->showAll($transactions);
    }

    public function show(Transaction $transaction)
    {
        return $this->showOne($transaction);
    }

}
