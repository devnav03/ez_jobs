<?php

namespace App\Http\Controllers;
/**
 * :: Plan Controller ::
 * 
 *
 **/
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use Files;
use Illuminate\Support\Facades\Storage;
use App\Models\Plan;
use Illuminate\Http\Request;


class PlanController  extends  Controller{

    public function index() {
        if((\Auth::user()->user_type) == 1){
            return view('admin.plans.index');
        } else {
            \Auth::logout();
            \Session::flush();
            return redirect()->route('admin');
        }
    }
  
    public function create() {
        if((\Auth::user()->user_type) == 1){
        return view('admin.plans.create');
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
            $validator = (new Plan)->validate($inputs);
            if( $validator->fails() ) {
                return back()->withErrors($validator)->withInput();
            }
         
            (new Plan)->store($inputs);
           
            return redirect()->route('plans.index')
                ->with('success', lang('messages.created', 'Plan'));
        } catch (\Exception $exception) {
         
            return redirect()->route('plans.create')
                ->withInput()
                ->with('error', lang('messages.server_error').$exception->getMessage());
        }
    }

  
    public function update(Request $request, $id = null) {
        $result = (new Plan)->find($id);
        if (!$result) {
            abort(401);
        }
        $inputs = $request->all();
        try {

        if($request->category == 1){
            if(isset($request->job_search))
            $job_search = $inputs['job_search'];
            if(isset($request->job_branding))
            $job_branding = $inputs['job_branding'];
            $inputs = $inputs + [
                'job_search'  => !empty($job_search)?$job_search:0,
                'job_branding'  => !empty($job_branding)?$job_branding:0,
            ];  
        }

            (new Plan)->store($inputs, $id);
            return redirect()->route('plans.index')
                ->with('success', lang('messages.updated', 'Plans'));
        } catch (\Exception $exception) {
           // dd($exception);

            return redirect()->route('plans.edit', [$id])
                ->withInput()
                ->with('error', lang('messages.server_error'));
        }
    }

  
    public function edit($id = null) {
        $result = (new Plan)->find($id);
        if (!$result) {
            abort(401);
        }

        if((\Auth::user()->user_type) == 1){
            return view('admin.plans.create', compact('result'));
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

       // dd('test');

        $start = ($page - 1) * $perPage;
        if (isset($inputs['form-search']) && $inputs['form-search'] != '') {
            $inputs = array_filter($inputs);
            unset($inputs['_token']);

            $data = (new Plan)->getPlan($inputs, $start, $perPage);
            $totalGameMaster = (new Plan)->totalPlan($inputs);
            $total = $totalGameMaster->total;
     //   dd($data);

        } else {

            $data = (new Plan)->getPlan($inputs, $start, $perPage);
            $totalGameMaster = (new Plan)->totalPlan();
            $total = $totalGameMaster->total;
        }

       // dd($data);

        return view('admin.plans.load_data', compact('inputs', 'data', 'total', 'page', 'perPage'));
    }

 
    public function Toggle($id = null) {
        if (!\Request::isMethod('post') && !\Request::ajax()) {
            return lang('messages.server_error');
        }

        try {
            $game = Plan::find($id);
        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('Plan')));
        }

        $game->update(['status' => !$game->status]);
        $response = ['status' => 1, 'data' => (int)$game->status . '.gif'];
        // return json response
        return json_encode($response);
    }

  
    public function Action(Request $request)  {

        $inputs = $request->all();
        if (!isset($inputs['tick']) || count($inputs['tick']) < 1) {
            return redirect()->route('plans.index')
                ->with('error', lang('messages.atleast_one', string_manip(lang('Plan'))));
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

        Plan::whereRaw('id IN (' . $ids . ')')->update(['status' => $status]);
        return redirect()->route('plans.index')
            ->with('success', lang('messages.updated', lang('game_master.game')));
    }


    public function drop($id) {

        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }

        $result = (new Plan)->find($id);
        if (!$result) {
            // use ajax return response not abort because ajaz request abort not works
            abort(401);
        }

        try {
            // get the unit w.r.t id
            $result = (new Plan)->find($id);
            if($result->status == 1) {
                $response = ['status' => 0, 'message' => lang('designation.designation_in_use')];
            }
             else {
                (new Plan)->tempDelete($id);
                $response = ['status' => 1, 'message' => lang('messages.deleted', lang('Designation.Designation'))];
             }
        }
        catch (Exception $exception) {
            $response = ['status' => 0, 'message' => lang('messages.server_error')];
        }        
        // return json response
        return json_encode($response);
    }

    

}
