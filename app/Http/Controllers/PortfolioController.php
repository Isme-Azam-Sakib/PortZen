<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portfolio;
use App\Models\Template;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
    }

    public function create()
    {
        $templates = Template::where('is_active', true)->get();
        return view('portfolios.create', compact('templates'));
    }

    public function setup(Request $request)
    {
        $template = Template::findOrFail($request->template_id);
        return view('portfolios.setup', compact('template'));
    }

    public function store(Request $request)
    {
        Log::info('Portfolio store method called', $request->all());

        // Validate the request
        $validated = $request->validate([
            'template_id' => 'required|exists:templates,id',
            'title' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:255',
            'tools' => 'nullable|array',
            'tools.*' => 'string|max:255',
            'experience_level' => 'required|in:beginner,intermediate,expert',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website_url' => 'nullable|url|max:255',
            'social_links' => 'nullable|array',
            'social_links.*.platform' => 'required|string|in:behance,dribbble,linkedin,instagram,twitter',
            'social_links.*.url' => 'required|url',
            'show_work_experience' => 'nullable|string',
            'work_experiences' => 'nullable|array',
            'work_experiences.*.job_title' => 'required_with:show_work_experience|string|max:255',
            'work_experiences.*.company_name' => 'required_with:show_work_experience|string|max:255',
            'work_experiences.*.start_date' => 'required_with:show_work_experience|date',
            'work_experiences.*.end_date' => 'nullable|date|after_or_equal:work_experiences.*.start_date',
            'work_experiences.*.is_current' => 'nullable|boolean',
            'work_experiences.*.responsibilities' => 'nullable|string'
        ]);

        try {
            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                $path = $request->file('profile_image')->store('profile-images', 'public');
                $validated['profile_image'] = $path;
            }

            // Filter out empty values from arrays
            $validated['skills'] = array_filter($validated['skills'] ?? []);
            $validated['tools'] = array_filter($validated['tools'] ?? []);
            $validated['social_links'] = array_filter($validated['social_links'] ?? []);

            // Create the portfolio
            $portfolio = new Portfolio();
            $portfolio->user_id = Auth::id();
            $portfolio->template_id = $validated['template_id'];
            $portfolio->title = $validated['title'];
            $portfolio->full_name = $validated['full_name'];
            $portfolio->tagline = $validated['tagline'];
            $portfolio->bio = $validated['bio'];
            $portfolio->profile_image = $validated['profile_image'] ?? null;
            $portfolio->skills = $validated['skills'];
            $portfolio->tools = $validated['tools'];
            $portfolio->experience_level = $validated['experience_level'];
            $portfolio->email = $validated['email'];
            $portfolio->phone = $validated['phone'];
            $portfolio->website_url = $validated['website_url'];
            $portfolio->social_links = $validated['social_links'];
            $portfolio->is_public = true;

            $portfolio->save();

            if (!$portfolio->id) {
                throw new \Exception('Portfolio could not be created.');
            }

            // Handle work experiences if provided
            if ($request->has('show_work_experience') && $request->has('work_experiences')) {
                foreach ($request->work_experiences as $experience) {
                    // Skip if required fields are missing
                    if (empty($experience['job_title']) || empty($experience['company_name']) || empty($experience['start_date'])) {
                        continue;
                    }
                    
                    $portfolio->workExperiences()->create([
                        'job_title' => $experience['job_title'],
                        'company_name' => $experience['company_name'],
                        'start_date' => $experience['start_date'],
                        'end_date' => isset($experience['is_current']) ? null : ($experience['end_date'] ?? null),
                        'is_current' => isset($experience['is_current']),
                        'responsibilities' => $experience['responsibilities'] ?? null
                    ]);
                }
            }

            return redirect()
                ->route('portfolios.show', ['portfolio' => $portfolio->id])
                ->with('success', 'Portfolio created successfully!');

        } catch (\Exception $e) {
            if (isset($path)) {
                Storage::disk('public')->delete($path);
            }

            return back()
                ->withInput()
                ->with('error', 'Failed to create portfolio: ' . $e->getMessage());
        }
    }

    public function show(Portfolio $portfolio)
    {
        // Add better debugging
        Log::info('Showing portfolio:', [
            'id' => $portfolio->id, 
            'template_id' => $portfolio->template_id
        ]);
        
        // Check if portfolio is public or belongs to authenticated user
        if (!$portfolio->is_public && (!Auth::check() || Auth::id() !== $portfolio->user_id)) {
            abort(403, 'This portfolio is private.');
        }

        // Get the template relationship
        $template = $portfolio->template;
        
        // Check if template exists and is the Modern Portfolio template (id=3)
        if ($template && ($template->id == 3 || $template->name == 'Modern Portfolio')) {
            Log::info('Using modern-portfolio template', ['template_name' => $template->name, 'template_id' => $template->id]);
            
            // Only check the correct spelling folder
            if (view()->exists('templates.modern-portfolio')) {
                return view('templates.modern-portfolio', compact('portfolio'));
            }
            
            Log::warning('Template view not found for Modern Portfolio template');
        }

        // Fall back to default template
        return view('portfolios.show', compact('portfolio'));
    }

    public function edit(Portfolio $portfolio)
    {
        // Check if the current user owns this portfolio
        if ($portfolio->user_id !== auth()->id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to edit this portfolio.');
        }

        return view('portfolios.edit', compact('portfolio'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        // Check if the current user owns this portfolio
        if ($portfolio->user_id !== auth()->id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to update this portfolio.');
        }

        // Debug logging
        Log::info('Portfolio update request received', [
            'portfolio_id' => $portfolio->id,
            'user_id' => auth()->id(),
            'request_data' => $request->except(['profile_image', 'banner_image']),
            'has_profile_image' => $request->hasFile('profile_image'),
            'has_banner_image' => $request->hasFile('banner_image'),
        ]);

        // Pre-process skills if they came as a string
        if ($request->has('skills_text') && !$request->has('skills')) {
            $skills = explode(',', $request->skills_text);
            $skills = array_map('trim', $skills);
            $skills = array_filter($skills);
            $request->merge(['skills' => $skills]);
            Log::info('Processed skills from text input', ['skills' => $skills]);
        }

        // If skills array is empty, add a default skill to pass validation
        if (empty($request->skills)) {
            $request->merge(['skills' => ['General']]);
            Log::info('Added default skill because skills array was empty');
        }

        // Validate request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'tagline' => 'required|string|max:255',
            'bio' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'website_url' => 'nullable|url',
            'experience_level' => 'required|string|in:beginner,intermediate,advanced,expert',
            'skills' => 'required|array',
            'skills.*' => 'string|max:255',
            'tools' => 'nullable|array',
            'tools.*' => 'string|max:255',
            'social_links' => 'nullable|array',
            'social_links.*.platform' => 'required_with:social_links|string|in:behance,dribbble,linkedin,instagram,twitter',
            'social_links.*.url' => 'required_with:social_links|url',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'work_experiences' => 'nullable|array',
            'work_experiences.*.id' => 'nullable|exists:work_experiences,id',
            'work_experiences.*.job_title' => 'required_with:work_experiences|string|max:255',
            'work_experiences.*.company_name' => 'required_with:work_experiences|string|max:255',
            'work_experiences.*.start_date' => 'required_with:work_experiences|date',
            'work_experiences.*.end_date' => 'nullable|date',
            'work_experiences.*.is_current' => 'nullable',
            'work_experiences.*.responsibilities' => 'nullable|string'
        ]);

        // Log validated data
        Log::info('Portfolio update validated data', [
            'portfolio_id' => $portfolio->id,
            'validated_data' => array_diff_key($validated, ['profile_image' => '', 'banner_image' => '']),
        ]);

        try {
            // Handle profile image upload if a new one is provided
            if ($request->hasFile('profile_image')) {
                // Delete old image if it exists
                if ($portfolio->profile_image) {
                    Storage::disk('public')->delete($portfolio->profile_image);
                }
                $validated['profile_image'] = $request->file('profile_image')->store('profile-images', 'public');
                Log::info('New profile image saved', ['path' => $validated['profile_image']]);
            }

            // Handle banner image upload if a new one is provided
            if ($request->hasFile('banner_image')) {
                // Delete old banner image if it exists
                if ($portfolio->banner_image) {
                    Storage::disk('public')->delete($portfolio->banner_image);
                }
                $validated['banner_image'] = $request->file('banner_image')->store('banner-images', 'public');
                Log::info('New banner image saved', ['path' => $validated['banner_image']]);
            }

            // Perform the update
            $portfolio->update($validated);
            Log::info('Portfolio updated successfully', ['portfolio_id' => $portfolio->id]);

            // Handle work experiences
            if ($request->has('work_experiences')) {
                // Get IDs of existing experiences from the request
                $existingIds = collect($request->work_experiences)
                    ->filter(function ($exp) {
                        return !empty($exp['id']);
                    })
                    ->pluck('id')
                    ->toArray();
                
                // Delete experiences that aren't in the request anymore
                $deletedExperiences = $portfolio->workExperiences()
                    ->whereNotIn('id', $existingIds)
                    ->delete();
                
                Log::info('Deleted work experiences', [
                    'count' => $deletedExperiences,
                    'existing_ids' => $existingIds
                ]);
                
                // Update or create experiences
                foreach ($request->work_experiences as $index => $experience) {
                    // Skip if required fields are missing
                    if (empty($experience['job_title']) || empty($experience['company_name']) || empty($experience['start_date'])) {
                        Log::warning('Skipping work experience due to missing required fields', [
                            'index' => $index,
                            'experience' => $experience
                        ]);
                        continue;
                    }
                    
                    $experienceData = [
                        'job_title' => $experience['job_title'],
                        'company_name' => $experience['company_name'],
                        'start_date' => $experience['start_date'],
                        'end_date' => isset($experience['is_current']) ? null : ($experience['end_date'] ?? null),
                        'is_current' => isset($experience['is_current']),
                        'responsibilities' => $experience['responsibilities'] ?? null
                    ];
                    
                    if (!empty($experience['id'])) {
                        // Update existing
                        $portfolio->workExperiences()
                            ->where('id', $experience['id'])
                            ->update($experienceData);
                        Log::info('Updated work experience', [
                            'id' => $experience['id'],
                            'data' => $experienceData
                        ]);
                    } else {
                        // Create new
                        $newExperience = $portfolio->workExperiences()->create($experienceData);
                        Log::info('Created new work experience', [
                            'id' => $newExperience->id,
                            'data' => $experienceData
                        ]);
                    }
                }
            } else {
                // If no work experiences in request, remove all existing ones
                $deletedCount = $portfolio->workExperiences()->delete();
                Log::info('Removed all work experiences', ['count' => $deletedCount]);
            }

            return redirect()->route('portfolios.show', $portfolio)
                ->with('success', 'Portfolio updated successfully!');
        } catch (\Exception $e) {
            Log::error('Portfolio update failed', [
                'portfolio_id' => $portfolio->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Failed to update portfolio: ' . $e->getMessage());
        }
    }

    /**
     * Update a specific portfolio element via AJAX
     */
    public function updateElement(Request $request, Portfolio $portfolio)
    {
        // Check if the current user owns this portfolio
        if ($portfolio->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update this portfolio.'
            ], 403);
        }

        // Log the request for debugging
        Log::info('Portfolio element update request', [
            'portfolio_id' => $portfolio->id,
            'request_all' => $request->all(),
            'has_file' => $request->hasFile('value'),
            'content_type' => $request->header('Content-Type'),
        ]);

        try {
            // Validate fields based on request type
            $validated = $request->validate([
                'field' => 'required|string',
                'value' => 'required_without:file'
            ]);

            $field = $validated['field'];
            
            // Check if field is valid
            if (!in_array($field, [
                'title', 'full_name', 'tagline', 'bio', 'email', 'phone', 
                'website_url', 'experience_level', 'skills', 'tools', 
                'social_links', 'profile_image', 'banner_image', 'heading_color'
            ])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid field name'
                ], 400);
            }

            // For array fields, we need special handling
            if ($request->has('type') && $request->type === 'array') {
                switch ($field) {
                    case 'skills':
                    case 'tools':
                        // For adding a new skill/tool
                        if ($request->has('action') && $request->action === 'add') {
                            $currentItems = $portfolio->{$field} ?? [];
                            // Only add if not already exists and is not empty
                            if (!empty($validated['value']) && !in_array($validated['value'], $currentItems)) {
                                $currentItems[] = $validated['value'];
                                $portfolio->{$field} = $currentItems;
                                $portfolio->save();
                            }
                        }
                        // For removing a skill/tool
                        elseif ($request->has('action') && $request->action === 'remove') {
                            $currentItems = $portfolio->{$field} ?? [];
                            $portfolio->{$field} = array_values(array_filter($currentItems, function($item) use ($validated) {
                                return $item !== $validated['value'];
                            }));
                            $portfolio->save();
                        }
                        // For updating a skill/tool
                        elseif ($request->has('action') && $request->action === 'update') {
                            if (is_array($validated['value']) && isset($validated['value']['old']) && isset($validated['value']['new'])) {
                                $oldValue = $validated['value']['old'];
                                $newValue = $validated['value']['new'];
                            
                            $currentItems = $portfolio->{$field} ?? [];
                                $updatedItems = [];
                                
                                foreach ($currentItems as $item) {
                                    if ($item === $oldValue) {
                                        $updatedItems[] = $newValue;
                                    } else {
                                        $updatedItems[] = $item;
                                    }
                                }
                            
                            $portfolio->{$field} = $updatedItems;
                            $portfolio->save();
                            }
                        }
                        break;
                    
                    case 'social_links':
                        // Validate social platform
                        $request->validate([
                            'platform' => 'required|string|in:behance,dribbble,linkedin,instagram,twitter',
                            'url' => 'required_if:action,add|url',
                            'action' => 'required|in:add,remove,update'
                        ]);
                        
                        $socialLinks = $portfolio->social_links ?? [];
                        
                        if ($request->action === 'add') {
                            // Add new social link
                            $socialLinks[] = [
                                'platform' => $request->platform,
                                'url' => $request->url
                            ];
                        }
                        elseif ($request->action === 'update') {
                            // Update existing social link
                            foreach ($socialLinks as $key => $link) {
                                if ($link['platform'] === $request->platform) {
                                    $socialLinks[$key]['url'] = $request->url;
                                    break;
                                }
                            }
                        }
                        elseif ($request->action === 'remove') {
                            // Remove social link
                            $socialLinks = array_filter($socialLinks, function($link) use ($request) {
                                return $link['platform'] !== $request->platform;
                            });
                        }
                        
                        $portfolio->social_links = array_values($socialLinks);
                        $portfolio->save();
                        break;
                }
            }
            // For file uploads
            elseif ($request->hasFile('value')) {
                // Only allow updates for profile_image and banner_image
                if (!in_array($field, ['profile_image', 'banner_image'])) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid field for file upload'
                    ], 400);
                }
                
                // Log file details
                $file = $request->file('value');
                Log::info('File upload details', [
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'error' => $file->getError()
                ]);
                
                // Validate the file
                $request->validate([
                    'value' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);
                
                // Delete old image if it exists
                if ($portfolio->$field) {
                    Storage::disk('public')->delete($portfolio->$field);
                }
                
                // Store the new image
                $path = $request->file('value')->store($field === 'profile_image' ? 'profile-images' : 'banner-images', 'public');
                $portfolio->$field = $path;
                $portfolio->save();
                
                // Log the success
                Log::info('File uploaded successfully', [
                    'field' => $field,
                    'path' => $path
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => ucfirst(str_replace('_', ' ', $field)) . ' updated successfully',
                    'path' => asset('storage/' . $path),
                    'value' => $path
                ]);
            }
            // For simple scalar fields
            else {
                $portfolio->{$field} = $validated['value'];
                $portfolio->save();
            }

            return response()->json([
                'success' => true,
                'message' => ucfirst(str_replace('_', ' ', $field)) . ' updated successfully',
                'value' => $portfolio->{$field}
            ]);
        }
        catch (\Exception $e) {
            Log::error('Portfolio element update failed', [
                'portfolio_id' => $portfolio->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Dedicated method for banner uploads to simplify the process
     */
    public function uploadBanner(Request $request, Portfolio $portfolio)
    {
        // Check if the current user owns this portfolio
        if ($portfolio->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update this portfolio.'
            ], 403);
        }

        // Log the request for debugging
        Log::info('Banner upload request', [
            'portfolio_id' => $portfolio->id,
            'has_file' => $request->hasFile('banner_image'),
            'content_type' => $request->header('Content-Type'),
            'all_data' => $request->all(),
        ]);

        try {
            // Validate the banner image
            $request->validate([
                'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Delete old banner image if it exists
            if ($portfolio->banner_image) {
                Storage::disk('public')->delete($portfolio->banner_image);
            }

            // Store the new banner image
            $path = $request->file('banner_image')->store('banner-images', 'public');
            $portfolio->banner_image = $path;
            $portfolio->save();

            // Log success
            Log::info('Banner uploaded successfully', [
                'portfolio_id' => $portfolio->id,
                'path' => $path
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Banner image updated successfully',
                'path' => asset('storage/' . $path),
                'value' => $path
            ]);
        } catch (\Exception $e) {
            Log::error('Banner upload failed', [
                'portfolio_id' => $portfolio->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to upload banner: ' . $e->getMessage()
            ], 500);
        }
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function destroy(Portfolio $portfolio)
    {
        // Check if the current user owns this portfolio
        if ($portfolio->user_id !== auth()->id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to delete this portfolio.');
        }

        try {
            // Delete profile image if exists
            if ($portfolio->profile_image) {
                Storage::disk('public')->delete($portfolio->profile_image);
            }

            // Delete the portfolio
            $portfolio->delete();

            return redirect()->route('dashboard')->with('success', 'Portfolio deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Failed to delete portfolio: ' . $e->getMessage());
        }
    }
}

