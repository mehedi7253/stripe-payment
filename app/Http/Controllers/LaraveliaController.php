<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Stripe\StripeClient;
use Stripe\Exception\CardException;

class LaraveliaController extends Controller
{
    public function index()
    {
        return view('stripe.index');
    }

    public function store(Request $request)
    {
        try {
            $stripe = new StripeClient(env('STRIPE_SECRET'));

            $stripe->paymentIntents->create([
                'amount' => 99 * 100,
                'currency' => 'usd',
                'payment_method' => $request->payment_method,
                'description' => 'Demo payment with stripe',
                'confirm' => false,
                'receipt_email' => 'mh271786@gmail.com',
            ]);
        } catch (CardException $th) {
            throw new Exception("There was a problem processing your payment", 1);
        }

        return back()->withSuccess('Payment done.');
    }
}
