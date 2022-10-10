<?php

namespace App\Http\Controllers;
/**
 * :: Category Controller ::
 * 
 *
 **/
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use Files;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController  extends  Controller{

    public function index() {
        if((\Auth::user()->user_type) == 1){
            return view('admin.category.index');
        } else {
            \Auth::logout();
            \Session::flush();
            return redirect()->route('admin');
        }
    }
  
    public function create() {
        if((\Auth::user()->user_type) == 1){
        $parent_cats = Category::where('status', 1)->where('parent_id', Null)->get();
        return view('admin.category.create', compact('parent_cats'));
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
            $validator = (new Category)->validate($inputs);
            if( $validator->fails() ) {
                return back()->withErrors($validator)->withInput();
            }

            $slug_name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $inputs['name'])));
            $inputs = $inputs + [
                    'created_by' => Auth::id(),
                    'url' =>  $slug_name,
                ];  


            if(isset($inputs['icon']) or !empty($inputs['icon'])) {
                $image_name = rand(100000, 999999);
                $fileName = '';
                if($file = $request->hasFile('icon')) {
                    $file = $request->file('icon') ;
                    $img_name = $file->getClientOriginalName();
                    $fileName = $image_name.$img_name;
                    $destinationPath = public_path().'/uploads/cat_icon/' ;
                    $file->move($destinationPath, $fileName);
                }
                $fname ='/uploads/cat_icon/';
                $image = $fname.$fileName;
            }
            else{
                $image = '';
            }
            
            unset($inputs['icon']);
            $inputs['icon'] = $image;

         
            (new Category)->store($inputs);
           
            return redirect()->route('category.index')
                ->with('success', lang('messages.created', lang('category.category')));
        } catch (\Exception $exception) {
         
            return redirect()->route('category.create')
                ->withInput()
                ->with('error', lang('messages.server_error').$exception->getMessage());
        }
    }

  
    public function update(Request $request, $id = null) {
        $result = (new Category)->find($id);
        if (!$result) {
            abort(401);
        }
        $inputs = $request->all();
        try {
            $inputs = $inputs + [
                'updated_by' => Auth::id(),
            ];   
            if(isset($inputs['icon']) or !empty($inputs['icon'])) {
                $image_name = rand(100000, 999999);
                $fileName = '';
                if($file = $request->hasFile('icon')) {
                    $file = $request->file('icon') ;
                    $img_name = $file->getClientOriginalName();
                    $fileName = $image_name.$img_name;
                    $destinationPath = public_path().'/uploads/cat_icon/' ;
                    $file->move($destinationPath, $fileName);
                }
                $fname ='/uploads/cat_icon/';
                $image = $fname.$fileName;
            }
            else{
                $image = $result->icon;
            }
            unset($inputs['icon']);
            $inputs['icon'] = $image;
            (new Category)->store($inputs, $id);
            return redirect()->route('category.index')
                ->with('success', lang('messages.updated', lang('category.category')));
        } catch (\Exception $exception) {
            return redirect()->route('category.edit', [$id])
                ->withInput()
                ->with('error', lang('messages.server_error'));
        }
    }

  
    public function edit($id = null) {
        $result = (new Category)->find($id);
        if (!$result) {
            abort(401);
        }
        $parentCategory = (new Category)->getCategoryService();
        $parent_cats = Category::where('status', 1)->where('parent_id', null)->get();

        if((\Auth::user()->user_type) == 1){
            return view('admin.category.create', compact('result','parent_cats', 'parentCategory'));
        } else {
            \Auth::logout();
            \Session::flush();
            return redirect()->route('admin');
        }
    }


    public function categoryPaginate(Request $request, $pageNumber = null) {
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

            $data = (new Category)->getCategory($inputs, $start, $perPage);
            $totalGameMaster = (new Category)->totalCategory($inputs);
            $total = $totalGameMaster->total;
     //   dd($data);

        } else {

            $data = (new Category)->getCategory($inputs, $start, $perPage);
            $totalGameMaster = (new Category)->totalCategory();
            $total = $totalGameMaster->total;
        }

       // dd($data);

        return view('admin.category.load_data', compact('inputs', 'data', 'total', 'page', 'perPage'));
    }

 
    public function categoryToggle($id = null) {
        if (!\Request::isMethod('post') && !\Request::ajax()) {
            return lang('messages.server_error');
        }

        try {
            $game = Category::find($id);
        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('category.category')));
        }

        $game->update(['status' => !$game->status]);
        $response = ['status' => 1, 'data' => (int)$game->status . '.gif'];
        // return json response
        return json_encode($response);
    }

  
    public function categoryAction(Request $request)  {

        $inputs = $request->all();
        if (!isset($inputs['tick']) || count($inputs['tick']) < 1) {
            return redirect()->route('category.index')
                ->with('error', lang('messages.atleast_one', string_manip(lang('category.category'))));
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

        Category::whereRaw('id IN (' . $ids . ')')->update(['status' => $status]);
        return redirect()->route('category.index')
            ->with('success', lang('messages.updated', lang('game_master.game')));
    }


    public function drop($id) {

        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }

        $result = (new Category)->find($id);
        if (!$result) {
            // use ajax return response not abort because ajaz request abort not works
            abort(401);
        }

        try {
            // get the unit w.r.t id
            $result = (new Category)->find($id);
            // if($result->status == 1) {
            //     $response = ['status' => 0, 'message' => lang('category.category_in_use')];
            // }
            //  else {
                (new Category)->tempDelete($id);
                $response = ['status' => 1, 'message' => lang('messages.deleted', lang('category.category'))];
             // }
        }
        catch (Exception $exception) {
            $response = ['status' => 0, 'message' => lang('messages.server_error')];
        }        
        // return json response
        return json_encode($response);
    }

    public function getSubcategory(Request $request) {
      $main_id = $request->main_id;
      $category = \DB::table('categories')->where('parent_id', $main_id)->where('status', 1)->where('status', 1)->get();
      $subcategoryList='';
      $subcategoryList .= '<option value="">select</option>';
      foreach($category as $key => $subcategory)
      $subcategoryList .= '<option value="' . $subcategory->id . '">'. $subcategory->name .'</option>';
      return $subcategoryList; 
    }

    public function getState(Request $request) {
      $category = \DB::table('states')->where('country_id', $request->country_id)->get();
      $subcategoryList='';
      $subcategoryList .= '<option value="">select</option>';
      foreach($category as $key => $subcategory)
      $subcategoryList .= '<option value="' . $subcategory->id . '">'. $subcategory->name .'</option>';
      return $subcategoryList; 
    }

    public function getCity(Request $request) {
      $category = \DB::table('cities')->where('state_id', $request->state_id)->get();
      $subcategoryList='';
      $subcategoryList .= '<option value="">select</option>';
      foreach($category as $key => $subcategory)
      $subcategoryList .= '<option value="' . $subcategory->id . '">'. $subcategory->name .'</option>';
      return $subcategoryList; 
    }


    public function getPage(Request $request) {
      $main_id = $request->page_name;
      if($main_id == "Product"){
         $category = \DB::table('products')->where('status', 1)->select('id', 'name')->get();
      }

      if($main_id == "Category"){
         $category = \DB::table('categories')->where('status', 1)->select('id', 'name')->get();
      }

      if($main_id == "Brand"){
         $category = \DB::table('brands')->where('status', 1)->select('id', 'name')->get();
      }      
      $subcategoryList='';
      $subcategoryList .= '<option value="">select</option>';
      foreach($category as $key => $subcategory)
      $subcategoryList .= '<option value="' . $subcategory->id . '">'. $subcategory->name .'</option>';
      return $subcategoryList; 
    }

    

}
