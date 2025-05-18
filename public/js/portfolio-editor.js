/**
 * Portfolio Editor - Handles all in-place editing functionality for the Modern Portfolio template
 */

// Get portfolio ID from meta tag
const PORTFOLIO_ID = document.querySelector('meta[name="portfolio-id"]')?.content;

// Global variables for element editing
let activeElement = null;
let activeField = null;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize gallery upload functionality
    initializeGalleryUpload();
    
    // Initialize gallery item actions (delete, caption, reorder)
    initializeGalleryActions();
    
    // Initialize editable elements
    initializeEditableElements();
    
    // Initialize skill management
    initializeSkillManagement();
    
    // Initialize color picker
    initializeColorPicker();
});

/**
 * Initializes the gallery upload functionality
 */
function initializeGalleryUpload() {
    const form = document.getElementById('galleryUploadForm');
    const fileInput = document.getElementById('gallery_images');
    const progressContainer = document.querySelector('.upload-progress-container');
    const progressFill = document.querySelector('.progress-fill');
    const progressText = document.querySelector('.progress-text');

    if (fileInput && form) {
        fileInput.addEventListener('change', function(e) {
            if (this.files.length > 0) {
                const formData = new FormData();
                
                // Add CSRF token to FormData
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                formData.append('_token', csrfToken);
                
                // Add files to FormData
                for (let i = 0; i < this.files.length; i++) {
                    formData.append('images[]', this.files[i]);
                }
                
                progressContainer.style.display = 'block';
                progressFill.style.width = '0%';
                progressText.textContent = '0%';

                const xhr = new XMLHttpRequest();
                xhr.open('POST', form.action, true);
                
                // Track upload progress
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        const percentComplete = Math.round((e.loaded / e.total) * 100);
                        progressFill.style.width = percentComplete + '%';
                        progressText.textContent = percentComplete + '%';
                    }
                });
                
                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                progressFill.style.width = '100%';
                                progressText.textContent = 'Complete!';
                                setTimeout(() => {
                                    progressContainer.style.display = 'none';
                                    window.location.reload();
                                }, 1000);
                            } else {
                                showNotification(response.message || 'Upload failed', 'error');
                                console.error('Upload failed:', response.message);
                                progressContainer.style.display = 'none';
                            }
                        } catch (e) {
                            showNotification('Upload failed: Invalid response', 'error');
                            console.error('Error parsing response:', e, xhr.responseText);
                            progressContainer.style.display = 'none';
                        }
                    } else {
                        showNotification('Upload failed: Server error', 'error');
                        console.error('Server error:', xhr.status, xhr.responseText);
                        progressContainer.style.display = 'none';
                    }
                    
                    // Reset the file input to allow re-uploading the same files
                    fileInput.value = '';
                };
                
                xhr.onerror = function() {
                    showNotification('Upload failed: Network error', 'error');
                    console.error('Network error during upload');
                    progressContainer.style.display = 'none';
                    fileInput.value = '';
                };
                
                xhr.send(formData);
            }
        });
    }
}

/**
 * Initializes gallery item actions (delete, caption, reorder)
 */
