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

use File;

use App\Payment;

use App\Models\UploadImage;

use Illuminate\Support\Facades\Storage;

/**

 * Class HomeController.

 */

class VerifyController extends Controller

{

    /**

     * @return \Illuminate\View\View

     */
 
    public function index(Request $request)
    {
       
        $page = Page::find(9);
        
        return view('students.user-verify.index',compact('page'));    
    }
    
    public function uploadImage(Request $request){
        $image = $request->file('file');
        $name = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/storage/files/verify-img');
        $image->move($destinationPath, $name);
        $upload = UploadImage::where('user_id',auth()->user()->id)->first();
        if(!empty($upload)){
            $upload->file_name = $name;
            $upload->user_id = auth()->user()->id;
            $upload->save();
        }
        else{
            $upload = new UploadImage;
            $upload->file_name = $name;
            $upload->user_id = auth()->user()->id;
            $upload->save();
        }
        $user = User::find(auth()->user()->id);
        $user->image_status = 1;
        $user->save();
        return redirect()->back()->with('message','Successfully Uploaded');
    }
}







