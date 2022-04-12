<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Helpers\Frontend\Auth\Socialite;
use App\Events\Frontend\Auth\UserRegistered;
use App\Models\Auth\User;
use App\Models\BillingModel;
use App\Models\Transactions;
use Arcanedev\NoCaptcha\Rules\CaptchaRule;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Repositories\Frontend\Auth\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ClosureValidationRule;
use Carbon\Carbon;
use App\Models\ReferralLog;
use App\Models\PromoCode;
use Illuminate\Support\Facades\Mail;

// 
/**
 * Class RegisterController.
 */
class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * RegisterController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    public function redirectPath()
    {
        return route(home_route());
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        abort_unless(config('access.registration'), 404);

        return view('frontend.auth.register')
            ->withSocialiteLinks((new Socialite)->getSocialLinks());
    }

    /**
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function register(Request $request)
    {
        if($request->role == 'student'){
            $validator = Validator::make(Input::all(), [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'social_security_number'=>'required|unique:users',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
                'dob'=>'required',
                'phone'=>'required',
                'address'=>'required',
                'city'=>'required',
                'pincode'=>'required',
                'state'=>'required',
                'active'=>'required',
                // 'country'=>'required',
                'g-recaptcha-response' => (config('access.captcha.registration') ? ['required',new CaptchaRule] : ''),
            ],[
                'g-recaptcha-response.required' => __('validation.attributes.frontend.captcha'),
            ]);
        }
        else{
            $validator = Validator::make(Input::all(), [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
                'phone'=>'required',
                'address'=>'required',
                'city'=>'required',
                'pincode'=>'required',
                'state'=>'required',
                'active'=>'required',
                // 'country'=>'required',
                'g-recaptcha-response' => (config('access.captcha.registration') ? ['required',new CaptchaRule] : ''),
            ],[
                'g-recaptcha-response.required' => __('validation.attributes.frontend.captcha'),
            ]);
        }
        

        if ($validator->passes()) {
            // Store your user in database
            // event(new Registered($user = $this->create($request->all())));
            $user = User::create([
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
                'uniqe_id'=>mt_rand(),
                'password' => Hash::make($request['password']),
            ]); 
                 
                  
            $user->dob = isset($request['dob']) ? $request['dob'] : NULL ;
            $user->social_security_number = isset($request['social_security_number']) ? $request['social_security_number'] : NULL ;
            $user->phone = isset($request['phone']) ? $request['phone'] : NULL ;
            $user->gender = isset($request['gender']) ? $request['gender'] : NULL;
            $user->address = isset($request['address']) ? $request['address'] : NULL;
            $user->paypal_address = isset($request['paypal_address']) ? $request['paypal_address'] : NULL;
            $user->city =  isset($request['city']) ? $request['city'] : NULL;
            $user->pincode = isset($request['pincode']) ? $request['pincode'] : NULL;
            $user->name_suffix = isset($request['name_suffix']) ? $request['name_suffix'] : NULL;
            $user->state = isset($request['state']) ? $request['state'] : NULL;
            $user->country = isset($request['country']) ? $request['country'] : 'United States';
            $user->middle_name = isset($request['middle_name']) ? $request['middle_name'] : NULL;
            $user->start_date = Carbon::today()->format('Y-m-d 00:00:00');
            $user->bill_date = Carbon::today()->addDays(31)->format('Y-m-d 00:00:00');
            $user->referred_by = $request->referral_id;
            
            $user->company_name = isset($request['company_name']) ? $request['company_name'] : NULL ;
            $user->website_type = isset($request['website_type']) ? $request['website_type'] : NULL ;
            $user->website_url = isset($request['website_url']) ? $request['website_url'] : NULL ;
            $user->description = isset($request['description']) ? $request['description'] : NULL ;
            
            
            $user->promo_code = $request->promo_code;
            $user->save();
            $userForRole = User::find($user->id);
            $userForRole->confirmed = 0;
            $userForRole->save();
            if($request->role == 'student') $userForRole->assignRole('student');
            else if($request->role == 'affiliate') $userForRole->assignRole('affiliate');
            //Create Referral Log if the referral id is exist 
            if(!empty($request->referral_id)){
                
                $referral = ReferralLog::where('ip_address',$request->ip_address)->where('referral_id',$request->referral_id)->first();
                if(!empty($referral)){
                    $referral_user = User::find($request->referral_id);
                    if(!empty($referral_user)){
                        $referral_user->clicks += 1;
                        $referral_user->save();
                    }
                }
                else{
                    $referral_user = User::find($request->referral_id);
                    if(!empty($referral_user)){
                        $referral_user->clicks += 1;
                        $referral_user->unique_clicks += 1;
                        $referral_user->save();
                    }
                }
                ReferralLog::create([
                    'user_id'=>$user->id,
                    'referral_id'=>$request->referral_id,
                    'ip_address'=>$request->ip_address,
                    'site_name'=>$request->site_name,
                    'date'=>Carbon::today()->format('Y-m-d H:i:s'),
                ]);
                
            }
            
            
            // email data
            $email_data = array(
                'first_name' => $request['first_name'],
                'email' => $request['email'],
                'uuid'=>$user->uuid
            );
    
            //send email with the template
            Mail::send('welcome_email', $email_data, function ($message) use ($email_data) {
                $message->to($email_data['email'], $email_data['first_name'])
                    ->subject('Welcome to DotComLessons')
                    ->from('welcome@dotcomlessons.com', 'DotComLessons');
            });
            
            //send email to no-reply@dotcomlessons
            Mail::send('admin_email', $email_data, function ($message) use ($email_data) {
                $message->to('no-reply@dotcomlessons.com', $email_data['first_name'])
                    ->subject('New user sign up on dotcomlessons')
                    ->from('welcome@dotcomlessons.com', 'DotComLessons');
            });
            //send email to his referal user
            if(!empty($request->referral_id)){
                $ref_user = User::find($request->referral_id);
                if(!empty($ref_user)){
                    $email_data['email'] = $ref_user->email;
                    Mail::send('referral_email', $email_data, function ($message) use ($email_data) {
                        $message->to($email_data['email'], $email_data['first_name'])
                            ->subject('You have a New Referral on DotcomLessons')
                            ->from('welcome@dotcomlessons.com', 'DotComLessons');
                    });
                }
            }
            //2 steps transaction - first course - 30 and Annual Gold package - 99 = 129
            if(empty($request->promo_code)){
                $this->generateTransaction($user,0);
            }
            else{
                //check if the promo code is active or not
                $today = Carbon::today()->format('Y-m-d');
                $promo_code = PromoCode::where('promo_code',$request->promo_code)->first();
                if(!empty($promo_code)){
                    $start_date = $promo_code->start_date;
                    $end_date = $promo_code->end_date;
                    if ($today >= $start_date && $today <= $end_date){
                         $this->generateTransaction($user,$promo_code->discount_amount);
                         $user->current_credit = 129.99 - $promo_code->discount_amount;
                         $user->save();
                    }
                    else{
                         $this->generateTransaction($user,0);
                    }
                }
                else{
                     $this->generateTransaction($user,0);
                }
                
            }
            
            return response(['success' => true]);

        }

        return response(['errors' => $validator->errors()]);
    }
    
    public function generateTransaction($user,$discount){
        $amount = 99.99 - $discount;
        $available_credit = 2000 - $amount;
        Transactions::create([
            'user_id'=>$user->id,
            'transaction_type'=>'Annual Gold package',
            'amount'=>$amount,
            'remaining_credit'=>$available_credit,
            'date'=>Carbon::today()->format('Y-m-d H:i:s'),
            'referral_id'=>$user->referred_by,
            'commission'=>!empty($user->referred_by) ? 30:NULL,
            'owe_amount'=>-$amount
        ]);
        $available_credit = $available_credit - 30;
        Transactions::create([
            'user_id'=>$user->id,
            'transaction_type'=>'One time processing fee',
            'amount'=>30,
            'remaining_credit'=>$available_credit,
            'date'=>Carbon::today()->format('Y-m-d H:i:s'),
            'referral_id'=>$user->referred_by,
            'commission'=>!empty($user->referred_by) ? 5:NULL,
            'owe_amount'=>-30
        ]); 
        $user->available_credit = $available_credit;
        $user->save();
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'uniqe_id'=>mt_rand(),
            'password' => Hash::make($data['password']),
        ]); 
             
              
        $user->dob = isset($data['dob']) ? $data['dob'] : NULL ;
        $user->social_security_number = isset($data['social_security_number']) ? $data['social_security_number'] : NULL ;
        $user->phone = isset($data['phone']) ? $data['phone'] : NULL ;
        $user->gender = isset($data['gender']) ? $data['gender'] : NULL;
        $user->address = isset($data['address']) ? $data['address'] : NULL;
        $user->city =  isset($data['city']) ? $data['city'] : NULL;
        $user->pincode = isset($data['pincode']) ? $data['pincode'] : NULL;
        $user->state = isset($data['state']) ? $data['state'] : NULL;
        $user->country = isset($data['country']) ? $data['country'] : NULL;
        $user->save();
      
        $userForRole = User::find($user->id);
        $userForRole->confirmed = 0;
        $userForRole->save();
        $userForRole->assignRole('student');
        // email data
        $email_data = array(
            'first_name' => $data['first_name'],
            'email' => $data['email'],
        );

        // send email with the template
        Mail::send('welcome_email', $email_data, function ($message) use ($email_data) {
            $message->to($email_data['email'], $email_data['first_name'])
                ->subject('Welcome to DotComLessons')
                ->from('support@dotcomlessons.com', 'DotComLessons');
        });
        return $user;
    }



}
