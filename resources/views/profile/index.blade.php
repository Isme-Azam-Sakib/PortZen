@extends('layouts.app')

@section('content')
<!-- Ensure these CSS and JS files are loaded for the profile page -->
@push('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

<div class="profile-container container">
    <div class="profile-header">
        <div class="row align-items-center">
            <div class="col-md-2 text-center mb-4 mb-md-0">
                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="profile-avatar">
            </div>
            <div class="col-md-6">
                <h1 class="profile-title">{{ $user->name }}</h1>
                <p class="profile-email">{{ $user->email }}</p>
                @if($user->location)
                <p><i class="fa-solid fa-location-dot"></i> {{ $user->location }}</p>
                @endif
            </div>
            <div class="col-md-4">
                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-value">{{ $portfolios->count() }}</div>
                        <div class="stat-label">Portfolios</div>
                    </div>
                    @if($user->created_at)
                    <div class="stat-item">
                        <div class="stat-value">{{ $user->created_at->diffInDays() }}</div>
                        <div class="stat-label">Days Active</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Session Status Messages -->
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <!-- Profile Tabs -->
    <ul class="nav nav-tabs" id="profileTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-content" type="button" role="tab" aria-controls="profile-content" aria-selected="true">
                <i class="fa-solid fa-user"></i> Personal Info
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security-content" type="button" role="tab" aria-controls="security-content" aria-selected="false">
                <i class="fa-solid fa-shield-halved"></i> Security
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="portfolios-tab" data-bs-toggle="tab" data-bs-target="#portfolios-content" type="button" role="tab" aria-controls="portfolios-content" aria-selected="false">
                <i class="fa-solid fa-briefcase"></i> Portfolios
            </button>
        </li>
    </ul>
    
    <div class="tab-content" id="profileTabsContent">
        <!-- Profile Tab -->
        <div class="tab-pane fade show active" id="profile-content" role="tabpanel" aria-labelledby="profile-tab">
            <div class="profile-card">
                <h2 class="profile-card-title"><i class="fa-solid fa-user-pen"></i> Personal Information</h2>
                <form id="profile-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="avatar-preview">
                                <img id="avatar-preview" src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
                                <label for="avatar-upload" class="avatar-edit">
                                    <i class="fa-solid fa-camera"></i>
                                </label>
                                <input type="file" id="avatar-upload" name="avatar" accept="image/*">
                            </div>
                            <p class="text-muted small mt-2">Click the camera icon to change your profile picture</p>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" id="location" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $user->location) }}" placeholder="City, Country">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="website" class="form-label">Website</label>
                                <input type="url" id="website" name="website" class="form-control @error('website') is-invalid @enderror" value="{{ old('website', $user->website) }}" placeholder="https://...">
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="bio" class="form-label">Bio</label>
                                <textarea id="bio" name="bio" class="form-control @error('bio') is-invalid @enderror" rows="4">{{ old('bio', $user->bio) }}</textarea>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-update">
                                    <i class="fa-solid fa-save"></i> Update Profile
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Security Tab -->
        <div class="tab-pane fade" id="security-content" role="tabpanel" aria-labelledby="security-tab">
            <div class="profile-card">
                <h2 class="profile-card-title"><i class="fa-solid fa-key"></i> Update Password</h2>
                <form id="password-form" action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="form-group">
                        <label for="current_password" class="form-label">Current Password</label>
                        <div class="input-group">
                            <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#current_password">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">New Password</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#password">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div id="password-strength" class="password-strength"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <div class="input-group">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#password_confirmation">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <button type="submit" class="btn btn-update">
                            <i class="fa-solid fa-key"></i> Update Password
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="profile-card mt-4">
                <h2 class="profile-card-title text-danger"><i class="fa-solid fa-exclamation-triangle"></i> Danger Zone</h2>
                <p>Once you delete your account, all of your portfolios and data will be permanently deleted. This action cannot be undone.</p>
                
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')
                    
                    <div class="form-group">
                        <label for="delete_password" class="form-label">Confirm your password to delete account</label>
                        <input type="password" id="delete_password" name="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" required>
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <button type="submit" class="btn btn-delete" id="delete-account-btn">
                            <i class="fa-solid fa-trash"></i> Delete Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Portfolios Tab -->
        <div class="tab-pane fade" id="portfolios-content" role="tabpanel" aria-labelledby="portfolios-tab">
            <div class="profile-card">
                <h2 class="profile-card-title">
                    <i class="fa-solid fa-briefcase"></i> Your Portfolios
                    <a href="{{ route('portfolios.create') }}" class="btn btn-sm btn-update float-end">
                        <i class="fa-solid fa-plus"></i> Create New Portfolio
                    </a>
                </h2>
                
                @if($portfolios->count() > 0)
                    <ul class="portfolio-list">
                        @foreach($portfolios as $portfolio)
                            <li class="portfolio-item">
                                <div>
                                    <div class="portfolio-item-title">{{ $portfolio->title }}</div>
                                    <div class="portfolio-item-date">Created {{ $portfolio->created_at->diffForHumans() }}</div>
                                </div>
                                <div class="portfolio-item-actions">
                                    <a href="{{ route('portfolios.show', $portfolio) }}" class="btn btn-sm btn-update">
                                        <i class="fa-solid fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('portfolios.edit', $portfolio) }}" class="btn btn-sm btn-update">
                                        <i class="fa-solid fa-pencil"></i> Edit
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center py-5">
                        <i class="fa-solid fa-briefcase fa-3x mb-3 text-muted"></i>
                        <p class="mb-4">You haven't created any portfolios yet</p>
                        <a href="{{ route('portfolios.create') }}" class="btn btn-update">
                            <i class="fa-solid fa-plus"></i> Create Your First Portfolio
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/profile.js') }}"></script>
@endpush
@endsection 