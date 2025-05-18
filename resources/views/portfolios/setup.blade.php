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
                        
                        <!-- Work Experience Section Toggle -->
                        <div class="mb-4 mt-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Work Experience</h5>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="show_work_experience" name="show_work_experience">
                                    <label class="form-check-label" for="show_work_experience">Show in portfolio</label>
                                </div>
                            </div>
                            <hr>
                        </div>

                        <!-- Work Experience Section - Hidden by default -->
                        <div id="work_experience_section" class="hidden mb-4">
                            <div id="work_experiences_container">
                                <!-- Work Experience items will be added here dynamically -->
                            </div>
                            
                            <button type="button" class="btn btn-primary add-work-experience">
                                <i class="fas fa-plus"></i> Add Work Experience
                            </button>
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

<!-- Template for new work experience item -->
<template id="work_experience_template">
    <div class="work-experience-item card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0">New Experience</h6>
            <button type="button" class="btn btn-sm btn-danger remove-experience">
                <i class="fas fa-trash"></i>
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
    // Existing portfolio-setup.js functionality
    
    // Work Experience Section Toggle
    const showWorkExperience = document.getElementById('show_work_experience');
    const workExperienceSection = document.getElementById('work_experience_section');
    
    showWorkExperience.addEventListener('change', function() {
        if (this.checked) {
            workExperienceSection.classList.remove('hidden');
        } else {
            workExperienceSection.classList.add('hidden');
        }
    });
    
    // Add Work Experience
    const workExperiencesContainer = document.getElementById('work_experiences_container');
    const addWorkExperienceBtn = document.querySelector('.add-work-experience');
    const workExperienceTemplate = document.getElementById('work_experience_template');
    let experienceIndex = 0;
    
    // Add at least one experience when toggle is enabled
    showWorkExperience.addEventListener('change', function() {
        if (this.checked && workExperiencesContainer.children.length === 0) {
            addWorkExperienceBtn.click();
        }
    });
    
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
});
</script>
@endpush
@endsection 