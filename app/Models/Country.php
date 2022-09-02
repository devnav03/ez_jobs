<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
   
    protected $table = 'countries';
   
    protected $fillable = [
       'phone_code', 'country_code', 'country_name'
    ];

   


}
