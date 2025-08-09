<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $activePayment = $user->getActivePayment();
        // dd($activePayment);
        return view('stripe',[
            'activePayment' => $activePayment
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->hasActivePayment()) {
            return redirect()->back()->with('info', 'You already have an active subscription.');
        }

        try{
            $stripe = new \Stripe\StripeClient(config('stripe.stripe_secret'));
            $charge = $stripe->charges->create([
            'amount' => $request->price * 100,
            'currency' => 'gbp',
            'source' => $request->stripeToken,
            'description' => 'from devwhizz IT'
            ]);

             $expiresAt = Carbon::now()->addDays(7);

            // Save payment record
            Payment::create([
                'user_id' => $user->id,
                'stripe_charge_id' => $charge->id,
                'amount' => $request->price,
                'currency' => 'gbp',
                'status' => $charge->status,
                'paid_at' => now(),
                'expires_at' => $expiresAt,
                'access_days' => 7
            ]);

            return redirect()->route('profile') // or wherever you want to redirect
                ->with('success', 'Payment successful! You now have 7 days of full access to all resume features.');
        }catch (\Exception $e) {
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }


        // dd($charge);
    }
}
