<?php

namespace App\Http\Controllers;
/**
 * :: Blog Controller ::
 * 
 *
 **/
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use Files;
use Illuminate\Support\Facades\Storage;
use App\Models\Blog;
use Illuminate\Http\Request;


class BlogController  extends  Controller{

    public function index() {
        if((\Auth::user()->user_type) == 1){
            return view('admin.blogs.index');
        } else {
            \Auth::logout();
            \Session::flush();
            return redirect()->route('admin');
        }
    }
  
    public function create() {
        if((\Auth::user()->user_type) == 1){
        return view('admin.blogs.create');
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
            $validator = (new Blog)->validate($inputs);
            if( $validator->fails() ) {
                return back()->withErrors($validator)->withInput();
            }

            if(isset($inputs['image']) or !empty($inputs['image'])) {
                $image_name = rand(100000, 999999);
                $fileName = '';
                if($file = $request->hasFile('image'))  {
                    $file = $request->file('image');
                    $img_name = $file->getClientOriginalName();
                    $fileName = $image_name.$img_name;
                    $destinationPath = public_path().'/uploads/blog_images/' ;
                    $file->move($destinationPath, $fileName);
                }
                $fname ='/uploads/blog_images/';
                $image = $fname.$fileName;
            }
            else{
                $image = null;
            }
            unset($inputs['image']);
            $inputs['image'] = $image;
            
            $slug_name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $inputs['title'])));
                $inputs = $inputs + [
                    'url' =>  $slug_name,
                ]; 

            (new Blog)->store($inputs);
           
            return redirect()->route('blogs.index')
                ->with('success', lang('messages.created', 'Blog'));
        } catch (\Exception $exception) {
         
            return redirect()->route('blogs.create')
                ->withInput()
                ->with('error', lang('messages.server_error').$exception->getMessage());
        }
    }

  
    public function update(Request $request, $id = null) {
        $result = (new Blog)->find($id);
        if (!$result) {
            abort(401);
        }
        $inputs = $request->all();
        try {

            if(isset($inputs['image']) or !empty($inputs['image'])) {
                $image_name = rand(100000, 999999);
                $fileName = '';
                if($file = $request->hasFile('image'))  {
                    $file = $request->file('image');
                    $img_name = $file->getClientOriginalName();
                    $fileName = $image_name.$img_name;
                    $destinationPath = public_path().'/uploads/blog_images/' ;
                    $file->move($destinationPath, $fileName);
                }
                $fname ='/uploads/blog_images/';
                $image = $fname.$fileName;
            }
            else{
                $image = $result->image;
            }
            unset($inputs['image']);
            $inputs['image'] = $image;

            (new Blog)->store($inputs, $id);
            return redirect()->route('blogs.index')
                ->with('success', lang('messages.updated', 'Blog'));
        } catch (\Exception $exception) {
           // dd($exception);
            return redirect()->route('blogs.edit', [$id])
                ->withInput()
                ->with('error', lang('messages.server_error'));
        }
    }

  
    public function edit($id = null) {
        $result = (new Blog)->find($id);
        if (!$result) {
            abort(401);
        }

        if((\Auth::user()->user_type) == 1){
            return view('admin.blogs.create', compact('result'));
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

            $data = (new Blog)->getBlogs($inputs, $start, $perPage);
            $totalGameMaster = (new Blog)->totalBlogs($inputs);
            $total = $totalGameMaster->total;
     //   dd($data);

        } else {

            $data = (new Blog)->getBlogs($inputs, $start, $perPage);
            $totalGameMaster = (new Blog)->totalBlogs();
            $total = $totalGameMaster->total;
        }

       // dd($data);

        return view('admin.blogs.load_data', compact('inputs', 'data', 'total', 'page', 'perPage'));
    }

 
    public function Toggle($id = null) {
        if (!\Request::isMethod('post') && !\Request::ajax()) {
            return lang('messages.server_error');
        }

        try {
            $game = Blog::find($id);
        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('Blog')));
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
