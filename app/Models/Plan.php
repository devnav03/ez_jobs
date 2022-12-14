<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;
    protected $table = 'plans';
   
    protected $fillable = [
        'name', 'price', 'profile_view', 'description', 'category', 'job_description', 'job_search', 
        'job_branding', 'city', 'duration', 'job_post', 'status', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function validate($inputs, $id = null){
        $rules['name']  = 'required|unique:plans';
        $rules['price'] = 'required';
        $rules['category'] = 'required';

        if($inputs['category']== 1) {
            $rules['description'] = 'required';
        }

        if($inputs['category']== 2) {
            $rules['profile_view'] = 'required';
            $rules['duration'] = 'required';
        }

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


    public function getCategoryService() {
        $result = $this->where('status', 1)->pluck('name', 'id')->toArray();
        return ['' => '-Select Category-'] + $result;
    }

    

    public function getPlan($search = null, $skip, $perPage) {
        $take = ((int)$perPage > 0) ? $perPage : 20;
        $filter = 1; // default filter if no search

        $fields = [
            'id',
            'name',
            'category',
            'price',
            'profile_view',
            'duration',
            'job_post',
            'status',
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
             $keyword = (array_key_exists('keyword', $search)) ?
                 " AND (name LIKE '%" .addslashes(trim($search['keyword'])) . "%')" : "";
             $filter .= $keyword;
         }

         return $this->whereRaw($filter)
                ->orderBy($orderEntity, $orderAction)
                ->skip($skip)->take($take)
                ->get($fields);
    }

  
    public function totalPlan($search = null)
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
