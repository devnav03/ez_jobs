<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\UserDevice;
use App\Models\Category;
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
      $vacancies = Job::select(\DB::raw('sum(status) as count'), 'title')->groupBy('title')->orderBy('count','desc')->where('status', 1)->where('created_at', '>', now()->subDays(30)->endOfDay())->limit(20)->get();
       return apiResponseApp(true, 200, null, null, $vacancies);
    }
    
    public function functional_areas(Request $request){
      $data = Category::where('status', 1)->where('parent_id', $request->category_id)->select('id', 'name')->inRandomOrder()->get();
       return apiResponseApp(true, 200, null, null, $data);
    }

    public function job_details(Request $request){

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

          $data['employer_name'] = @$job->employer_name;
          $data['city'] = @$job->city;
          $data['state'] = @$job->state;
          $data['industry'] = @$job->cat;
          $data['function_area'] = @$job->sub_cat;
          $data['education'] = @$job->education;


          return apiResponseApp(true, 200, null, null, $data);

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

    




    

}
