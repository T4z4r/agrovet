<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPayment;
use App\Models\Subscription;
use Illuminate\Http\Request;

class WebSubscriptionPaymentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $payments = SubscriptionPayment::with(['user', 'subscription.shop', 'subscription.subscriptionPackage'])->get();

            return response()->json([
                'data' => $payments
            ]);
        }

        $payments = SubscriptionPayment::with(['user', 'subscription.shop', 'subscription.subscriptionPackage'])->get();
        $subscriptions = Subscription::with('shop', 'subscriptionPackage')->get();
        return view('subscription-payments.index', compact('payments', 'subscriptions'));
    }

    public function create()
    {
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return view('subscription-payments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'status' => 'required|in:pending,completed,failed',
            'payment_method' => 'nullable|string'
        ]);

        $data['user_id'] = auth()->id();

        SubscriptionPayment::create($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Subscription payment created successfully']);
        }

        return redirect()->route('admin.subscription-payments.index')->with('success', 'Subscription payment created successfully');
    }

    public function show($id)
    {
        $payment = SubscriptionPayment::with('user', 'subscription.shop', 'subscription.subscriptionPackage')->findOrFail($id);
        return view('subscription-payments.show', compact('payment'));
    }

    public function edit($id)
    {
        $payment = SubscriptionPayment::findOrFail($id);
        if (request()->ajax()) {
            return response()->json($payment);
        }
        return view('subscription-payments.edit', compact('payment'));
    }

    public function update(Request $request, $id)
    {
        $payment = SubscriptionPayment::findOrFail($id);

        $data = $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'status' => 'required|in:pending,completed,failed',
            'payment_method' => 'nullable|string'
        ]);

        $payment->update($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Subscription payment updated successfully']);
        }

        return redirect()->route('admin.subscription-payments.index')->with('success', 'Subscription payment updated successfully');
    }

    public function destroy($id)
    {
        $payment = SubscriptionPayment::findOrFail($id);

        $payment->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Subscription payment deleted successfully']);
        }
        return redirect()->route('admin.subscription-payments.index')->with('success', 'Subscription payment deleted successfully');
    }
}
