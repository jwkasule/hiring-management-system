<?php

namespace App\Http\Controllers\Auth;

use Mail;
use App\Models\User;
use App\Models\OtpStore;
use App\Models\Trakings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Jenssegers\Agent\Facades\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use DeviceDetector\Parser\Client\Browser;
use Illuminate\Support\Facades\Mail as FacadesMail;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        // dd($request->all());
       // $request->authenticate();
    //    $check_user=User::all();
    //    dd($check_user);
        
        // dd($user_id->$request->id);  
        
        
       // dd($request->email);
        $password_status=User::where('email',$request->email)->get();
        if(!$password_status->isEmpty()){
           
        
        $temp_pass_status=$password_status[0]->temp_password;
    //   dd($password_status);
        
         $pass = Hash::check($request->password, $temp_pass_status);

        //   dd($pass);
        
        if(!$temp_pass_status==null && $pass){
            
            $get_user=User::where('email',$request->email)
                            ->where('temp_password', Hash::check('temp_password',$request->password))
                            ->get();
                            
                            // dd($get_user[0]->id);
                            $get_id=$get_user[0]->id;
                        //   dd($get_user);      
                if($get_user->isNotEmpty()){
                     return view('auth.newpassword',compact('get_id'));
                
                }
                else{
                    return "incorrect";
                }
        }
        else{
        
       $credentials = $request->only('email', 'password');
    //   dd($credentials);
       if (Auth::attempt($credentials)) {   
        $id = Auth::user()->id;
        
        $user_id = User::where('id',$id)->get();
        $user_fname = $user_id[0]['fname'];
        $user_lname = $user_id[0]['lname'];
        $username =  $user_fname . " " .  $user_lname;
       
        //dd( $username);
       
        $email= $request->email;
        $random=rand(111111,999999);
        $user_data=User::where('id',$id)->get('mobile');
        $is_present_mobile_no=OtpStore::where('mobile_no',$user_data[0]->mobile)->get();
        if($is_present_mobile_no->isEmpty()){
            $otpstore= new OtpStore;
            $otpstore->otp=$random;
            
            $otpstore->mobile_no=$user_data[0]->mobile; 
            $otpstore->save();
               

            $customer_mobile=$otpstore->mobile_no;
          $customer_otp=  $otpstore->otp;
        

        }
        else{
            $otpstore=OtpStore::where('mobile_no','=',$user_data[0]->mobile)->first();
            $otpstore->otp=$random;
            $otp_in=$otpstore->otp;
            $otpstore->update();

        }
        $request->session()->regenerate();
        $request->session()->put('USER_ID', Auth::id());
        $userid=session('USER_ID');


        // dd($otp_in,$email);

       // $this->mail_send('Prasant','666555');
        $this->mail_send( $random ,$email,$username,'abinash889@gmail.com');

        if(Auth::user()->status == 1){
            return view('auth.otp');
            }
            
            else{
    
                return redirect ('/');
            }

       }

        $request->session()->regenerate();
         $request->session()->put('USER_ID', Auth::id());
         $userid=session('USER_ID');
        //dd(session('USER_ID'));
       
        //  return redirect()->intended(RouteServiceProvider::HOME)->with('msg',"Invalid Password");
        return redirect ('/login')->with('msg',"Invalid Password");
        }
    }
    else{
        return redirect ('/login')->with('msg',"Invalid User Id");
    }
    }

    //prasant email
    public function mail_send($random,$email,$username)
    {
        // echo "hyy";
 $data = [ 'otp' => $random , 'email' => $email, 'username' => $username];
 
        // $data = ['name' => $fname, 'password' => $password];
         $smail = $email;
        $user['to'] = $smail;
     
        FacadesMail::send('mail.otp', $data, function ($messages) use ($user) {
            $messages->to($user['to']);

            $messages->subject('CT-HIRING OTP');
        });
    }
    
    public function newpass(Request $request)
    {
    //   dd($request->all());
       
       $device = User::where('id',$request->tempassword_id);
        $device->update([
        'password' => Hash::make($request->password),
        'temp_password' => null
        ]);
         
        return redirect ('/login');
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function otp()
    {
        return view('auth.otp');
    }
    public function otp_verify(Request $request){

       // dd($request->all(),session('USER_ID'));
        $mobile_no_get=User::where('id',session('USER_ID'))->get('mobile');
        $get_otp=OtpStore::where('mobile_no',$mobile_no_get[0]->mobile)->get();
         
        //dd($request->otp,$get_otp[0]->otp);
       if($request->otp==$get_otp[0]->otp){

        $request->session()->put('otp_verified',true);
        // dd($request->session());
        
        
        // $bro = '';
        // if(Browser::$request->isChrome())
        // {
		// 	$bro = 'crome';
        // }
		// elseif($request->Browser::isFirefox())
        // {
		// 	$bro = 'edg';
        // }
		
        // @elseif(Browser::isOpera())
		// <p>Opera Browser</p>
		// @elseif(Browser::isSafari())
		// 	<p>Safari Browser</p>
		// @elseif(Browser::isIE())
		// 	<p>Internet Explorer Browser</p>
		// @elseif(Browser::isEdge())
		// 	<p>Microsoft Edge Browser</p>
		// @endif


           //create user traking data in traking model
           
           //$Browser = $_SERVER['HTTP_USER_AGENT'];
           
           //$Browser = header('User-Agent');


        //    Browser::isMobile();
        //    Browser::isTablet();
        //    Browser::isDesktop();
           
        //    // Every wondered if it is a bot who loading your page?
        //    if (Browser::isBot()) {
        //        echo 'No need to wonder anymore!';
        //    }
           
        //    // Check for vendors.
        //    if (Browser::isFirefox() || Browser::isOpera()) {
        //        $output .= '<script src="firefox-fix.js"></script>';
        //    }


           //$brow = get_browser( $request->header('User-Agent') , true);

           //$fbro =  implode(" ",$brow);

           //$json = json_encode($brow);

            // $rawbro = $request->userAgent();
            // $bro = '';
            // if(strpos($_SERVER[$rawbro], 'Chrome')){
            //     $bro = 'crome';
            // }
            // else{

            //     $bro = 'edg';

            // }
            
            //$user_agent = $request->server('HTTP_USER_AGENT');

            $user_agent = $request->header('User-Agent');
             $bname = 'Unknown';
            // $platform = 'Unknown';

            // $agent = new Agent($request);
            // $bname = $agent->browser();




            // // Next get the name of the useragent yes seperately and for good reason
            if(preg_match('/MSIE/i',$user_agent) && !preg_match('/Opera/i',$user_agent))
            {
                $bname = 'Internet Explorer';
                $ub = "MSIE";
            }
            elseif(preg_match('/Firefox/i',$user_agent))
            {
                $bname = 'Mozilla Firefox';
                $ub = "Firefox";
            }
            elseif(preg_match('/Chrome/',$user_agent))
            {
                $bname = 'Google Chrome';
                $ub = "Chrome";
            }
            elseif(preg_match('/Safari/i',$user_agent))
            {
                $bname = 'Apple Safari';
                $ub = "Safari";
            }
            elseif(preg_match('/Opera/i',$user_agent))
            {
                $bname = 'Opera';
                $ub = "Opera";
            }
            elseif(preg_match('/edg/',$user_agent))
            {
                $bname = 'Netscape';
                $ub = "Netscape";
            }else{
                $bname = 'edg';
            }



           Trakings::create([
            'users_id' =>auth()->id(),
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'ip_addresh' => $request->ip(),
            
            //'device' => $json,
            //'device' => get_browser( $request->header('User-Agent') , true),
            //'device' => $request->userAgent(),
            
            //'device' => $request->header('User-Agent'),

            
            'device' => $bname
            //'device' => $request->
            
           
        ]);



        return redirect('/');

       }
       else{
        // Auth::logout();
        $request->session()->flash('otpmsg','Invalid OTP'); 
        return view('auth.otp');

       }
    }



}

