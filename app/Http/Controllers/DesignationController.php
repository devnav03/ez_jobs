<?php

namespace App\Http\Controllers;
/**
 * :: Designation Controller ::
 * 
 *
 **/
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use Files;
use Illuminate\Support\Facades\Storage;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController  extends  Controller{

    public function index() {
        if((\Auth::user()->user_type) == 1){
            return view('admin.designation.index');
        } else {
            \Auth::logout();
            \Session::flush();
            return redirect()->route('admin');
        }
    }
  
    public function create() {
        if((\Auth::user()->user_type) == 1){
        return view('admin.designation.create');
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
            $validator = (new Designation)->validate($inputs);
            if( $validator->fails() ) {
                return back()->withErrors($validator)->withInput();
            }
         
            (new Designation)->store($inputs);
           
            return redirect()->route('designation.index')
                ->with('success', lang('messages.created', 'Designation'));
        } catch (\Exception $exception) {
         
            return redirect()->route('designation.create')
                ->withInput()
                ->with('error', lang('messages.server_error').$exception->getMessage());
        }
    }

  
    public function update(Request $request, $id = null) {
        $result = (new Designation)->find($id);
        if (!$result) {
            abort(401);
        }
        $inputs = $request->all();
        try {
   
            // $inputs = $inputs + [
            //         'updated_by' => Auth::id(),
            // ];   

            (new Designation)->store($inputs, $id);
            return redirect()->route('designation.index')
                ->with('success', lang('messages.updated', 'Designation'));
        } catch (\Exception $exception) {
            return redirect()->route('designation.edit', [$id])
                ->withInput()
                ->with('error', lang('messages.server_error'));
        }
    }

  
    public function edit($id = null) {
        $result = (new Designation)->find($id);
        if (!$result) {
            abort(401);
        }

        if((\Auth::user()->user_type) == 1){
            return view('admin.designation.create', compact('result'));
        } else {
            \Auth::logout();
            \Session::flush();
            return redirect()->route('admin');
        }
    }


    public function designationPaginate(Request $request, $pageNumber = null) {
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

            $data = (new Designation)->getCategory($inputs, $start, $perPage);
            $totalGameMaster = (new Designation)->totalCategory($inputs);
            $total = $totalGameMaster->total;
     //   dd($data);

        } else {

            $data = (new Designation)->getCategory($inputs, $start, $perPage);
            $totalGameMaster = (new Designation)->totalCategory();
            $total = $totalGameMaster->total;
        }

       // dd($data);

        return view('admin.designation.load_data', compact('inputs', 'data', 'total', 'page', 'perPage'));
    }

 
    public function designationToggle($id = null) {
        if (!\Request::isMethod('post') && !\Request::ajax()) {
            return lang('messages.server_error');
        }

        try {
            $game = Designation::find($id);
        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('Designation')));
        }

        $game->update(['status' => !$game->status]);
        $response = ['status' => 1, 'data' => (int)$game->status . '.gif'];
        // return json response
        return json_encode($response);
    }

  
    public function designationAction(Request $request)  {

        $inputs = $request->all();
        if (!isset($inputs['tick']) || count($inputs['tick']) < 1) {
            return redirect()->route('designation.index')
                ->with('error', lang('messages.atleast_one', string_manip(lang('Designation'))));
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

        Designation::whereRaw('id IN (' . $ids . ')')->update(['status' => $status]);
        return redirect()->route('designation.index')
            ->with('success', lang('messages.updated', lang('game_master.game')));
    }


    public function drop($id) {

        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }

        $result = (new Designation)->find($id);
        if (!$result) {
            // use ajax return response not abort because ajaz request abort not works
            abort(401);
        }

        try {
            // get the unit w.r.t id
            $result = (new Designation)->find($id);
            if($result->status == 1) {
                $response = ['status' => 0, 'message' => lang('designation.designation_in_use')];
            }
             else {
                (new Designation)->tempDelete($id);
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
