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

use App\Models\Page;

use Auth;

/**

 * Class HomeController.

 */

class RewardsProgramController extends Controller

{

    /**

     * @return \Illuminate\View\View

     */
 
    public function index(Request $request)
    {
        
        $rewards = Transactions::where('referral_id',auth()->user()->id)
            ->whereIn('transaction_type',array('Annual Gold package','Course Purchase'))
            ->where('card_status',1)
            ->orderBy('date','desc')->paginate(10);
        foreach($rewards as $reward){
            if($reward->transaction_type == 'Annual Gold package') $reward->commission = 30;
            else $reward->commission = 10;
            $reward->date = Carbon::parse($reward->date)->format('m-d-Y');
        }
        $tier_2_ids = array();
        $tier_1_ids = User::where('referred_by',auth()->user()->id)->pluck('id')->toArray();
        $tier_2_ids = User::whereIn('referred_by',$tier_1_ids)->pluck('id')->toArray();
        $rewards_2 = Transactions::whereIn('user_id',$tier_2_ids)
            ->whereIn('transaction_type',array('Annual Gold package','Course Purchase'))
            ->where('card_status',1)
            ->orderBy('date','desc')->paginate(10);
        foreach($rewards_2 as $reward){
            $reward->date = Carbon::parse($reward->date)->format('m-d-Y');
            if($reward->transaction_type == 'Annual Gold package') $reward->commission = 15;
            else $reward->commission = 5;
        }
        
        $page = Page::find(14);
        return view('students.rewards-program.index',compact('rewards','page','rewards_2'));    
    }
}







