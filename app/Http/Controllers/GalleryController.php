<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class GalleryController extends Controller
{
    public function upload(Request $request)
    {
        try {
            Log::info('Gallery upload started', ['user_id' => auth()->id()]);

            // Validate request has files
            if (!$request->hasFile('images')) {
                Log::error('No images found in request', ['user_id' => auth()->id()]);
                return response()->json([
                    'success' => false,
                    'message' => 'No images were uploaded'
                ], 400);
            }

            // Validate files
            $request->validate([
                'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Get authenticated user's portfolio
            $portfolio = auth()->user()->portfolio;
            
            if (!$portfolio) {
                Log::error('No portfolio found for user', ['user_id' => auth()->id()]);
                return response()->json([
                    'success' => false,
                    'message' => 'Portfolio not found'
                ], 404);
            }

            // Check image count
            $currentCount = $portfolio->galleryImages()->count();
            $newImagesCount = count($request->file('images'));
            
            if ($currentCount + $newImagesCount > 30) {
                Log::warning('Maximum gallery limit would be exceeded', [
                    'user_id' => auth()->id(),
                    'current_count' => $currentCount,
                    'new_count' => $newImagesCount
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Maximum gallery limit of 30 images would be exceeded'
                ], 400);
            }

            $uploadedImages = [];

            foreach ($request->file('images') as $image) {
                try {
                    // Store image in public disk under gallery directory
                    $path = $image->store('gallery', 'public');
                    
                    if (!$path) {
                        Log::error('Failed to store image', [
                            'user_id' => auth()->id(),
                            'original_name' => $image->getClientOriginalName()
                        ]);
                        continue;
                    }

                    // Create gallery image record
                    $galleryImage = $portfolio->galleryImages()->create([
                        'image_path' => $path,
                        'sort_order' => $currentCount + count($uploadedImages)
                    ]);

                    $uploadedImages[] = $galleryImage;
                    
                    Log::info('Image uploaded successfully', [
                        'user_id' => auth()->id(),
                        'image_id' => $galleryImage->id,
                        'path' => $path
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to process image', [
                        'user_id' => auth()->id(),
                        'error' => $e->getMessage(),
                        'original_name' => $image->getClientOriginalName()
                    ]);
                    // If we failed to upload this image, continue with others
                    continue;
                }
            }

            if (empty($uploadedImages)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to upload any images'
                ], 500);
            }

            Log::info('Gallery upload completed', [
                'user_id' => auth()->id(),
                'uploaded_count' => count($uploadedImages)
            ]);

            return response()->json([
                'success' => true,
                'message' => count($uploadedImages) . ' images uploaded successfully',
                'images' => $uploadedImages
            ]);

        } catch (\Exception $e) {
            Log::error('Gallery upload error', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(GalleryImage $image)
    {
        try {
            if ($image->portfolio->user_id !== auth()->id()) {
                Log::warning('Unauthorized delete attempt', [
                    'user_id' => auth()->id(),
                    'image_id' => $image->id
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            // Delete file from storage
            if (Storage::disk('public')->exists($image->image_path)) {
                if (!Storage::disk('public')->delete($image->image_path)) {
                    Log::error('Failed to delete image file', [
                        'user_id' => auth()->id(),
                        'image_id' => $image->id,
                        'path' => $image->image_path
                    ]);
                    throw new \Exception('Failed to delete image file');
                }
            }

            // Delete database record
            $image->delete();

            Log::info('Image deleted successfully', [
                'user_id' => auth()->id(),
                'image_id' => $image->id
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to delete image', [
                'user_id' => auth()->id(),
                'image_id' => $image->id,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete image'
            ], 500);
        }
    }
} 