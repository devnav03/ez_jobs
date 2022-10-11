<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\UserDevice;
use App\Models\Category;
use App\Models\Company;
use App\Models\JobApplies;
use App\Models\JobSeekersDetail;
use App\Models\SaveJob;
use App\Models\Country;
use ElfSundae\Laravel\Hashid\Facades\Hashid;
use App\Models\Job;
use App\Models\SmsCode;
use App\Models\ForceUpdate;
use Auth;
use Ixudra\Curl\Facades\Curl;
use PDF;


class JobController extends Controller
{

    public function category(Request $request){
      $data = Category::where('status', 1)->where('parent_id', NULL)->select('id', 'name')->inRandomOrder()->get();
       return apiResponseApp(true, 200, null, null, $data);
    }

    public function popular(Request $request){

      // $vacancies = Job::select(\DB::raw('sum(status) as count'), 'title')->groupBy('title')->orderBy('count','desc')->where('status', 1)->where('created_at', '>', now()->subDays(30)->endOfDay())->limit(20)->get();
      $user = User::where('api_key', $request->api_key)->select('id')->first();
      if($user){ 
        $function_area =  JobSeekersDetail::where('seeker_id', $user->id)->select('sub_category')->first();
        if(!empty($function_area)){

            $jobs = \DB::table("jobs")
            ->join('users', 'users.id', '=', 'jobs.employer_id')
            ->join('cities', 'cities.id', '=', 'jobs.city_id')
            ->select('jobs.id', 'jobs.title', 'jobs.salary', 'jobs.job_type', 'users.profile_image', 'users.id as company_id', 'cities.name as city', 'jobs.created_at', 'users.country')
            ->where('jobs.status', 1)
            ->where('jobs.sub_category', $function_area->sub_category)
            ->where('users.status', 1)  
            ->where('jobs.created_at', '>', now()->subDays(30)->endOfDay())
            ->inRandomOrder()->limit(10)->get();


        } else {
            $jobs = \DB::table("jobs")
            ->join('users', 'users.id', '=', 'jobs.employer_id')
            ->join('cities', 'cities.id', '=', 'jobs.city_id')
            ->select('jobs.id', 'jobs.title', 'jobs.salary', 'jobs.job_type', 'users.profile_image', 'users.id as company_id', 'cities.name as city', 'jobs.created_at', 'users.country')
            ->where('jobs.status', 1)
            ->where('users.status', 1)  
            ->where('jobs.created_at', '>', now()->subDays(30)->endOfDay())
            ->inRandomOrder()->limit(10)->get();
        }

          $data = [];
          $url = route('home');
          foreach ($jobs as $job) {
            $company = User::where('id', $job->company_id)->select('employer_name')->first();
            $country = Country::where('id', $job->country)->select('country_name')->first();

            $job_list['id'] = $job->id;
            $job_list['title'] = $job->title;
            $job_list['salary'] = $job->salary;
            $job_list['job_type'] = $job->job_type;
            $job_list['posted_at'] = \Carbon\Carbon::parse($job->created_at)->diffForHumans();
            $job_list['image'] = $url.$job->profile_image;
            $job_list['city'] = $job->city;
            $job_list['country'] = $country->country_name;
            $job_list['company'] = $company->employer_name;
            $data[] = $job_list;
          }


        return apiResponseApp(true, 200, null, null, $data);
      }

    }
    


