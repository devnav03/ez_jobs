<?php

namespace App\Http\Controllers\Front;
/**
 * :: Plan Controller ::
 * To manage games.
 *
 **/
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use Files;
use Illuminate\Support\Facades\Storage;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\LoginLog;
use App\Models\Designation;
use App\Models\Education;
use App\Models\Plan;
use App\Models\JobSeekersDetail;
use App\Models\Billing;
use Redirect;

use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payment as PaypalPayment;
use PayPal\Api\PaymentExecution;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use ElfSundae\Laravel\Hashid\Facades\Hashid;
use Session;
use Curl;
use Illuminate\Support\Facades\Input;

class PlanController extends Controller{

      private $_api_context;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');

       // dd(\Config::get('paypal'));
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);

    }

    
    public function membership_plan(){

        if((\Auth::user()->user_type) == 2){
            $job_plans = Plan::where('status', 1)->where('category', 1)->select('id', 'name', 'price', 'description', 'job_description', 'job_search', 'job_branding', 'city')->get();
            $countries = Country::all();

            $profile_plans = Plan::where('status', 1)->where('category', 2)->select('id', 'name', 'price', 'profile_view', 'duration')->get();

        return view('frontend.pages.plan', compact('job_plans', 'countries', 'profile_plans'));

        } else {
            \Auth::logout();
            \Session::flush();
            return redirect()->route('login');
        }

    }

    public function getQuantity(Request $request){
          
          return $data['price'] = '<i class="fa-solid fa-indian-rupee-sign"></i>'.$request->price*$request->qty;

    }

    public function buy(Request $request){
        try {
            $user_id = Auth::id(); 
            $plan = Plan::where('id', $request->plan_id)->select('price')->first();
            $billing_id = $this->generateBillingID();

            $Billing = new Billing();
            $Billing->user_id = $user_id;
            $Billing->plan_id = $request->plan_id;
            $Billing->price = $plan->price;
            $Billing->quantity = $request->quantity;
            $Billing->status = 0;
            $Billing->billing_id = $billing_id;
            $Billing->save();

          return $this->payWithpaypal($billing_id); 

        } catch (\Exception $exception) {
          //  dd($exception); 
            return back();
        }
    }

    public function billing_information(){
        $user_id = Auth::id(); 
        $billings = Billing::join('plans', 'plans.id', '=', 'billings.plan_id')
        ->select('billings.id', 'billings.price', 'billings.transaction_id', 'billings.created_at', 'billings.status', 'plans.name as plan', 'plans.category', 'billings.quantity')->where('billings.status', 1)->where('billings.user_id', $user_id)->orderBy('billings.id', 'DESC')->get();
        $countries = Country::all();
        return view('frontend.pages.billing', compact('billings', 'countries'));
    }

    public function generateBillingID() {
        $orderObj = Billing::orderBy('created_at', 'desc')->value('billing_id');
        if ($orderObj) {
            $orderNr = $orderObj;
            $removed1char = substr($orderNr, 4);
            $generateOrder_nr = $stpad = '#' . str_pad($removed1char + 1, 5, "0", STR_PAD_LEFT);
        } else {
            $generateOrder_nr = '#' . str_pad(1, 5, "0", STR_PAD_LEFT);
        }
        return $generateOrder_nr;
    }


    private function payWithpaypal($billing_id){
    try {
        $Total_ammount = 0;   
        $order = $billing_id;
        $plan = Billing::where('billing_id', $billing_id)->select('price', 'quantity', 'plan_id')->first();
        if($plan){
        $plan_cat = Plan::where('id', $plan->plan_id)->select('category')->first();
        if($plan_cat->category == 1){
            $Total_ammount = $plan->price*$plan->quantity;
        } else {
            $Total_ammount = $plan->price;
        }
        }
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName('Item 1')  /** item name **/
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($Total_ammount); /** unit price **/    

        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($Total_ammount);
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Your transaction description');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(route('payment_status', compact('order')))
            ->setCancelUrl(route('payment_status', compact('order')));
       
        $payment = new PaypalPayment();

        $hello = $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        $payment->create($this->_api_context);  
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_urls = $link->getHref();
                break;
            }
        }
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_urls)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_urls);
        }
        \Session::put('error', 'Unknown error occurred');
        return Redirect::route('paywithpaypal'); 
    } 
        catch (\PayPal\Exception\PPConnectionException $ex) {
            //dd($ex);
            if (\Config::get('app.debug')) {
                \Session::put('error', 'Connection timeout');
                    return Redirect::route('paywithpaypal');
            } else {
                \Session::put('error', 'Some error occur, sorry for inconvenient');
                    return Redirect::route('paywithpaypal');
               }
        }
    }
    

    public function show(Request $request){
    try {
        $payment_id = Session::get('paypal_payment_id');
        Session::forget('paypal_payment_id');
          if (empty($_GET['PayerID']) || empty($_GET['token'])) {
            return Redirect::route('failed_payment');
        }
        $payment = PaypalPayment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($_GET['PayerID']);
        $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') {
            $order_id = $_GET['order'];

            Billing::where('billing_id', $order_id)
            ->update([
                'transaction_id' =>  $payment_id,
                'status' =>  1,
            ]);

            $user_id =  Auth::id();
            $user = User::where('id', $user_id)->select('name', 'email', 'employer_name', 'job_post_limit', 'profile_view_limit')->first();
            $email = $user->email;
            $name = $user->name;
            $employer_name = $user->employer_name;   
              
            $plan =  Billing::join('plans', 'billings.plan_id', '=', 'plans.id')
                ->select('plans.name', 'billings.quantity', 'billings.price', 'plans.profile_view', 'plans.category', 'plans.duration', 'plans.job_description', 'plans.job_search', 'plans.job_branding', 'plans.city')
                ->where('billings.billing_id', $order_id)
                ->first(); 

            $data['plan'] = $plan;
            $expire_date = '';

            if($plan->category == 2){
                $today = date('Y-m-d');
                $expire_date = date('Y-m-d', strtotime($today. ' +'.$plan->duration.' days'));
                User::where('id', $user_id)
                ->update([
                    'job_post_limit' => $user->job_post_limit+$plan->job_post,
                    'profile_view_limit' => $user->profile_view_limit+$plan->profile_view,
                    'plan_expire' => $expire_date,
                ]);
            } else {
                User::where('id', $user_id)
                ->update([
                    'job_post_limit' => $user->job_post_limit+$plan->quantity,
                    'job_description' => $plan->job_description,
                    'job_search' => $plan->job_search,
                    'job_branding' => $plan->job_branding,
                    'city_plan' => $plan->city,
                ]);
            }

            $home = route('home');
        
            // \Mail::send('email.billing_admin', $data, function($message) use ($email){
            //   $message->from($email);
            //   $message->to('no-reply@ez-job.co');
            //   $message->subject('EZ-Job - Plan Active');
            // });
            $type = 1;
            $plan_name = $plan->name;
            $category = $plan->category;
            $quantity = $plan->quantity;
            $job_description = $plan->job_description;
            $city = $plan->city;
            $job_search = $plan->job_search;
            $job_branding = $plan->job_branding;
            $profile_view = $plan->profile_view;
            $duration = $plan->duration;


            $responce = $this->send_email($home, $employer_name, $name, $email, $payment_id, $type, $plan_name, $category, $quantity, $job_description, $city, $job_search, $job_branding, $profile_view, $duration);


            // \Mail::send('email.billing', $data, function($message) use ($email){
            //   $message->from('navjot@shailersolutions.com');
            //   $message->to($email);
            //   $message->subject('EZ-Job - New Plan Active');
            // });
            
            $type = 2;
            $responce = $this->send_email($home, $employer_name, $name, $email, $payment_id, $type, $plan_name, $category, $quantity, $job_description, $city, $job_search, $job_branding, $profile_view, $duration);

            $countries = Country::all();

            return view('frontend.pages.thanku', compact('plan', 'countries', 'payment_id', 'expire_date'));

        } else{

        return Redirect::route('failed_payment');
    }

    } catch (\Exception $exception) {
        //dd($exception);
        return redirect()->route('home');
    }
}

public function send_email($home, $employer_name, $name, $email, $payment_id, $type, $plan_name, $category, $quantity, $job_description, $city, $job_search, $job_branding, $profile_view, $duration){
        $postdata = http_build_query(
        array(
        'home' => $home,
        'employer_name' => $employer_name,
        'name' => $name,
        'email' => $email,
        'payment_id' => $payment_id,
        'type' => $type,
        'plan_name' => $plan_name,
        'category' => $category,
        'quantity' => $quantity,
        'job_description' => $job_description,
        'city' => $city,
        'job_search' => $job_search,
        'job_branding' => $job_branding,
        'profile_view' => $profile_view,
        'duration' => $duration,

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
        $result = file_get_contents('https://sspl20.com/jyoti/uttuapp/api/send-billing-email-ez', false, $context);
        return $result;
    }

   


}
