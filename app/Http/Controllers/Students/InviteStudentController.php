<?php



namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;

use App\Models\Auth\User;

use App\Models\Transactions;

use App\Models\System\Session;

use App\Models\Page;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Response;

use Carbon\Carbon;

use Cookie;

use Auth;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\Models\InviteEmail;
/**

 * Class HomeController.

 */

class InviteStudentController extends Controller

{

    /**

     * @return \Illuminate\View\View

     */
 
    public function index(Request $request)
    {
        $page = Page::find(17);
        return view('students.invite-student.index',compact('page'));    
    }
    
    public function inviteEmail(Request $request){
        // $validator = Validator::make(Input::all(), [
        //     'first_name' => 'required|max:255',
        //     'email' => 'required|email|max:255',
        // ]);
        // email data
        $subject = $request->first_name.' - Did you see this yet!';
        $email_data = array(
            'first_name' => $request['first_name'],
            'email' => $request['email'],
            'subject'=>$subject,
            'id'=>auth()->user()->id,
            'user_name'=>auth()->user()->first_name,
        );
        InviteEmail::create([
            'name'=>$request->first_name,
            'email'=>$request->email,
            'user_id'=>auth()->user()->id,
            'date'=>Carbon::today()->format('Y-m-d')
            ]);
        //send email with the template
        Mail::send('emails.invite_student', $email_data, function ($message) use ($email_data) {
            $message->to($email_data['email'], $email_data['first_name'])
                ->subject($email_data['subject'])
                ->from('welcome@dotcomlessons.com', 'DotComLessons');
        });
        return redirect()->back()->with('success', 'Successfully Sent Invite Email');
        
    }
}







