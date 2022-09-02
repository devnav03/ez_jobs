<?php

namespace App\Http\Controllers;
/**
 * :: Transaction Controller ::
 * 
 *
 **/
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use Files;
use Illuminate\Support\Facades\Storage;
use App\Models\Billing;
use App\Models\Category;
use App\Models\Country;
use App\Models\Education;
use App\User;
use Illuminate\Http\Request;

class TransactionController  extends  Controller{

    public function index() {
        if((\Auth::user()->user_type) == 1){
            return view('admin.transaction.index');
        } else {
            \Auth::logout();
            \Session::flush();
            return redirect()->route('admin');
        }
    }
  
    public function create() {
        if((\Auth::user()->user_type) == 1){
        return view('admin.transaction.create');
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

            $data = (new Billing)->getBilling($inputs, $start, $perPage);
            $totalGameMaster = (new Billing)->totalBilling($inputs);
            $total = $totalGameMaster->total;
           // dd($data);

        } else {

            $data = (new Billing)->getBilling($inputs, $start, $perPage);
            $totalGameMaster = (new Billing)->totalBilling();
            $total = $totalGameMaster->total;
        }


        return view('admin.transaction.load_data', compact('inputs', 'data', 'total', 'page', 'perPage'));
    }

 
    public function Toggle($id = null) {
        if (!\Request::isMethod('post') && !\Request::ajax()) {
            return lang('messages.server_error');
        }

        try {
            $game = Billing::find($id);
        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('transaction')));
        }

        $game->update(['status' => !$game->status]);
        $response = ['status' => 1, 'data' => (int)$game->status . '.gif'];
        // return json response
        return json_encode($response);
    }

  
    public function Action(Request $request)  {

        $inputs = $request->all();
        if (!isset($inputs['tick']) || count($inputs['tick']) < 1) {
            return redirect()->route('transaction.index')
                ->with('error', lang('messages.atleast_one', string_manip(lang('Transaction'))));
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

        Billing::whereRaw('id IN (' . $ids . ')')->update(['status' => $status]);
        return redirect()->route('transaction.index')
            ->with('success', lang('messages.updated', lang('game_master.game')));
    }


    public function drop($id) {

        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }

        $result = (new Billing)->find($id);
        if (!$result) {
            // use ajax return response not abort because ajaz request abort not works
            abort(401);
        }

        try {
            // get the unit w.r.t id
            $result = (new Billing)->find($id);
            if($result->status == 1) {
                $response = ['status' => 0, 'message' => lang('transaction In Use')];
            }
             else {
                (new Billing)->tempDelete($id);
                $response = ['status' => 1, 'message' => lang('messages.deleted', lang('transaction'))];
             }
        }
        catch (Exception $exception) {
            $response = ['status' => 0, 'message' => lang('messages.server_error')];
        }        
        // return json response
        return json_encode($response);
    }

    

}
