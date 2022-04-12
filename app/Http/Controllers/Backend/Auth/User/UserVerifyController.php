<?php

namespace App\Http\Controllers\Backend\Auth\User;

use App\Models\Auth\User;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Auth\UserRepository;
use App\Http\Requests\Backend\Auth\User\ManageUserRequest;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;

/**
 * Class UserVerifyController.
 */
class UserVerifyController extends Controller
{
    public function verify(){
        echo "123";die;
    }
    // /**
    //  * @var UserRepository
    //  */
    // protected $userRepository;

    // /**
    //  * @param UserRepository $userRepository
    //  */
    // public function __construct(UserRepository $userRepository)
    // {
    //     $this->userRepository = $userRepository;
    // }

    // /**
    //  * @param ManageUserRequest $request
    //  * @param User              $user
    //  *
    //  * @return mixed
    //  */
    // public function sendConfirmationEmail(ManageUserRequest $request, User $user)
    // {
    //     // Shouldn't allow users to confirm their own accounts when the application is set to manual confirmation
    //     if (config('access.users.requires_approval')) {
    //         return redirect()->back()->withFlashDanger(__('alerts.backend.users.cant_resend_confirmation'));
    //     }

    //     if ($user->isConfirmed()) {
    //         return redirect()->back()->withFlashSuccess(__('exceptions.backend.access.users.already_confirmed'));
    //     }

    //     $user->notify(new UserNeedsConfirmation($user->confirmation_code));

    //     return redirect()->back()->withFlashSuccess(__('alerts.backend.users.confirmation_email'));
    // }

    /**
     * @param ManageUserRequest $request
     * @param User              $user
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    // public function verify(ManageUserRequest $request, User $user)
    // {
    //     //$this->userRepository->verify($user);
    //     return redirect()->route('admin.auth.user.index')->withFlashSuccess('Successfully Verified!');
    // }

    /**
     * @param ManageUserRequest $request
     * @param User              $user
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    // public function unverify(ManageUserRequest $request, User $user)
    // {
    //     //$this->userRepository->unverify($user);

    //     return redirect()->route('admin.auth.user.index')->withFlashSuccess('Sorry, Unverified!');
    // }
}
