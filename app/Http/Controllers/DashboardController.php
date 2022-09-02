<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class DashboardController extends Controller {
  
    public function index() {
        $user_id =  Auth::id();
        $currentMonth = date('m');
        $newusers = \DB::table("users")
        ->where('user_type', 2)
        ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
        ->count();

        return view('admin.dashboard', compact('newusers'));
    }  


}
