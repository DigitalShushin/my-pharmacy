<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

use App\Models\SaleReturn;
use App\Models\SaleReturnItem;
use App\Models\Sale;
use App\Models\SalesItem;
use App\Models\Customer;

use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['frontend']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (view()->exists($request->path())) {
            return view($request->path());
        }
        return abort(404);
    }

    public function root()
    {
        $thisMonth = now()->month;
        $thisYear = now()->year;

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        // Total sales amount(Daily Sales)
        $totalSalesDaily = Sale::whereDate('created_at', $today)
                            ->sum('total_amount');

    
        $totalReturnsDaily = SaleReturnItem::whereDate('created_at', $today)
                                ->selectRaw('SUM(rate * quantity) as total')
                                ->value('total') ?? 0;

        $totalEarningsDaily = $totalSalesDaily - $totalReturnsDaily;

        $currentEarningsDaily = Sale::whereDate('created_at', $today)
                            ->sum('total_amount');

        $previousEarningsDaily = Sale::whereDate('created_at', $yesterday)
                            ->sum('total_amount');

        if ($previousEarningsDaily == 0) {
            $percentageChangeDaily = $currentEarningsDaily > 0 ? 100 : 0; // handle divide by zero
        } else {
            $percentageChangeDaily = (($currentEarningsDaily - $previousEarningsDaily) / $previousEarningsDaily) * 100;
        }

        // Total sales amount(Monthly Sales)
        $totalSales = Sale::whereMonth('created_at', $thisMonth)
                      ->whereYear('created_at', $thisYear)
                      ->sum('total_amount');

        $totalReturns = SaleReturn::whereMonth('created_at', $thisMonth)
                         ->whereYear('created_at', $thisYear)
                         ->sum('total_refund') ?? 0;

        $totalEarnings = $totalSales - $totalReturns;

        // Current month start and end
        $thisMonthStart = Carbon::now()->startOfMonth()->toDateString();
        $thisMonthEnd = Carbon::now()->endOfMonth()->toDateString();

        // Last month start and end
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        $currentEarnings = Sale::whereBetween('created_at', [$thisMonthStart, $thisMonthEnd])
                           ->sum('total_amount');

        $previousEarnings = Sale::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
                           ->sum('total_amount');

        if ($previousEarnings == 0) {
            $percentageChange = $currentEarnings > 0 ? 100 : 0; // handle divide by zero
        } else {
            $percentageChange = (($currentEarnings - $previousEarnings) / $previousEarnings) * 100;
        }

        // Sales COunt
        // $totalOrders = Sale::whereMonth('created_at', now()->month)
        //                     ->whereYear('created_at', now()->year)
        //                     ->count();

        // $currentEarningsSale = SalesItem::whereBetween('created_at', [$thisMonthStart, $thisMonthEnd])->count();

        // $previousEarningsSale = SalesItem::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd]) ->count();

        // if ($previousEarningsSale == 0) {
        //     $percentageChangeSale = $currentEarningsSale > 0 ? 100 : 0; // handle divide by zero
        // } else {
        //     $percentageChangeSale = (($currentEarningsSale - $previousEarningsSale) / $previousEarningsSale) * 100;
        // }

        // Customer Count
        // $totalCustomers = Customer::whereMonth('created_at', $thisMonth)
        //                   ->whereYear('created_at', $thisYear)
        //                   ->count();

        // $currentCustomer = Customer::whereBetween('created_at', [$thisMonthStart, $thisMonthEnd])->count();

        // $previousCustomer = Customer::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd]) ->count();

        // if ($previousCustomer == 0) {
        //     $percentageChangeCustomer = $currentCustomer > 0 ? 100 : 0;
        // } else {
        //     $percentageChangeCustomer = (($currentCustomer - $previousCustomer) / $previousCustomer) * 100;
        // }

        // dd($currentCustomer, $previousCustomer);

        // return view('index', compact('totalEarnings', 'percentageChange', 'totalOrders', 'percentageChangeSale', 'totalCustomers', 'percentageChangeCustomer'));

        // Earnings
        $totalEarnings = Sale::selectRaw('SUM(total_amount) as total')->value('total') ?? 0;

        // Daily earnings
        $now = Carbon::now();
        $daysInMonth = $now->daysInMonth; // e.g., 30 or 31

        $startOfMonth = $now->copy()->startOfMonth(); // e.g., 2025-06-01 00:00:00
        $endOfToday = $now->copy()->endOfDay();  

        $dailyEarnings = Sale::selectRaw("DATE(created_at) as date, SUM(total_amount) as total")
                                    ->whereBetween('created_at', [$startOfMonth, $endOfToday])
                                    ->groupBy('date')
                                    ->pluck('total', 'date')
                                    ->toArray();

        // Create array with keys = '01', '02', ... and values = 0
        $allDays = [];

        // generate upto today's date in a month
        // for ($day = 1; $day <= $now->day; $day++) {
        //     $date = $now->copy()->startOfMonth()->addDays($day - 1)->toDateString(); // e.g., 2025-06-01
        //     $allDays[$date] = 0;
        // }

        // generate whole days in a month
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = $now->copy()->startOfMonth()->addDays($day - 1)->toDateString(); // 'YYYY-MM-DD'
            $allDays[$date] = 0;
        }

        $mergedDailyEarnings = array_merge($allDays, $dailyEarnings);

        $today = Carbon::today(); // gets today's date at 00:00:00

        $todayEarnings = Sale::whereDate('created_at', $today)
                                ->sum('total_amount');
    
        // Monthly earnings

        $dayLabels = array_keys($mergedDailyEarnings); 

        $allMonths = [
            'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0,
            'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0,
            'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0
        ];

        $monthlyEarnings = Sale::selectRaw("DATE_FORMAT(sales_date, '%b') as month, SUM(total_amount) as total")
                                ->whereYear('sales_date', now()->year)
                                ->groupBy('month')
                                ->pluck('total', 'month')
                                ->toArray();

        $mergedEarnings = array_merge($allMonths, $monthlyEarnings);

        

        return view('index', compact('totalEarningsDaily', 'percentageChangeDaily', 'totalEarnings', 'percentageChange', 'totalEarnings', 'monthlyEarnings', 'mergedEarnings','dayLabels', 'mergedDailyEarnings', 'todayEarnings'));
    }

    /*Language Translation*/
    public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }

    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        $user = User::find($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');

        if ($request->file('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/images/');
            $avatar->move($avatarPath, $avatarName);
            $user->avatar =  $avatarName;
        }

        $user->update();
        if ($user) {
            Session::flash('message', 'User Details Updated successfully!');
            Session::flash('alert-class', 'alert-success');
            // return response()->json([
            //     'isSuccess' => true,
            //     'Message' => "User Details Updated successfully!"
            // ], 200); // Status code here
            return redirect()->back();
        } else {
            Session::flash('message', 'Something went wrong!');
            Session::flash('alert-class', 'alert-danger');
            // return response()->json([
            //     'isSuccess' => true,
            //     'Message' => "Something went wrong!"
            // ], 200); // Status code here
            return redirect()->back();

        }
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return response()->json([
                'isSuccess' => false,
                'Message' => "Your Current password does not matches with the password you provided. Please try again."
            ], 200); // Status code
        } else {
            $user = User::find($id);
            $user->password = Hash::make($request->get('password'));
            $user->update();
            if ($user) {
                Session::flash('message', 'Password updated successfully!');
                Session::flash('alert-class', 'alert-success');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Password updated successfully!"
                ], 200); // Status code here
            } else {
                Session::flash('message', 'Something went wrong!');
                Session::flash('alert-class', 'alert-danger');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Something went wrong!"
                ], 200); // Status code here
            }
        }
    }
}
