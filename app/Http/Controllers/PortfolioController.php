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
        \Log::info('Portfolio store method called', $request->all());

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
            'social_links.*.url' => 'required|url'
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

            // Make sure the portfolio was created and has an ID
            if (!$portfolio->id) {
                throw new \Exception('Portfolio could not be created.');
            }

            return redirect()
                ->route('portfolios.show', ['portfolio' => $portfolio->id])
                ->with('success', 'Portfolio created successfully!');

        } catch (\Exception $e) {
            // If profile image was uploaded, delete it
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
        // Add some debugging
        \Log::info('Showing portfolio:', ['id' => $portfolio->id]);
        
        // Check if portfolio is public or belongs to authenticated user
        if (!$portfolio->is_public && (!Auth::check() || Auth::id() !== $portfolio->user_id)) {
            abort(403, 'This portfolio is private.');
        }

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
            'tools' => 'nullable|array',
            'social_links' => 'nullable|array',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle profile image upload if a new one is provided
        if ($request->hasFile('profile_image')) {
            // Delete old image if it exists
            if ($portfolio->profile_image) {
                Storage::delete($portfolio->profile_image);
            }
            $validated['profile_image'] = $request->file('profile_image')->store('profile-images', 'public');
        }

        $portfolio->update($validated);

        return redirect()->route('portfolios.show', $portfolio)
            ->with('success', 'Portfolio updated successfully!');
    }
}

