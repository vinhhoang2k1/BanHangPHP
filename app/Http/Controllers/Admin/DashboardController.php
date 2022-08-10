<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request){
        $amountOrder = Order::count();
        $pendingOrderNumber = Order::where('status', 'pending')->count();
        $successOrderNumber = Order::where('status', 'success')->count();
        $cancelOrderNumber = Order::where('status', 'cancel')->count();
        $totalMoney = Order::where('status', 'success')->sum('total_money');
        $totalCustomer = Customer::count();

        $typeDate = $request->query('type') ?? 'year';
        $report = [];
        if ($typeDate == 'year') {

            $date = $request->query('date') ?? date('Y', time());
//            $report = Order::whereYear('created_at', $date)->where('status', 'success')->sum('total_money');
            $orders = Order::select(
                DB::raw('sum(total_money) as sums'),
                DB::raw("DATE_FORMAT(created_at,'%m') as monthKey")
            )
                ->whereYear('created_at', $date)
                ->where('status', 'success')
                ->groupBy('monthKey')
                ->orderBy('monthKey', 'ASC')
                ->get()->toArray();

            foreach (range(1, 12) as $key => $value) {

                foreach ($orders as $order) {
                    if ($value == (int) $order['monthKey']) {
                        $report[$key] = $order['sums'];
                        break;
                    } else {
                        $report[$key] = 0;
                    }
                }

            }

        } elseif ($typeDate == 'month') {

            $date = $request->query('date') ?? date('Y-m', time());
            $date = explode('-', $date);
            $orders = Order::select(
                DB::raw('sum(total_money) as sums'),
                DB::raw("DATE_FORMAT(created_at,'%d') as dayKey")
            )
                ->whereYear('created_at', $date[0])
                ->whereMonth('created_at', $date[1])
                ->where('status', 'success')
                ->groupBy('dayKey')
                ->orderBy('dayKey', 'ASC')
                ->get()->toArray();


            $dayOfMonth = cal_days_in_month(CAL_GREGORIAN, now()->format('m'),now()->format('Y'));

            foreach (range(1, $dayOfMonth) as $key => $value) {

                foreach ($orders as $order) {

                    if ($value == (int) $order['dayKey']) {
                        $report[$key] = $order['sums'];
                         break;
                    } else {
                        $report[$key] = 0;
                    }
                }

            }

         }


        return view('admin.dashboard',
            compact(
                'amountOrder',
                'pendingOrderNumber',
                'successOrderNumber',
                'cancelOrderNumber',
                'totalMoney',
                'totalCustomer',
                'typeDate',
                'report'
            )
        );
    }
}
