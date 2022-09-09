<?php

namespace App\Http\Controllers\Front;
/**
 * :: Home Controller ::
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
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\LoginLog;
use App\Models\Designation;
use App\Models\Job;
use App\Models\Education;
use App\Models\ProfileView;
use App\Models\Plan;
use App\Models\JobSeekersDetail;
use Carbon\Carbon;
use Redirect;
use GuzzleHttp\Client;

class HomeController extends Controller{
 
    public function index() {

        $countries = Country::all();
        $user_id = Auth::id();
        $function_area =  JobSeekersDetail::where('seeker_id', $user_id)->select('sub_category')->first();
        if(!empty($function_area)){

           $jobs = \DB::table("jobs")
            ->join('users', 'users.id', '=', 'jobs.employer_id')
            ->join('cities', 'cities.id', '=', 'jobs.city_id')
            ->select('jobs.id', 'jobs.title', 'jobs.salary', 'jobs.job_type', 'jobs.created_at', 'users.profile_image', 'users.id as company_id', 'cities.name as city')
            ->where('jobs.status', 1)
            ->where('jobs.sub_category', $function_area->sub_category)
            ->where('users.status', 1)  
            ->where('jobs.created_at', '>', now()->subDays(30)->endOfDay())
            ->inRandomOrder()->limit(10)->get();

        } else {
            $jobs = \DB::table("jobs")
            ->join('users', 'users.id', '=', 'jobs.employer_id')
            ->join('cities', 'cities.id', '=', 'jobs.city_id')
            ->select('jobs.id', 'jobs.title', 'jobs.salary', 'jobs.job_type', 'jobs.created_at', 'users.profile_image', 'users.id as company_id', 'cities.name as city')
            ->where('jobs.status', 1)
            ->where('users.status', 1)  
            ->where('jobs.created_at', '>', now()->subDays(30)->endOfDay())
            ->inRandomOrder()->limit(10)->get();
        }

        $companies = \DB::table("users")
        ->join('cities', 'cities.id', '=', 'users.city')
        ->select('users.id', 'users.name', 'users.profile_image', 'users.employer_name', 'cities.name as city')
        ->where('users.status', 1)  
        ->where('users.user_type', 2)
        ->inRandomOrder()
        ->limit(9)->get();

        $categories = Category::where('status', 1)->where('parent_id', NULL)->select('id', 'name', 'icon', 'url')->inRandomOrder()->limit(8)->get();

        $vacancies = Job::select(\DB::raw('sum(status) as count'), 'title')->groupBy('title')->orderBy('count','desc')->where('status', 1)->where('created_at', '>', now()->subDays(30)->endOfDay())->limit(8)->get();

        $live_job = Job::where('status', 1)->where('created_at', '>', now()->subDays(7)->endOfDay())->count();
        $new_job = Job::where('status', 1)->where('created_at', '>', now()->subDays(30)->endOfDay())->count();
        $companies_count = User::where('status', 1)->where('user_type', 2)->count();
        $candidate_count = User::where('status', 1)->where('user_type', 3)->count();
        
        if($user_id){
            if((\Auth::user()->user_type) == 2){
                $testimonials = Testimonial::where('status', 1)->where('category', 1)->select('comment', 'rating', 'name', 'designation', 'image')->get();
            } else {
                $testimonials = Testimonial::where('status', 1)->where('category', 2)->select('comment', 'rating', 'name', 'designation', 'image')->get();
            }
        } else {
               $testimonials = Testimonial::where('status', 1)->where('category', 2)->select('comment', 'rating', 'name', 'designation', 'image')->get();
        }

        return view('frontend.home', compact('countries', 'jobs', 'companies', 'categories', 'vacancies', 'live_job', 'new_job', 'companies_count', 'candidate_count', 'testimonials'));
    }

    public function candidate_profile($id = null){

        try{

            $user_id = Auth::id();
            $today = date('Y-m-d');
            $plan_expire =  Auth::user()->plan_expire;
            $limit = Auth::user()->profile_view_limit;
            if($plan_expire != NULL && $today <= $plan_expire && $limit != 0){

            $profile_view = ProfileView::where('candidate_id', $id)->where('employer_id', $user_id)->select('id')->first();
            if(empty($profile_view)){
                $ProfileView = new ProfileView();
                $ProfileView->candidate_id = $id;
                $ProfileView->employer_id = $user_id;
                $ProfileView->save();
                User::where('id', $user_id)
                    ->update([
                    'profile_view_limit' => Auth::user()->profile_view_limit-1,
                ]);
            }

            $profile = User::join('job_seekers_details', 'job_seekers_details.seeker_id', '=', 'users.id')
            ->join('categories', 'categories.id', '=', 'job_seekers_details.sub_category')
            ->join('cities', 'cities.id', '=', 'users.city')
            ->join('countries', 'countries.id', '=', 'users.country')
            ->join('states', 'states.id', '=', 'users.state')
            ->join('designations', 'designations.id', '=', 'job_seekers_details.designation_id')
            ->join('educations', 'educations.id', '=', 'job_seekers_details.education')
            ->select('categories.name as cat', 
                'users.id', 
                'users.name', 
                'users.profile_image', 
                'users.email', 'users.mobile', 
                'users.gender', 
                'users.date_of_birth', 
                'users.address', 
                'designations.name as designation',
                'educations.name as education',
                'cities.name as city',
                'states.name as state',
                'countries.country_name as country',
                'job_seekers_details.experience_years', 
                'job_seekers_details.experience_months',
                'job_seekers_details.key_skills',
                'job_seekers_details.salary_lakhs',
                'job_seekers_details.salary_thousands',
                'job_seekers_details.resume'
            )
            ->where('users.id', $id)->first();
            $countries = Country::all(); 
             
            return view('frontend.pages.candidate_profile', compact('profile', 'countries'));

            } else {
               return redirect()->route('membership-plan');
            }

        } catch (Exception $exception) {
            return back();
        }

    }
    

    public function company_details($id = null){
        try{

            $countries = Country::all();
            $company = \DB::table("users")
            ->join('cities', 'cities.id', '=', 'users.city')
            ->join('states', 'states.id', '=', 'users.state')
            ->select('users.id', 'users.name', 'users.profile_image', 'users.employer_name', 'cities.name as city',
         'users.address', 'states.name as state')
            ->where('users.status', 1)  
            ->where('users.user_type', 2)
            ->where('users.id', $id)
            ->first(); 

            $jobs = \DB::table("jobs")
            ->join('users', 'users.id', '=', 'jobs.employer_id')
            ->join('cities', 'cities.id', '=', 'jobs.city_id')
            ->select('jobs.id', 'jobs.title', 'jobs.salary', 'jobs.job_type', 'jobs.created_at', 'users.profile_image', 'users.id as company_id', 'cities.name as city')
            ->where('jobs.status', 1)
            ->where('users.status', 1) 
            ->where('jobs.employer_id', $id)   
            ->where('jobs.created_at', '>', now()->subDays(30)->endOfDay())->inRandomOrder()->paginate(25);
      
            return view('frontend.pages.company_details', compact('countries', 'company', 'jobs'));

        } catch (Exception $exception) {
            return back();
        }
    }

    public function action(Request $request){
       
        $query = $request->get('query');
        $jobs = \DB::table("jobs")
            ->join('users', 'users.id', '=', 'jobs.employer_id')
            ->select('jobs.title')
            ->where('jobs.status', 1)
            ->where('users.country', $request->country_id)
            ->where('users.status', 1) 
            ->where('jobs.title',  'like', '%'.$query.'%')  
            ->where('jobs.created_at', '>', now()->subDays(30)->endOfDay())
            ->groupBy('jobs.title')
            ->inRandomOrder()->limit(10)->get();
        $output = '';
        foreach($jobs as $row){
            $output .= '<li><a href="'.route('search-job', ['search' => ''.$row->title.'', 'country_id' => $request->country_id]).'">'.$row->title.'</a></li>';
        }
          $data = array(
           'table_data'  => $output,
          );
          echo json_encode($data);

    }

    public function search_job($search = null, $country_id = null){
        try {

            $jobs = \DB::table("jobs")
            ->join('users', 'users.id', '=', 'jobs.employer_id')
            ->join('cities', 'cities.id', '=', 'jobs.city_id')
            ->select('jobs.id', 'jobs.title', 'jobs.salary', 'jobs.job_type', 'jobs.created_at', 'users.profile_image', 'users.id as company_id', 'cities.name as city')
            ->where('jobs.status', 1)
            ->where('jobs.title', $search)
            ->where('users.status', 1)  
            ->where('users.country', $country_id)  
            ->where('jobs.created_at', '>', now()->subDays(30)->endOfDay())->inRandomOrder()->paginate(15);

            //dd($jobs);

            $categories = Category::where('status', 1)->where('parent_id', NULL)->select('name', 'id')->get();
            $countries = Country::all();
            return view('frontend.pages.jobs', compact('countries', 'jobs', 'categories'));

        } catch (Exception $exception) {
            return back();
        }
    }
    

    public function job_filter(Request $request){
        try {
            $jobs = \DB::table("jobs")
            ->join('users', 'users.id', '=', 'jobs.employer_id')
            ->join('cities', 'cities.id', '=', 'jobs.city_id')
            ->select('jobs.id', 'jobs.title', 'jobs.salary', 'jobs.job_type', 'jobs.created_at', 'users.profile_image', 'users.id as company_id', 'cities.name as city')
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
            return view('frontend.pages.job_filter', compact('jobs'));
        } catch (Exception $exception) {
            return back();
        }
    }


    public function candidate_filter(Request $request){
        try {

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

            if($request->category){
                $candidates->where('job_seekers_details.category', $request->category);
            }
            if($request->sub_category){
                $candidates->where('job_seekers_details.sub_category', $request->sub_category);
            }

            $candidates = $candidates->get();

            return view('frontend.pages.candidate_filter', compact('candidates'));
        } catch (Exception $exception) {
            return back();
        }
    }

    public function company_filter(Request $request){
        try {

            $companies = \DB::table("users")
            ->join('cities', 'cities.id', '=', 'users.city')
            ->select('users.id', 'users.name', 'users.profile_image', 'users.employer_name', 'cities.name as city')
            ->where('users.status', 1)  
            ->where('users.user_type', 2);
     
            if($request->country){
                $companies->where('users.country', $request->country);
            }
            if($request->state){
                $companies->where('users.state', $request->state);
            }
            if($request->city){
                $companies->where('users.city', $request->city);
            }  
            if($request->company_name){
                $companies->where('users.employer_name', 'like', '%'.$request->company_name.'%');
            }

            $companies = $companies->get();

            return view('frontend.pages.company_filter', compact('companies'));
        } catch (Exception $exception) {
            return back();
        }
    }

    public function login() {
        $countries = Country::all();
        return view('frontend.pages.login', compact('countries'));
    }
    
    public function register() {
        $countries = Country::all();
        return view('frontend.pages.register', compact('countries'));
    }
    
    public function jobs() {
        $countries = Country::all();
        $user_id = Auth::id();
        $function_area =  JobSeekersDetail::where('seeker_id', $user_id)->select('sub_category')->first();
        if(!empty($function_area)){

           $jobs = \DB::table("jobs")
            ->join('users', 'users.id', '=', 'jobs.employer_id')
            ->join('cities', 'cities.id', '=', 'jobs.city_id')
            ->select('jobs.id', 'jobs.title', 'jobs.salary', 'jobs.job_type', 'jobs.created_at', 'users.profile_image', 'users.id as company_id', 'cities.name as city')
            ->where('jobs.status', 1)
            ->where('jobs.sub_category', $function_area->sub_category)
            ->where('users.status', 1)  
            ->where('jobs.created_at', '>', now()->subDays(30)->endOfDay())->inRandomOrder()->paginate(15);

        } else {
            $jobs = \DB::table("jobs")
            ->join('users', 'users.id', '=', 'jobs.employer_id')
            ->join('cities', 'cities.id', '=', 'jobs.city_id')
            ->select('jobs.id', 'jobs.title', 'jobs.salary', 'jobs.job_type', 'jobs.created_at', 'users.profile_image', 'users.id as company_id', 'cities.name as city')
            ->where('jobs.status', 1)
            ->where('users.status', 1)  
            ->where('jobs.created_at', '>', now()->subDays(30)->endOfDay())->inRandomOrder()->paginate(15);
        } 

        $categories = Category::where('status', 1)->where('parent_id', NULL)->select('name', 'id')->get();

        return view('frontend.pages.jobs', compact('countries', 'jobs', 'categories'));
    }
    
    public function companies() {
        $countries = Country::all();
        $companies = \DB::table("users")
        ->join('cities', 'cities.id', '=', 'users.city')
        ->select('users.id', 'users.name', 'users.profile_image', 'users.employer_name', 'cities.name as city')
        ->where('users.status', 1)  
        ->where('users.user_type', 2)
        ->inRandomOrder()->paginate(9); 
        return view('frontend.pages.companies', compact('countries', 'companies'));
    }
    

    public function candidates() {
          
        if((\Auth::user()->user_type) == 2){

            $countries = Country::all();
            $candidates = User::join('job_seekers_details', 'job_seekers_details.seeker_id', '=', 'users.id')
            ->join('categories', 'categories.id', '=', 'job_seekers_details.sub_category')
            ->join('cities', 'cities.id', '=', 'users.city')
            ->select('categories.name as cat', 'users.id', 'users.name', 'users.profile_image', 'job_seekers_details.experience_years', 'job_seekers_details.experience_months', 'cities.name as city')
            ->where('users.user_type', 3)
            ->where('users.status', 1)->where('categories.status', 1)->paginate(15);
            $categories = Category::where('status', 1)->where('parent_id', NULL)->select('name', 'id')->get();

        return view('frontend.pages.candidates', compact('countries', 'candidates', 'categories'));
        } else {
            \Auth::logout();
            \Session::flush();
            return redirect()->route('login');
        }
    }

    public function profileShow(){

        try{
            $user_id =  Auth::id();
            $user = User::where('id', $user_id)->first();
            $countries = Country::all();
            $states = State::where('country_id', $user->country)->select('name', 'id')->get();
            $cities = City::where('state_id', $user->state)->select('name', 'id')->get();
            $categories = Category::where('status', 1)->where('parent_id', NULL)->select('name', 'id')->get();
            $details = JobSeekersDetail::where('seeker_id', $user_id)->first();

            $sub_categories = Category::where('status', 1)->where('parent_id', '!=', NULL)->where('parent_id', @$details->category)->select('name', 'id')->get();

            $designations = Designation::where('status', 1)->select('name', 'id')->get();
            $educations = Education::where('status', 1)->select('name', 'id')->get();

            return view('frontend.pages.profile', compact('user', 'countries', 'states', 'cities', 'categories', 'details', 'sub_categories', 'designations', 'educations'));

        } catch (Exception $e) {
            return back();
        }
    }
   
    
    public function update_profile(Request $request){
        try{

            $inputs = $request->all(); 
            $user_id = Auth::id();
            $user = User::where('id', $user_id)->select('profile_image')->first();
            if(isset($inputs['profile_image']) or !empty($inputs['profile_image'])) {
                $image_name = rand(100000, 999999);
                $fileName = '';
                if($file = $request->hasFile('profile_image'))  {
                    $file = $request->file('profile_image') ;
                    $img_name = $file->getClientOriginalName();
                    $image_resize = Image::make($file->getRealPath()); 
                    $image_resize->resize(250, 250);
                    $fileName = $image_name.$img_name;
                    $image_resize->save(public_path('/uploads/user_images/' .$fileName));       
                }
                $fname ='/uploads/user_images/';
                $image = $fname.$fileName;
            }
            else{
                $image = $user->profile_image;
            }
            unset($inputs['profile_image']);
            $inputs['profile_image'] = $image;

            User::where('id', $user_id)
                ->update([
                'name' =>  $request->name,
                'email' =>  $request->email,
                'mobile' =>  $request->mobile,
                'address' =>  $request->address,
                'gender' =>  $request->gender,
                'date_of_birth' =>  $request->date_of_birth,
                'country' =>  $request->country,
                'state' =>  $request->state,
                'city' =>  $request->city,
                'profile_image' => $image,
                'profile_completion' => 1,
            ]);
            
            $detail = JobSeekersDetail::where('seeker_id', $user_id)->select('resume')->first();

            if(isset($inputs['resume']) or !empty($inputs['resume'])) {
                $image_name = rand(100000, 999999);
                $fileName = '';
                if($file = $request->hasFile('resume'))  {
                    $file = $request->file('resume') ;
                    $img_name = $file->getClientOriginalName();
                    $fileName = $image_name.$img_name;
                    $destinationPath = public_path().'/uploads/resumes/' ;
                    $file->move($destinationPath, $fileName);
                }
                $fname ='/uploads/resumes/';
                $image = $fname.$fileName;
            }
            else{
                $image = @$detail->resume;
            }
            unset($inputs['resume']);
            $inputs['resume'] = $image; 
            
            if(empty($detail)){
                $JobSeekersDetail = new JobSeekersDetail();
                $JobSeekersDetail->category = $request->category;
                $JobSeekersDetail->seeker_id = $user_id;
                $JobSeekersDetail->sub_category = $request->sub_category;
                $JobSeekersDetail->designation_id = $request->designation_id;
                $JobSeekersDetail->education = $request->education;
                $JobSeekersDetail->experience_years = $request->experience_years;
                $JobSeekersDetail->experience_months = $request->experience_months;
                $JobSeekersDetail->salary_lakhs = $request->salary_lakhs;
                $JobSeekersDetail->salary_thousands = $request->salary_thousands;
                $JobSeekersDetail->key_skills = $request->key_skills;
                $JobSeekersDetail->resume = $image;
                $JobSeekersDetail->save();
            } else {
                JobSeekersDetail::where('seeker_id', $user_id)
                ->update([
                    'category' => $request->category,
                    'sub_category' =>  $request->sub_category,
                    'designation_id' =>  $request->designation_id,
                    'education' =>  $request->education,
                    'experience_years' =>  $request->experience_years,
                    'experience_months' =>  $request->experience_months,
                    'salary_lakhs' =>  $request->salary_lakhs,
                    'salary_thousands' =>  $request->salary_thousands,
                    'key_skills' =>  $request->key_skills,
                    'resume' => $image,
                ]);
            }

            return redirect()->back()->with('profile_update', 'profile update');
        }
        catch (Exception $e) {
            return back();
        }
    }


    public function employer_profile_update(Request $request){
        try {

            $inputs = $request->all(); 
            $validator = (new User)->validate_employer_profile_update($inputs);
            if ($validator->fails()) {
                return redirect()->route('my-profile')
                ->withInput()->withErrors($validator);
            } 
            $user_id = Auth::id();
            $user = User::where('id', $user_id)->select('profile_image', 'video')->first();
            if(isset($inputs['profile_image']) or !empty($inputs['profile_image'])) {
                $image_name = rand(100000, 999999);
                $fileName = '';
                if($file = $request->hasFile('profile_image'))  {
                    $file = $request->file('profile_image') ;
                    $img_name = $file->getClientOriginalName();
                    $image_resize = Image::make($file->getRealPath()); 
                    $image_resize->resize(250, 250);
                    $fileName = $image_name.$img_name;
                    $image_resize->save(public_path('/uploads/user_images/' .$fileName));       
                }
                $fname ='/uploads/user_images/';
                $image = $fname.$fileName;
            }
            else{
                $image = $user->profile_image;
            }
            unset($inputs['profile_image']);
            $inputs['profile_image'] = $image;


            if(isset($inputs['video']) or !empty($inputs['video'])) {
                $image_name = rand(100000, 999999);
                $fileName = '';
                if($file = $request->hasFile('video'))  {
                    $file = $request->file('video') ;
                    $img_name = $file->getClientOriginalName();
                    $fileName = $image_name.$img_name;
                    $destinationPath = public_path().'/uploads/videos/' ;
                    $file->move($destinationPath, $fileName);
                }
                $fname ='/uploads/videos/';
                $video = $fname.$fileName;
            }
            else{
                $video = @$user->video;
            }
            unset($inputs['video']);
            $inputs['video'] = $video;

            User::where('id', $user_id)
                ->update([
                'employer_name' =>  $request->employer_name,      
                'name' =>  $request->name,
                'email' =>  $request->email,
                'mobile' =>  $request->mobile,
                'address' =>  $request->address,
                'gender' =>  $request->gender,
                'date_of_birth' =>  $request->date_of_birth,
                'country' =>  $request->country,
                'state' =>  $request->state,
                'city' =>  $request->city,
                'vacancy' =>  $request->vacancy,
                'profile_image' => $image,
                'video' => $video,
                'profile_completion' => 1,
            ]);

            return redirect()->back()->with('profile_update', 'profile update');

        } catch (Exception $e) {
            return back();
        }
    }


    public function getSubcategory(Request $request) {
      $main_id = $request->main_id;
      $category = \DB::table('categories')->where('parent_id', $main_id)->where('status', 1)->where('status', 1)->get();
      $subcategoryList='';
      $subcategoryList .= '<option value="">select</option>';
      foreach($category as $key => $subcategory)
      $subcategoryList .= '<option value="' . $subcategory->id . '">'. $subcategory->name .'</option>';
      return $subcategoryList; 
    }

    public function save_register(Request $request){
        try {

            $inputs = $request->all(); 
            $validator = (new User)->validate_front($inputs);
            if ($validator->fails()) {
                return redirect()->route('register')
                ->withInput()->withErrors($validator);
            }  

            if(isset($inputs['profile_image']) or !empty($inputs['profile_image'])) {
                $image_name = rand(100000, 999999);
                $fileName = '';
                if($file = $request->hasFile('profile_image'))  {
                    $file = $request->file('profile_image') ;
                    $img_name = $file->getClientOriginalName();
                    $image_resize = Image::make($file->getRealPath()); 
                    $image_resize->resize(250, 250);
                    $fileName = $image_name.$img_name;
                    $image_resize->save(public_path('/uploads/user_images/' .$fileName));       
                }
                $fname ='/uploads/user_images/';
                $image = $fname.$fileName;
            }
            else{
                $image = null;
            }
            unset($inputs['profile_image']);
            $inputs['profile_image'] = $image;
            $inputs['user_type'] = $request->role;
            $password = \Hash::make($inputs['password']);
            unset($inputs['password']);
            $inputs['password'] = $password;

            $user_id = (new User)->store($inputs);

            $name = $inputs['name'];
           // $data['id'] = $user_id;

            $email = $inputs['email'];
            // \Mail::send('email.user_verify', $data, function($message) use ($email){
            //     $message->from('no-reply@ez-job.co');
            //     $message->to($email);
            //     $message->subject('Register');
            // });
       
            $home = route('home');
            $link = route('emailverify', $user_id);
            $name = $name;
            $responce = $this->send_email($home, $link, $name, $email);
           return redirect()->back()->with('message_reg', 'Register Done!');
            
        } catch (Exception $e) {
            return back();
        }
    }


    public function send_email($home, $link, $name, $email){
        $postdata = http_build_query(
        array(
        'home' => $home,
        'link' => $link,
        'name' => $name,
        'email' => $email,
        )
        );
        $opts = array('http' =>
        array(
        'method'  => 'POST',
        'header'  => 'Content-Type: application/x-www-form-urlencoded',
        'content' => $postdata
        )
        );
        $context  = stream_context_create($opts);
        $result = file_get_contents('https://sspl20.com/jyoti/uttuapp/api/send-email-ez', false, $context);
        return $result;
    }



    public function emailVerify($user_id) {
        try{
            if($user_id){
                $user = User::where('id', $user_id)->select('user_type')->first();
                // if($user->user_type == 3){

                    User::where('id', $user_id)->update(['status' => '1', 'is_verify' => '1']);
                    $user_data = User::where('id', $user_id)->first();
                    \Auth::login($user_data);

                    return redirect()->route('home')->with('account_confirm', 'account_confirm');

                // } else {
                //     User::where('id', $user_id)->update(['is_verify' => '1']);
                //     return redirect()->route('approval-waiting', $user_id);
                // }
            }
        }
        catch(\Exception $e){
           // dd($e);
        }
    }


    public function postLogin(Request $request) {
        try{
        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'status' => 1
        ];
          
          $ip = $request->getClientIp();
          $inputs = $request->all();
        
            $validator = (new User)->validateLoginUser($inputs);
            if($validator->fails() ) {
                return back()->withErrors($validator)->withInput();
            }

            if (Auth::attempt($credentials))  {
                $user_data = User::where('email', $request->email)->first();
                \Auth::login($user_data);
                $LoginLog = new LoginLog();
                $LoginLog->username = $request->username;
                $LoginLog->is_login = 1;
                $LoginLog->user_id = $user_data->id;
                $LoginLog->ip = $ip;
                $LoginLog->save();       
                $redirectTo = \Session::get('redirect_url');
                if($redirectTo){
                   return Redirect::to('/'.$redirectTo);
                } else {

                if($user_data->profile_completion == 1){
                    return redirect()->route('home');
                } else {
                    return redirect()->route('my-profile');
                }

                }

            }  else {
                    $LoginLog = new LoginLog();
                    $LoginLog->username = $request->username;
                    $LoginLog->is_login = 0;
                    $LoginLog->ip = $ip;
                    $LoginLog->save();
                    return back()->with('failed_login', 'failed_login');
        }
              
    } catch(\exception $ex){
          // dd($ex);
            return back();
          }
    }


public function logout() {
    $user_id =  \Auth::id();
    \Auth::logout();
    \Session::flush();
    return redirect()->route('log-in');
}


    

}
