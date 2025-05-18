<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use App\Models\Portfolio;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $portfolio = Portfolio::where('user_id', auth()->id())->first();
            
            if (!$portfolio) {
                Log::error('No portfolio found for user', ['user_id' => auth()->id()]);
                return response()->json([
                    'success' => false,
                    'message' => 'Portfolio not found'
                ], 404);
            }

            Log::info('Found portfolio', ['portfolio_id' => $portfolio->id]);

            // Verify we can see gallery images table
            try {
                $existingCount = DB::table('gallery_images')->where('portfolio_id', $portfolio->id)->count();
                Log::info('Existing gallery images', ['count' => $existingCount]);
            } catch (\Exception $e) {
                Log::error('Error checking existing gallery images', ['error' => $e->getMessage()]);
            }

            // Check if gallery_images table exists
            if (!Schema::hasTable('gallery_images')) {
                // Create gallery_images table if it doesn't exist
                Schema::create('gallery_images', function (Blueprint $table) {
                    $table->id();
                    $table->foreignId('portfolio_id')->constrained()->onDelete('cascade');
                    $table->string('image_path');
                    $table->text('caption')->nullable();
                    $table->integer('sort_order')->default(0);
                    $table->timestamps();
                });
                Log::info('Created gallery_images table');
            }

            // Count existing images using direct query
            $currentCount = DB::table('gallery_images')->where('portfolio_id', $portfolio->id)->count();
            Log::info('Current gallery image count', ['count' => $currentCount]);
            
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

                    Log::info('Image stored at path', ['path' => $path]);

                    // Create gallery image directly with DB query builder to avoid potential model issues
                    $imageId = DB::table('gallery_images')->insertGetId([
                        'portfolio_id' => $portfolio->id,
                        'image_path' => $path,
                        'sort_order' => $currentCount + count($uploadedImages),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    if (!$imageId) {
                        Log::error('Failed to insert gallery image record', [
                            'portfolio_id' => $portfolio->id,
                            'path' => $path
                        ]);
                        continue;
                    }

                    Log::info('Image record created', ['image_id' => $imageId, 'portfolio_id' => $portfolio->id]);

                    $uploadedImages[] = [
                        'id' => $imageId,
                        'image_path' => $path
                    ];
                    
                } catch (\Exception $e) {
                    Log::error('Failed to process image', [
                        'user_id' => auth()->id(),
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
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

            // Verify images were added
            $afterCount = DB::table('gallery_images')->where('portfolio_id', $portfolio->id)->count();
            Log::info('Gallery upload completed', [
                'user_id' => auth()->id(),
                'uploaded_count' => count($uploadedImages),
                'before_count' => $currentCount,
                'after_count' => $afterCount
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
    
    /**
     * Get image caption
     */
    public function getCaption(GalleryImage $image)
    {
        try {
            if ($image->portfolio->user_id !== auth()->id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            
            return response()->json([
                'success' => true,
                'caption' => $image->caption
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to get caption', [
                'user_id' => auth()->id(),
                'image_id' => $image->id,
                'error' => $e->getMessage()
            ]);
            return response()->json(['success' => false, 'message' => 'Error fetching caption'], 500);
        }
    }
    
    /**
     * Save image caption
     */
    public function saveCaption(Request $request, GalleryImage $image)
    {
        try {
            if ($image->portfolio->user_id !== auth()->id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            
            $validated = $request->validate([
                'caption' => 'nullable|string|max:255'
            ]);
            
            $image->caption = $validated['caption'];
            $image->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Caption saved successfully',
                'caption' => $image->caption
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to save caption', [
                'user_id' => auth()->id(),
                'image_id' => $image->id,
                'error' => $e->getMessage()
            ]);
            return response()->json(['success' => false, 'message' => 'Error saving caption'], 500);
        }
    }
    
    /**
     * Reorder gallery images
     */
    public function reorder(Request $request)
    {
        try {
            $validated = $request->validate([
                'order' => 'required|array',
                'order.*' => 'numeric|exists:gallery_images,id'
            ]);
            
            $portfolio = Portfolio::where('user_id', auth()->id())->first();
            
            if (!$portfolio) {
                return response()->json(['success' => false, 'message' => 'Portfolio not found'], 404);
            }
            
            // Get images that belong to the portfolio and are in the order array
            $images = GalleryImage::whereIn('id', $validated['order'])
                ->where('portfolio_id', $portfolio->id)
                ->get()
                ->keyBy('id');
            
            // Update sort_order for each image
            foreach ($validated['order'] as $index => $imageId) {
                if (isset($images[$imageId])) {
                    $images[$imageId]->sort_order = $index;
                    $images[$imageId]->save();
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Gallery order updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to reorder gallery', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);
            return response()->json(['success' => false, 'message' => 'Error reordering gallery'], 500);
        }
    }
} 