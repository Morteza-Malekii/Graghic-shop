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
    /**
     * تولید فرم/ریدایرکت به درگاه پرداخت
     */
    public function generate(Order $order)
    {
        // ۱. ایجاد رکورد اولیه
        $payment = PaymentModel::create([
            'order_id'       => $order->id,
            'transaction_id' => '',
            'reference_id'   => null,
            'gateway'        => config('payment.default'),
            'currency'       => 'IRR',
            'status'         => 'initiated',
            'payload'        => null,
        ]);

        // ۲. آماده‌سازی اینوایس
        $invoice = (new Invoice)
            ->amount($order->total_amount)        // Facade با currency='T' خودش تومان→ریال می‌کند
            ->detail("پرداخت سفارش #{$order->id}")
            ->transactionId($payment->id);

        // ۳. ریدایرکت به درگاه با شناسهٔ تراکنش
        return Payment::via('zarinpal')
                      ->callbackUrl(route('payment.callback', ['payment' => $payment->id]))
                      ->purchase($invoice, function($driver, $tid) use ($payment) {
                          $payment->update(['transaction_id' => $tid]);
                      })
                      ->pay()      // رندر یا ریدایرکت
                      ->render();
    }

    /**
     * دریافت callback از درگاه و بررسی نتیجه
     */
    public function verify(Request $request, PaymentModel $payment)
    {
        try {
            // ۱. فراخوانی verify از Facade
            $receipt = Payment::via('zarinpal')
                              ->amount($payment->order->total_amount)
                              ->transactionId($payment->transaction_id)
                              ->verify();

            // ۲. اگر موفق بود، آپدیت رکورد payment
            $payment->update([
                'status'       => 'paid',
                'reference_id' => $receipt->getReferenceId(),
                // 'payload'      => json_encode($receipt->all()),
            ]);

            // ۳. آپدیت وضعیت سفارش
            $payment->order->update(['status' => 'paid']);
            Session::forget('cart');
            return redirect()->route('order.success', $payment->order);

        } catch (InvalidPaymentException $e) {
            // ۴. در صورت خطا
            $payment->update(['status' => 'failed']);

            return redirect()
                ->route('order.failure', $payment->order)
                ->with('error', $e->getMessage());
        }
    }
}
