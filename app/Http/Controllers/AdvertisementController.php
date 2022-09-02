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
use App\Models\Advertisement;
use App\Models\Interest;
use App\User;
use Illuminate\Http\Request;

class AdvertisementController extends Controller{
 
    public function  index() {
        return view('admin.advertisements.index');
    }
  
    public function create() {

        $Vendor = (new User)->getVendor(); 
        $Interest = (new Interest)->getInterestList(); 

        return view('admin.advertisements.create', compact('Vendor', 'Interest'));
    }


    public function store(Request $request) {
        $inputs = $request->all();
       // dd($request);
        try {
            $validator = (new Advertisement)->validate($inputs);
            if( $validator->fails() ) {
                return back()->withErrors($validator)->withInput();
            }
       
            if(isset($inputs['file']) or !empty($inputs['file'])) {
                $image_name = rand(100000, 999999);
                $fileName = '';
                if($file = $request->hasFile('file'))  {
                    $file = $request->file('file') ;
                    $img_name = $file->getClientOriginalName();
                    $fileName = $image_name.$img_name;
                    $destinationPath = public_path().'/uploads/ads/' ;
                    $file->move($destinationPath, $fileName);
                }
                $fname ='/uploads/ads/';
                $image = $fname.$fileName;

                $getID3 = new \getID3;
                $file = $getID3->analyze(public_path().$image);
                $duration = date('s', $file['playtime_seconds']);

            } else {
                $image = "";
                $duration = "";
            }


            unset($inputs['file']);
            $inputs['url'] = $image;
            $inputs['duration'] = $duration;

            $inputs = $inputs + [
                'created_by' => Auth::id(),
            ];  

            (new Advertisement)->store($inputs);

            return redirect()->route('advertisements.index')
                ->with('success', lang('messages.created', lang('Advertisement')));
        } catch (\Exception $exception) {
            //dd($exception);

            return redirect()->route('advertisements.create')
                ->withInput()
                ->with('error', lang('messages.server_error').$exception->getMessage());
        }
    }

  
    public function update(Request $request, $id = null) {
        $result = (new Advertisement)->find($id);
        if (!$result) {
            abort(401);
        }
        $inputs = $request->all();
        try {

            $inputs = $inputs + [
                'updated_by' => Auth::id(),
            ];  
             
            (new Advertisement)->store($inputs, $id);

            return redirect()->route('advertisements.index')
                ->with('success', lang('messages.updated', lang('Advertisement')));
        } catch (\Exception $exception) {
            return redirect()->route('advertisements.edit', [$id])
                ->withInput()
                ->with('error', lang('messages.server_error'));
        }
    }

  
    public function edit($id = null) {
        $result = (new Advertisement)->find($id);
        if (!$result) {
            abort(401);
        }

        $Vendor = (new User)->getVendor(); 
        $Interest = (new Interest)->getInterestList();

        return view('admin.advertisements.create', compact('result', 'Vendor', 'Interest'));
    }


    public function advertisementsPaginate(Request $request, $pageNumber = null) {

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

            $data = (new Advertisement)->getAdvertisement($inputs, $start, $perPage);
            $totalGameMaster = (new Advertisement)->totalAdvertisement($inputs);
            $total = $totalGameMaster->total;
        } else {

            $data = (new Advertisement)->getAdvertisement($inputs, $start, $perPage);
            $totalGameMaster = (new Advertisement)->totalAdvertisement();
            $total = $totalGameMaster->total;
        }

        return view('admin.advertisements.load_data', compact('inputs', 'data', 'total', 'page', 'perPage'));
    }

 
    public function advertisementsToggle($id = null) {
        if (!\Request::isMethod('post') && !\Request::ajax()) {
            return lang('messages.server_error');
        }

        try {
            $game = Advertisement::find($id);
        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('Advertisements')));
        }

        $game->update(['status' => !$game->status]);
        $response = ['status' => 1, 'data' => (int)$game->status . '.gif'];
        // return json response
        return json_encode($response);
    }

  
    public function advertisementsAction(Request $request) {
        $inputs = $request->all();
        if (!isset($inputs['tick']) || count($inputs['tick']) < 1) {
            return redirect()->route('advertisements.index')
                ->with('error', lang('messages.atleast_one', string_manip(lang('Advertisements'))));
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

        Advertisement::whereRaw('id IN (' . $ids . ')')->update(['status' => $status]);
        return redirect()->route('advertisements.index')
            ->with('success', lang('messages.updated', lang('Advertisements')));
    }


    public function drop($id) {
        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }

        $result = (new Advertisement)->find($id);
        if (!$result) {
            abort(401);
        }

        try {
   
            (new Advertisement)->tempDelete($id);
            $response = ['status' => 1, 'message' => lang('messages.deleted', lang('Advertisement'))];
             
        }
        catch (Exception $exception) {
            $response = ['status' => 0, 'message' => lang('messages.server_error')];
        }        
        // return json response
        return json_encode($response);
    }

    

}
