<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestFactory extends Model
{
    protected $fillable = [
      'name','address',
    ];
}
