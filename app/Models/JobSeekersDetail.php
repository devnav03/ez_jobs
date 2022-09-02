<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobSeekersDetail extends Model
{
    use SoftDeletes;
    protected $table = 'job_seekers_details';
   
    protected $fillable = [
        'seeker_id', 'category', 'sub_category', 'designation_id', 'education', 'experience_years', 
        'experience_months', 'key_skills', 'salary_lakhs', 'salary_thousands', 'resume', 'resume_builder', 
        'created_at', 'updated_at', 'deleted_at'
    ];




























}