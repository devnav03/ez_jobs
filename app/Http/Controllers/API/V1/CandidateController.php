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
use App\Models\ProfileView;
use ElfSundae\Laravel\Hashid\Facades\Hashid;
use App\Models\Job;
use App\Models\SmsCode;
use App\Models\ForceUpdate;
use Auth;
use Ixudra\Curl\Facades\Curl;
use PDF;


class CandidateController extends Controller {



	public function candidates(Request $request){

        $user = User::where('api_key', $request->api_key)->select('user_type', 'plan_expire', 'profile_view_limit')->first();
        if($user->user_type == 2){ 
            
	        $candidates = User::join('job_seekers_details', 'job_seekers_details.seeker_id', '=', 'users.id')
            ->join('categories', 'categories.id', '=', 'job_seekers_details.sub_category')
            ->join('cities', 'cities.id', '=', 'users.city')
            ->select('categories.name as cat', 'users.id', 'users.name', 'users.profile_image', 'job_seekers_details.experience_years', 'job_seekers_details.experience_months', 'cities.name as city')
            ->where('users.user_type', 3)
            ->where('users.status', 1)->where('categories.status', 1)->limit(20)->get();

            $today = date('Y-m-d');
            $plan_expire = $user->plan_expire;
            $limit = $user->profile_view_limit;

            $data = [];
            if($plan_expire != NULL && $today <= $plan_expire && $limit != 0){
                foreach ($candidates as  $candidate) {
                    $profile['id'] = $candidate->id;
                    $profile['name'] = $candidate->name;
                    $profile['function_area'] = $candidate->cat;
                    if($candidate->profile_image){
                        $profile['profile_image'] = route('home').$candidate->profile_image;
                    } else {
                       $profile['profile_image'] = 'https://jobpilot.templatecookie.com/backend/image/default.png';
                    }
                    $profile['experience'] = $candidate->experience_years.'y '.$candidate->experience_months.'m';
                    $profile['city'] = $candidate->city;
                    $profile['view'] = 1;
                    $data[] = $profile;
                }
            } else {
                foreach ($candidates as  $candidate) {
                    $profile['id'] = $candidate->id;
                    $profile['name'] = $candidate->name;
                    $profile['function_area'] = $candidate->cat;
                    $profile['profile_image'] = 'https://jobpilot.templatecookie.com/backend/image/default.png';
                    $profile['experience'] = $candidate->experience_years.'y '.$candidate->experience_months.'m';
                    $profile['city'] = $candidate->city;
                    $profile['view'] = 0;
                    $data[] = $profile; 
                }
            }

            return apiResponseApp(true, 200, null, null, $data);  

        }
       
	}

    
    public function candidate_details(Request $request){
        $user = User::where('api_key', $request->api_key)->select('id', 'user_type', 'plan_expire', 'profile_view_limit')->first();
        if($user->user_type == 2){ 
            $user_id = $user->id;
            $today = date('Y-m-d');
            $plan_expire =  $user->plan_expire;
            $limit = $user->profile_view_limit;
            $id = $request->candidate_id;
            if($plan_expire != NULL && $today <= $plan_expire && $limit != 0){
                $profile_view = ProfileView::where('candidate_id', $id)->where('employer_id', $user_id)->select('id')->first();
	            if(empty($profile_view)){
	                $ProfileView = new ProfileView();
	                $ProfileView->candidate_id = $id;
	                $ProfileView->employer_id = $user_id;
	                $ProfileView->save();
	                User::where('id', $user_id)
	                    ->update([
	                    'profile_view_limit' => $limit-1,
	                ]);
	            }

            $profile = User::join('job_seekers_details', 'job_seekers_details.seeker_id', '=', 'users.id')
            ->join('categories', 'categories.id', '=', 'job_seekers_details.sub_category')
            ->join('cities', 'cities.id', '=', 'users.city')
            ->join('countries', 'countries.id', '=', 'users.country')
            ->join('states', 'states.id', '=', 'users.state')
            ->join('designations', 'designations.id', '=', 'job_seekers_details.designation_id')
            ->join('educations', 'educations.id', '=', 'job_seekers_details.education')
            ->select('categories.name as cat', 'users.id', 'users.name', 'users.profile_image', 'users.email', 'users.mobile', 'users.gender', 'users.date_of_birth', 'users.address',  'designations.name as designation', 'educations.name as education', 'cities.name as city', 'states.name as state',
                'countries.country_name as country', 'job_seekers_details.experience_years',  'job_seekers_details.experience_months', 'job_seekers_details.key_skills', 'job_seekers_details.salary_lakhs', 'job_seekers_details.salary_thousands', 'job_seekers_details.resume'
            )->where('users.id', $id)->first();
            
            if($profile->profile_image){
	            $image = $profile->profile_image;
	            unset($profile['profile_image']);
            } else {
            	$image = '';
            }

            if($profile->resume){
	            $resume = $profile->resume;
	            unset($profile['resume']);
            } else {
            	$resume = '';
            }

            $profile['profile_image'] = route('home').$image;
            $profile['resume'] = route('home').$resume;
            return apiResponseApp(true, 200, null, null, $profile);
            } else {
                $message = 'Kindly Upgrade Your Plan';
                return apiResponseApp(false, 201, $message, null, null);

            }
        }
    }