    public function latest(Request $request){

      // $vacancies = Job::select(\DB::raw('sum(status) as count'), 'title')->groupBy('title')->orderBy('count','desc')->where('status', 1)->where('created_at', '>', now()->subDays(30)->endOfDay())->limit(20)->get();
      $user = User::where('api_key', $request->api_key)->select('id')->first();
      if($user){ 
        $function_area =  JobSeekersDetail::where('seeker_id', $user->id)->select('sub_category')->first();
        if(!empty($function_area)){

            $jobs = \DB::table("jobs")
            ->join('users', 'users.id', '=', 'jobs.employer_id')
            ->join('cities', 'cities.id', '=', 'jobs.city_id')
            ->select('jobs.id', 'jobs.title', 'jobs.salary', 'jobs.job_type', 'users.profile_image', 'users.id as company_id', 'cities.name as city', 'jobs.created_at', 'users.country')
            ->where('jobs.status', 1)
            ->where('jobs.sub_category', $function_area->sub_category)
            ->where('users.status', 1)  
            ->where('jobs.created_at', '>', now()->subDays(30)->endOfDay())
            ->orderBy('jobs.id', 'desc')->limit(10)->get();


        } else {
            $jobs = \DB::table("jobs")
            ->join('users', 'users.id', '=', 'jobs.employer_id')
            ->join('cities', 'cities.id', '=', 'jobs.city_id')
            ->select('jobs.id', 'jobs.title', 'jobs.salary', 'jobs.job_type', 'users.profile_image', 'users.id as company_id', 'cities.name as city', 'jobs.created_at', 'users.country')
            ->where('jobs.status', 1)
            ->where('users.status', 1)  
            ->where('jobs.created_at', '>', now()->subDays(30)->endOfDay())
            ->orderBy('jobs.id', 'desc')->limit(10)->get();
        }

          $data = [];
          $url = route('home');
          foreach ($jobs as $job) {
            $company = User::where('id', $job->company_id)->select('employer_name')->first();
            $country = Country::where('id', $job->country)->select('country_name')->first();

            $job_list['id'] = $job->id;
            $job_list['title'] = $job->title;
            $job_list['salary'] = $job->salary;
            $job_list['job_type'] = $job->job_type;
            $job_list['posted_at'] = \Carbon\Carbon::parse($job->created_at)->diffForHumans();
            $job_list['image'] = $url.$job->profile_image;
            $job_list['city'] = $job->city;
            $job_list['country'] = $country->country_name;
            $job_list['company'] = $company->employer_name;
            $data[] = $job_list;
          }


        return apiResponseApp(true, 200, null, null, $data);
      }

    }

    public function functional_areas(Request $request){
      $data = Category::where('status', 1)->where('parent_id', $request->category_id)->select('id', 'name')->inRandomOrder()->get();
       return apiResponseApp(true, 200, null, null, $data);
    }

    public function job_details(Request $request){
        
        $user = User::where('api_key', $request->api_key)->select('id')->first();
        if($user){ 

        $job = Job::join('users', 'users.id', '=', 'jobs.employer_id')
            ->join('cities', 'cities.id', '=', 'jobs.city_id')
            ->join('states', 'states.id', '=', 'jobs.state_id')
            ->join('categories', 'categories.id', '=', 'jobs.category_id')
            ->join('educations', 'educations.id', '=', 'jobs.qualifications')
            ->join('categories as function_area', 'function_area.id', '=', 'jobs.sub_category')
            ->select('jobs.id', 'jobs.title', 'jobs.salary', 'jobs.job_type', 'jobs.job_description', 'jobs.created_at', 'users.profile_image', 'users.employer_name', 'cities.name as city', 'states.name as state', 'categories.name as cat', 'function_area.name as sub_cat', 'educations.name as education')
            ->where('jobs.status', 1)
            ->where('jobs.id', $request->job_id)
            ->where('users.status', 1)  
            ->where('jobs.created_at', '>', now()->subDays(30)->endOfDay())
            ->first();

          $data['id'] = @$job->id;
          $data['title'] = @$job->title;
          $data['salary'] = @$job->salary;
          $data['job_type'] = @$job->job_type;
          $data['job_description'] = @$job->job_description;
          $data['posted_at'] = \Carbon\Carbon::parse(@$job->created_at)->diffForHumans();
          $data['image'] = route('home').@$job->profile_image;
          
          $SaveJob = SaveJob::where('job_id', $request->job_id)->where('user_id', $user->id)->first();
          if($SaveJob){
            $data['save_job'] = 1;  
          } else {
            $data['save_job'] = 0;   
          }
          
          $JobApplies = JobApplies::where('job_id', $request->job_id)->where('user_id', $user->id)->first();
          if($JobApplies){
            $data['job_apply'] = 1;  
          } else {
            $data['job_apply'] = 0;   
          }

          $data['employer_name'] = @$job->employer_name;
          $data['city'] = @$job->city;
          $data['state'] = @$job->state;
          $data['industry'] = @$job->cat;
          $data['function_area'] = @$job->sub_cat;
          $data['education'] = @$job->education;

          return apiResponseApp(true, 200, null, null, $data);
        }
    }
    
