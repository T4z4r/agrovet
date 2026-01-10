<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebSubscriptionPaymentController extends Controller
{
    public function index(Request $request)
    {
        // Placeholder for subscription payments
        $payments = collect(); // Empty for now

        if ($request->ajax()) {
            return response()->json([
                'data' => $payments
            ]);
        }

        return view('subscription-payments.index', compact('payments'));
    }

    // Other methods can be added later
}