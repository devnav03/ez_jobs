<?php

namespace App\Http\Controllers\Front;
/**
 * :: Plan Controller ::
 * To manage games.
 *
 **/
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use Files;
use Illuminate\Support\Facades\Storage;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\LoginLog;
use App\Models\Designation;
use App\Models\Education;
use App\Models\Plan;
use App\Models\Job;
use App\Models\JobApplies;
use App\Models\SaveJob;
use App\Models\ProfileView;
use App\Models\SaveCandidate;
use App\Models\JobSeekersDetail;
use Redirect;
use DateTime;

class JobController extends Controller{

    
    public function index(){
        if((\Auth::user()->user_type) == 2){
            $user_id = Auth::id();
            $plans =  \DB::table('jobs')
                ->join('categories', 'categories.id', '=','jobs.category_id')
                ->join('categories as c2', 'c2.id', '=','jobs.sub_category')
                ->select('jobs.id', 'jobs.title', 'jobs.category_id', 'jobs.sub_category', 'jobs.salary', 'jobs.job_type', 'jobs.created_at', 'categories.name as cat', 'c2.name as sub_cat', 'jobs.status')
                ->where('jobs.employer_id', $user_id)
                ->get();
            $countries = Country::all();
        return view('frontend.pages.job', compact('plans', 'countries'));

        } else {
            \Auth::logout();
            \Session::flush();
            return redirect()->route('login');
        }
    }

    public function saveJob(Request $request){
        $user_id = Auth::id();
        $save_job = SaveJob::where('job_id', $request->job_id)->where('user_id', $user_id)->select('id')->first();
        $data = [];
        if(empty($save_job)){
            $SaveJob = new SaveJob();
            $SaveJob->job_id = $request->job_id;
            $SaveJob->user_id = $user_id;
            $SaveJob->save();
            $data['button'] = '<button title="delete from save" value="'.$request->job_id.'" onclick="SaveJob(this.value)" class="text-primary-500 hoverbg-primary-50 plain-button icon-button">
                        <i class="fa-solid fa-bookmark"></i></button>'; 
            $data['message'] = 'Job successfully saved';
        } else {
            \DB::table('save_jobs')->where('id', $save_job->id)->delete();
            $data['button'] = '<button title="Save Job" value="'.$request->job_id.'" onclick="SaveJob(this.value)" class="text-primary-500 hoverbg-primary-50 plain-button icon-button">
                <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M15 19L8 14L1 19V3C1 2.46957 1.21071 1.96086 1.58579 1.58579C1.96086 1.21071 2.46957 1 3 1H13C13.5304 1 14.0391 1.21071 14.4142 1.58579C14.7893 1.96086 15 2.46957 15 3V19Z" stroke="#0a66cd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>';
            $data['message'] = 'Job successfully remove from saved job';
        }
        $data['job_id'] = $request->job_id;
        return $data;
    }

    public function appliers_list($id = null){
        try{
              
            $user_id = Auth::id();
            $chk_jobpost = Job::where('id', $id)->where('employer_id', $user_id)->count();
            if($chk_jobpost != 0){
            
            $candidates = User::join('job_seekers_details', 'job_seekers_details.seeker_id', '=', 'users.id')
            ->join('job_applies', 'job_applies.user_id', '=', 'users.id')
            ->join('categories', 'categories.id', '=', 'job_seekers_details.sub_category')
            ->join('cities', 'cities.id', '=', 'users.city')
            ->select('categories.name as cat', 'users.id', 'users.name', 'users.profile_image', 'job_seekers_details.experience_years', 'job_seekers_details.experience_months', 'cities.name as city', 'job_applies.created_at')
            ->where('users.user_type', 3)
            ->where('users.status', 1)
            ->where('job_applies.job_id', $id)->get();
            
            $countries = Country::all();
            $job = Job::where('id', $id)->select('title', 'created_at')->first();

            //dd($candidates);

            return view('frontend.pages.appliers_list', compact('candidates', 'countries', 'job'));

            } else {
                return back();
            }

        } catch (Exception $e) {
            return back();
        }

    }


