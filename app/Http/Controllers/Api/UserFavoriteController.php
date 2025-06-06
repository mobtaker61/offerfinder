<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserFavorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFavoriteController extends Controller
{
    /**
     * Add an item to favorites
     */
    public function store(Request $request)
    {
        $request->validate([
            'favoriteable_type' => 'required|in:App\Models\Offer,App\Models\Market,App\Models\Branch',
            'favoriteable_id' => 'required|integer'
        ]);

        // Check if the model exists
        $modelClass = $request->favoriteable_type;
        if (!class_exists($modelClass)) {
            return response()->json([
                'message' => 'Invalid model type'
            ], 422);
        }

        $model = $modelClass::find($request->favoriteable_id);
        if (!$model) {
            return response()->json([
                'message' => 'Model not found'
            ], 404);
        }

        $favorite = UserFavorite::create([
            'user_id' => Auth::id(),
            'favoriteable_type' => $request->favoriteable_type,
            'favoriteable_id' => $request->favoriteable_id
        ]);

        return response()->json([
            'message' => 'Item added to favorites successfully',
            'favorite' => $favorite
        ], 201);
    }

    /**
     * Remove an item from favorites
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'favoriteable_type' => 'required|in:App\Models\Offer,App\Models\Market,App\Models\Branch',
            'favoriteable_id' => 'required|integer'
        ]);

        $favorite = UserFavorite::where('user_id', Auth::id())
            ->where('favoriteable_type', $request->favoriteable_type)
            ->where('favoriteable_id', $request->favoriteable_id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['message' => 'Item removed from favorites successfully']);
        }

        return response()->json(['message' => 'Favorite not found'], 404);
    }

    /**
     * Get user's favorites
     */
    public function index(Request $request)
    {
        $request->validate([
            'type' => 'nullable|in:offer,market,branch'
        ]);

        $query = UserFavorite::where('user_id', Auth::id())->with('favoriteable');

        if ($request->type) {
            $type = 'App\Models\\' . ucfirst($request->type);
            $query->where('favoriteable_type', $type);
        }

        $favorites = $query->get();

        return response()->json([
            'favorites' => $favorites
        ]);
    }
} 