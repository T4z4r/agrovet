<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionPackage;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * List all available subscription packages
     */
    public function indexPackages()
    {
        $packages = SubscriptionPackage::where('is_active', true)->get();

        return response()->json([
            'success' => true,
            'data' => $packages
        ]);
    }

    /**
     * Get current user's subscription details
     */
    public function currentSubscription(Request $request)
    {
        $user = $request->user();
        $subscription = $this->subscriptionService->getCurrentSubscription($user);
        $remainingDays = $this->subscriptionService->getRemainingDays($user);
        $isActive = $this->subscriptionService->isSubscriptionActive($user);

        return response()->json([
            'success' => true,
            'data' => [
                'subscription' => $subscription,
                'remaining_days' => $remainingDays,
                'is_active' => $isActive
            ]
        ]);
    }

    /**
     * Subscribe to a package
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:subscription_packages,id',
            'shop_id' => 'nullable|exists:shops,id'
        ]);

        $user = $request->user();
        $package = SubscriptionPackage::findOrFail($request->package_id);

        // Check if user already has an active subscription
        $existingSubscription = $this->subscriptionService->getCurrentSubscription($user);
        if ($existingSubscription && $existingSubscription->end_date->isFuture()) {
            return response()->json([
                'success' => false,
                'message' => 'You already have an active subscription'
            ], 400);
        }

        // Create or update subscription
        $subscription = Subscription::updateOrCreate(
            [
                'user_id' => $user->id,
                'shop_id' => $request->shop_id ?? $user->shops()->first()?->id
            ],
            [
                'subscription_package_id' => $package->id,
                'start_date' => now(),
                'end_date' => now()->addMonths($package->duration_months),
                'status' => 'active'
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Subscription activated successfully',
            'data' => $subscription
        ]);
    }
}
