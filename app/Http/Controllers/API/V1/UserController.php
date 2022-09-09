<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\UserDevice;
use App\Models\Notification;
use ElfSundae\Laravel\Hashid\Facades\Hashid;
use App\Models\Notify;
use App\Models\SmsCode;
use App\Models\ForceUpdate;
use Auth;
use Ixudra\Curl\Facades\Curl;
use PDF;


class UserController extends Controller
{
    
      public function login(Request $request){
        try{
        $credentials = [
            'email' => $request->get('username'),
            'password' => $request->get('password'),
            'status' => 1
        ];

        $credentials1 = [
            'mobile' => $request->get('username'),
            'password' => $request->get('password'),
            'status' => 1
        ];
         
          $url = route('home');
          $inputs = $request->all();

            if (Auth::attempt($credentials))  {
                $user_data = User::where('email', $request->username)->first();
                $api_key = $this->generateApiKey();
                if($user_data->api_key){
                    $api_key = $user_data->api_key; 
                } else {
                User::where('email', $request->username)
                ->update([
                'api_key' =>  $api_key,
                 ]);
                }

                $data['name'] = $user_data->name;
                $data['user_type'] = $user_data->user_type;

                $data['employer_name'] = $user_data->employer_name;
                
                $data['email'] = $user_data->email;
                if($user_data->profile_image){
                  $data['image'] = $url.$user_data->profile_image;
                } else {
                  $data['image'] =$user_data->profile_image;
                }
                $data['mobile'] = $user_data->mobile;  
                $data['gender'] = $user_data->gender;  
                $data['address'] = $user_data->address; 

                $data['plan_expire'] = $user_data->plan_expire;  
                $data['profile_view_limit'] = $user_data->profile_view_limit;  
                $data['job_post_limit'] = $user_data->job_post_limit; 
                
                $data['api_key'] = $api_key;  

                return apiResponseApp(true, 200, null, null, $data);
              
            } else if(Auth::attempt($credentials1)) {
                $user_data = User::where('mobile', $request->username)->first();
                $api_key = $this->generateApiKey();
                if($user_data->api_key){
                    $api_key = $user_data->api_key;
                } else {
                User::where('email', $request->username)
                ->update([
                'api_key' =>  $api_key,
                 ]);
                }

                $data['name'] = $user_data->name;
                $data['employer_name'] = $user_data->employer_name;
                $data['user_type'] = $user_data->user_type;
                $data['email'] = $user_data->email;
                if($user_data->profile_image){
                  $data['image'] = $url.$user_data->profile_image;
                } else {
                  $data['image'] =$user_data->profile_image;
                }
                $data['mobile'] = $user_data->mobile; 
                $data['gender'] = $user_data->gender;  
                $data['address'] = $user_data->address; 
                $data['plan_expire'] = $user_data->plan_expire;  
                $data['profile_view_limit'] = $user_data->profile_view_limit;  
                $data['job_post_limit'] = $user_data->job_post_limit; 
                $data['api_key'] = $api_key; 

                return apiResponseApp(true, 200, null, null, $data);

        } else {
          
          $message = 'Invalid login credentials';
          return apiResponseApp(false, 201, $message, null, null);

        }
              
    } catch(Exception $e){
            return apiResponse(false, 500, lang('messages.server_error'));
        }
    }


    public function force_update(){

      try{
        $data['support'] = ForceUpdate::where('id', 1)->select('force_update', 'version')->first();
        return apiResponseApp(true, 200, null, null, $data);
      } catch(Exception $e){
           return apiResponse(false, 500, lang('messages.server_error'));
        }
    }
    
    public function user_device(Request $request){
      try{
          $check = UserDevice::where('device_token', $request->device_token)->first();
          if($request->api_key){
              $user = User::where('api_key', $request->api_key)->select('id')->first();
              $user_id = $user->id;
          } else {
            $user_id = "";
          }

          if($check){
           if($user_id){
            UserDevice::where('id', $check->id)
            ->update([
              'user_id' => $user_id,
            ]);
           }
          } else{
            if($user_id){
              UserDevice::create([
              'device_token' => $request->device_token,
              'user_id' => $user_id,
              ]);
            } else {
              UserDevice::create([
              'device_token' => $request->device_token,
              ]);
            }
          }

        $message = "Device Token Successfully Saved";
        return apiResponseAppmsg(true, 200, $message, null, null);

      } catch(Exception $e){
          return apiResponse(false, 500, lang('messages.server_error'));
      }
    }


    public function country(){
        $data = \DB::table('countries')->select('id', 'country_name as name')->get();
        return apiResponseApp(true, 200, null, null, $data);
    }
    
    public function states(Request $request){
        $data = \DB::table('states')->where('country_id', $request->country_id)->select('id', 'name')->get();
        return apiResponseApp(true, 200, null, null, $data);
    }
    