    public function candidate_filter(Request $request){
        $user = User::where('api_key', $request->api_key)->select('user_type', 'plan_expire', 'profile_view_limit')->first();
        if($user->user_type == 2){ 
        $candidates = User::join('job_seekers_details', 'job_seekers_details.seeker_id', '=', 'users.id')
            ->join('categories', 'categories.id', '=', 'job_seekers_details.sub_category')
            ->join('cities', 'cities.id', '=', 'users.city')
            ->select('categories.name as cat', 'users.id', 'users.name', 'users.profile_image', 'job_seekers_details.experience_years', 'job_seekers_details.experience_months', 'cities.name as city')
            ->where('users.user_type', 3)
            ->where('users.status', 1)->where('categories.status', 1);

            if($request->country){
                $candidates->where('users.country', $request->country);
            }
            if($request->state){
                $candidates->where('users.state', $request->state);
            }

            if($request->industry){
                $candidates->where('job_seekers_details.category', $request->industry);
            }
            if($request->functional_area){
                $candidates->where('job_seekers_details.sub_category', $request->functional_area);
            }

            $candidates = $candidates->get();

            $today = date('Y-m-d');
            $plan_expire = $user->plan_expire;
            $limit = $user->profile_view_limit;

            $data = [];
            if($plan_expire != NULL && $today <= $plan_expire && $limit != 0){
                foreach ($candidates as  $candidate) {
                    $profile['id'] = $candidate->id;
                    $profile['name'] = $candidate->name;
                    $profile['function_area'] = $candidate->cat;
                    if($candidate->profile_image){
                        $profile['profile_image'] = route('home').$candidate->profile_image;
                    } else {
                       $profile['profile_image'] = 'https://jobpilot.templatecookie.com/backend/image/default.png';
                    }
                    $profile['experience'] = $candidate->experience_years.'y '.$candidate->experience_months.'m';
                    $profile['city'] = $candidate->city;
                    $profile['view'] = 1;
                    $data[] = $profile;
                }
            } else {
                foreach ($candidates as  $candidate) {
                    $profile['id'] = $candidate->id;
                    $profile['name'] = $candidate->name;
                    $profile['function_area'] = $candidate->cat;
                    $profile['profile_image'] = 'https://jobpilot.templatecookie.com/backend/image/default.png';
                    $profile['experience'] = $candidate->experience_years.'y '.$candidate->experience_months.'m';
                    $profile['city'] = $candidate->city;
                    $profile['view'] = 0;
                    $data[] = $profile; 
                }
            }

            return apiResponseApp(true, 200, null, null, $data);

        }
    }























}