function initializeGalleryActions() {
    // Handle image deletions
    document.querySelectorAll('.delete-image').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this image?')) {
                const imageId = this.dataset.imageId;
                const galleryItem = this.closest('.gallery-item');
                
                fetch(`/portfolio/gallery/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        galleryItem.style.opacity = '0';
                        setTimeout(() => {
                            galleryItem.remove();
                            showNotification('Image deleted successfully');
                        }, 300);
                    } else {
                        showNotification(data.message || 'Deletion failed', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Deletion failed: Network error', 'error');
                });
            }
        });
    });

    // Caption functionality
    const captionButtons = document.querySelectorAll('.caption-image');
    captionButtons.forEach(button => {
        button.addEventListener('click', function() {
            const imageId = this.dataset.imageId;
            showCaptionModal(imageId);
        });
    });

    // Improved drag and drop functionality
    initializeGalleryDragDrop();
}

/**
 * Initializes drag and drop functionality for gallery items
 */
function initializeGalleryDragDrop() {
    const galleryGrid = document.querySelector('.gallery-grid');
    let draggedItem = null;
    let draggedItemRect = null;
    let mouseOffset = { x: 0, y: 0 };

    document.querySelectorAll('.move-image').forEach(handle => {
        const galleryItem = handle.closest('.gallery-item');
        
        handle.addEventListener('mousedown', function(e) {
            e.preventDefault();
            draggedItem = galleryItem;
            draggedItemRect = draggedItem.getBoundingClientRect();
            
            // Calculate mouse offset relative to item
            mouseOffset.x = e.clientX - draggedItemRect.left;
            mouseOffset.y = e.clientY - draggedItemRect.top;
            
            // Create ghost image
            draggedItem.classList.add('dragging');
            
            // Update dragged item position
            updateDraggedPosition(e);
            
            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        });
    });

    function updateDraggedPosition(e) {
        if (!draggedItem) return;
        
        const x = e.clientX - mouseOffset.x;
        const y = e.clientY - mouseOffset.y;
        
        draggedItem.style.left = x + 'px';
        draggedItem.style.top = y + 'px';
    }

    function onMouseMove(e) {
        if (!draggedItem) return;
        
        updateDraggedPosition(e);
        
        const items = [...galleryGrid.querySelectorAll('.gallery-item:not(.dragging)')];
        
        // Remove previous drag-over class
        items.forEach(item => item.classList.remove('drag-over'));
        
        // Find the closest item
        const closestItem = items.reduce((closest, item) => {
            const rect = item.getBoundingClientRect();
            const offset = e.clientY - (rect.top + rect.height / 2);
            
            if (closest.offset === null || Math.abs(offset) < Math.abs(closest.offset)) {
                return { element: item, offset: offset };
            }
            return closest;
        }, { element: null, offset: null });
        
        if (closestItem.element) {
            closestItem.element.classList.add('drag-over');
        }
    }

    function onMouseUp(e) {
        if (!draggedItem) return;
        
        const items = [...galleryGrid.querySelectorAll('.gallery-item:not(.dragging)')];
        const closestItem = items.reduce((closest, item) => {
            const rect = item.getBoundingClientRect();
            const offset = e.clientY - (rect.top + rect.height / 2);
            
            if (closest.offset === null || Math.abs(offset) < Math.abs(closest.offset)) {
                return { element: item, offset: offset };
            }
            return closest;
        }, { element: null, offset: null });
        
        if (closestItem.element) {
            closestItem.element.classList.remove('drag-over');
            galleryGrid.insertBefore(draggedItem, 
                closestItem.offset > 0 ? closestItem.element.nextSibling : closestItem.element);
            
            // Reset dragged item styles
            draggedItem.classList.remove('dragging');
            draggedItem.style.left = '';
            draggedItem.style.top = '';
            
            // Save the new order
            saveGalleryOrder();
        }
        
        draggedItem = null;
        document.removeEventListener('mousemove', onMouseMove);
        document.removeEventListener('mouseup', onMouseUp);
    }
}

/**
 * Saves the updated gallery order to the server
 */
function saveGalleryOrder() {
    const items = [...document.querySelectorAll('.gallery-item')];
    const order = items.map(item => {
        const button = item.querySelector('.action-btn');
        return button ? button.dataset.imageId : null;
    }).filter(id => id);

    fetch('/portfolio/gallery/reorder', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ order })
    })
    .catch(error => console.error('Error saving order:', error));
}

/**
 * Shows the caption modal for an image
 */
function showCaptionModal(imageId) {
    let modal = document.querySelector('.caption-modal');
    if (!modal) {
        modal = document.createElement('div');
        modal.className = 'caption-modal';
        modal.innerHTML = `
            <div class="caption-modal-content">
                <h3>Edit Image Caption</h3>
                <textarea placeholder="Enter caption here..." id="caption-textarea"></textarea>
                <div class="caption-modal-actions">
                    <button class="save-caption">Save</button>
                    <button class="cancel-caption">Cancel</button>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    }

    // Fetch existing caption
    fetch(`/portfolio/gallery/${imageId}/caption`)
        .then(response => response.json())
        .then(data => {
            if (data.caption) {
                modal.querySelector('#caption-textarea').value = data.caption;
            }
        });

    modal.classList.add('active');

    // Handle save
    modal.querySelector('.save-caption').addEventListener('click', () => {
        const caption = modal.querySelector('#caption-textarea').value;
        saveImageCaption(imageId, caption);
        modal.classList.remove('active');
    });

    // Handle cancel
    modal.querySelector('.cancel-caption').addEventListener('click', () => {
        modal.classList.remove('active');
    });

    // Close on outside click
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('active');
        }
    });
}

