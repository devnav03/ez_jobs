<?php

namespace App\Http\Controllers;
/**
 * :: advertisements Controller ::
 * To manage games.
 *
 **/
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use Files;
use Illuminate\Support\Facades\Storage;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller{
 
    public function  index() {
        return view('admin.permissions.index');
    }
  
    public function create() {

        return view('admin.permissions.create');
    }


    public function store(Request $request) {
        $inputs = $request->all();
       // dd($request);
        try {
            $validator = (new Permission)->validate($inputs);
            if( $validator->fails() ) {
                return back()->withErrors($validator)->withInput();
            }
       

            $inputs = $inputs + [
                'created_by' => Auth::id(),
            ];  

            (new Permission)->store($inputs);

            return redirect()->route('permissions.index')
                ->with('success', lang('messages.created', lang('Permission')));
        } catch (\Exception $exception) {
            //dd($exception);

            return redirect()->route('permissions.create')
                ->withInput()
                ->with('error', lang('messages.server_error').$exception->getMessage());
        }
    }

  
    public function update(Request $request, $id = null) {
        $result = (new Permission)->find($id);
        if (!$result) {
            abort(401);
        }
        $inputs = $request->all();
        try {

            $inputs = $inputs + [
                'updated_by' => Auth::id(),
            ];  
             
            (new Permission)->store($inputs, $id);

            return redirect()->route('permissions.index')
                ->with('success', lang('messages.updated', lang('Permission')));
        } catch (\Exception $exception) {
            return redirect()->route('permissions.edit', [$id])
                ->withInput()
                ->with('error', lang('messages.server_error'));
        }
    }

  
    public function edit($id = null) {
        $result = (new Permission)->find($id);
        if (!$result) {
            abort(401);
        }
        return view('admin.permissions.create', compact('result'));
    }


    public function permissionsPaginate(Request $request, $pageNumber = null) {

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

            $data = (new Permission)->getPermission($inputs, $start, $perPage);
            $totalGameMaster = (new Permission)->totalPermission($inputs);
            $total = $totalGameMaster->total;
        } else {

            $data = (new Permission)->getPermission($inputs, $start, $perPage);
            $totalGameMaster = (new Permission)->totalPermission();
            $total = $totalGameMaster->total;
        }

        return view('admin.permissions.load_data', compact('inputs', 'data', 'total', 'page', 'perPage'));
    }

 
    public function permissionsToggle($id = null) {
        if (!\Request::isMethod('post') && !\Request::ajax()) {
            return lang('messages.server_error');
        }

        try {
            $game = Permission::find($id);
        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('Permission')));
        }

        $game->update(['status' => !$game->status]);
        $response = ['status' => 1, 'data' => (int)$game->status . '.gif'];
        // return json response
        return json_encode($response);
    }

  
    public function permissionsAction(Request $request) {
        $inputs = $request->all();
        if (!isset($inputs['tick']) || count($inputs['tick']) < 1) {
            return redirect()->route('permissions.index')
                ->with('error', lang('messages.atleast_one', string_manip(lang('Permission'))));
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

        Permission::whereRaw('id IN (' . $ids . ')')->update(['status' => $status]);
        return redirect()->route('permissions.index')
            ->with('success', lang('messages.updated', lang('Advertisements')));
    }


    public function drop($id) {
        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }

        $result = (new Permission)->find($id);
        if (!$result) {
            abort(401);
        }

        try {
   
            (new Permission)->tempDelete($id);
            $response = ['status' => 1, 'message' => lang('messages.deleted', lang('Permission'))];
             
        }
        catch (Exception $exception) {
            $response = ['status' => 0, 'message' => lang('messages.server_error')];
        }        
        // return json response
        return json_encode($response);
    }

    

}
