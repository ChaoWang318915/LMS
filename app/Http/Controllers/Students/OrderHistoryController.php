<?php



namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;

use App\Models\Auth\User;

use App\Models\Transactions;

use App\Models\System\Session;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Response;

use Carbon\Carbon;

use Cookie;

use Auth;

/**

 * Class HomeController.

 */

class OrderHistoryController extends Controller

{

    /**

     * @return \Illuminate\View\View

     */
 
    public function index(Request $request)
    {
        $orders = Transactions::where('user_id',auth()->user()->id)->where('transaction_type','!=','Make Payment')->orderBy('date','desc')->paginate(20);
        foreach($orders as $order){
            $order->date = Carbon::parse($order->date)->format('m-d-Y');
        }
        return view('students.order-history.index',compact('orders'));    
    }
}







