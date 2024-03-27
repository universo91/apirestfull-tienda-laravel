<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    //Implementamos el trait SoftDeletes
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];

    protected $dates = ['deleted_at'];

    protected $hidden = ['pivot'];

    public function products() {
        return $this->belongsToMany( Product::class );
    }
}