/**
 * Saves an image caption to the server
 */
function saveImageCaption(imageId, caption) {
    fetch(`/portfolio/gallery/${imageId}/caption`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ caption })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const galleryItem = document.querySelector(`.gallery-item [data-image-id="${imageId}"]`).closest('.gallery-item');
            let captionElement = galleryItem.querySelector('.image-caption');
            
            if (caption) {
                if (!captionElement) {
                    captionElement = document.createElement('div');
                    captionElement.className = 'image-caption';
                    galleryItem.querySelector('.gallery-item-overlay').appendChild(captionElement);
                }
                captionElement.textContent = caption;
            } else if (captionElement) {
                captionElement.remove();
            }
            
            showNotification('Caption saved successfully');
        } else {
            showNotification('Failed to save caption', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to save caption', 'error');
    });
}

/**
 * Initializes masonry layout for gallery
 */
function initializeMasonryLayout() {
    const masonryLayout = () => {
        const grid = document.querySelector('.gallery-grid');
        if (!grid) return;
        
        const items = document.querySelectorAll('.gallery-item');
        const rowHeight = 10;
        let columns = 3;

        // Determine number of columns based on viewport width
        if (window.innerWidth <= 480) columns = 1;
        else if (window.innerWidth <= 768) columns = 2;
        else if (window.innerWidth <= 1200) columns = 3;
        else columns = 4;

        // Reset grid
        grid.style.gridTemplateRows = 'masonry';
        grid.style.gridTemplateColumns = `repeat(${columns}, 1fr)`;

        // Adjust item heights
        items.forEach(item => {
            const img = item.querySelector('img');
            if (img.complete) {
                const height = img.getBoundingClientRect().height;
                item.style.gridRowEnd = `span ${Math.ceil(height / rowHeight)}`;
            } else {
                img.addEventListener('load', () => {
                    const height = img.getBoundingClientRect().height;
                    item.style.gridRowEnd = `span ${Math.ceil(height / rowHeight)}`;
                });
            }
        });
    };

    // Initial layout
    masonryLayout();

    // Update layout on window resize
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(masonryLayout, 250);
    });

    // Update layout when images load
    const images = document.querySelectorAll('.gallery-item img');
    images.forEach(img => {
        if (!img.complete) {
            img.addEventListener('load', masonryLayout);
        }
    });
}

/**
 * Initializes editable elements
 */
function initializeEditableElements() {
    const editableElements = document.querySelectorAll('.editable-element');
    
    editableElements.forEach(element => {
        const field = element.dataset.field;
        const type = element.dataset.type;
        const editButton = element.nextElementSibling?.querySelector('.edit-button');
        
        if (editButton) {
            editButton.addEventListener('click', function(e) {
                e.stopPropagation();
                makeEditable(element, field, type);
            });
        }
        
        // Double click to edit
        element.addEventListener('dblclick', function() {
            makeEditable(element, field, type);
        });
    });
}

/**
 * Makes an element editable by replacing it with an input or textarea
 */
function makeEditable(element, field, type) {
    // Prevent editing multiple elements at once
    if (document.querySelector('.editable-field-active')) {
        return;
    }
    
    const originalContent = element.innerHTML;
    const originalValue = element.textContent.trim();
    element.classList.add('editable-field-active');
    
    let inputElement = '';
    if (type === 'text') {
        if (field === 'bio') {
            inputElement = `<textarea class="edit-textarea">${originalValue}</textarea>`;
        } else {
            inputElement = `<input type="text" class="edit-input" value="${originalValue}">`;
        }
    } else if (type === 'array') {
        // For skills and tools - will implement separately
        return;
    }
    
    const actionButtons = `
        <div class="edit-actions">
            <button class="edit-save">Save</button>
            <button class="edit-cancel">Cancel</button>
        </div>
    `;
    
    element.innerHTML = inputElement + actionButtons;
    
    // Focus on the input
    const input = element.querySelector('input, textarea');
    if (input) {
        input.focus();
        input.setSelectionRange(input.value.length, input.value.length);
    }
    
    // Setup event listeners
    const saveButton = element.querySelector('.edit-save');
    const cancelButton = element.querySelector('.edit-cancel');
    
    saveButton.addEventListener('click', function() {
        saveChanges(element, field, input.value);
    });
    
    cancelButton.addEventListener('click', function() {
        cancelEdit(element, originalContent);
    });
    
    // Save on Enter key
    if (input) {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                saveChanges(element, field, input.value);
            }
        });
    }
}

