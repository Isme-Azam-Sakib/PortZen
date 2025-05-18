@extends('layouts.app')

@section('content')
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

    <ul class="nav nav-tabs" id="profileTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-content" type="button" role="tab" aria-controls="profile-content" aria-selected="true">
                <i class="fa-solid fa-user"></i> Profile
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password-content" type="button" role="tab" aria-controls="password-content" aria-selected="false">
                <i class="fa-solid fa-lock"></i> Security
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
                                <input type="text" id="location" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $user->location) }}" placeholder="e.g., New York, USA">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="website" class="form-label">Website</label>
                                <input type="url" id="website" name="website" class="form-control @error('website') is-invalid @enderror" value="{{ old('website', $user->website) }}" placeholder="https://yourwebsite.com">
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="bio" class="form-label">Bio</label>
                                <textarea id="bio" name="bio" class="form-control @error('bio') is-invalid @enderror" rows="4" placeholder="Tell us a bit about yourself">{{ old('bio', $user->bio) }}</textarea>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-update">
                                    <i class="fa-solid fa-floppy-disk"></i> Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Password Tab -->
        <div class="tab-pane fade" id="password-content" role="tabpanel" aria-labelledby="password-tab">
            <div class="profile-card">
                <h2 class="profile-card-title"><i class="fa-solid fa-lock"></i> Change Password</h2>
                
                <form id="password-form" action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    
                    <div class="form-group position-relative">
                        <label for="current_password" class="form-label">Current Password</label>
                        <div class="input-group">
                            <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#current_password">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group position-relative">
                        <label for="password" class="form-label">New Password</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#password">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        <div id="password-strength" class="password-strength mt-2"></div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group position-relative">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <div class="input-group">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#password_confirmation">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-update">
                            <i class="fa-solid fa-key"></i> Update Password
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="profile-card mt-4">
                <h2 class="profile-card-title text-danger"><i class="fa-solid fa-circle-exclamation"></i> Danger Zone</h2>
                
                <div class="alert alert-warning">
                    <i class="fa-solid fa-triangle-exclamation"></i> Deleting your account is permanent and cannot be undone. All your data, including portfolios, will be permanently removed.
                </div>
                
                <form action="{{ route('profile.destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    
                    <div class="form-group">
                        <label for="delete_password" class="form-label">Enter Your Password to Confirm</label>
                        <input type="password" id="delete_password" name="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" required>
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="text-end mt-4">
                        <button type="submit" id="delete-account-btn" class="btn btn-delete">
                            <i class="fa-solid fa-user-slash"></i> Delete Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Portfolios Tab -->
        <div class="tab-pane fade" id="portfolios-content" role="tabpanel" aria-labelledby="portfolios-tab">
            <div class="profile-card">
                <h2 class="profile-card-title"><i class="fa-solid fa-briefcase"></i> Your Portfolios</h2>
                
                @if($portfolios->count() > 0)
                    <ul class="portfolio-list">
                        @foreach($portfolios as $portfolio)
                            <li class="portfolio-item">
                                <div>
                                    <h4 class="portfolio-item-title">{{ $portfolio->full_name }}</h4>
                                    <p class="portfolio-item-date">Created {{ $portfolio->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="portfolio-item-actions">
                                    <a href="{{ route('portfolios.show', $portfolio) }}" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('portfolios.edit', $portfolio) }}" class="btn btn-sm btn-secondary">
                                        <i class="fa-solid fa-pencil"></i> Edit
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center py-5">
                        <i class="fa-solid fa-folder-open fa-4x mb-3 text-muted"></i>
                        <h3>No Portfolios Yet</h3>
                        <p>Create your first portfolio to showcase your work and skills.</p>
                    </div>
                @endif
                
                <div class="text-center mt-4">
                    <a href="{{ route('portfolios.create') }}" class="btn btn-update">
                        <i class="fa-solid fa-plus"></i> Create New Portfolio
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<link href="{{ asset('css/profile.css') }}" rel="stylesheet">
<script src="{{ asset('js/profile.js') }}"></script>

<style>
/* Password strength styles */
.password-strength {
    font-size: 0.85rem;
    font-weight: 600;
    padding: 2px 10px;
    border-radius: 20px;
    display: inline-block;
}
.very-weak { color: #e74c3c; }
.weak { color: #e67e22; }
.medium { color: #f39c12; }
.strong { color: #27ae60; }
.very-strong { color: #2ecc71; }
</style>
@endpush 