<?php

namespace App\Http\Controllers;
/**
 * :: Education Controller ::
 * 
 *
 **/
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use Files;
use Illuminate\Support\Facades\Storage;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController  extends  Controller{

    public function index() {
        if((\Auth::user()->user_type) == 1){
            return view('admin.education.index');
        } else {
            \Auth::logout();
            \Session::flush();
            return redirect()->route('admin');
        }
    }
  
    public function create() {
        if((\Auth::user()->user_type) == 1){
        return view('admin.education.create');
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
            $validator = (new Education)->validate($inputs);
            if( $validator->fails() ) {
                return back()->withErrors($validator)->withInput();
            }
         
            (new Education)->store($inputs);
           
            return redirect()->route('education.index')
                ->with('success', lang('messages.created', 'Education'));
        } catch (\Exception $exception) {
         
            return redirect()->route('education.create')
                ->withInput()
                ->with('error', lang('messages.server_error').$exception->getMessage());
        }
    }

  
    public function update(Request $request, $id = null) {
        $result = (new Education)->find($id);
        if (!$result) {
            abort(401);
        }
        $inputs = $request->all();
        try {
   
            // $inputs = $inputs + [
            //         'updated_by' => Auth::id(),
            // ];   

            (new Education)->store($inputs, $id);
            return redirect()->route('education.index')
                ->with('success', lang('messages.updated', 'Education'));
        } catch (\Exception $exception) {
            return redirect()->route('education.edit', [$id])
                ->withInput()
                ->with('error', lang('messages.server_error'));
        }
    }

  
    public function edit($id = null) {
        $result = (new Education)->find($id);
        if (!$result) {
            abort(401);
        }

        if((\Auth::user()->user_type) == 1){
            return view('admin.education.create', compact('result'));
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

            $data = (new Education)->getEducations($inputs, $start, $perPage);
            $totalGameMaster = (new Education)->totalEducations($inputs);
            $total = $totalGameMaster->total;
            // dd($data);

        } else {

            $data = (new Education)->getEducations($inputs, $start, $perPage);
            $totalGameMaster = (new Education)->totalEducations();
            $total = $totalGameMaster->total;
        }

       // dd($data);

        return view('admin.education.load_data', compact('inputs', 'data', 'total', 'page', 'perPage'));
    }

 
    public function Toggle($id = null) {
        if (!\Request::isMethod('post') && !\Request::ajax()) {
            return lang('messages.server_error');
        }

        try {
            $game = Education::find($id);
        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('Education')));
        }

        $game->update(['status' => !$game->status]);
        $response = ['status' => 1, 'data' => (int)$game->status . '.gif'];
        // return json response
        return json_encode($response);
    }

  
    public function Action(Request $request)  {

        $inputs = $request->all();
        if (!isset($inputs['tick']) || count($inputs['tick']) < 1) {
            return redirect()->route('education.index')
                ->with('error', lang('messages.atleast_one', string_manip(lang('Education'))));
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

        Education::whereRaw('id IN (' . $ids . ')')->update(['status' => $status]);
        return redirect()->route('education.index')
            ->with('success', lang('messages.updated', lang('game_master.game')));
    }


    public function drop($id) {

        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }

        $result = (new Education)->find($id);
        if (!$result) {
            // use ajax return response not abort because ajaz request abort not works
            abort(401);
        }

        try {
            // get the unit w.r.t id
            $result = (new Education)->find($id);
            // if($result->status == 1) {
            //     $response = ['status' => 0, 'message' => lang('Education In Use')];
            // }
            //  else {
                (new Education)->tempDelete($id);
                $response = ['status' => 1, 'message' => lang('messages.deleted', lang('Education'))];
             // }
        }
        catch (Exception $exception) {
            $response = ['status' => 0, 'message' => lang('messages.server_error')];
        }        
        // return json response
        return json_encode($response);
    }

    

}
