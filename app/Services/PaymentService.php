<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment as PaymentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Illuminate\Support\Str;

class PaymentService
{
    public function generate(Order $order)
    {
        $payment = PaymentModel::create([
            'order_id'       => $order->id,
            'transaction_id' => '',
            'reference_id'   => null,
            'gateway'        => config('payment.default'),
            'currency'       => 'T',
            'status'         => 'initiated',
            'payload'        => null,
        ]);

        $invoice = (new Invoice)
            ->amount($order->total_amount)
            ->detail("پرداخت سفارش #{$order->id}")
            ->transactionId($payment->id);

        return Payment::via('zarinpal')
                      ->callbackUrl(route('payment.callback', ['payment' => $payment->id]))
                      ->purchase($invoice, function($driver, $tid) use ($payment) {
                          $payment->update(['transaction_id' => $tid]);
                      })
                      ->pay()
                      ->render();
    }

    public function verify(Request $request, PaymentModel $payment)
    {
        try {
            $receipt = Payment::via('zarinpal')
                              ->amount($payment->order->total_amount)
                              ->transactionId($payment->transaction_id)
                              ->verify();

            $payment->update([
                'status'       => 'paid',
                'reference_id' => $receipt->getReferenceId(),
                // 'payload'      => json_encode($receipt->all()),
            ]);

            $payment->order->update(['status' => 'paid']);
            Session::forget('cart');
            return redirect()->route('order.success', $payment->order);

        } catch (InvalidPaymentException $e) {
            $payment->update(['status' => 'failed']);
            $payment->order->update(['status' => 'failed']);
            return redirect()
                ->route('order.failure', $payment->order)
                ->with('error', $e->getMessage());
        }
    }
}
