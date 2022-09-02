<?php

namespace App\Http\Controllers;
/**
 * :: Interest Controller ::
 * 
 *
 **/
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use Files;
use Illuminate\Support\Facades\Storage;
use App\Models\Interest;
use Illuminate\Http\Request;

class InterestController extends Controller{
 
    public function  index() {
        return view('admin.interests.index');
    }
  
    public function create() {

        return view('admin.interests.create');
    }


    public function store(Request $request) {
        $inputs = $request->all();
        // dd($request);
        try {
            $validator = (new Interest)->validate($inputs);
            if( $validator->fails() ) {
                return back()->withErrors($validator)->withInput();
            }

            $inputs = $inputs + [
                'created_by' => Auth::id(),
            ];  

            (new Interest)->store($inputs);

            return redirect()->route('interests.index')
                ->with('success', lang('messages.created', lang('Interest')));
        } catch (\Exception $exception) {
            return redirect()->route('interests.create')
                ->withInput()
                ->with('error', lang('messages.server_error').$exception->getMessage());
        }
    }

  
    public function update(Request $request, $id = null)
    {
        $result = (new Interest)->find($id);
        if (!$result) {
            abort(401);
        }
        $inputs = $request->all();
        try {
      
            $inputs = $inputs + [
                'updated_by' => Auth::id(),
            ];  

            (new Interest)->store($inputs, $id);

            return redirect()->route('interests.index')
                ->with('success', lang('messages.updated', lang('Interest')));
        } catch (\Exception $exception) {
            return redirect()->route('interests.edit', [$id])->withInput()->with('error', lang('messages.server_error'));
        }
    }

  
    public function edit($id = null) {
        $result = (new Interest)->find($id);
        if (!$result) {
            abort(401);
        }
        return view('admin.interests.create', compact('result'));
    }


    public function interestsPaginate(Request $request, $pageNumber = null) {

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

            $data = (new Interest)->getInterest($inputs, $start, $perPage);
            $totalGameMaster = (new Interest)->totalInterest($inputs);
            $total = $totalGameMaster->total;
        } else {

            $data = (new Interest)->getInterest($inputs, $start, $perPage);
            $totalGameMaster = (new Interest)->totalInterest();
            $total = $totalGameMaster->total;
        }

        return view('admin.interests.load_data', compact('inputs', 'data', 'total', 'page', 'perPage'));
    }

 
    public function interestsToggle($id = null) {
        if (!\Request::isMethod('post') && !\Request::ajax()) {
            return lang('messages.server_error');
        }

        try {
            $game = Interest::find($id);
        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('Interest')));
        }

        $game->update(['status' => !$game->status]);
        $response = ['status' => 1, 'data' => (int)$game->status . '.gif'];
        // return json response
        return json_encode($response);
    }

  
    public function interestsAction(Request $request) {
        $inputs = $request->all();
        if (!isset($inputs['tick']) || count($inputs['tick']) < 1) {
            return redirect()->route('interests.index')
                ->with('error', lang('messages.atleast_one', string_manip(lang('Interest'))));
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

        Interest::whereRaw('id IN (' . $ids . ')')->update(['status' => $status]);
        return redirect()->route('interests.index')
            ->with('success', lang('messages.updated', lang('Interest')));
    }


    public function drop($id) {
        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }

        $result = (new Interest)->find($id);
        if (!$result) {
            abort(401);
        }

        try {
   
            (new Interest)->tempDelete($id);
            $response = ['status' => 1, 'message' => lang('messages.deleted', lang('Interest'))];
             
        }
        catch (Exception $exception) {
            $response = ['status' => 0, 'message' => lang('messages.server_error')];
        }        
        // return json response
        return json_encode($response);
    }

    

}
