<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    private static array $takenColors    = [];
    private static int   $lastColorIndex = 0;

    public function index(Request $request)
    {
        if(!isSuperAdmin())
            return redirect()->to('/dashboard/orders');

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $orders = Order::whereBetween('created_at', [$startDate ?? '2025-01-01', Carbon::parse($endDate)->endOfDay() ?? date('Y-m-d')])->get();

        $ordersMonthlyRate = $this->getMonthlyRate('orders', [], $request->year ?? date('Y'));
        $totalEarningsPerMonth = [];

        foreach ($ordersMonthlyRate['data'] as $month => $rate) {
            $monthOrders = Order::whereYear('created_at', $request->year ?? date('Y'))->whereMonth('created_at', $month + 1)->get();
            $totalEarningsPerMonth['data'][$month] = $monthOrders->sum('sale_price') - ($monthOrders->sum('actual_price') + $monthOrders->sum('shipping_price'));
        }

        $totalEarningsPerMonth['min'] = min($totalEarningsPerMonth['data']);
        $totalEarningsPerMonth['max'] = max($totalEarningsPerMonth['data']) * 1.15;

        $ordersCitiesPercentage = Order::select('city')->get()->groupBy('city.name')->map(function ($orders) {

            $cityName = $orders[0]->city['name'];

            return
            [
                'label' => $cityName . ': ' . count($orders),
                'data' => count($orders),
                'color' => $this->getUniqueColor(),
            ];

        })->values()->toArray();

        $productsOrdersPercentage = Product::select(['id', 'name'])->with('orders')->get()->map(function ($product) {

            return
            [
                'label' => $product->name,// . ': ' . count($product->orders),
                'data' => count($product->orders),
                'color' => $this->getUniqueColor(),
            ];
        })->values()->toArray();

        if ( count($ordersCitiesPercentage) > 1)
            $this->swapArrayElements($ordersCitiesPercentage , 0);

        if ( count($productsOrdersPercentage) > 1)
            $this->swapArrayElements($productsOrdersPercentage , 0);

        $top5Products = Product::select(['id', 'name'])->withCount('orders')->orderBy('orders_count', 'desc')->limit(5)->get();

        return view('dashboard.index', get_defined_vars());

    }

    public function getMonthlyRate($tableName, $filters = [], $year)
    {

        $array = array();

        for ($i = 1; $i <= 12; $i++) {
            $MonthCount = DB::table($tableName)->select('id')->where($filters)->whereYear('created_at', $year)->whereMonth('created_at', $i)->count();

            array_push($array, $MonthCount);
        }

        return [
            'data' => $array,
            'min' => min($array),
            'max' => max($array) * 1.15,
        ];
    }

    public function getUniqueColor()
    {
        $colorIndex = DashboardController::$lastColorIndex++;

        $colors = [
            '#fe4a49' , '#2ab7ca' , '#fed766' , '#96969e' , '#f6abb6' ,
            '#011f4b' , '#6497b1' , '#005b96' , '#851e3e' , '#251e3e' ,
            '#dec3c3' , '#4a4e4d' , '#f6cd61' , '#fe8a71' , '#0e9aa7' ,
            '#63ace5' , '#4b86b4' , '#009688' , '#ee4035' , '#f37736' ,
            '#fdf498' , '#7bc043' , '#0392cf' , '#283655' , ' #aaaaaa' ,
            '#c99789' , '#ff6f69' , '#ffa700' , '#008744' , '#f37735' ,
            '#4b3832' , '#854442' , '#fff4e6' , '#3c2f2f' , '#be9b7b' ,
            '#8d5524' , '#bfd6f6' , '#cecbcb' , '#e3c9c9' , '#3d1e6d' ,
            '#edc951' , '#eb6841' , '#cc2a36' , '#76b4bd' , '#d11141'
        ];


        if ( in_array( $colors[$colorIndex] , DashboardController::$takenColors) &&  count( DashboardController::$takenColors ) != count($colors) )
        {

            $this->getUniqueColor();

        }else
        {
            array_push( DashboardController::$takenColors , $colors[$colorIndex] );

            return $colors[$colorIndex];
        }
    }

    public function swapArrayElements(&$modelStatusesPercentage , $startIndex)
    {
        $temp                                       = $modelStatusesPercentage[$startIndex];
        $modelStatusesPercentage[$startIndex]       = $modelStatusesPercentage[ $startIndex + 1 ];
        $modelStatusesPercentage[ $startIndex + 1 ] = $temp;
    }
}
