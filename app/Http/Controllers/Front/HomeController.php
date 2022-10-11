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
use App\Models\Blog;
use App\Models\Contact;
use App\Models\Testimonial;
use App\Models\ContentManagement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\LoginLog;
use App\Models\Designation;
// use ElfSundae\Laravel\Hashid\Facades\Hashid;
use App\Models\Job;
use App\Models\Faq;
use App\Models\Education;
use App\Models\Slider;
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

        $sliders = Slider::where('status', 1)->where('page', 'home')->where('deleted_at', NULL)->select('image', 'link', 'title')->get();

        return view('frontend.home', compact('countries', 'jobs', 'companies', 'categories', 'vacancies', 'live_job', 'new_job', 'companies_count', 'candidate_count', 'testimonials', 'sliders'));
    }

    public function blogs(){
        try {
            $blogs = Blog::where('status', 1)->select('title', 'image', 'url')->get();
            $countries = Country::all();
            $sliders = Slider::where('status', 1)->where('page', 'blog')->where('deleted_at', NULL)->select('image', 'link', 'title')->get();
            return view('frontend.pages.blogs', compact('countries', 'blogs', 'sliders'));
        } catch (Exception $exception) {
            return back();
        }
    }
    
    public function terms_and_conditions(){
        try{
            $countries = Country::all();
            $terms_and_conditions = ContentManagement::where('id', 1)->select('terms_condition')->first(); 
            return view('frontend.pages.term-condition', compact('terms_and_conditions', 'countries'));
        } catch(\Exception $ex){

        //dd($ex);
        return back();
        }
    } 

    public function privacy_policy(){
        try {
            $countries = Country::all();
            $privacy = ContentManagement::where('id', 1)->select('privacy_policy')->first(); 
            return view('frontend.pages.privacy_policy', compact('privacy', 'countries'));
        }
        catch (\Exception $exception) {
        return back();
        }
    }

    public function forgotPassword() {
        $countries = Country::all();
        return view('frontend.pages.forgot-password', compact('countries'));
    }

    public function updatePassword($user_id)  {

        $user_id = \decrypt($user_id);
        $user = User::where('id', $user_id)->first();
        $countries = Country::all();

        return view('frontend.pages.forgot_change_password', compact('user_id', 'user', 'countries'));
    }
    
    public function changePassword() {
        $countries = Country::all();
        return view('frontend.pages.change-password', compact('countries')); 
    }

    public function changePasswordStore(Request $request){
    
    try{
        $inputs = $request->all();
        $validator = (new User)->password_validate($inputs);
          if( $validator->fails() ) {
            return back()->withErrors($validator)->withInput();
        }

        $id =  Auth::id();
        $user = User::where('id', $id)->first();
        $password = \Hash::make($inputs['new_password']);
        $old_password = \Hash::make($inputs['old_password']);

        // dd($user->id);
     
        if (!\Hash::check($request->old_password, $user->password)){
          return back()->with('old_password_not_match', 'old_password_not_match');  

       } else {

             unset($inputs['new_password']);
        $inputs = $inputs + ['password' => $password];
       (new User)->store($inputs, $id);

       return back()->with('password_change', 'password_change');
       }    

    } catch(Exception $exception){

      return back();
    }

  }

    public function changePasswordForgot(Request $request) {
        try{
          $inputs = $request->all();

          $validator = (new User)->validate_password_forgot($inputs);
          if( $validator->fails() ) {
              return back()->withErrors($validator)->withInput();
          }
          
          $password = \Hash::make($inputs['new_password']);
          $id = $inputs['user_id'];
          unset($inputs['new_password']);

           $inputs = $inputs + ['password' => $password];
          //dd($inputs);
            (new User)->store($inputs, $id);
           //dd(User::find($id));

          return back()->with('success', 'Password Successfully Changed');
        } catch(Exception $exception){

        return back();
      }
    }

    public function checkEmail(Request $request)
    {
        try{
            $inputs = $request->all();
            // $validator = (new User)->validateForgotPasswordEmail($inputs);
            // if( $validator->fails() ) {
            //     return back()->withErrors($validator)->withInput();
            // }
            $user_detail = User::where('email', $inputs['email'])->first();
            if(!empty($user_detail)) {

                $user_id = \encrypt($user_detail->id);
                $email = $user_detail->email;

                // \Mail::send('email.forgot_password', $data, function($message) use($email){
                //     $message->from('no-reply@ez-job.co');
                //     $message->to($email);
                //     $message->subject('EZ Jobs - Forgot Password');
                // });

                $home = route('home');

                $link = route('update_password', $user_id);

                $postdata = http_build_query(
                    array(
                    'home' => $home,
                    'email' => $email,
                    'user_id' => $link,
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
                $result = file_get_contents('https://sspl20.com/jyoti/uttuapp/api/forgot-pasw', false, $context);
                
                //dd($result);
            }
            else{
                return back()->with('failure_email', 'Email not Found.');
            }

            return back()->with('success_forgot', 'Please Check Your Mail');

        } catch (\Exception $exception) {
         // dd($exception);
            return back()
                ->withInput()
                ->with('error', lang('messages.server_error').$exception->getMessage());
        }
    }

    public function faq(){

        $countries = Country::all();
        $faqs = Faq::where('status', 1)->select('title', 'description')->get();

        return view('frontend.pages.faq', compact('countries', 'faqs'));
    }

    public function about_us(){
        try {

        $user_id = Auth::id();
        if($user_id){
            if((\Auth::user()->user_type) == 2){
                $testimonials = Testimonial::where('status', 1)->where('category', 1)->select('comment', 'rating', 'name', 'designation', 'image')->get();
            } else {
                $testimonials = Testimonial::where('status', 1)->where('category', 2)->select('comment', 'rating', 'name', 'designation', 'image')->get();
            }
        } else {
               $testimonials = Testimonial::where('status', 1)->where('category', 2)->select('comment', 'rating', 'name', 'designation', 'image')->get();
        }

        $countries = Country::all();
        $new_job = Job::where('status', 1)->where('created_at', '>', now()->subDays(30)->endOfDay())->count();
        $companies_count = User::where('status', 1)->where('user_type', 2)->count();
        $candidate_count = User::where('status', 1)->where('user_type', 3)->count();

        return view('frontend.pages.about_us', compact('countries', 'new_job', 'companies_count', 'testimonials', 'candidate_count'));
        } catch (Exception $exception) {
            return back();
        }
    }

    public function contact_us(){
        $countries = Country::all();
        $two = mt_rand(1,9); 
        $three = mt_rand(100,999);
        return view('frontend.pages.contact_us', compact('countries', 'two', 'three'));
    }
    
    public function contactEnquiry(Request $request){
        try{
            $inputs = $request->all();
            $validator = (new Contact)->front_contact($inputs);
            if( $validator->fails() ) {
              return back()->withErrors($validator)->withInput();
            } 

            $rec_total = $request->two + $request->three;
            if($request->rec_value == $rec_total){


            if($request->last_name){
                $inputs['name'] = $request->first_name .' '.$request->last_name;
            } else {
                $inputs['name'] = $request->first_name;
            }
     
            (new Contact)->store($inputs);
            // $email = $inputs['email'];
            // $data['mail_data'] = $inputs;
             
            // \Mail::send('email.enquiry', $data, function($message) use ($email){
            //     $message->from($email);
            //     $message->to('navjot@shailersolutions.com');
            //     $message->subject('Enquiry');
            // });

            return back()->with('enquiry_sub', lang('messages.created', lang('comment_sub')));
        } else {
            return back()->with('recap_sub', lang('messages.created', lang('comment_sub')));
        }

        } catch(Exception $exception) {
           // dd($exception);
         
                return back();
        }
    }

    public function blog_details($url = null){
        try {

            $blog = Blog::where('status', 1)->where('url', $url)->select('title', 'image', 'content')->first();
            $countries = Country::all();
            return view('frontend.pages.blog_detail', compact('countries', 'blog'));

        } catch (Exception $exception) {
            return back();
        }
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
        try {
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
        $sliders = Slider::where('status', 1)->where('page', 'find_job')->where('deleted_at', NULL)->select('image', 'link', 'title')->get();

     //   dd($sliders);

        return view('frontend.pages.jobs', compact('countries', 'jobs', 'categories', 'sliders'));
        } catch (Exception $e) {
            return back();
        }
    }


    public function most_popular_vacancies($title = null){
        try {
        
        $countries = Country::all();
        $jobs = \DB::table("jobs")
        ->join('users', 'users.id', '=', 'jobs.employer_id')
        ->join('cities', 'cities.id', '=', 'jobs.city_id')
        ->select('jobs.id', 'jobs.title', 'jobs.salary', 'jobs.job_type', 'jobs.created_at', 'users.profile_image', 'users.id as company_id', 'cities.name as city')
        ->where('jobs.status', 1)
        ->where('jobs.title', $title) 
        ->where('jobs.created_at', '>', now()->subDays(30)->endOfDay())->inRandomOrder()->paginate(15);
        $categories = Category::where('status', 1)->where('parent_id', NULL)->select('name', 'id')->get();

        return view('frontend.pages.jobs', compact('countries', 'jobs', 'categories'));

        } catch (Exception $e) {
            return back();
        }
    }

    public function functional_area($id = null){
        try {
            $categories = Category::where('status', 1)->where('parent_id', $id)->select('id', 'name', 'icon', 'url')->inRandomOrder()->get();
            $countries = Country::all();
            $job = Category::where('id', $id)->select('name')->first();
            return view('frontend.pages.functional_area', compact('countries', 'categories', 'job'));

        } catch (Exception $e) {
            return back();
        }
    }

    public function job_by_functional_area($id = null){
        try {

        $countries = Country::all();
        $jobs = \DB::table("jobs")
        ->join('users', 'users.id', '=', 'jobs.employer_id')
        ->join('cities', 'cities.id', '=', 'jobs.city_id')
        ->select('jobs.id', 'jobs.title', 'jobs.salary', 'jobs.job_type', 'jobs.created_at', 'users.profile_image', 'users.id as company_id', 'cities.name as city')
        ->where('jobs.status', 1)
        ->where('jobs.sub_category', $id) 
        ->where('jobs.created_at', '>', now()->subDays(30)->endOfDay())->inRandomOrder()->paginate(15);
        $categories = Category::where('status', 1)->where('parent_id', NULL)->select('name', 'id')->get();

        return view('frontend.pages.jobs', compact('countries', 'jobs', 'categories'));

        } catch (Exception $e) {
            return back();
        }

    }
    
    public function companies() {
        try {
            $countries = Country::all();
            $companies = \DB::table("users")
            ->join('cities', 'cities.id', '=', 'users.city')
            ->select('users.id', 'users.name', 'users.profile_image', 'users.employer_name', 'cities.name as city')
            ->where('users.status', 1)  
            ->where('users.user_type', 2)
            ->inRandomOrder()->paginate(9); 
            $sliders = Slider::where('status', 1)->where('page', 'companies')->where('deleted_at', NULL)->select('image', 'link', 'title')->get();
            return view('frontend.pages.companies', compact('countries', 'companies', 'sliders'));

        } catch (Exception $e) {
            return back();
        }
    }
    

    public function candidates() {
        try {  
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
        } catch (Exception $e) {
            return back();
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
            //dd($responce);
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
