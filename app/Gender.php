<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    protected $fillable = [
      'object',

    ];

    public function product(){
        return $this->hasMany('App\Product');
    }
}
