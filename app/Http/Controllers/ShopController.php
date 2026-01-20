<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    /**
     * Display the authenticated user's shop details.
     */
    public function show(): JsonResponse
    {
        $shop = Shop::where('owner_id', Auth::id())->first();

        if (!$shop) {
            return response()->json(['message' => 'Shop not found'], 404);
        }

        return response()->json(['message' => 'Shop retrieved successfully', 'data' => $shop]);
    }

    /**
     * Update the authenticated user's shop details.
     */
    public function update(Request $request): JsonResponse
    {
        $shop = Shop::where('owner_id', Auth::id())->first();

        if (!$shop) {
            return response()->json(['message' => 'Shop not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'location' => 'sometimes|string|max:255|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $shop->update($request->only(['name', 'location']));

        return response()->json($shop);
    }
}