    public function remove_save_job(Request $request){
        $user = User::where('api_key', $request->api_key)->select('id')->first();
        if($user){ 
            SaveJob::where('job_id', $request->job_id)->where('user_id', $user->id)->delete();
            $message = 'Saved job Successfully removed';   
            return apiResponseAppmsg(true, 200, $message, null, null);
        }
    }
    
    public function jobs_by_functional_areas(Request $request){
          $jobs = \DB::table("jobs")
            ->join('users', 'users.id', '=', 'jobs.employer_id')
            ->join('cities', 'cities.id', '=', 'jobs.city_id')
            ->select('jobs.id', 'jobs.title', 'jobs.salary', 'jobs.job_type', 'jobs.created_at', 'users.profile_image', 'users.id as company_id', 'cities.name as city')
            ->where('jobs.status', 1)
            ->where('jobs.sub_category', $request->functional_area_id)
            ->where('users.status', 1)  
            ->where('jobs.created_at', '>', now()->subDays(30)->endOfDay())->inRandomOrder()->get();
          $data = [];
          $url = route('home');
          foreach ($jobs as $job) {
            $company = User::where('id', $job->company_id)->select('employer_name')->first();
            $job_list['id'] = $job->id;
            $job_list['title'] = $job->title;
            $job_list['salary'] = $job->salary;
            $job_list['job_type'] = $job->job_type;
            $job_list['posted_at'] = \Carbon\Carbon::parse($job->created_at)->diffForHumans();
            $job_list['image'] = $url.$job->profile_image;
            $job_list['city'] = $job->city;
            $job_list['company'] = $company->employer_name;
            $data[] = $job_list;
          }

       return apiResponseApp(true, 200, null, null, $data);
    }

    public function job_apply(Request $request){
      $user = User::where('api_key', $request->api_key)->select('id')->first();
      if($user){ 
        $job = Job::where('id', $request->job_id)->select('employer_id')->first();
        $save_job1 = JobApplies::where('job_id', $request->job_id)->where('user_id', $user->id)->select('id')->first();
        if(empty($save_job1)){
            $SaveJob = new JobApplies();
            $SaveJob->job_id = $request->job_id;
            $SaveJob->user_id = $user->id;
            $SaveJob->employer_id = $job->employer_id;
            $SaveJob->save();
        }
          $message = 'Successfully applied for job';   
          return apiResponseAppmsg(true, 200, $message, null, null);
    }
    }
    
    public function live_job_search(Request $request){
      $jobs = \DB::table("jobs")
            ->join('users', 'users.id', '=', 'jobs.employer_id')
            ->select('jobs.title')
            ->where('jobs.status', 1)
            ->where('users.status', 1) 
            ->where('jobs.title',  'like', '%'.$request->search.'%')  
            ->where('jobs.created_at', '>', now()->subDays(30)->endOfDay())
            ->groupBy('jobs.title')
            ->inRandomOrder()->limit(10)->get();
          return apiResponseApp(true, 200, null, null, $jobs);
    }

    public function job_filter(Request $request){

        $jobs = \DB::table("jobs")
            ->join('users', 'users.id', '=', 'jobs.employer_id')
            ->join('cities', 'cities.id', '=', 'jobs.city_id')
            ->select('jobs.id', 'jobs.title', 'jobs.salary', 'jobs.job_type', 'jobs.created_at', 'users.profile_image', 'users.employer_name', 'cities.name as city')
            ->where('jobs.status', 1)
            ->where('users.status', 1)  
            ->where('jobs.created_at', '>', now()->subDays(30)->endOfDay());
            if($request->city){
                $jobs->where('jobs.city_id',$request->city);
            }
            if($request->keyword){
                $jobs->where('jobs.title', 'like', '%'.$request->keyword.'%');
            }
            if($request->country){
                $jobs->where('users.country', $request->country);
            }
            if($request->state){
                $jobs->where('jobs.state_id', $request->state);
            }
            if($request->category){
                $jobs->where('jobs.category_id', $request->category);
            }
            if($request->sub_category){
                $jobs->where('jobs.sub_category', $request->sub_category);
            }
            $jobs = $jobs->get();

            $data = [];
            foreach ($jobs as $value) {
              $row['id'] = $value->id;
              $row['title'] = $value->title;
              $row['salary'] = $value->salary;
              $row['job_type'] = $value->job_type;
              $row['posted_at'] = \Carbon\Carbon::parse($value->created_at)->diffForHumans();
              $row['image'] = route('home').$value->profile_image;
              $row['city'] = $value->city;  
              $row['company'] = $value->employer_name;
              $data[] = $row;
            }
            return apiResponseApp(true, 200, null, null, $data);

    }

