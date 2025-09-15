<?php

namespace App\Console\Commands;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpireShedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check automatically expire';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orders = Order::where('compliance_status', 'active')->get();
        foreach ($orders as $order) {
            $renewalDate = Carbon::parse($order->renewal_date);
            $currentDate = Carbon::now();
            if ($currentDate->greaterThan($renewalDate)) {
                $order->compliance_status = 'expired';
                $order->save();
            }
        }
        $this->info('All active orders with renewal date today have been expired.');

    }
}
