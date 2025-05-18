<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Ensure profile CSS and JS files exist
        $this->ensureProfileAssetsExist();
    }

    /**
     * Ensure profile CSS and JS files are created if they don't exist
     * 
     * @return void
     */
    protected function ensureProfileAssetsExist()
    {
        $cssPath = public_path('css/profile.css');
        $jsPath = public_path('js/profile.js');
        
        // Create css directory if it doesn't exist
        if (!File::exists(public_path('css'))) {
            File::makeDirectory(public_path('css'), 0755, true);
        }
        
        // Create js directory if it doesn't exist
        if (!File::exists(public_path('js'))) {
            File::makeDirectory(public_path('js'), 0755, true);
        }
        
        // Create profile.css if it doesn't exist
        if (!File::exists($cssPath)) {
            // Default profile CSS content
            $cssContent = file_get_contents(resource_path('assets/css/profile.css'));
            if (!$cssContent) {
                $cssContent = "/* Profile Page Styling */
.profile-container {
    padding: 40px 0;
}

.profile-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 40px;
    margin-bottom: 30px;
    color: #fff;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
}

.profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.profile-title {
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 10px;
}

/* Add more CSS as needed */";
            }
            
            File::put($cssPath, $cssContent);
        }
        
        // Create profile.js if it doesn't exist
        if (!File::exists($jsPath)) {
            // Default profile JS content
            $jsContent = file_get_contents(resource_path('assets/js/profile.js'));
            if (!$jsContent) {
                $jsContent = "/* Profile Page JavaScript */
document.addEventListener('DOMContentLoaded', function() {
    // Password toggle visibility
    const togglePasswordBtns = document.querySelectorAll('.toggle-password');
    
    if (togglePasswordBtns) {
        togglePasswordBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const target = document.querySelector(this.getAttribute('data-target'));
                
                if (target.type === 'password') {
                    target.type = 'text';
                    this.innerHTML = '<i class=\"fa-solid fa-eye-slash\"></i>';
                } else {
                    target.type = 'password';
                    this.innerHTML = '<i class=\"fa-solid fa-eye\"></i>';
                }
            });
        });
    }
    
    // Avatar upload preview
    const avatarUpload = document.getElementById('avatar-upload');
    const avatarPreview = document.getElementById('avatar-preview');
    
    if (avatarUpload && avatarPreview) {
        avatarUpload.addEventListener('change', function() {
            const file = this.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.addEventListener('load', function() {
                    avatarPreview.src = this.result;
                });
                
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Other profile JS functionality
});";
            }
            
            File::put($jsPath, $jsContent);
        }
    }
}
