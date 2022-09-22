<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Job;
use Auth;

class DashboardController extends Controller {
  
    public function index() {
        $user_id =  Auth::id();
        $currentMonth = date('m');
        // $Employer_count_new = \DB::table("users")
        // ->where('user_type', 2)
        // ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
        // ->count();

        $Employer_count = User::where('user_type', 2)->count();
        $job_seekers_count = User::where('user_type', 3)->count();
        $total_job_count = (new Job)->totalJobs();
        $active_jobs = Job::where('created_at', '>', now()->subDays(30)->endOfDay())->count();

        $days = date('d');
        $date= date('Y-m');

        $month = date('m');

        $dataPoints = [];
        $dataPoints_rev = [];
        $dataPoints_cus = [];
        $dataPoints_ret = [];
        
        for ($x = 1; $x <= $month; $x++) {
        // $today = $date.'-'.$x;   
        // $today = date('Y-m-d', strtotime($today));
        $year = date('Y');
        $today = $year.'-'.$x; 
        $today = date('Y-m', strtotime($today));
        $emp_reg = \DB::table('users')->where('user_type', 2)->whereRaw('date_format(users.created_at,"%Y-%m")'."='".$today . "'")->count(\DB::raw('DISTINCT id'));
        $cand_reg = \DB::table('users')->where('user_type', 3)->whereRaw('date_format(users.created_at,"%Y-%m")'."='".$today . "'")->count(\DB::raw('DISTINCT id'));
        $mon = '';
        if($x == 1){
        	$mon = 'Jan';
        } else if($x == 2){
            $mon = 'Feb';
        } else if($x == 3){
            $mon = 'Mar';
        } else if($x == 4){
            $mon = 'Apr';
        } else if($x == 5){
            $mon = 'May';
        } else if($x == 6){
            $mon = 'Jun';
        } else if($x == 7){
            $mon = 'Jul';
        } else if($x == 8){
            $mon = 'Aug';
        } else if($x == 9){
            $mon = 'Sep';
        } else if($x == 10){
            $mon = 'Oct';
        } else if($x == 11){
            $mon = 'Nov';
        } else {
            $mon = 'Dec';
        }
 
        $lab['label'] = $mon;
        $lab['y'] = $emp_reg;
        $dataPoints[] = $lab;

        $lab1['label'] = $mon;            
        $lab1['y'] = $cand_reg;   
        $dataPoints_rev[] = $lab1;
    
     
        }


        


  


        return view('admin.dashboard', compact('Employer_count', 'job_seekers_count', 'total_job_count', 'active_jobs', 'dataPoints', 'dataPoints_rev'));
    }  


}
