<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model {
    use SoftDeletes;
    protected $table = 'messages';
   
    protected $fillable = [
        'user_id', 'from_id', 'message', 'seen', 'created_at', 'sent', 'updated_at', 'deleted_at'
    ];

    public function validate($inputs, $id = null){
        $rules['message'] = 'required';
        return \Validator::make($inputs, $rules);
    }

    public function store($inputs, $id = null) {
       // dd($inputs);
        if ($id) {
            return $this->find($id)->update($inputs);
        } else {
            return $this->create($inputs)->id;
        }
    }

    public function deleteCategory($id) {
        $this->where('id', $id)->delete();
    }

    public function tempDelete($id) {
        $this->find($id)->update(['deleted_at' => convertToUtc()]);
    }


}
