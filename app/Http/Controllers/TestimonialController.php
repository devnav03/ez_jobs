<?php

namespace App\Http\Controllers;
/**
 * :: Testimonial Controller ::
 * 
 *
 **/
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use Files;
use Illuminate\Support\Facades\Storage;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends  Controller{

    public function index() {
        if((\Auth::user()->user_type) == 1){
            return view('admin.testimonials.index');
        } else {
            \Auth::logout();
            \Session::flush();
            return redirect()->route('admin');
        }
    }
  
    public function create() {
        if((\Auth::user()->user_type) == 1){
        return view('admin.testimonials.create');
        } else {
            \Auth::logout();
            \Session::flush();
            return redirect()->route('admin');
        }
    }

    public function store(Request $request) {
        
        $inputs = $request->all();
       // dd($request);
        try {
            $validator = (new Testimonial)->validate($inputs);
            if( $validator->fails() ) {
                return back()->withErrors($validator)->withInput();
            }
            
            $image = '';

            if(isset($inputs['image']) or !empty($inputs['image'])) {
                $image_name = rand(100000, 999999);
                $fileName = '';
                if($file = $request->hasFile('image'))  {
                    $file = $request->file('image') ;
                    $img_name = $file->getClientOriginalName();
                    $fileName = $image_name.$img_name;
                    $destinationPath = public_path().'/uploads/testimonials/' ;
                    $file->move($destinationPath, $fileName);
                }
                $fname ='/uploads/testimonials/';
                $image = $fname.$fileName;
            }
            unset($inputs['image']);
            $inputs['image'] = $image;

            (new Testimonial)->store($inputs);
           
            return redirect()->route('testimonials.index')
                ->with('success', lang('messages.created', 'Testimonials'));
        } catch (\Exception $exception) {
         
            return redirect()->route('testimonials.create')
                ->withInput()
                ->with('error', lang('messages.server_error').$exception->getMessage());
        }
    }

  
    public function update(Request $request, $id = null) {
        $result = (new Testimonial)->find($id);
        if (!$result) {
            abort(401);
        }
        $inputs = $request->all();
        try {
   
            $image = $result->image;

            if(isset($inputs['image']) or !empty($inputs['image'])) {
                $image_name = rand(100000, 999999);
                $fileName = '';
                if($file = $request->hasFile('image'))  {
                    $file = $request->file('image') ;
                    $img_name = $file->getClientOriginalName();
                    $fileName = $image_name.$img_name;
                    $destinationPath = public_path().'/uploads/testimonials/' ;
                    $file->move($destinationPath, $fileName);
                }
                $fname ='/uploads/testimonials/';
                $image = $fname.$fileName;
            }
            unset($inputs['image']);
            $inputs['image'] = $image;  

            (new Testimonial)->store($inputs, $id);
            return redirect()->route('testimonials.index')
                ->with('success', lang('messages.updated', 'Testimonial'));
        } catch (\Exception $exception) {
            return redirect()->route('testimonials.edit', [$id])
                ->withInput()
                ->with('error', lang('messages.server_error'));
        }
    }

  
    public function edit($id = null) {
        $result = (new Testimonial)->find($id);
        if (!$result) {
            abort(401);
        }

        if((\Auth::user()->user_type) == 1){
            return view('admin.testimonials.create', compact('result'));
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

            $data = (new Testimonial)->getTestimonial($inputs, $start, $perPage);
            $totalGameMaster = (new Education)->totalTestimonial($inputs);
            $total = $totalGameMaster->total;
     //   dd($data);

        } else {

            $data = (new Testimonial)->getTestimonial($inputs, $start, $perPage);
            $totalGameMaster = (new Testimonial)->totalTestimonial();
            $total = $totalGameMaster->total;
        }

       // dd($data);

        return view('admin.testimonials.load_data', compact('inputs', 'data', 'total', 'page', 'perPage'));
    }

 
    public function Toggle($id = null) {
        if (!\Request::isMethod('post') && !\Request::ajax()) {
            return lang('messages.server_error');
        }

        try {
            $game = Testimonial::find($id);
        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('Testimonial')));
        }

        $game->update(['status' => !$game->status]);
        $response = ['status' => 1, 'data' => (int)$game->status . '.gif'];
        // return json response
        return json_encode($response);
    }

  
    public function Action(Request $request)  {

        $inputs = $request->all();
        if (!isset($inputs['tick']) || count($inputs['tick']) < 1) {
            return redirect()->route('testimonials.index')
                ->with('error', lang('messages.atleast_one', string_manip(lang('Testimonials'))));
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

        Testimonial::whereRaw('id IN (' . $ids . ')')->update(['status' => $status]);
        return redirect()->route('testimonials.index')
            ->with('success', lang('messages.updated', lang('Testimonial')));
    }


    public function drop($id) {

        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }

        $result = (new Testimonial)->find($id);
        if (!$result) {
            // use ajax return response not abort because ajaz request abort not works
            abort(401);
        }

        try {
            // get the unit w.r.t id
            $result = (new Testimonial)->find($id);
            if($result->status == 1) {
                $response = ['status' => 0, 'message' => lang('Testimonials In Use')];
            }
             else {
                (new Testimonial)->tempDelete($id);
                $response = ['status' => 1, 'message' => lang('messages.deleted', lang('Education'))];
             }
        }
        catch (Exception $exception) {
            $response = ['status' => 0, 'message' => lang('messages.server_error')];
        }        
        // return json response
        return json_encode($response);
    }

    

}
