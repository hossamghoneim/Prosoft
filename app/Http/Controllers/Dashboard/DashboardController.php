<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {

        list(

          $totalOrders,
          $thisMonthClients,
          $thisMonthOrders,
          $totalSalesCategories,
          $dailySales,
          $productsCategories,
          $ordersGoalThisMonth

        ) = $this->getStatisticsVars();

        return view('dashboard.index',compact('thisMonthClients','thisMonthOrders','ordersGoalThisMonth','totalOrders','totalSalesCategories','productsCategories','dailySales'));
    }


    public function getStatisticsVars()
    {
//        $totalOrders = Order::with('orderItems:order_id,quantity,product_price,product_id')->select('id','sub_total')->get();
//
//        return
//        [
//            $totalOrders ,
//            User::whereMonth('created_at' , date('m') )->select('name','image')->get(),
//            Order::whereMonth('created_at' , date('m') )->select('id')->count(),
//            $this->getTotalSalesCategories( $totalOrders ),
//            $this->getDailySales(),
//            Category::select('id')->withCount('products')->get()->sortByDesc('products_count')->values(),
//            200,
//        ];

        return
            [
                collect(),
                collect(),
                0,
                collect(),
                0,
                collect(),
                1,
            ];

    }

    private function getTotalSalesCategories( $totalOrders )
    {
        return  $totalOrders
                ->pluck('orderItems')
                ->flatten()
                ->groupBy('product.category_id')
                ->map( function( $orders ){

                    return
                    [
                        'total_price' => $orders->sum( fn($order) => $order['quantity'] * $order['product_price']),
                        'category'    => $orders->first()->product->category->name
                    ];

                })->sortByDesc('total_price');

    }

    private function getDailySales()
    {

        $monthSales = Order::whereMonth('date' , date('m') )->groupBy('date')
            ->selectRaw('SUM(sub_total) total_sales, date')
            ->get();

        $monthDays  = collect( range(1, date('d')) )->map( fn( $day ) => date('Y-m-') . ( $day >= 10 ? '' : '0' ) . $day );

        foreach ($monthDays as $day )
        {
            $daySales = $monthSales->firstWhere('date',$day);
            $dailySales[] = [ 'date' => explode('-',$day)[2] , 'sales' => $daySales ? $daySales->total_sales : 0 ];
        }

        return $dailySales;
    }

}
