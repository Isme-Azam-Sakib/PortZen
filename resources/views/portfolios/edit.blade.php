@extends('layouts.app')

@section('content')
<style>
    #work_experience_section.hidden {
        display: none;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Portfolio</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('portfolios.update', $portfolio) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Portfolio Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $portfolio->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                   id="full_name" name="full_name" value="{{ old('full_name', $portfolio->full_name) }}" required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Banner Image</label>
                            <div class="d-flex flex-column">
                                @if($portfolio->banner_image)
                                    <div class="mb-3 position-relative" style="max-width: 400px;">
                                        <img src="{{ asset('storage/' . $portfolio->banner_image) }}" 
                                             class="img-fluid rounded border" 
                                             alt="Current Banner">
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="badge bg-dark">Current Banner</span>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="mb-2">
                                    <input type="file" class="form-control @error('banner_image') is-invalid @enderror" 
                                           id="banner_image" name="banner_image" accept="image/*">
                                    <div class="form-text">Recommended size: 1920x1080px. Max size: 2MB</div>
                                    @error('banner_image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tagline" class="form-label">Tagline</label>
                            <input type="text" class="form-control @error('tagline') is-invalid @enderror" 
                                   id="tagline" name="tagline" value="{{ old('tagline', $portfolio->tagline) }}" required>
                            @error('tagline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" 
                                      id="bio" name="bio" rows="4" required>{{ old('bio', $portfolio->bio) }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $portfolio->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone (Optional)</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $portfolio->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="website_url" class="form-label">Website URL (Optional)</label>
                            <input type="url" class="form-control @error('website_url') is-invalid @enderror" 
                                   id="website_url" name="website_url" value="{{ old('website_url', $portfolio->website_url) }}">
                            @error('website_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="experience_level" class="form-label">Experience Level</label>
                            <select class="form-select @error('experience_level') is-invalid @enderror" 
                                    id="experience_level" name="experience_level" required>
                                <option value="">Select Level</option>
                                @foreach(['beginner', 'intermediate', 'advanced', 'expert'] as $level)
                                    <option value="{{ $level }}" 
                                        {{ old('experience_level', $portfolio->experience_level) == $level ? 'selected' : '' }}>
                                        {{ ucfirst($level) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('experience_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="profile_image" class="form-label">Profile Image</label>
                            @if($portfolio->profile_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $portfolio->profile_image) }}" 
                                         alt="Current profile image" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('profile_image') is-invalid @enderror" 
                                   id="profile_image" name="profile_image">
                            @error('profile_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Skills</label>
                            <div class="skill-inputs">
                                @foreach($portfolio->skills as $index => $skill)
                                    <div class="position-relative mb-2">
                                        <input type="text" name="skills[]" class="form-control" 
                                               value="{{ $skill }}" required>
                                        @if(!$loop->first)
                                            <button type="button" class="btn btn-danger btn-sm position-absolute end-0 me-2" 
                                                    style="top: 50%; transform: translateY(-50%);"
                                                    onclick="this.parentElement.remove()">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                                <button type="button" class="btn btn-secondary add-skill">
                                    <i class="fa-solid fa-plus"></i> Add Skill
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tools (Optional)</label>
                            <div class="tool-inputs">
                                @foreach($portfolio->tools ?? [] as $index => $tool)
                                    <div class="position-relative mb-2">
                                        <input type="text" name="tools[]" class="form-control" 
                                               value="{{ $tool }}">
                                        <button type="button" class="btn btn-danger btn-sm position-absolute end-0 me-2" 
                                                style="top: 50%; transform: translateY(-50%);"
                                                onclick="this.parentElement.remove()">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                @endforeach
                                <button type="button" class="btn btn-secondary add-tool">
                                    <i class="fa-solid fa-plus"></i> Add Tool
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Social Links (Optional)</label>
                            <div class="social-inputs">
                                @foreach($portfolio->social_links ?? [] as $index => $social)
                                    <div class="input-group mb-2">
                                        <select class="form-select" name="social_links[{{ $index }}][platform]" required>
                                            <option value="">Select Platform</option>
                                            <option value="behance" {{ $social['platform'] == 'behance' ? 'selected' : '' }}>
                                                <i class="fa-brands fa-behance"></i> Behance
                                            </option>
                                            <option value="dribbble" {{ $social['platform'] == 'dribbble' ? 'selected' : '' }}>
                                                <i class="fa-brands fa-dribbble"></i> Dribbble
                                            </option>
                                            <option value="linkedin" {{ $social['platform'] == 'linkedin' ? 'selected' : '' }}>
                                                <i class="fa-brands fa-linkedin"></i> LinkedIn
                                            </option>
                                            <option value="instagram" {{ $social['platform'] == 'instagram' ? 'selected' : '' }}>
                                                <i class="fa-brands fa-instagram"></i> Instagram
                                            </option>
                                            <option value="twitter" {{ $social['platform'] == 'twitter' ? 'selected' : '' }}>
                                                <i class="fa-brands fa-twitter"></i> Twitter
                                            </option>
                                        </select>
                                        <input type="url" class="form-control" 
                                               name="social_links[{{ $index }}][url]" 
                                               value="{{ $social['url'] }}"
                                               placeholder="https://..."
                                               pattern="https?://.+"
                                               title="Include http:// or https:// in the URL"
                                               required>
                                        <button type="button" class="btn btn-danger" onclick="this.closest('.input-group').remove()">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                @endforeach
                                <button type="button" class="btn btn-secondary add-social">
                                    <i class="fa-solid fa-plus"></i> Add Social Link
                                </button>
                            </div>
                        </div>

                        <!-- Work Experience Section Toggle -->
                        <div class="mb-4 mt-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Work Experience</h5>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="show_work_experience" 
                                           {{ $portfolio->workExperiences->count() > 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="show_work_experience">Show in portfolio</label>
                                </div>
                            </div>
                            <hr>
                        </div>

                        <!-- Work Experience Section - Hidden by default if no experiences -->
                        <div id="work_experience_section" class="{{ $portfolio->workExperiences->count() == 0 ? 'hidden' : '' }} mb-4">
                            <div id="work_experiences_container">
                                @foreach($portfolio->workExperiences as $index => $experience)
                                <div class="work-experience-item card mb-3">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">Experience #{{ $index + 1 }}</h6>
                                        <button type="button" class="btn btn-sm btn-danger remove-experience">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" name="work_experiences[{{ $index }}][id]" value="{{ $experience->id }}">
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Job Title</label>
                                            <input type="text" class="form-control" name="work_experiences[{{ $index }}][job_title]" 
                                                   value="{{ $experience->job_title }}" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Company Name</label>
                                            <input type="text" class="form-control" name="work_experiences[{{ $index }}][company_name]" 
                                                   value="{{ $experience->company_name }}" required>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Start Date</label>
                                                <input type="date" class="form-control" name="work_experiences[{{ $index }}][start_date]" 
                                                       value="{{ $experience->start_date->format('Y-m-d') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">End Date</label>
                                                <input type="date" class="form-control" name="work_experiences[{{ $index }}][end_date]" 
                                                       value="{{ $experience->end_date ? $experience->end_date->format('Y-m-d') : '' }}"
                                                       {{ $experience->is_current ? 'disabled' : '' }}>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input current-position" 
                                                   id="is_current_{{ $index }}" name="work_experiences[{{ $index }}][is_current]"
                                                   {{ $experience->is_current ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_current_{{ $index }}">I currently work here</label>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Responsibilities</label>
                                            <textarea class="form-control" rows="3" name="work_experiences[{{ $index }}][responsibilities]">{{ $experience->responsibilities }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <button type="button" class="btn btn-primary add-work-experience">
                                <i class="fa-solid fa-plus"></i> Add Work Experience
                            </button>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" id="updatePortfolioBtn">
                                <i class="fa-solid fa-save"></i> Update Portfolio
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Template for new work experience item -->
<template id="work_experience_template">
    <div class="work-experience-item card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0">New Experience</h6>
            <button type="button" class="btn btn-sm btn-danger remove-experience">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Job Title</label>
                <input type="text" class="form-control" name="work_experiences[__INDEX__][job_title]" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Company Name</label>
                <input type="text" class="form-control" name="work_experiences[__INDEX__][company_name]" required>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Start Date</label>
                    <input type="date" class="form-control" name="work_experiences[__INDEX__][start_date]" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">End Date</label>
                    <input type="date" class="form-control end-date" name="work_experiences[__INDEX__][end_date]">
                </div>
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input current-position" id="is_current___INDEX__" 
                       name="work_experiences[__INDEX__][is_current]">
                <label class="form-check-label" for="is_current___INDEX__">I currently work here</label>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Responsibilities</label>
                <textarea class="form-control" rows="3" name="work_experiences[__INDEX__][responsibilities]"></textarea>
            </div>
        </div>
    </div>
</template>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Define URLs for backend endpoints
    const bannerUploadUrl = "{{ route('portfolios.upload-banner', $portfolio->id) }}";
    
    // Add form submission debug
    const form = document.querySelector("form[action='{{ route('portfolios.update', $portfolio) }}']");
    const updateBtn = document.getElementById('updatePortfolioBtn');
    
    if (form && updateBtn) {
        form.addEventListener('submit', function(e) {
            console.log('Form submission initiated', {
                action: this.action,
                method: this.method,
                enctype: this.enctype
            });
        });
        
        updateBtn.addEventListener('click', function() {
            console.log('Update button clicked');
        });
    }
    
    // Handle banner image upload with AJAX
    const bannerImageInput = document.getElementById('banner_image');
    if (bannerImageInput) {
        bannerImageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const formData = new FormData();
                formData.append('banner_image', this.files[0]);
                formData.append('_token', '{{ csrf_token() }}');
                
                // Show loading indicator
                const loadingIndicator = document.createElement('div');
                loadingIndicator.className = 'alert alert-info mt-2';
                loadingIndicator.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Uploading banner image...';
                this.parentNode.appendChild(loadingIndicator);
                
                // Disable the input
                this.disabled = true;
                
                // Send the AJAX request
                fetch(bannerUploadUrl, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    // Remove loading indicator
                    loadingIndicator.remove();
                    
                    if (data.success) {
                        // Show success message
                        const successMsg = document.createElement('div');
                        successMsg.className = 'alert alert-success mt-2';
                        successMsg.innerHTML = '<i class="fa-solid fa-check"></i> Banner updated successfully';
                        this.parentNode.appendChild(successMsg);
                        
                        // Show preview of the new banner immediately
                        const bannerPreviewContainer = document.querySelector('.position-relative');
                        
                        if (bannerPreviewContainer) {
                            // Update existing preview
                            const previewImg = bannerPreviewContainer.querySelector('img');
                            if (previewImg) {
                                // Determine correct path format
                                let imagePath = data.path;
                                if (!imagePath.startsWith('http') && !imagePath.startsWith('/storage')) {
                                    imagePath = `/storage/${imagePath}`;
                                }
                                
                                // Update image path with timestamp to prevent caching issues
                                previewImg.src = imagePath + '?t=' + new Date().getTime();
                            }
                        } else {
                            // Create new preview if none exists
                            const previewContainer = document.createElement('div');
                            previewContainer.className = 'mb-3 position-relative';
                            previewContainer.style.maxWidth = '400px';
                            
                            // Determine correct path format
                            let imagePath = data.path;
                            if (!imagePath.startsWith('http') && !imagePath.startsWith('/storage')) {
                                imagePath = `/storage/${imagePath}`;
                            }
                            
                            // Add preview with timestamp to prevent caching
                            previewContainer.innerHTML = `
                                <img src="${imagePath}?t=${new Date().getTime()}" 
                                     class="img-fluid rounded border" 
                                     alt="New Banner">
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-success">New Banner</span>
                                </div>
                            `;
                            
                            // Add the preview before the file input
                            this.parentNode.parentNode.insertBefore(previewContainer, this.parentNode);
                        }
                        
                        // No need to reload - banner is updated in the UI
                    } else {
                        // Show error message
                        const errorMsg = document.createElement('div');
                        errorMsg.className = 'alert alert-danger mt-2';
                        errorMsg.textContent = data.message || 'Error uploading banner image';
                        this.parentNode.appendChild(errorMsg);
                        
                        // Re-enable the input
                        this.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    
                    // Remove loading indicator
                    loadingIndicator.remove();
                    
                    // Show error message
                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'alert alert-danger mt-2';
                    errorMsg.textContent = 'Error uploading banner image. Please try again.';
                    this.parentNode.appendChild(errorMsg);
                    
                    // Re-enable the input
                    this.disabled = false;
                });
            }
        });
    }
    
    // Handle Skills
    const skillInputs = document.querySelector('.skill-inputs');
    const addSkillBtn = skillInputs.querySelector('.add-skill');
    
    addSkillBtn.addEventListener('click', function() {
        const wrapper = document.createElement('div');
        wrapper.className = 'position-relative mb-2';
        
        wrapper.innerHTML = `
            <input type="text" name="skills[]" class="form-control" required>
            <button type="button" class="btn btn-danger btn-sm position-absolute end-0 me-2" 
                    style="top: 50%; transform: translateY(-50%);"
                    onclick="this.parentElement.remove()">
                <i class="fa-solid fa-trash"></i>
            </button>
        `;
        
        skillInputs.insertBefore(wrapper, addSkillBtn);
    });

    // Handle Tools
    const toolInputs = document.querySelector('.tool-inputs');
    const addToolBtn = toolInputs.querySelector('.add-tool');
    
    addToolBtn.addEventListener('click', function() {
        const wrapper = document.createElement('div');
        wrapper.className = 'position-relative mb-2';
        
        wrapper.innerHTML = `
            <input type="text" name="tools[]" class="form-control">
            <button type="button" class="btn btn-danger btn-sm position-absolute end-0 me-2" 
                    style="top: 50%; transform: translateY(-50%);"
                    onclick="this.parentElement.remove()">
                <i class="fa-solid fa-trash"></i>
            </button>
        `;
        
        toolInputs.insertBefore(wrapper, addToolBtn);
    });

    // Handle Social Links
    const socialInputs = document.querySelector('.social-inputs');
    const addSocialBtn = socialInputs.querySelector('.add-social');
    let socialCount = document.querySelectorAll('.social-inputs .input-group').length;
    
    addSocialBtn.addEventListener('click', function() {
        const wrapper = document.createElement('div');
        wrapper.className = 'input-group mb-2';
        
        wrapper.innerHTML = `
            <select class="form-select" name="social_links[${socialCount}][platform]" required>
                <option value="">Select Platform</option>
                <option value="behance"><i class="fa-brands fa-behance"></i> Behance</option>
                <option value="dribbble"><i class="fa-brands fa-dribbble"></i> Dribbble</option>
                <option value="linkedin"><i class="fa-brands fa-linkedin"></i> LinkedIn</option>
                <option value="instagram"><i class="fa-brands fa-instagram"></i> Instagram</option>
                <option value="twitter"><i class="fa-brands fa-twitter"></i> Twitter</option>
            </select>
            <input type="url" class="form-control" 
                   name="social_links[${socialCount}][url]" 
                   placeholder="https://..."
                   pattern="https?://.+"
                   title="Include http:// or https:// in the URL"
                   required>
            <button type="button" class="btn btn-danger" onclick="this.closest('.input-group').remove()">
                <i class="fa-solid fa-trash"></i>
            </button>
        `;
        
        socialInputs.insertBefore(wrapper, addSocialBtn);
        socialCount++;
    });
    
    // Work Experience Section Toggle
    const showWorkExperience = document.getElementById('show_work_experience');
    const workExperienceSection = document.getElementById('work_experience_section');
    
    if (showWorkExperience && workExperienceSection) {
        showWorkExperience.addEventListener('change', function() {
            if (this.checked) {
                workExperienceSection.classList.remove('hidden');
            } else {
                workExperienceSection.classList.add('hidden');
            }
        });
    }
    
    // Add Work Experience
    const workExperiencesContainer = document.getElementById('work_experiences_container');
    const addWorkExperienceBtn = document.querySelector('.add-work-experience');
    const workExperienceTemplate = document.getElementById('work_experience_template');
    let experienceIndex = document.querySelectorAll('.work-experience-item').length;
    
    if (addWorkExperienceBtn && workExperienceTemplate && workExperiencesContainer) {
        addWorkExperienceBtn.addEventListener('click', function() {
            const template = workExperienceTemplate.innerHTML;
            const newExperience = template.replace(/__INDEX__/g, experienceIndex);
            
            // Create a div and set its HTML content
            const container = document.createElement('div');
            container.innerHTML = newExperience;
            
            // Get the first child (the actual work experience card)
            const experienceCard = container.firstElementChild;
            
            // Append the card to the container
            workExperiencesContainer.appendChild(experienceCard);
            
            // Setup event listeners for the new experience
            setupExperienceListeners(experienceCard);
            
            experienceIndex++;
        });
        
        // Setup existing work experience event listeners
        document.querySelectorAll('.work-experience-item').forEach(item => {
            setupExperienceListeners(item);
        });
        
        function setupExperienceListeners(experienceItem) {
            // Remove button
            const removeBtn = experienceItem.querySelector('.remove-experience');
            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    experienceItem.remove();
                });
            }
            
            // Current position checkbox
            const currentCheckbox = experienceItem.querySelector('.current-position');
            const endDateInput = experienceItem.querySelector('input[name$="[end_date]"]');
            
            if (currentCheckbox && endDateInput) {
                currentCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        endDateInput.disabled = true;
                        endDateInput.value = '';
                    } else {
                        endDateInput.disabled = false;
                    }
                });
            }
        }
    }
});
</script>
@endpush
@endsection