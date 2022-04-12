<?php

namespace App\Http\Controllers\Backend\Auth\User;

use App\Models\Auth\User;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Auth\UserRepository;
use App\Http\Requests\Backend\Auth\User\ManageUserRequest;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use Illuminate\Support\Facades\Mail;

/**
 * Class UserConfirmationController.
 */
class UserConfirmationController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param ManageUserRequest $request
     * @param User              $user
     *
     * @return mixed
     */
    public function sendConfirmationEmail(ManageUserRequest $request, User $user)
    {
        // Shouldn't allow users to confirm their own accounts when the application is set to manual confirmation
        if (config('access.users.requires_approval')) {
            return redirect()->back()->withFlashDanger(__('alerts.backend.users.cant_resend_confirmation'));
        }

        if ($user->isConfirmed()) {
            return redirect()->back()->withFlashSuccess(__('exceptions.backend.access.users.already_confirmed'));
        }
        $user->notify(new UserNeedsConfirmation($user->uuid));
        return redirect()->back()->withFlashSuccess(__('alerts.backend.users.confirmation_email'));
    }
    
    public function verify(ManageUserRequest $request, User $user)
    {
        $user->verify_status = 1 ;
        $user->save();
        // email data
        $email_data = array(
            'first_name' => $user->first_name,
            'email' => $user->email,
        );

        //send email with the template
        Mail::send('emails.approve_image', $email_data, function ($message) use ($email_data) {
            $message->to($email_data['email'], $email_data['first_name'])
                ->subject('Dotcomlessons: Image ID Accepted')
                ->from('welcome@dotcomlessons.com', 'DotComLessons');
        });
        return redirect()->back()->withFlashSuccess('Successfully Verified');
    }
    
    public function unverify(ManageUserRequest $request, User $user)
    {
        $user->verify_status = 0 ;
        $user->save();
        // email data
        $email_data = array(
            'first_name' => $user->first_name,
            'email' => $user->email,
        );

        //send email with the template
        Mail::send('emails.deny_image', $email_data, function ($message) use ($email_data) {
            $message->to($email_data['email'], $email_data['first_name'])
                ->subject('Dotcomlessons: Image ID Not Accepted')
                ->from('welcome@dotcomlessons.com', 'DotComLessons');
        });
        return redirect()->back()->withFlashSuccess('Sorry, unVerified');
    }
    
    
    public function pay_verify(ManageUserRequest $request, User $user)
    {
        $user->f_pay_status = 1 ;
        $user->save();
        // email data
        // $email_data = array(
        //     'first_name' => $user->first_name,
        //     'email' => $user->email,
        // );

        // //send email with the template
        // Mail::send('emails.approve_payment', $email_data, function ($message) use ($email_data) {
        //     $message->to($email_data['email'], $email_data['first_name'])
        //         ->subject('Dotcomlessons: Image ID Accepted')
        //         ->from('welcome@dotcomlessons.com', 'DotComLessons');
        // });
        return redirect()->back()->withFlashSuccess('Successfully Payment Verified');
    }
    
    public function unpay_verify(ManageUserRequest $request, User $user)
    {
        $user->f_pay_status = 0 ;
        $user->save();
        // // email data
        // $email_data = array(
        //     'first_name' => $user->first_name,
        //     'email' => $user->email,
        // );

        // //send email with the template
        // Mail::send('emails.deny_image', $email_data, function ($message) use ($email_data) {
        //     $message->to($email_data['email'], $email_data['first_name'])
        //         ->subject('Dotcomlessons: Image ID Not Accepted')
        //         ->from('welcome@dotcomlessons.com', 'DotComLessons');
        // });
        return redirect()->back()->withFlashSuccess('Sorry, unVerified');
    }

    /**
     * @param ManageUserRequest $request
     * @param User              $user
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function confirm(ManageUserRequest $request, User $user)
    {
        $this->userRepository->confirm($user);

        return redirect()->route('admin.auth.user.index')->withFlashSuccess(__('alerts.backend.users.confirmed'));
    }

    /**
     * @param ManageUserRequest $request
     * @param User              $user
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function unconfirm(ManageUserRequest $request, User $user)
    {
        $this->userRepository->unconfirm($user);

        return redirect()->route('admin.auth.user.index')->withFlashSuccess(__('alerts.backend.users.unconfirmed'));
    }
}