    public function job_posts(Request $request){

      $user = User::where('api_key', $request->api_key)->where('user_type', 2)->select('id')->first();
      if($user){ 

      


      }
    }
      


    public function save_job(Request $request){
      $user = User::where('api_key', $request->api_key)->select('id')->first();
      if($user){ 
      $save_job = SaveJob::where('job_id', $request->job_id)->where('user_id', $user->id)->select('id')->first();
        if(empty($save_job)){
            $SaveJob = new SaveJob();
            $SaveJob->job_id = $request->job_id;
            $SaveJob->user_id = $user->id;
            $SaveJob->save();            
        }
        $message = 'Job successfully saved';
        return apiResponseAppmsg(true, 200, $message, null, null);
      }
    }


    public function applied_job_list(Request $request){
        $user = User::where('api_key', $request->api_key)->select('id')->first();
        if($user){ 
          $datas = \DB::table("jobs")
            ->join('job_applies', 'jobs.id', '=', 'job_applies.job_id')
            ->join('users', 'users.id', '=', 'jobs.employer_id')
            ->join('cities', 'cities.id', '=', 'jobs.city_id')
            ->select('jobs.id', 'jobs.title', 'jobs.salary', 'jobs.job_type', 'jobs.created_at', 'users.profile_image', 'users.id as company_id', 'users.employer_name', 'cities.name as city')
            ->where('jobs.status', 1)
            ->where('job_applies.user_id', $user->id)
            ->where('users.status', 1)  
            ->where('jobs.created_at', '>', now()->subDays(30)->endOfDay())
            ->inRandomOrder()->limit(30)->get();
          $data = [];
          foreach ($datas as $value) {
            $row['id'] = $value->id;
            $row['title'] = $value->title;
            $row['salary'] = $value->salary;
            $row['job_type'] = $value->job_type;
            $row['posted_at'] = \Carbon\Carbon::parse($value->created_at)->diffForHumans();
            $row['image'] = route('home').$value->profile_image;
            $row['city'] = $value->city;  
            $row['company'] = $value->employer_name;
            $data[] = $row;
          }
          return apiResponseApp(true, 200, null, null, $data);
        }
    }

    public function saved_job_list(Request $request){
        $user = User::where('api_key', $request->api_key)->select('id')->first();
        if($user){ 
          $datas = \DB::table("jobs")
            ->join('save_jobs', 'jobs.id', '=', 'save_jobs.job_id')
            ->join('users', 'users.id', '=', 'jobs.employer_id')
            ->join('cities', 'cities.id', '=', 'jobs.city_id')
            ->select('jobs.id', 'jobs.title', 'jobs.salary', 'jobs.job_type', 'jobs.created_at', 'users.profile_image', 'users.id as company_id', 'users.employer_name', 'cities.name as city')
            ->where('jobs.status', 1)
            ->where('save_jobs.user_id', $user->id)
            ->where('save_jobs.deleted_at', null) 
            ->where('users.status', 1)  
            ->where('jobs.created_at', '>', now()->subDays(30)->endOfDay())
            ->inRandomOrder()->limit(30)->get();
          $data = [];
          foreach ($datas as $value) {
            $row['id'] = $value->id;
            $row['title'] = $value->title;
            $row['salary'] = $value->salary;
            $row['job_type'] = $value->job_type;
            $row['posted_at'] = \Carbon\Carbon::parse($value->created_at)->diffForHumans();
            $row['image'] = route('home').$value->profile_image;
            $row['city'] = $value->city;  
            $row['company'] = $value->employer_name;
            $data[] = $row;
          }
          return apiResponseApp(true, 200, null, null, $data);
        }
    }



    

}
