<?php



namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;

use App\Models\Auth\User;

use App\Models\Transactions;

use App\Payment;

use App\Models\System\Session;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Response;

use Carbon\Carbon;

use Cookie;

use Auth;

/**

 * Class HomeController.

 */

class PaymentHistoryController extends Controller

{

    /**

     * @return \Illuminate\View\View

     */
 
    public function index(Request $request)
    {
        $payments = Payment::where('user_id',auth()->user()->id)->orderBy('id','desc')->paginate(20);
        foreach($payments as $payment){
            $payment->payment_date = Carbon::parse($payment->payment_date)->format('m-d-Y');
        }
        return view('students.payment-history.index',compact('payments'));    
    }
}







