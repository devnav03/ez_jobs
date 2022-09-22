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

        // if (is_array($search) && count($search) > 0) {
        //     $keyword = (array_key_exists('keyword', $search)) ?
        //         " AND (users.employer_name LIKE '%" .addslashes(trim($search['keyword'])) . "%')" : "";
        //     $filter .= $keyword;
        // }

        if(isset($search['status'])){
            if($search['status'] == 2){
                unset($search['status']);
                $search['status'] = 0;
            }
        }

        if(isset($search['from'])){
            $search['from'] = date('Y-m-d H:i:s', strtotime($search['from']));
        }

        if(isset($search['to'])){
            $search['to'] = date('Y-m-d H:i:s', strtotime($search['to']));
            $search['to'] = date('Y-m-d H:i:s', strtotime($search['to'] . ' +1 day'));
        }

        if (is_array($search) && count($search) > 0) {
            $f1 = (array_key_exists('plan_id', $search)) ? " AND (billings.plan_id = '" .
                addslashes($search['plan_id']) . "')" : "";

            $f5 = (array_key_exists('employer', $search)) ? " AND (billings.user_id = '" .
                addslashes($search['employer']) . "')" : "";    
              

            $f2 = (array_key_exists('from', $search)) ? " AND (billings.created_at >= '" .
                addslashes($search['from']) . "')" : "";  


            $f3 = (array_key_exists('status', $search)) ? " AND (billings.status = '" .
                addslashes($search['status']) . "')" : "";

           $f4 =  (array_key_exists('to', $search)) ? " AND (billings.created_at <= '" .
                addslashes($search['to']) . "')" : ""; 
            $filter .= $f1 . $f2 . $f3 . $f4 . $f5;
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