/**
 * Saves changes to an editable element
 */
function saveChanges(element, field, value) {
    // Using the global constant to avoid syntax errors
    const portfolioId = PORTFOLIO_ID;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    
    console.log('Saving changes:', { field, value, portfolioId });
    
    fetch(`/portfolios/${portfolioId}/update-element`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            field: field,
            value: value
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            // Reset element with new value
            element.classList.remove('editable-field-active');
            element.innerHTML = value;
            showNotification(data.message, 'success');
        } else {
            throw new Error(data.message || 'Update failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Restore original content
        cancelEdit(element, value);
        showNotification(error.message || 'Failed to update', 'error');
    });
}

/**
 * Cancels editing and restores original content
 */
function cancelEdit(element, originalContent) {
    element.classList.remove('editable-field-active');
    element.innerHTML = originalContent;
}

/**
 * Shows a notification to the user
 */
function showNotification(message, type = 'success') {
    // Create notification if it doesn't exist
    let notification = document.querySelector('.notification');
    if (!notification) {
        notification = document.createElement('div');
        notification.className = 'notification';
        document.body.appendChild(notification);
    }
    
    // Set content and type
    notification.textContent = message;
    notification.className = `notification ${type}`;
    
    // Show notification
    setTimeout(() => {
        notification.classList.add('show');
    }, 10);
    
    // Hide notification after 3 seconds
    setTimeout(() => {
        notification.classList.remove('show');
    }, 3000);
}

/**
 * Initializes skill management
 */
function initializeSkillManagement() {
    // Setup add skill form
    setupAddSkillForm();
    
    // Setup remove buttons for skills
    setupRemoveButtons();
    
    // Setup skill edit buttons
    setupSkillEditButtons();
}

/**
 * Sets up the form for adding new skills
 */
function setupAddSkillForm() {
    document.querySelectorAll('.add-skill-form').forEach(form => {
        // Remove any existing event listeners
        const newForm = form.cloneNode(true);
        form.parentNode.replaceChild(newForm, form);
        
        newForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const input = this.querySelector('input');
            const value = input.value.trim();
            
            if (value === '') return;
            
            const portfolioId = PORTFOLIO_ID;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            
            fetch(`/portfolios/${portfolioId}/update-element`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    field: 'skills',
                    value: value,
                    type: 'array',
                    action: 'add'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Create a new skill block with the same structure as existing ones
                    const skillsContainer = document.querySelector('.skills-container');
                    const existingSkill = skillsContainer.querySelector('.icon-block:not(:last-child)');
                    
                    if (existingSkill) {
                        const newSkill = existingSkill.cloneNode(true);
                        
                        // Update the skill name
                        const skillName = newSkill.querySelector('h4');
                        if (skillName) skillName.textContent = value;
                        
                        // Update the remove button data attribute
                        const removeBtn = newSkill.querySelector('.remove-skill-btn');
                        if (removeBtn) removeBtn.dataset.skill = value;

                        // Update the edit button data attribute
                        const editBtn = newSkill.querySelector('.edit-skill-btn');
                        if (editBtn) editBtn.dataset.skill = value;
                        
                        // Insert the new skill before the add skill form
                        const addSkillBlock = skillsContainer.querySelector('.icon-block:last-child');
                        skillsContainer.insertBefore(newSkill, addSkillBlock);
                        
                        // Reset opacity (in case it was animated out)
                        newSkill.style.opacity = 1;
                        
                        // Clear input
                        input.value = '';
                        
                        // Setup event listener for the new buttons
                        setupRemoveButtons();
                        setupSkillEditButtons();
                        
                        showNotification('Skill added successfully', 'success');
                    }
                } else {
                    throw new Error(data.message || 'Failed to add skill');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification(error.message || 'Failed to add skill', 'error');
            });
        });
        
        // Add click handler for the button to submit the form
        const addButton = newForm.querySelector('.add-skill-button');
        if (addButton) {
            addButton.addEventListener('click', function(e) {
                e.preventDefault();
                newForm.dispatchEvent(new Event('submit'));
            });
        }
    });
}

