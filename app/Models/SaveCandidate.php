<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaveCandidate extends Model
{
    // use SoftDeletes;
    protected $table = 'save_candidates';
   
    protected $fillable = [
        'candidate_id', 'employer_id', 'created_at', 'updated_at'
    ];



 


}
