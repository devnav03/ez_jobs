<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Billing extends Model
{
    use SoftDeletes;
    protected $table = 'billings';
   
    protected $fillable = [
        'billing_id', 'user_id', 'plan_id', 'quantity', 'price', 'status', 'transaction_id', 'created_at', 'updated_at', 'deleted_at'
    ];



    

    public function getBilling($search = null, $skip, $perPage)
    {
         $take = ((int)$perPage > 0) ? $perPage : 20;
         $filter = 1; // default filter if no search

         $fields = [
            'users.id as user_id',
            'users.employer_name',
            'users.name',
            'billings.id',
            'billings.price',
            'billings.transaction_id',
            'billings.created_at',
            'billings.status',
            'billings.quantity',
            'plans.name as plan',
            'plans.category'

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
                 " AND (users.employer_name LIKE '%" .addslashes(trim($search['keyword'])) . "%')" : "";
             $filter .= $keyword;
         }

         return $this->join('users', 'users.id', '=', 'billings.user_id')
                ->join('plans', 'plans.id', '=', 'billings.plan_id')
                ->whereRaw($filter)
                ->orderBy($orderEntity, $orderAction)
                ->skip($skip)->take($take)
                ->get($fields);
    }

  
    public function totalBilling($search = null)
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
