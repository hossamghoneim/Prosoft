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
        return [
            collect(),
            collect(),
            0,
            collect(),
            0,
            collect(),
            1,
        ];
    }

}
