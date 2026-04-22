<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OnboardingTourController extends Controller
{
    public function complete(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user && ! $user->tour_completed_at) {
            $user->forceFill(['tour_completed_at' => now()])->saveQuietly();
        }

        return response()->json(['ok' => true]);
    }
}