    public function cities(Request $request){
        $data = \DB::table('cities')->where('state_id', $request->state_id)->select('id', 'name')->get();
        return apiResponseApp(true, 200, null, null, $data);
    }


    public function register(Request $request){
        try {

          $inputs = $request->all();

          $check_val =  User::where('email', $request->email)->first();
          if($check_val){
            $data['message'] = "The email has already registered";
            return apiResponseApp(false, 201, null, null, $data); 
          }
            

          // $check_val1 =  User::where('mobile', $request->mobile)->first();
          // if($check_val1){
          //   $data['message'] = "The mobile number has already registered";
          //   return apiResponseApp(false, 200, null, null, $data); 
          // }
          
          $password = \Hash::make($inputs['password']);
           unset($inputs['password']);

          $inputs['password'] = $password;
          // $inputs['user_type'] = 2;
          $inputs['status'] = 0;
          $inputs['register_from'] = 'APP';

            $user_id = (new User)->store($inputs);
            $email = $inputs['email'];
            $name = $inputs['name'];
            $home = route('home');
            $link = route('emailverify', $user_id);
            $responce = $this->send_email($home, $link, $name, $email);

            $message = "Your Account has been created with EZ-Job. We have sent a confirmation link on your registered email Kindly check & Confirm.";
            return apiResponseAppmsg(true, 200, $message, null, null);

              // return apiResponseApp(true, 200, null, null, $data);

        } catch(Exception $e){

         // dd($e);
        return apiResponse(false, 500, lang('messages.server_error'));

        }
    }
    

    public function send_email($home, $link, $name, $email){
        $postdata = http_build_query(
        array(
        'home' => $home,
        'link' => $link,
        'name' => $name,
        'email' => $email,
        )
        );
        $opts = array('http' =>
        array(
        'method'  => 'POST',
        'header'  => 'Content-Type: application/x-www-form-urlencoded',
        'content' => $postdata
        )
        );
        $context  = stream_context_create($opts);
        $result = file_get_contents('https://sspl20.com/jyoti/uttuapp/api/send-email-ez', false, $context);
        return $result;
    }

    public function signup_user(Request $request){
        try {

          $inputs = $request->all();

          $name = $request->first_name .' '. $request->last_name;
          $inputs['name'] = $name;
          
          if($request->email){
          $check_val =  User::where('email', $request->email)->first();
          if($check_val){

          $check_val1 =  User::where('mobile', $request->mobile)->first();
          if($check_val1){
            $data['message'] = "The email and mobile number has already registered";
            return apiResponseApp(false, 200, null, null, $data); 
          } else {
            $data['message'] = "The email has already registered";
            return apiResponseApp(false, 200, null, null, $data); 
          }
            
          }
          }

          $check_val1 =  User::where('mobile', $request->mobile)->first();
          if($check_val1){

            $data['message'] = "The mobile number has already registered";
            return apiResponseApp(false, 200, null, null, $data); 
          }

          if(isset($inputs['image']) or !empty($inputs['image'])){
                $image_name = rand(100000, 999999);
                $fileName = '';
              if($file = $request->hasFile('image')) {
                    $file = $request->file('image') ;
                    $img_name = $file->getClientOriginalName();
                    $fileName = $image_name.$img_name;
                    $destinationPath = public_path().'/uploads/user_images/' ;
                    $file->move($destinationPath, $fileName);
                }
                $fname ='/uploads/user_images/';
                $profile_images = $fname.$fileName;
       
            } else {
                $profile_images = NULL;
            }

  
          $inputs['user_type'] = 2;
          $inputs['status'] = 1;
          $inputs['profile_image'] = $profile_images;
          $api_key = $this->generateApiKey();
          $inputs['api_key'] = $api_key;     
      

          $user_id = (new User)->store($inputs);
          $user_data = User::where('id', $user_id)->first();

          $data['name'] = $user_data->name;
          $data['api_key'] = $user_data->api_key;
          $data['mobile'] = $user_data->mobile;
          $data['email'] = $user_data->email;
          $data['date_of_birth'] = $user_data->date_of_birth;
          $data['city'] = $user_data->city;
          $data['state'] = $user_data->state;
          if($user_data->country){
            $country = \DB::table('countries')->where('id', $user_data->country)->select('country_name')->first();
          $data['country'] = $country->country_name;  
          } else {
          $data['country'] = NULL; 
          }
          $url = route('admin'); 

          $data['about_me'] = $user_data->about_me;
          $data['gender'] = $user_data->gender;

          if($user_data->profile_image){
              $data['image'] = $url.$user_data->profile_image;
              } else {
              $data['image'] =$user_data->profile_image;
          }


          return apiResponseApp(true, 200, null, null, $data);


        } catch(Exception $e){

         // dd($e);

        return apiResponse(false, 500, lang('messages.server_error'));

        }

    }



