<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfileView extends Model
{
    // use SoftDeletes;
    protected $table = 'profile_views';
   
    protected $fillable = [
        'candidate_id', 'employer_id', 'created_at', 'updated_at'
    ];



 


}