/**
 * Sets up the remove skill buttons
 */
function setupRemoveButtons() {
    document.querySelectorAll('.remove-skill-btn').forEach(button => {
        // Clone to remove existing event listeners
        const newButton = button.cloneNode(true);
        button.parentNode.replaceChild(newButton, button);
        
        // Add new click event listener
        newButton.addEventListener('click', function(e) {
            e.preventDefault();
            const skill = this.dataset.skill;
            const portfolioId = PORTFOLIO_ID;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            
            fetch(`/portfolios/${portfolioId}/update-element`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    field: 'skills',
                    value: skill,
                    type: 'array',
                    action: 'remove'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the skill block from UI
                    const skillBlock = this.closest('.icon-block');
                    if (skillBlock) {
                        skillBlock.style.opacity = 0;
                        setTimeout(() => {
                            skillBlock.remove();
                        }, 300);
                    }
                    showNotification('Skill removed successfully', 'success');
                } else {
                    throw new Error(data.message || 'Failed to remove skill');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification(error.message || 'Failed to remove skill', 'error');
            });
        });
    });
}

/**
 * Sets up the skill edit buttons
 */
function setupSkillEditButtons() {
    document.querySelectorAll('.edit-skill-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const skillName = this.dataset.skill;
            const skillEditModal = document.getElementById('skillEditModal');
            const skillEditInput = document.getElementById('skillEditInput');
            const oldSkillValue = document.getElementById('oldSkillValue');
            
            if (skillEditModal && skillEditInput && oldSkillValue) {
                oldSkillValue.value = skillName;
                skillEditInput.value = skillName;
                
                // Show modal
                skillEditModal.classList.add('active');
                
                // Focus input
                skillEditInput.focus();
                skillEditInput.setSelectionRange(0, skillEditInput.value.length);
            }
        });
    });
    
    // Handle save skill edit
    const saveSkillBtn = document.getElementById('saveSkillEdit');
    if (saveSkillBtn) {
        saveSkillBtn.addEventListener('click', function() {
            const oldSkillValue = document.getElementById('oldSkillValue');
            const skillEditInput = document.getElementById('skillEditInput');
            const skillEditModal = document.getElementById('skillEditModal');
            
            const oldSkill = oldSkillValue.value;
            const newSkill = skillEditInput.value.trim();
            
            if (newSkill && newSkill !== oldSkill) {
                updateSkill(oldSkill, newSkill);
            }
            
            skillEditModal.classList.remove('active');
        });
    }
    
    // Handle cancel skill edit
    const cancelSkillBtn = document.getElementById('cancelSkillEdit');
    if (cancelSkillBtn) {
        cancelSkillBtn.addEventListener('click', function() {
            const skillEditModal = document.getElementById('skillEditModal');
            skillEditModal.classList.remove('active');
        });
    }
    
    // Close modal when clicking outside
    const skillEditModal = document.getElementById('skillEditModal');
    if (skillEditModal) {
        skillEditModal.addEventListener('click', function(e) {
            if (e.target === skillEditModal) {
                skillEditModal.classList.remove('active');
            }
        });
    }
}

/**
 * Updates a skill with new value
 */
function updateSkill(oldSkill, newSkill) {
    const portfolioId = PORTFOLIO_ID;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    
    fetch(`/portfolios/${portfolioId}/update-element`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            field: 'skills',
            value: {
                old: oldSkill,
                new: newSkill
            },
            type: 'array',
            action: 'update'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the skill in the UI
            document.querySelectorAll('.edit-skill-btn').forEach(btn => {
                if (btn.dataset.skill === oldSkill) {
                    btn.dataset.skill = newSkill;
                    const skillBlock = btn.closest('.icon-block');
                    const skillName = skillBlock.querySelector('h4');
                    if (skillName) skillName.textContent = newSkill;
                    
                    // Also update remove button
                    const removeBtn = skillBlock.querySelector('.remove-skill-btn');
                    if (removeBtn) removeBtn.dataset.skill = newSkill;
                }
            });
            
            showNotification('Skill updated successfully', 'success');
        } else {
            throw new Error(data.message || 'Failed to update skill');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification(error.message || 'Failed to update skill', 'error');
    });
}

/**
 * Initializes color picker functionality
 */
