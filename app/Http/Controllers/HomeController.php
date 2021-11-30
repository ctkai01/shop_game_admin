<?php

namespace App\Http\Controllers;

use App\Models\DetailProduct;
use App\Models\Recharge;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $productsSold = DetailProduct::where('sold', DetailProduct::SOLD)->get();
        $rechargeAccess = Recharge::where('status', 1)->get();
   
        $totalBought = $productsSold->reduce(function ($total, $productSold) {
            return $total + $productSold->product->price*(100 - $productSold->product->discount)/100;
        }, 0);

        $totalRecharge = $rechargeAccess->reduce(function ($total, $recharge) {
            return $total + $recharge->coin;
        }, 0);

        return view('home', compact('totalBought', 'totalRecharge'));
    }

    public function getProduct(Request $request) {
        $type = '';
        if ($request->ajax()) {
            $colectionUsers = collect([]);
            if ($request->time == '0') {
                $userColl = DetailProduct::where('sold', DetailProduct::SOLD)->get();

                for ($i = (int) date('N') - 1; $i >= 0; $i--) {
                    $date = date('Y-m-d', strtotime(' -' . $i . ' day'));
                    
                    $myDate = Carbon::createFromFormat('Y-m-d', $date);
                    $startOfDayTimestamp = $myDate->startOfDay()->timestamp;
                    $endOfDayTimestamp = $myDate->endOfDay()->timestamp;
                    
                    $userCreatedIntime = $userColl->filter(function ($user) use($startOfDayTimestamp, $endOfDayTimestamp) {
                        return strtotime($user->updated_at) > $startOfDayTimestamp && strtotime($user->updated_at) < $endOfDayTimestamp;
                    });

                    $colectionUsers->push($userCreatedIntime->count());
                }
                for ($i = (int) date('N') + 1; $i <= 7; $i++) {
                    $colectionUsers->push(0);
                }
                $type = 'Week';
            } else if ($request->time == '1') {
                $userColl = DetailProduct::where('sold', DetailProduct::SOLD)->get();

                for ($i = (int) date('j') - 1; $i >= 0; $i--) {
                    $date = date('Y-m-d', strtotime(' -' . $i . ' day'));

                    $myDate = Carbon::createFromFormat('Y-m-d', $date);
                    $startOfDayTimestamp = $myDate->startOfDay()->timestamp;
                    $endOfDayTimestamp = $myDate->endOfDay()->timestamp;

                    $userCreatedIntime = $userColl->filter(function ($user) use($startOfDayTimestamp, $endOfDayTimestamp) {
                        return strtotime($user->updated_at) > $startOfDayTimestamp && strtotime($user->updated_at) < $endOfDayTimestamp;
                    });

                    $colectionUsers->push($userCreatedIntime->count());
                }
                $dayOfMonthCurrent = cal_days_in_month(CAL_GREGORIAN, (int) date('n'), (int) date('o'));
                for ($i = (int) date('j') + 1; $i <= $dayOfMonthCurrent; $i++) {
                    $colectionUsers->push(0);
                }
                $type = 'Month';
            } else {
                // $users = User::select('id', 'created_at')
                $users = DetailProduct::select('id', 'created_at')->where('sold', DetailProduct::SOLD)

                ->get()
                ->groupBy(function($date) {
                    return Carbon::parse($date->updated_at)->format('m'); 
                });

                $usermcount = [];
                foreach ($users as $key => $value) {
                    $usermcount[(int)$key] = count($value);
                }

                for ($i = 1; $i <= 12; $i++){
                    if(!empty($usermcount[$i])){
                        $colectionUsers->push($usermcount[$i]);
                    }else {
                        $colectionUsers->push(0);
                    }
                }
                $type = 'Year';
            }
            return response()->json([
                'users' => $colectionUsers,
                'type' => $type
            ]);
        }
    }
}
