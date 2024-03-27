<?php

namespace App\Http\Controllers\buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;

class BuyerTransactionController extends ApiController
{

    public function index(Buyer $buyer)
    {
        //Obteniendo las transacciones de un comprador
        $transactions = $buyer->transactions;

        return $this->showAll($transactions);
    }

}
