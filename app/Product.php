<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
      'catelogy_id','gender_id','name','description','price','image',
    ];

    public function catelogy(){
        return $this->belongsTo('App\Catelogy');
    }

    public function gender(){
        return $this->belongsTo('App\Gender');
    }


}
