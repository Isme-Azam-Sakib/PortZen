@extends('layouts.app')

@section('content')
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

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
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
});
</script>
@endpush
@endsection 