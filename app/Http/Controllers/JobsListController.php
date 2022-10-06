<?php

namespace App\Http\Controllers;
/**
 * :: Jobs List Controller ::
 * 
 *
 **/
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use Files;
use Illuminate\Support\Facades\Storage;
use App\Models\Job;
use App\Models\Category;
use App\Models\Country;
use App\Models\Education;
use App\User;
use Illuminate\Http\Request;

class JobsListController  extends  Controller{

    public function index() {
        if((\Auth::user()->user_type) == 1){

            $countries = Country::all();
            $education = Education::all();
            $users = User::where('user_type', 2)->select('name', 'id')->get();
            $categories = Category::where('status', 1)->where('parent_id', NULL)->select('name', 'id')->get();
            return view('admin.job.index', compact('categories', 'countries', 'education', 'users'));
        } else {
            \Auth::logout();
            \Session::flush();
            return redirect()->route('admin');
        }
    }
  
    public function create() {
        if((\Auth::user()->user_type) == 1){
        return view('admin.job.create');
        } else {
            \Auth::logout();
            \Session::flush();
            return redirect()->route('admin');
        }
    }

    public function  store(Request $request) {
        
        $inputs = $request->all();
       // dd($request);
        try {
            $validator = (new Job)->validate($inputs);
            if( $validator->fails() ) {
                return back()->withErrors($validator)->withInput();
            }
         
            (new Job)->store($inputs);
           
            return redirect()->route('jobs-list.index')
                ->with('success', lang('messages.created', 'Job'));
        } catch (\Exception $exception) {
         
            return redirect()->route('jobs-list.create')
                ->withInput()
                ->with('error', lang('messages.server_error').$exception->getMessage());
        }
    }
    

    public function job_applies($id = null){
        try {

            $candidates = User::join('job_seekers_details', 'job_seekers_details.seeker_id', '=', 'users.id')
            ->join('job_applies', 'job_applies.user_id', '=', 'users.id')
            ->join('categories', 'categories.id', '=', 'job_seekers_details.sub_category')
            ->join('cities', 'cities.id', '=', 'users.city')
            ->select('categories.name as cat', 'users.id', 'users.name', 'users.profile_image', 'job_seekers_details.experience_years', 'job_seekers_details.experience_months', 'cities.name as city', 'job_applies.created_at')
            ->where('users.user_type', 3)
            ->where('users.status', 1)
            ->where('job_applies.job_id', $id)->get();
            
            $job = Job::where('id', $id)->select('title', 'created_at', 'id')->first();

            return view('admin.job.job_applies', compact('candidates', 'job'));
            
        } catch (Exception $e) {
            return back();
        }
    }
  
    public function update(Request $request, $id = null) {
        $result = (new Job)->find($id);
        if (!$result) {
            abort(401);
        }
        $inputs = $request->all();
        try { 

            (new Job)->store($inputs, $id);
            return redirect()->route('jobs-list.index')
                ->with('success', lang('messages.updated', 'Job'));
        } catch (\Exception $exception) {
            return redirect()->route('jobs-list.edit', [$id])
                ->withInput()
                ->with('error', lang('messages.server_error'));
        }
    }

  
    public function edit($id = null) {
        $result = (new Job)->find($id);
        if (!$result) {
            abort(401);
        }

        if((\Auth::user()->user_type) == 1){

           $job = \DB::table('jobs')
                ->join('categories', 'categories.id', '=','jobs.category_id')
                ->join('categories as c2', 'c2.id', '=','jobs.sub_category')
                ->join('users', 'users.id', '=','jobs.employer_id')
                ->join('states', 'states.id', '=','jobs.state_id')
                ->join('cities', 'cities.id', '=','jobs.city_id')
                ->join('educations', 'educations.id', '=','jobs.qualifications')
                ->select('jobs.title', 'jobs.category_id', 'jobs.sub_category', 'jobs.salary', 'jobs.job_type', 'jobs.created_at', 'categories.name as cat', 'c2.name as sub_cat', 'jobs.status', 'users.name as member_name', 'users.employer_name', 'users.mobile', 'users.email', 'states.name as state', 'cities.name as city', 'educations.name as education', 'jobs.job_description', 'users.profile_image', 'jobs.id', 'jobs.number_of_positions')
                ->where('jobs.id', $id)
                ->first();

            return view('admin.job.create', compact('result', 'job'));
        } else {
            \Auth::logout();
            \Session::flush();
            return redirect()->route('admin');
        }
    }


    public function Paginate(Request $request, $pageNumber = null) {
        // dd($request);

        if (!\Request::isMethod('post') && !\Request::ajax()) { //
            return lang('messages.server_error');
        }

        $inputs = $request->all();
        $page = 1;
        if (isset($inputs['page']) && (int)$inputs['page'] > 0) {
            $page = $inputs['page'];
        }

        $perPage = 20;
        if (isset($inputs['perpage']) && (int)$inputs['perpage'] > 0) {
            $perPage = $inputs['perpage'];
        }

        $start = ($page - 1) * $perPage;
        if (isset($inputs['form-search']) && $inputs['form-search'] != '') {
            $inputs = array_filter($inputs);
            unset($inputs['_token']);

            $data = (new Job)->getJobs($inputs, $start, $perPage);
            $totalGameMaster = (new Job)->totalJobs($inputs);
            $total = $totalGameMaster->total;
           // dd($data);

        } else {

            $data = (new Job)->getJobs($inputs, $start, $perPage);
            $totalGameMaster = (new Job)->totalJobs();
            $total = $totalGameMaster->total;
        }

       // dd($data);

        return view('admin.job.load_data', compact('inputs', 'data', 'total', 'page', 'perPage'));
    }

 
    public function Toggle($id = null) {
        if (!\Request::isMethod('post') && !\Request::ajax()) {
            return lang('messages.server_error');
        }

        try {
            $game = Job::find($id);
        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('Job')));
        }

        $game->update(['status' => !$game->status]);
        $response = ['status' => 1, 'data' => (int)$game->status . '.gif'];
        // return json response
        return json_encode($response);
    }

  
    public function Action(Request $request)  {

        $inputs = $request->all();
        if (!isset($inputs['tick']) || count($inputs['tick']) < 1) {
            return redirect()->route('jobs-list.index')
                ->with('error', lang('messages.atleast_one', string_manip(lang('Job'))));
        }

        $ids = '';
        foreach ($inputs['tick'] as $key => $value) {
            $ids .= $value . ',';
        }

        $ids = rtrim($ids, ',');
        $status = 0;
        if (isset($inputs['active'])) {
            $status = 1;
        }

        Job::whereRaw('id IN (' . $ids . ')')->update(['status' => $status]);
        return redirect()->route('jobs-list.index')
            ->with('success', lang('messages.updated', lang('game_master.game')));
    }


    public function drop($id) {

        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }

        $result = (new Job)->find($id);
        if (!$result) {
            // use ajax return response not abort because ajaz request abort not works
            abort(401);
        }

        try {
            // get the unit w.r.t id
            $result = (new Job)->find($id);
            if($result->status == 1) {
                $response = ['status' => 0, 'message' => lang('Job In Use')];
            }
             else {
                (new Job)->tempDelete($id);
                $response = ['status' => 1, 'message' => lang('messages.deleted', lang('Job'))];
             }
        }
        catch (Exception $exception) {
            $response = ['status' => 0, 'message' => lang('messages.server_error')];
        }        
        // return json response
        return json_encode($response);
    }

    

}
