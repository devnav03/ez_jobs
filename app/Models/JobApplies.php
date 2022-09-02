<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplies extends Model
{
    use SoftDeletes;
    protected $table = 'job_applies';
   
    protected $fillable = [
        'job_id', 'user_id', 'employer_id', 'created_at', 'updated_at', 'deleted_at'
    ];








}
