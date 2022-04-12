<?php

namespace App\Http\Controllers\Backend\Auth\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class AccountController.
 */
class AccountController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        
        $user = auth()->user();
        if(!empty($user->social_security_number)){
            $ssn = explode(' - ',$user->social_security_number);
            $user->social_security_number = 'XXX - XX - '.$ssn[2];
        }
      
        return view('backend.account.index',compact('user'));
    }
}