function initializeColorPicker() {
    // Add event listeners to color picker buttons
    document.querySelectorAll('.color-picker-button').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            activeField = this.dataset.field;
            activeElement = this.closest('.editable-container').querySelector('.editable-element');
            
            const colorPickerModal = document.getElementById('colorPickerModal');
            const customColorInput = document.getElementById('custom-color');
            
            if (!colorPickerModal || !customColorInput) return;
            
            // Get current color and set it in the color picker
            const currentColor = window.getComputedStyle(activeElement).color;
            customColorInput.value = rgbToHex(currentColor);
            
            // Set a default selection
            const colorSamples = document.querySelectorAll('.color-sample');
            colorSamples.forEach(sample => sample.classList.remove('selected'));
            
            const defaultColor = document.querySelector('.color-sample[data-color="#ffffff"]');
            if (defaultColor) {
                defaultColor.classList.add('selected');
            }
            
            // Show the modal
            colorPickerModal.classList.add('active');
        });
    });
    
    // Handle color sample selection
    const colorSamples = document.querySelectorAll('.color-sample');
    colorSamples.forEach(sample => {
        sample.addEventListener('click', function() {
            // Remove selected class from all samples
            colorSamples.forEach(s => s.classList.remove('selected'));
            // Add selected class to current sample
            this.classList.add('selected');
            // Update custom color input
            const customColorInput = document.getElementById('custom-color');
            if (customColorInput) {
                customColorInput.value = this.dataset.color;
            }
        });
    });
    
    // Handle save color
    const saveColorBtn = document.getElementById('saveColor');
    if (saveColorBtn) {
        saveColorBtn.addEventListener('click', function() {
            const colorPickerModal = document.getElementById('colorPickerModal');
            const customColorInput = document.getElementById('custom-color');
            const selectedColor = document.querySelector('.color-sample.selected')?.dataset.color || customColorInput.value;
            
            if (activeElement && activeField) {
                // Apply color immediately for visual feedback
                activeElement.style.color = selectedColor;
                
                // Send update to server
                updateElementColor(activeField, selectedColor);
            }
            
            colorPickerModal.classList.remove('active');
        });
    }
    
    // Handle cancel color
    const cancelColorBtn = document.getElementById('cancelColor');
    if (cancelColorBtn) {
        cancelColorBtn.addEventListener('click', function() {
            const colorPickerModal = document.getElementById('colorPickerModal');
            colorPickerModal.classList.remove('active');
        });
    }
    
    // Close modal when clicking outside
    const colorPickerModal = document.getElementById('colorPickerModal');
    if (colorPickerModal) {
        colorPickerModal.addEventListener('click', function(e) {
            if (e.target === colorPickerModal) {
                colorPickerModal.classList.remove('active');
            }
        });
    }
}

/**
 * Updates an element's color
 */
function updateElementColor(field, color) {
    const portfolioId = PORTFOLIO_ID;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    
    console.log('Updating element color:', { field, color, portfolioId });
    
    fetch(`/portfolios/${portfolioId}/update-element`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            field: field,
            value: color
        })
    })
    .then(response => {
        console.log('Color update response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Color update response data:', data);
        if (data.success) {
            // Update meta tag with new color value to persist on page refresh
            let headingColorMeta = document.querySelector('meta[name="heading-color"]');
            if (!headingColorMeta) {
                headingColorMeta = document.createElement('meta');
                headingColorMeta.setAttribute('name', 'heading-color');
                document.head.appendChild(headingColorMeta);
            }
            headingColorMeta.setAttribute('content', color);
            
            showNotification('Color updated successfully', 'success');
        } else {
            throw new Error(data.message || 'Failed to update color');
        }
    })
    .catch(error => {
        console.error('Color update error:', error);
        showNotification(error.message || 'Failed to update color', 'error');
    });
}

/**
 * Helper function to convert RGB color to HEX
 */
function rgbToHex(rgb) {
    // If rgb is empty or not a string, return a default color
    if (!rgb || typeof rgb !== 'string') return '#ffffff';
    
    // If already in hex format, return it
    if (rgb.startsWith('#')) return rgb;
    
    // Extract rgb values
    const match = rgb.match(/^rgb\s*\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*\)$/i);
    if (!match) return '#ffffff';
    
    return "#" + ((1 << 24) + (parseInt(match[1]) << 16) + (parseInt(match[2]) << 8) + parseInt(match[3])).toString(16).slice(1);
} 