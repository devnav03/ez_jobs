<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use SoftDeletes;
    protected $table = 'jobs';
   
    protected $fillable = [
        'employer_id', 'title', 'category_id', 'number_of_positions', 'sub_category', 'state_id', 'city_id', 'salary', 'job_type', 'qualifications', 'experience_to', 'experience_from', 'job_description', 'status', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function validate($inputs, $id = null){

        $rules['title']  = 'required|max:255';
        $rules['category_id'] = 'required';
        $rules['sub_category'] = 'required';
        $rules['state_id'] = 'required';
        $rules['city_id'] = 'required';
        $rules['salary']  = 'required|max:255';
        $rules['job_type'] = 'required|max:255';
        $rules['number_of_positions'] = 'required|max:255';
        $rules['qualifications'] = 'required|max:255';
        $rules['job_description'] = 'required';

        return \Validator::make($inputs, $rules);
    }

    public function validateEdit($inputs, $id = null) {
        $rules['id'] = 'required';
        return \Validator::make($inputs, $rules);
    }


    public function store($inputs, $id = null)
    {
       // dd($inputs);
        if ($id) {
            return $this->find($id)->update($inputs);
        } else {
            return $this->create($inputs)->id;
        }
    }

    

    public function getJobs($search = null, $skip, $perPage) {
         $take = ((int)$perPage > 0) ? $perPage : 20;
         $filter = 1; // default filter if no search

         $fields = [
            'jobs.id',
            'jobs.title',
            'jobs.salary',
            'jobs.job_type',
            'jobs.created_at',
            'jobs.status',
            'c2.name as sub_cat',
            'categories.name as cat',
            'educations.name as education',
            'users.employer_name',
            'users.profile_image',

         ];

         $sortBy = [
             'name' => 'name',
         ];

         $orderEntity = 'id';
         $orderAction = 'desc';
         if (isset($search['sort_action']) && $search['sort_action'] != "") {
             $orderAction = ($search['sort_action'] == 1) ? 'desc' : 'asc';
         }

         if (isset($search['sort_entity']) && $search['sort_entity'] != "") {
             $orderEntity = (array_key_exists($search['sort_entity'], $sortBy)) ? $sortBy[$search['sort_entity']] : $orderEntity;
         }

        if (is_array($search) && count($search) > 0) {
            $f1 = (array_key_exists('title', $search)) ? " AND (jobs.title Like '%" .
                addslashes($search['title']) . "%')" : "";
              
            $f2 = (array_key_exists('category_id', $search)) ? " AND (jobs.category_id = '" .
                addslashes($search['category_id']) . "')" : "";

            $f3 = (array_key_exists('sub_category', $search)) ? " AND (jobs.sub_category = '" .
                addslashes($search['sub_category']) . "')" : "";

            $f4 = (array_key_exists('state_id', $search)) ? " AND (jobs.state_id = '" .
                addslashes(trim($search['state_id'])) . "')" : "";
            
            $f5 = (array_key_exists('city_id', $search)) ? " AND (jobs.city_id = '" .
                addslashes(trim($search['city_id'])) . "')" : "";

            $f6 = (array_key_exists('qualifications', $search)) ? " AND (jobs.qualifications = '" .
                addslashes(trim($search['qualifications'])) . "')" : "";
            
            $f7 = (array_key_exists('employer_id', $search)) ? " AND (jobs.employer_id = '" .
                addslashes(trim($search['employer_id'])) . "')" : "";

            $filter .= $f1 . $f2 . $f3 . $f4 . $f5 . $f6 . $f7;
        }


        return $this->leftjoin('categories as c2', 'jobs.sub_category' ,'=', 'c2.id')
            ->leftjoin('categories', 'jobs.category_id' ,'=', 'categories.id')
            ->leftjoin('educations', 'jobs.qualifications' ,'=', 'educations.id')
            ->leftjoin('users', 'jobs.employer_id', '=', 'users.id')
            ->whereRaw($filter)
            ->orderBy($orderEntity, $orderAction)
            ->skip($skip)->take($take)
            ->get($fields);
    }

  
    public function totalJobs($search = null)
    {
         $filter = 1; // if no search add where

         // when search
         if (is_array($search) && count($search) > 0) {
             $partyName = (array_key_exists('keyword', $search)) ? " AND name LIKE '%" .
                 addslashes(trim($search['keyword'])) . "%' " : "";
             $filter .= $partyName;
         }
         return $this->select(\DB::raw('count(*) as total'))
             ->whereRaw($filter)->first();
     }

    public function tempDelete($id)
    {
        $this->find($id)->update([ 'deleted_by' => authUserId(), 'deleted_at' => convertToUtc()]);
    }


}
