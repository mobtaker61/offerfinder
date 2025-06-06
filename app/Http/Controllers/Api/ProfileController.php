<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Get authenticated user's profile
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $user = $request->user();
        
        // Add full avatar URL to the response
        if ($user->avatar) {
            $user->avatar_url = Storage::url($user->avatar);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $user
            ]
        ]);
    }

    /**
     * Update authenticated user's profile
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = $request->user();
            Log::info('Updating profile for user: ' . $user->id);
            
            $data = $request->except('avatar');

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                Log::info('Avatar file received', [
                    'original_name' => $request->file('avatar')->getClientOriginalName(),
                    'mime_type' => $request->file('avatar')->getMimeType(),
                    'size' => $request->file('avatar')->getSize()
                ]);

                // Delete old avatar if exists
                if ($user->avatar) {
                    Log::info('Deleting old avatar: ' . $user->avatar);
                    Storage::delete($user->avatar);
                }

                // Generate unique filename
                $extension = $request->file('avatar')->getClientOriginalExtension();
                $filename = 'avatar_' . $user->id . '_' . Str::random(10) . '.' . $extension;
                
                // Store the new avatar
                $path = $request->file('avatar')->storeAs('avatars', $filename, 'public');
                Log::info('New avatar stored at: ' . $path);
                
                if (!$path) {
                    throw new \Exception('Failed to store avatar file');
                }

                $data['avatar'] = $path;
            }

            $user->update($data);
            Log::info('Profile updated successfully for user: ' . $user->id);

            // Add full avatar URL to the response
            if ($user->avatar) {
                $user->avatar_url = Storage::url($user->avatar);
                Log::info('Avatar URL: ' . $user->avatar_url);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successfully',
                'data' => [
                    'user' => $user
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Profile update failed', [
                'user_id' => $user->id ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update profile',
                'errors' => [
                    'server' => [$e->getMessage()]
                ]
            ], 500);
        }
    }

    /**
     * Delete user's avatar
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAvatar(Request $request)
    {
        try {
            $user = $request->user();
            Log::info('Deleting avatar for user: ' . $user->id);

            if ($user->avatar) {
                Storage::delete($user->avatar);
                $user->update(['avatar' => null]);
                Log::info('Avatar deleted successfully for user: ' . $user->id);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Avatar deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Avatar deletion failed', [
                'user_id' => $user->id ?? 'unknown',
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete avatar',
                'errors' => [
                    'server' => [$e->getMessage()]
                ]
            ], 500);
        }
    }
} 