<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Models\BillingModel;

/**
 * Class ForgotPasswordController.
 */
class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        $fetch_menuItem = new BillingModel();
        $Menu_itm_data  =   $fetch_menuItem->fecth_meunItem();
        return view('frontend.auth.passwords.email',['menu_item'=>$Menu_itm_data]);
    }
}
