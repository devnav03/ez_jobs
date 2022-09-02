<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'user_type', 'name', 'employer_name', 'profile_view_limit', 'job_post_limit', 'profile_completion', 'email', 'password', 'state', 'city', 'country', 'mobile' , 'profile_image', 'gender', 'date_of_birth', 'job_description', 'job_search', 'job_branding', 'city_plan', 'address', 'is_verify', 'status', 'updated_at', 'deleted_at', 'created_at'
    ];

  
    public function validate_front($inputs, $id = null) {
        $rules['name'] = 'required|string|max:100|regex:/^[a-zA-Z ]+$/';
        $rules['email'] = 'required|email|max:100|unique:users';
        $rules['mobile'] = 'required|unique:users';
        $rules['role'] = 'required';
        if($inputs['role']== 3) {
            $rules['gender'] = 'required';
        }
        $rules['password'] = 'required|min:6';
        $rules['confirm_password'] = 'required|same:password';
        $rules['date_of_birth'] = 'required';
        $rules['address'] = 'required';
        $rules['country'] = 'required';
        $rules['city'] = 'required';
        $rules['state'] = 'required';
        $rules['profile_image'] = 'required';

        return \Validator::make($inputs, $rules);
    }

    public function validate_employer_profile_update($inputs){

        $rules['video'] = 'max:50240';
        $rules['employer_name'] = 'required';
        $rules['vacancy'] = 'required';
        return \Validator::make($inputs, $rules);
    }

    public function validate($inputs, $id = null) {
        $rules['name'] = 'required|string|max:100|regex:/^[a-zA-Z ]+$/';
        $rules['email'] = 'required|email|max:100|unique:users';
        $rules['mobile'] = 'required|digits:10|unique:users';
        $rules['password'] = 'required|min:6';
        $rules['user_type'] = 'required';
        $rules['company_id'] = 'required';
 
        return \Validator::make($inputs, $rules);
    }

    public function validatePassword($inputs, $id = null){   
        $rules['password']          = 'required';
        $rules['new_password']      = 'required|same:confirm_password|min:6';
        $rules['confirm_password']  = 'required';
        return \Validator::make($inputs, $rules);
    }

    public function validateLoginUser($inputs, $id = null)
    {
        $rules['email'] = 'required';
        $rules['password'] = 'required';
        return \Validator::make($inputs, $rules);
    }


    public function store($input, $id = null)
    {
        if ($id) {
            return $this->find($id)->update($input);
        } else {
            return $this->create($input)->id;
        }
    } 


    public function getCustomer($search = null, $skip, $perPage) {
         $take = ((int)$perPage > 0) ? $perPage : 20;
         $filter = 1; // default filter if no search
         $fields = [
                'id',
                'name',
                'email',
                'user_type', 
                'mobile', 
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
            $f1 = (array_key_exists('email', $search)) ? " AND (users.email Like '%" .
                addslashes($search['email']) . "%')" : "";
              
            $f2 = (array_key_exists('mobile', $search)) ? " AND (users.mobile Like '%" .
                addslashes($search['mobile']) . "%')" : "";

            $f3 = (array_key_exists('status', $search)) ? " AND (users.status = '" .
                addslashes($search['status']) . "')" : "";
           $f4 = (array_key_exists('name', $search)) ? " AND (users.name LIKE '%" .
                addslashes(trim($search['name'])) . "%')" : "";  
            $filter .= $f1 . $f2 . $f3 . $f4;
        }
         return $this
             ->whereRaw($filter)
             ->where('user_type', 3)
             ->orderBy($orderEntity, $orderAction)
             ->skip($skip)->take($take)->get($fields);
    }

     public function getEmployer($search = null, $skip, $perPage) {
         $take = ((int)$perPage > 0) ? $perPage : 20;
         $filter = 1; // default filter if no search
         $fields = [
                'id',
                'name',
                'email',
                'user_type', 
                'employer_name', 
                'mobile',  
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
            $f1 = (array_key_exists('employer_name', $search)) ? " AND (users.employer_name Like '%" .
                addslashes($search['employer_name']) . "%')" : "";
              
            $f2 = (array_key_exists('mobile', $search)) ? " AND (users.mobile Like '%" .
                addslashes($search['mobile']) . "%')" : "";

            $f3 = (array_key_exists('status', $search)) ? " AND (users.status = '" .
                addslashes($search['status']) . "')" : "";
           $f4 = (array_key_exists('name', $search)) ? " AND (users.name LIKE '%" .
                addslashes(trim($search['name'])) . "%')" : "";  
            $filter .= $f1 . $f2 . $f3 . $f4;
        }

         return $this
             ->whereRaw($filter)
             ->where('user_type', 2)
             ->orderBy($orderEntity, $orderAction)
             ->skip($skip)->take($take)->get($fields);
    }


    public function totalCustomer($search = null)
     {
         $filter = 1; // if no search add where

         // when search
         if (is_array($search) && count($search) > 0) {
             $partyName = (array_key_exists('keyword', $search)) ? " AND name LIKE '%" .
                 addslashes(trim($search['keyword'])) . "%' " : "";
             $filter .= $partyName;
         }
         return $this->select(\DB::raw('count(*) as total'))
                    ->where('user_type', 3)
                    ->whereRaw($filter)
                    ->first();
    }
    
    public function totalEmployer($search = null){
         $filter = 1; // if no search add where

         // when search
         if (is_array($search) && count($search) > 0) {
             $partyName = (array_key_exists('keyword', $search)) ? " AND name LIKE '%" .
                 addslashes(trim($search['keyword'])) . "%' " : "";
             $filter .= $partyName;
         }
         return $this->select(\DB::raw('count(*) as total'))
                    ->where('user_type', 2)
                    ->whereRaw($filter)
                    ->first();
    }


    public function updatePassword($password){
        return $this->where('id', authUserId())->update(['password' => $password]);
    } 
 



}
