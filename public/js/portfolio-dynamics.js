document.addEventListener('DOMContentLoaded', function() {
    // Get portfolio details for dynamic styling
    const portfolioId = document.querySelector('meta[name="portfolio-id"]').getAttribute('content');
    const headingColor = document.querySelector('meta[name="heading-color"]')?.getAttribute('content') || '#ffffff';
    const bannerImage = document.querySelector('meta[name="banner-image"]')?.getAttribute('content') || '';
    const defaultBannerImage = '/templates/modern/images/banner-images/banner-image-1.jpg';
    
    // Apply dynamic styles for heading color
    const nameElements = document.querySelectorAll('.editable-element[data-field="full_name"]');
    nameElements.forEach(el => {
        el.style.color = headingColor;
    });
    
    // Set banner background
    const bannerElement = document.getElementById('banner');
    if (bannerElement) {
        let backgroundUrl;
        
        // Handle both full URLs and relative paths
        if (bannerImage) {
            // Check if the path already starts with http or /storage
            if (bannerImage.startsWith('http') || bannerImage.startsWith('/storage')) {
                backgroundUrl = bannerImage;
            } else {
                // Otherwise prepend /storage/ for relative paths
                backgroundUrl = `/storage/${bannerImage}`;
            }
        } else {
            backgroundUrl = defaultBannerImage;
        }
        
        console.log('Setting banner background image:', backgroundUrl);
        bannerElement.style.background = `url("${backgroundUrl}") no-repeat center top`;
        bannerElement.style.backgroundSize = 'cover';
    }
    
    // Work Experience Management
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Handle Contact Form Submission
    const contactForm = document.getElementById('contactForm');
    const formStatus = document.getElementById('form-status');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Disable the submit button
            const submitButton = contactForm.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.textContent = 'Sending...';
            
            // Clear previous status
            formStatus.innerHTML = '';
            formStatus.className = '';
            formStatus.style.display = 'none';
            
            // Get form data
            const formData = new FormData(contactForm);
            
            // Send the form data
            fetch(contactForm.getAttribute('action'), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Show the status message
                formStatus.style.display = 'block';
                
                if (data.success) {
                    formStatus.innerHTML = `<div class="success-message">${data.message}</div>`;
                    formStatus.className = 'text-success';
                    
                    // Reset form
                    contactForm.reset();
                } else {
                    formStatus.innerHTML = `<div class="error-message">${data.message}</div>`;
                    formStatus.className = 'text-danger';
                }
                
                // Re-enable submit button
                submitButton.disabled = false;
                submitButton.textContent = 'Send Message';
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Show error message
                formStatus.style.display = 'block';
                formStatus.innerHTML = '<div class="error-message">Sorry, there was an error sending your message. Please try again later.</div>';
                formStatus.className = 'text-danger';
                
                // Re-enable submit button
                submitButton.disabled = false;
                submitButton.textContent = 'Send Message';
            });
        });
    }
    
    // Experience Edit Modal
    const experienceEditModal = document.getElementById('experienceEditModal');
    const experienceEditForm = document.getElementById('experienceEditForm');
    const editJobTitle = document.getElementById('editJobTitle');
    const editCompanyName = document.getElementById('editCompanyName');
    const editStartDate = document.getElementById('editStartDate');
    const editEndDate = document.getElementById('editEndDate');
    const editIsCurrent = document.getElementById('editIsCurrent');
    const editResponsibilities = document.getElementById('editResponsibilities');
    const experienceId = document.getElementById('experienceId');
    
    // Add Experience Modal
    const addExperienceModal = document.getElementById('addExperienceModal');
    const addExperienceForm = document.getElementById('addExperienceForm');
    const addExperienceBtn = document.getElementById('add-experience-btn');
    
    // Edit Experience Buttons
    if (document.querySelectorAll('.edit-experience-btn').length > 0) {
        document.querySelectorAll('.edit-experience-btn').forEach(button => {
            button.addEventListener('click', function() {
                const expId = this.getAttribute('data-experience-id');
                
                // Fetch experience data from the server
                fetch(`/experiences/${expId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Populate form fields
                            experienceId.value = data.experience.id;
                            editJobTitle.value = data.experience.job_title;
                            editCompanyName.value = data.experience.company_name;
                            editStartDate.value = data.experience.start_date.split('T')[0];
                            
                            if (data.experience.is_current) {
                                editIsCurrent.checked = true;
                                editEndDate.disabled = true;
                                editEndDate.value = '';
                            } else {
                                editIsCurrent.checked = false;
                                editEndDate.disabled = false;
                                editEndDate.value = data.experience.end_date ? data.experience.end_date.split('T')[0] : '';
                            }
                            
                            editResponsibilities.value = data.experience.responsibilities || '';
                            
                            // Show the modal
                            experienceEditModal.classList.add('active');
                        } else {
                            showNotification(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching experience:', error);
                        showNotification('Failed to load experience data', 'error');
                    });
            });
        });
    }
    
    // Handle the "I currently work here" checkbox
    if (editIsCurrent) {
        editIsCurrent.addEventListener('change', function() {
            if (this.checked) {
                editEndDate.disabled = true;
                editEndDate.value = '';
            } else {
                editEndDate.disabled = false;
            }
        });
    }
    
    const newIsCurrent = document.getElementById('newIsCurrent');
    if (newIsCurrent) {
        newIsCurrent.addEventListener('change', function() {
            if (this.checked) {
                document.getElementById('newEndDate').disabled = true;
                document.getElementById('newEndDate').value = '';
            } else {
                document.getElementById('newEndDate').disabled = false;
            }
        });
    }
    
    // Cancel buttons
    const cancelExperienceEdit = document.getElementById('cancelExperienceEdit');
    if (cancelExperienceEdit) {
        cancelExperienceEdit.addEventListener('click', function() {
            experienceEditModal.classList.remove('active');
        });
    }
    
    const cancelNewExperience = document.getElementById('cancelNewExperience');
    if (cancelNewExperience) {
        cancelNewExperience.addEventListener('click', function() {
            addExperienceModal.classList.remove('active');
        });
    }
    
    // Save Experience Edit
    if (experienceEditForm) {
        experienceEditForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = {
                job_title: editJobTitle.value,
                company_name: editCompanyName.value,
                start_date: editStartDate.value,
                end_date: editIsCurrent.checked ? null : editEndDate.value,
                is_current: editIsCurrent.checked,
                responsibilities: editResponsibilities.value
            };
            
            fetch(`/experiences/${experienceId.value}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Experience updated successfully', 'success');
                    experienceEditModal.classList.remove('active');
                    
                    // Reload the page to show the updated experience
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error updating experience:', error);
                showNotification('Failed to update experience', 'error');
            });
        });
    }
    
    // Delete Experience
    if (document.querySelectorAll('.delete-experience-btn').length > 0) {
        document.querySelectorAll('.delete-experience-btn').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Are you sure you want to delete this experience?')) {
                    const expId = this.getAttribute('data-experience-id');
                    
                    fetch(`/experiences/${expId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('Experience deleted successfully', 'success');
                            
                            // Remove the experience from the DOM
                            this.closest('.icon-block').remove();
                            
                            // If no more experiences, reload to hide the section
                            const remainingExperiences = document.querySelectorAll('.experience-actions');
                            if (remainingExperiences.length === 0) {
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            }
                        } else {
                            showNotification(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting experience:', error);
                        showNotification('Failed to delete experience', 'error');
                    });
                }
            });
        });
    }
    
    // Show Add Experience Modal
    if (addExperienceBtn) {
        addExperienceBtn.addEventListener('click', function() {
            // Reset form
            addExperienceForm.reset();
            document.getElementById('newEndDate').disabled = false;
            
            // Show modal
            addExperienceModal.classList.add('active');
        });
    }
    
    // Save New Experience
    if (addExperienceForm) {
        addExperienceForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = {
                portfolio_id: portfolioId,
                job_title: document.getElementById('newJobTitle').value,
                company_name: document.getElementById('newCompanyName').value,
                start_date: document.getElementById('newStartDate').value,
                end_date: document.getElementById('newIsCurrent').checked ? null : document.getElementById('newEndDate').value,
                is_current: document.getElementById('newIsCurrent').checked,
                responsibilities: document.getElementById('newResponsibilities').value
            };
            
            fetch('/experiences', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Experience added successfully', 'success');
                    addExperienceModal.classList.remove('active');
                    
                    // Reload the page to show the new experience
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error adding experience:', error);
                showNotification('Failed to add experience', 'error');
            });
        });
    }
    
    // Handle Banner Image Upload
    const changeBannerBtn = document.getElementById('changeBannerBtn');
    const bannerImageInput = document.getElementById('bannerImageInput');
    const bannerImageForm = document.getElementById('bannerImageForm');
    
    console.log('[DEBUG] Banner elements:', {
        changeBannerBtn: changeBannerBtn ? 'Found' : 'Not found',
        bannerImageInput: bannerImageInput ? 'Found' : 'Not found',
        bannerImageForm: bannerImageForm ? 'Found' : 'Not found'
    });
    
    // Manually add click handler to the banner button as a fallback
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            const bannerBtn = document.getElementById('changeBannerBtn');
            if (bannerBtn) {
                console.log('[DEBUG] Adding direct click handler to banner button');
                bannerBtn.onclick = function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('[DEBUG] Banner button clicked directly');
                    document.getElementById('bannerImageInput').click();
                    return false;
                };
            }
        }, 1000);
    });
    
    if (changeBannerBtn && bannerImageInput && bannerImageForm) {
        console.log('[DEBUG] Banner upload elements found');
        
        // Remove existing onclick to avoid conflicts
        changeBannerBtn.removeAttribute('onclick');
        changeBannerBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('[DEBUG] Banner change button clicked via event listener');
            bannerImageInput.click();
        });
        bannerImageInput.addEventListener('change', function() {
            console.log('[DEBUG] Banner image input changed:', this.files ? 'Files selected' : 'No files');
            
            if (this.files && this.files[0]) {
                const formData = new FormData(bannerImageForm);
                
                // Log form data for debugging
                console.log('[DEBUG] Form action:', bannerImageForm.action);
                console.log('[DEBUG] CSRF token present:', !!document.querySelector('meta[name="csrf-token"]')?.content);
                
                // Add CSRF token to form data explicitly
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                if (csrfToken) {
                    formData.append('_token', csrfToken);
                }
                
                // Disable the button while uploading
                changeBannerBtn.disabled = true;
                changeBannerBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Uploading...';
                
                fetch(bannerImageForm.action, {
                    method: 'POST',
                    // Don't set Content-Type header, let the browser set it with the boundary
                    body: formData
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response headers:', [...response.headers.entries()]);
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    
                    if (data.success) {
                        // Determine the correct URL format
                        let imagePath = data.path;
                        
                        // If path doesn't already start with http or /storage, prepend /storage/
                        if (!imagePath.startsWith('http') && !imagePath.startsWith('/storage')) {
                            imagePath = `/storage/${imagePath}`;
                        }
                        
                        // Update the banner image immediately with proper path
                        bannerElement.style.background = `url("${imagePath}") no-repeat center top`;
                        bannerElement.style.backgroundSize = 'cover';
                        
                        // Update the meta tag with consistent path
                        let bannerMeta = document.querySelector('meta[name="banner-image"]');
                        if (bannerMeta) {
                            // Store the path consistently
                            bannerMeta.setAttribute('content', data.value || imagePath);
                        }
                        
                        showNotification('Banner image updated successfully', 'success');
                        
                        // Don't reload the page immediately - let user see the change
                        // Only reload if needed after a longer delay
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        showNotification(data.message || 'Failed to update banner image', 'error');
                    }
                    
                    // Re-enable the button
                    changeBannerBtn.disabled = false;
                    changeBannerBtn.innerHTML = '<i class="fa fa-image"></i> Change Banner';
                })
                .catch(error => {
                    console.error('Error uploading banner:', error);
                    showNotification('Failed to update banner image', 'error');
                    
                    // Re-enable the button
                    changeBannerBtn.disabled = false;
                    changeBannerBtn.innerHTML = '<i class="fa fa-image"></i> Change Banner';
                });
            }
        });
    } else {
        console.error('Banner upload elements not found:', {
            changeBannerBtn: !!changeBannerBtn,
            bannerImageInput: !!bannerImageInput,
            bannerImageForm: !!bannerImageForm
        });
    }
    
    // Helper function to show notifications
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);
        
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
}); 