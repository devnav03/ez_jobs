<?php

namespace App\Http\Controllers;
/**
 * :: Employer Controller ::
 * 
 *
 **/
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use Files;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

use Illuminate\Http\Request;

class EmployerController  extends  Controller{

    public function index() {
        if((\Auth::user()->user_type) == 1){
            return view('admin.employer.index');
        } else {
            \Auth::logout();
            \Session::flush();
            return redirect()->route('admin');
        }
    }
  
    public function create() {
        if((\Auth::user()->user_type) == 1){
        return view('admin.employer.create');
        } else {
            \Auth::logout();
            \Session::flush();
            return redirect()->route('admin');
        }
    }

  
    public function edit($id = null) {
        $result = (new User)->find($id);
        if (!$result) {
            abort(401);
        }

        if((\Auth::user()->user_type) == 1){
           
            $state = State::where('id', $result->state)->select('name')->first();
            $city =  City::where('id', $result->city)->select('name')->first();
            $country = Country::where('id', $result->country)->select('country_name  as name')->first();

            return view('admin.employer.create', compact('result', 'city', 'state', 'country'));
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

            $data = (new User)->getEmployer($inputs, $start, $perPage);
            $totalGameMaster = (new User)->totalEmployer($inputs);
            $total = $totalGameMaster->total;
     //   dd($data);

        } else {

            $data = (new User)->getEmployer($inputs, $start, $perPage);
            $totalGameMaster = (new User)->totalEmployer();
            $total = $totalGameMaster->total;
        }

       // dd($data);

        return view('admin.employer.load_data', compact('inputs', 'data', 'total', 'page', 'perPage'));
    }

 
    public function Toggle($id = null) {
        if (!\Request::isMethod('post') && !\Request::ajax()) {
            return lang('messages.server_error');
        }

        try {
            $game = Employer::find($id);
        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('Employer')));
        }

        $game->update(['status' => !$game->status]);
        $response = ['status' => 1, 'data' => (int)$game->status . '.gif'];
        // return json response
        return json_encode($response);
    }

  
    public function Action(Request $request)  {

        $inputs = $request->all();
        if (!isset($inputs['tick']) || count($inputs['tick']) < 1) {
            return redirect()->route('employer.index')
                ->with('error', lang('messages.atleast_one', string_manip(lang('employer'))));
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

        Employer::whereRaw('id IN (' . $ids . ')')->update(['status' => $status]);
        return redirect()->route('employer.index')
            ->with('success', lang('messages.updated', lang('game_master.game')));
    }


    public function drop($id) {

        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }

        $result = (new Employer)->find($id);
        if (!$result) {
            // use ajax return response not abort because ajaz request abort not works
            abort(401);
        }

        try {
            // get the unit w.r.t id
            $result = (new Employer)->find($id);
            if($result->status == 1) {
                $response = ['status' => 0, 'message' => lang('Employer in use')];
            }
             else {
                (new Employer)->tempDelete($id);
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
