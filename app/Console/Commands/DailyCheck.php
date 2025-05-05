<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class DailyCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'do:daily_check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '
    هنعمل كرون جوب تبعت ريكوست لشركة الشحن ب آيديهات كل الاوردرات ونعدل حالات الشحن بتاعتهم ونخزن الاي دي كمان
    هنعدي على كل الاوردرات الي حالتها تم التوصيل الي عدى على تاريخ التوصيل يومين نحوله لتم الانتهاء';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentDateTime = now();
        if($currentDateTime->format('H:i') == '00:10')
        {
            Order::where('status', OrderStatus::delivered->value)->get()->each(function($order){
                if(now()->diffInDays($order->delivery_date) == 2)
                {
                    $order->update([
                        'status' => OrderStatus::finished->value
                    ]);
                }
            });

        }
        else
        {
            $ordersIds = Order::where('status', OrderStatus::prepared->value)->get()->pluck('id')->chunk(25)->toArray();
            for($i = 0; $i < count($ordersIds); $i++)
            {
                $ordersIds[$i] = implode(',', $ordersIds[$i]);
                $response = Http::asForm()->post('https://api.alwaseet-iq.net/v1/merchant/get-orders-by-ids-bulk?token=' . settings()->get('login_token'),
                        [
                            'ids' => $ordersIds[$i],
                        ])->json();

                if($response['status'])
                {
                    collect($response['data'])->each(function($order){
                        Order::where('qr_id', $order['id'])->update([
                            'shipping_status' => [
                                'id' => $order['status_id'],
                                'name' => $order['status']
                            ]
                        ]);
                    });
                }
            }

        }
    }
}
