<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Buyer;
use App\Product;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'quantity',
        'buyer_id',
        'pruduct_id'
    ];

    protected $dates = ['deleted_at'];

    public function buyer() {
        return $this->belongsTo( Buyer::class );
    }

    public function product() {
        return $this->belongsTo( Product::class );
    }
}
