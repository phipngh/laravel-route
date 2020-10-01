<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catelogy extends Model
{
    protected $fillable = [
        'name'
    ];

    public function product(){
        return $this->hasMany('App\Product');
    }


}
