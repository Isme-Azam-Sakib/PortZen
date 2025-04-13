@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Portfolio Details</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('portfolios.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="template_id" value="{{ $template->id }}">

                        <!-- Basic Information -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Portfolio Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                   id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tagline" class="form-label">Tagline</label>
                            <input type="text" class="form-control @error('tagline') is-invalid @enderror"
                                   id="tagline" name="tagline" value="{{ old('tagline') }}"
                                   placeholder="e.g., Freelance Graphic Designer | UI/UX Specialist">
                            @error('tagline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror"
                                      id="bio" name="bio" rows="4">{{ old('bio') }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="profile_image" class="form-label">Profile Image</label>
                            <input type="file" class="form-control @error('profile_image') is-invalid @enderror"
                                   id="profile_image" name="profile_image">
                            @error('profile_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Skills & Expertise -->
                        <div class="mb-3">
                            <label for="skills" class="form-label">Skills</label>
                            <div class="skill-inputs">
                                <input type="text" class="form-control mb-2 @error('skills.0') is-invalid @enderror"
                                       name="skills[]" placeholder="Enter a skill">
                                <button type="button" class="btn btn-secondary btn-sm add-skill">
                                    <i class="fas fa-plus"></i> Add Skill
                                </button>
                            </div>
                            @error('skills.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tools" class="form-label">Tools & Software</label>
                            <div class="tool-inputs">
                                <input type="text" class="form-control mb-2 @error('tools.0') is-invalid @enderror"
                                       name="tools[]" placeholder="Enter a tool">
                                <button type="button" class="btn btn-secondary btn-sm add-tool">
                                    <i class="fas fa-plus"></i> Add Tool
                                </button>
                            </div>
                            @error('tools.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="experience_level" class="form-label">Experience Level</label>
                            <select class="form-select @error('experience_level') is-invalid @enderror"
                                    id="experience_level" name="experience_level" required>
                                <option value="">Select Level</option>
                                <option value="beginner">Beginner</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="expert">Expert</option>
                            </select>
                            @error('experience_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contact Information -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                   id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="website_url" class="form-label">Website URL</label>
                            <input type="url" class="form-control @error('website_url') is-invalid @enderror"
                                   id="website_url" name="website_url" value="{{ old('website_url') }}">
                            @error('website_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Social Links -->
                        <div class="mb-3">
                            <label class="form-label">Social Media Links</label>
                            <div class="social-inputs">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"><i class="fas fa-share-alt"></i></span>
                                    <select class="form-select" name="social_links[0][platform]" required>
                                        <option value="">Select Platform</option>
                                        <option value="behance"><i class="fab fa-behance"></i> Behance</option>
                                        <option value="dribbble"><i class="fab fa-dribbble"></i> Dribbble</option>
                                        <option value="linkedin"><i class="fab fa-linkedin"></i> LinkedIn</option>
                                        <option value="instagram"><i class="fab fa-instagram"></i> Instagram</option>
                                        <option value="twitter"><i class="fab fa-twitter"></i> Twitter</option>
                                    </select>
                                    <span class="input-group-text"><i class="fas fa-link"></i></span>
                                    <input type="url" class="form-control" 
                                           name="social_links[0][url]" 
                                           placeholder="https://..."
                                           pattern="https?://.+"
                                           title="Include http:// or https:// in the URL">
                                </div>
                                <button type="button" class="btn btn-secondary btn-sm add-social">
                                    <i class="fas fa-plus"></i> Add Social Link
                                </button>
                            </div>
                            @error('social_links.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Portfolio
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/portfolio-setup.js') }}"></script>
@endpush
@endsection 