    public function saveCandidate(Request $request){
        $user_id = Auth::id();
        //dd($request);
        
        $today = date('Y-m-d');
        $plan_expire =  Auth::user()->plan_expire;
        $limit = Auth::user()->profile_view_limit;
        if($plan_expire != NULL && $today <= $plan_expire && $limit != 0){

        $save_job = SaveCandidate::where('candidate_id', $request->candidate_id)->where('employer_id', $user_id)->select('id')->first();
        $data = [];
        if(empty($save_job)){
            $SaveJob = new SaveCandidate();
            $SaveJob->candidate_id = $request->candidate_id;
            $SaveJob->employer_id = $user_id;
            $SaveJob->save();
            
            $profile_view = ProfileView::where('candidate_id', $request->candidate_id)->where('employer_id', $user_id)->select('id')->first();
        if(empty($profile_view)){
            $ProfileView = new ProfileView();
            $ProfileView->candidate_id = $request->candidate_id;
            $ProfileView->employer_id = $user_id;
            $ProfileView->save();

            User::where('id', $user_id)
                ->update([
                'profile_view_limit' => Auth::user()->profile_view_limit-1,
            ]);

        }

            $data['button'] = '<button title="delete from save" value="'.$request->candidate_id.'" onclick="saveCandidate(this.value)" class="text-primary-500 hoverbg-primary-50 plain-button icon-button">
                        <i class="fa-solid fa-bookmark"></i></button>'; 
            $data['message'] = 'Candidate successfully saved';
        } else {
            \DB::table('save_candidates')->where('id', $save_job->id)->delete();
            $data['button'] = '<button title="Save Candidate" value="'.$request->candidate_id.'" onclick="saveCandidate(this.value)" class="text-primary-500 hoverbg-primary-50 plain-button icon-button">
                <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M15 19L8 14L1 19V3C1 2.46957 1.21071 1.96086 1.58579 1.58579C1.96086 1.21071 2.46957 1 3 1H13C13.5304 1 14.0391 1.21071 14.4142 1.58579C14.7893 1.96086 15 2.46957 15 3V19Z" stroke="#0a66cd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>';
            $data['message'] = 'Candidate successfully remove from saved candidates';
        }
        $data['candidate_id'] = $request->candidate_id;
        $data['plan'] = 0;
       } else {
            $data['plan'] = 1;
            $data['candidate_id'] = $request->candidate_id;
            $data['message'] = 'Upgrade Your Plan';
            $data['button'] = '';
       }

        return $data;
    }

    public function job_details($id = null){

        try{

            $job = Job::join('users', 'users.id', '=', 'jobs.employer_id')
            ->join('cities', 'cities.id', '=', 'jobs.city_id')
            ->join('states', 'states.id', '=', 'jobs.state_id')
            ->join('categories', 'categories.id', '=', 'jobs.category_id')
            ->join('educations', 'educations.id', '=', 'jobs.qualifications')
            ->join('categories as function_area', 'function_area.id', '=', 'jobs.sub_category')
            ->select('jobs.id', 'jobs.title', 'jobs.salary', 'jobs.job_type', 'jobs.job_description', 'jobs.created_at', 'users.profile_image', 'users.employer_name', 'users.id as company_id', 'cities.name as city', 'states.name as state', 'categories.name as cat', 'function_area.name as sub_cat', 'educations.name as education')
            ->where('jobs.status', 1)
            ->where('jobs.id', $id)
            ->where('users.status', 1)  
            ->where('jobs.created_at', '>', now()->subDays(30)->endOfDay())
            ->first();

            $countries = Country::all();

            return view('frontend.pages.job_details', compact('job', 'countries'));

        } catch (Exception $e) {
            return back();
        }
    }

    public function saved_job(Request $request){
        try{

            $user_id = Auth::id();
            $jobs = \DB::table("jobs")
            ->join('save_jobs', 'jobs.id', '=', 'save_jobs.job_id')
            ->join('users', 'users.id', '=', 'jobs.employer_id')
            ->join('cities', 'cities.id', '=', 'jobs.city_id')
            ->select('jobs.id', 'jobs.title', 'jobs.salary', 'jobs.job_type', 'jobs.created_at', 'users.profile_image', 'users.id as company_id', 'users.employer_name', 'cities.name as city')
            ->where('jobs.status', 1)
            ->where('save_jobs.user_id', $user_id)
            ->where('users.status', 1)  
            ->where('jobs.created_at', '>', now()->subDays(30)->endOfDay())
            ->inRandomOrder()->limit(40)->get();

            $countries = Country::all();
            if((\Auth::user()->user_type) == 3){
            return view('frontend.pages.saved_job', compact('jobs', 'countries'));
            } else {
                return back();
            }
        } catch(Exception $e){
            return back();
        }
    }

    public function applyjob(Request $request){
        $user_id = Auth::id();
        //dd($request);
        $save_job1 = JobApplies::where('job_id', $request->job_id)->where('user_id', $user_id)->select('id')->first();
        $save_job = Job::where('id', $request->job_id)->select('employer_id')->first();
        $data = [];

        if(empty($save_job1)){
            $SaveJob = new JobApplies();
            $SaveJob->job_id = $request->job_id;
            $SaveJob->user_id = $user_id;
            $SaveJob->employer_id = $save_job->employer_id;
            $SaveJob->save();
            $data['apply_button'] = '<button class="btn btn-primary2-50" style="background:#d6d8d9;"><span class="button-icon align-icon-right" style="margin-right: 6px;"><i class="fa-solid fa-arrow-right-long"></i></span><span class="button-text">Applied</span></button>'; 
            $data['message'] = 'Successfully applied for job';
        }  else {
            $data['apply_button'] = '<button class="btn btn-primary2-50" style="background:#d6d8d9;"><span class="button-icon align-icon-right" style="margin-right: 6px;"><i class="fa-solid fa-arrow-right-long"></i></span><span class="button-text">Applied</span></button>'; 
            $data['message'] = 'Already applied for job';
        }
        $data['job_id'] = $request->job_id;
        return $data;
    }
    