     /*create app key*/
    private function generateApiKey() {
        return md5(uniqid(rand(), true));
    }

   
    //Update Profile
    public function updateProfile(Request $request){
      try{   

          if($request->api_key){
           $user = User::where('api_key', $request->api_key)->select('id', 'profile_image')->first();
          if($user) {  

            $inputs = $request->all();

            if(isset($inputs['user_image']) or !empty($inputs['user_image']))
            {

                $image_name = rand(100000, 999999);
                $fileName = '';

                if($file = $request->hasFile('user_image')) 
                {
                    $file = $request->file('user_image') ;
                    $img_name = $file->getClientOriginalName();
                    $fileName = $image_name.$img_name;
                    $destinationPath = public_path().'/uploads/user_images/' ;
                    $file->move($destinationPath, $fileName);
                }
                $fname ='/uploads/user_images/';
                $profile_images = $fname.$fileName;
       

            } else {
                $profile_images = $user->profile_image;
            }


            $inputs = $inputs + [    
                                  'updated_by' => $user->id,
                                  'profile_image' => $profile_images,];

            (new User)->store($inputs, $user->id);
            $url = route('home'); 
            
             $u_data = User::where('id', $user->id)->select('id', 'name', 'email', 'gender', 'mobile', 'profile_image', 'date_of_birth')->first();

             $data['id'] = $u_data->id;
             $data['name'] = $u_data->name;
             $data['email'] = $u_data->email;
             $data['mobile'] = $u_data->mobile;
             if($u_data->profile_image){
                  $data['profile_image'] = $url.$u_data->profile_image;
                } else {
                  $data['profile_image'] =$u_data->profile_image;
              }
             $data['gender'] = $u_data->gender;

            return apiResponseApp(true, 200, null, null, $data);

            //return apiResponse(true, 200, lang('User added successfully'));

           }

          }

        } catch(Exception $e){
        
         // dd($e);
          // return apiResponse(false, 500, lang('messages.server_error'));
           return apiResponseApp(true, 200, null, null, $e);
        }


    }

    public function addDeviceToken(Request $request){
        try{    
            $inputs = $request->all();

            $token_exist = UserDevice::where('device_token', $inputs['device_token'])->first();
            if (isset($token_exist)) {
                (new UserDevice)->store($inputs, $token_exist['id']);
            }else{
                (new UserDevice)->store($inputs);
            }
            return apiResponse(true, 200, lang('User added successfully'));

        }catch(Exception $e){
           return apiResponse(false, 500, lang('messages.server_error'));
        }
    }


    public function facebookLogin(Request $request)
    {
        try{
            $inputs = $request->all();
            $validator = ( new User )->validatefb( $inputs );
            if( $validator->fails() ) {
                return apiResponse(false, 406, "", errorMessages($validator->messages()));
            } 

            $check_email = (new User)->where('email', $inputs['email'])
                                    ->where('access_token', null)
                                    ->get();

            if (count($check_email) >=1) {
                return apiResponse(false, 500, lang('Email Address already exist in our records'));
            }

            $api_key = $this->generateApiKey();

            $password = \Hash::make($inputs['email']);

            $inputs = $inputs + [
                                    'role' => 2,
                                    'api_key'   => $api_key,
                                    'provider'   => 'facebook',
                                    'user_type'   => '3',
                                    'status'    => 1,
                                    'password' => $password
                                ];
            
            $check = (new User)->where('email', $inputs['email'])->first();
            if (count($check) == 0) {
                    $user = (new User)->store($inputs);
                    return apiResponse(true, 200, lang('User Successfully created'));
            }else{
                if ($check->access_token == null) {
                    $user = (new User)->store($inputs);
                    return apiResponse(true, 200, lang('User Successfully created'));
                }else{
                    $user = (new User)->updatestorfb($check->id, $inputs['access_token']);
                    return apiResponse(true, 200, lang('User Successfully created'));
                }
            
            }


        }
        catch(Exception $exception){
            return apiResponse(false, 500, lang('messages.server_error'));
        }
    }


    public function profile(Request $request){

        try{

          if($request->api_key){
           $user = User::where('api_key', $request->api_key)->select('id', 'name', 'email', 'mobile', 'profile_image', 'gender')->first();
            $url = route('home'); 

            if($user){
            $data['id'] = $user->id;
            $data['name'] = $user->name;
            $data['email'] = $user->email;
            $data['mobile'] = $user->mobile;
             if($user->profile_image){
                  $data['profile_image'] = $url.$user->profile_image;
                } else {
                  $data['profile_image'] =$user->profile_image;
              }
            $data['gender'] = $user->gender;

            return apiResponseApp(true, 200, null, null, $data); 
          }
          }

        } catch(Exception $e){
           return apiResponse(false, 500, lang('messages.server_error'));
        }

    }

    

}
