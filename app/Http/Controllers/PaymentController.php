<?php

namespace App\Http\Controllers;
use Shetabit\Multipay\Payment;
use Shetabit\Multipay\Invoice;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;


class PaymentController extends Controller
{
    public function payment()
    {
        echo 'ok';
    }

    public function verify()
    {

    }

}
