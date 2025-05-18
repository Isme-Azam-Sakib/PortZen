/* Profile Page JavaScript */
document.addEventListener('DOMContentLoaded', function() {
    // Password toggle visibility
    const togglePasswordBtns = document.querySelectorAll('.toggle-password');
    
    if (togglePasswordBtns) {
        togglePasswordBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const target = document.querySelector(this.getAttribute('data-target'));
                
                if (target.type === 'password') {
                    target.type = 'text';
                    this.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
                } else {
                    target.type = 'password';
                    this.innerHTML = '<i class="fa-solid fa-eye"></i>';
                }
            });
        });
    }
    
    // Password strength meter
    const newPassword = document.getElementById('password');
    const passwordStrength = document.getElementById('password-strength');
    
    if (newPassword && passwordStrength) {
        newPassword.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            let feedback = '';
            
            if (password.length >= 8) strength += 1;
            if (password.match(/[a-z]/)) strength += 1;
            if (password.match(/[A-Z]/)) strength += 1;
            if (password.match(/[0-9]/)) strength += 1;
            if (password.match(/[^a-zA-Z0-9]/)) strength += 1;
            
            switch (strength) {
                case 0:
                case 1:
                    feedback = 'Very Weak';
                    passwordStrength.className = 'password-strength very-weak';
                    break;
                case 2:
                    feedback = 'Weak';
                    passwordStrength.className = 'password-strength weak';
                    break;
                case 3:
                    feedback = 'Medium';
                    passwordStrength.className = 'password-strength medium';
                    break;
                case 4:
                    feedback = 'Strong';
                    passwordStrength.className = 'password-strength strong';
                    break;
                case 5:
                    feedback = 'Very Strong';
                    passwordStrength.className = 'password-strength very-strong';
                    break;
            }
            
            passwordStrength.textContent = feedback;
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
    
    // Form submission with AJAX
    const profileForm = document.getElementById('profile-form');
    
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    const alertElement = document.createElement('div');
                    alertElement.className = 'alert alert-success alert-dismissible fade show';
                    alertElement.innerHTML = `
                        <i class="fa-solid fa-circle-check"></i> ${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    
                    profileForm.prepend(alertElement);
                    
                    // Auto-dismiss after 3 seconds
                    setTimeout(() => {
                        alertElement.remove();
                    }, 3000);
                } else {
                    // Show error message
                    const alertElement = document.createElement('div');
                    alertElement.className = 'alert alert-danger alert-dismissible fade show';
                    alertElement.innerHTML = `
                        <i class="fa-solid fa-circle-exclamation"></i> ${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    
                    profileForm.prepend(alertElement);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }
    
    // Password form submission with AJAX
    const passwordForm = document.getElementById('password-form');
    
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    const alertElement = document.createElement('div');
                    alertElement.className = 'alert alert-success alert-dismissible fade show';
                    alertElement.innerHTML = `
                        <i class="fa-solid fa-circle-check"></i> ${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    
                    passwordForm.prepend(alertElement);
                    
                    // Reset form
                    passwordForm.reset();
                    
                    // Auto-dismiss after 3 seconds
                    setTimeout(() => {
                        alertElement.remove();
                    }, 3000);
                } else {
                    // Show error message
                    const alertElement = document.createElement('div');
                    alertElement.className = 'alert alert-danger alert-dismissible fade show';
                    alertElement.innerHTML = `
                        <i class="fa-solid fa-circle-exclamation"></i> ${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    
                    passwordForm.prepend(alertElement);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }
    
    // Delete account confirmation
    const deleteAccountBtn = document.getElementById('delete-account-btn');
    
    if (deleteAccountBtn) {
        deleteAccountBtn.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    }
}); 