    public function edit_job($id = null){
        try {

            $user_id = Auth::id();
            $job = Job::where('id', $id)->where('employer_id', $user_id)->first();
            if(!empty($job)){

            $countries = Country::all();

            $created_at = date('Y-m-d', strtotime($job->created_at));
            $earlier = new DateTime($created_at);
            $today = date('Y-m-d');
            $later = new DateTime($today);
            $abs_diff = $later->diff($earlier)->format("%a");
            
            if($abs_diff <= 30){
               $country_id =  \Auth::user()->country;
                $states = State::where('country_id', $country_id)->select('name', 'id')->get();
                $educations = Education::where('status', 1)->select('name', 'id')->get();
                $categories = Category::where('status', 1)->where('parent_id', NULL)->select('name', 'id')->get();
                $sub_categories = Category::where('status', 1)->where('parent_id', $job->category_id)->select('name', 'id')->get();
                $cities = City::where('state_id', $job->state_id)->select('name', 'id')->get();

                return view('frontend.pages.job_edit', compact('job', 'cities', 'countries', 'categories', 'states', 'educations', 'sub_categories'));
            } else {
              return redirect()->route('job-post')->with('job_expire', 'job_expire');
            }

            } else {
              echo '404';
            }

        } catch (Exception $e) {
            return back();
        }

    }

    public function new_job(){
        if((\Auth::user()->user_type) == 2){
            // $today = date('Y-m-d');
            // $plan_expire =  \Auth::user()->plan_expire;
            // if($plan_expire != NULL && $today <= $plan_expire){
            $country_id =  \Auth::user()->country;
            $countries = Country::all();
            $states = State::where('country_id', $country_id)->select('name', 'id')->get();
            $educations = Education::where('status', 1)->select('name', 'id')->get();
            $categories = Category::where('status', 1)->where('parent_id', NULL)->select('name', 'id')->get();
            return view('frontend.pages.job_post', compact('states', 'countries', 'categories', 'educations'));
            // } else {
            //     return redirect()->route('membership-plan');
            // }
        } else {
            \Auth::logout();
            \Session::flush();
            return redirect()->route('login');
        }
    }

    public function create_job(Request $request){
        try {
            $inputs = $request->all(); 
            $validator = (new Job)->validate($inputs);
            if ($validator->fails()) {
                return redirect()->route('post-a-new-job')
                ->withInput()->withErrors($validator);
            } 
            $user_id = Auth::id();
            $user = User::where('id', $user_id)->select('job_post_limit')->first();
            if($user->job_post_limit > 0){
                User::where('id', $user_id)
                ->update([
                    'job_post_limit' => $user->job_post_limit-1,
                ]);
                $job = new Job();
                $job->title = $request->title;
                $job->job_type = $request->job_type;
                $job->category_id = $request->category_id;
                $job->sub_category = $request->sub_category;
                $job->state_id = $request->state_id;
                $job->city_id = $request->city_id;
                $job->salary = $request->salary;
                $job->qualifications = $request->qualifications;
                $job->job_description = $request->job_description;
                $job->employer_id = $user_id;
                $job->save();
            } else {
                return redirect()->route('job-post')->with('upgrade_plan', 'upgrade_plan');
            }
            return redirect()->route('job-post')->with('job_posted', 'job_posted');
        } catch (Exception $e) {
            return back();
        }
    }


    public function update_job(Request $request){
        try {
            $inputs = $request->all(); 
            $validator = (new Job)->validate($inputs);
            if ($validator->fails()) {
                return redirect()->route('edit-job', $request->id)
                ->withInput()->withErrors($validator);
            } 
            $user_id = Auth::id();
 
                Job::where('id', $request->id)
                ->update([
                    'title' => $request->title,
                    'job_type' => $request->job_type,
                    'category_id' => $request->category_id,
                    'sub_category' => $request->sub_category,
                    'state_id' => $request->state_id,
                    'city_id' => $request->city_id,
                    'salary' => $request->salary,
                    'qualifications' => $request->qualifications,
                    'job_description' => $request->job_description,
                ]);
          
            return redirect()->route('job-post')->with('job_updated', 'job_updated');
        } catch (Exception $e) {
            return back();
        }
    }
    
    

}
