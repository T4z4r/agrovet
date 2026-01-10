<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Shop;
use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;

class WebSubscriptionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $subscriptions = Subscription::with('shop', 'subscriptionPackage')->orderBy('created_at', 'desc')->get();
            return response()->json([
                'data' => $subscriptions
            ]);
        }

        $subscriptions = Subscription::with('shop', 'subscriptionPackage')->orderBy('created_at', 'desc')->get();
        $shops = Shop::all();
        $packages = SubscriptionPackage::where('is_active', true)->get();
        return view('subscriptions.index', compact('subscriptions', 'shops', 'packages'));
    }

    public function create()
    {
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return view('subscriptions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'subscription_package_id' => 'required|exists:subscription_packages,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,inactive,expired'
        ]);

        Subscription::create($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Subscription created successfully']);
        }

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription created successfully');
    }

    public function show($id)
    {
        $subscription = Subscription::with('shop', 'subscriptionPackage', 'payments')->findOrFail($id);
        return view('subscriptions.show', compact('subscription'));
    }

    public function edit($id)
    {
        $subscription = Subscription::findOrFail($id);
        if (request()->ajax()) {
            return response()->json($subscription);
        }
        return view('subscriptions.edit', compact('subscription'));
    }

    public function update(Request $request, $id)
    {
        $subscription = Subscription::findOrFail($id);

        $data = $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'subscription_package_id' => 'required|exists:subscription_packages,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,inactive,expired'
        ]);

        $subscription->update($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Subscription updated successfully']);
        }

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription updated successfully');
    }

    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);

        $subscription->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Subscription deleted successfully']);
        }
        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription deleted successfully');
    }
}
