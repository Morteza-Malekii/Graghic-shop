<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Shetabit\Multipay\Invoice;

class PaymentService
{
    public function generate(Order $order)
    {
        $payment = Payment::create([
            'order_id' => $order->id,
            'transaction_id' => '',
            'reference_id'=>null,
            'gateway'=>config('payment.default'),
            'currency'=>'',
            'status'=>'initiated',
            'payload'=>'null',
        ]);
        $invoice = (new Invoice)->amount($order->total_amount)
                                ->detail("پرداخت سفارش #{$order->id}")
                                ->transactionId($payment->id);

        return Payment::purchase($invoice,function($driver,$transactionId) use ($payment){
            $payment->update(['transaction_id',$transactionId]);
        })->pay()->render();

    }
}
