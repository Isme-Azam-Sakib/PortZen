@extends('templates.layouts.modern')

@section('content')
<!-- Preloader -->
<div id="preloader">
    <div id="status" class="la-ball-triangle-path">
        <div></div>
        <div></div>
        <div></div>
            </div>
        </div>

<div class="page-border" data-wow-duration="0.7s" data-wow-delay="0.2s">
    <div class="top-border wow fadeInDown animated"></div>
    <div class="right-border wow fadeInRight animated"></div>
    <div class="bottom-border wow fadeInUp animated"></div>
    <div class="left-border wow fadeInLeft animated"></div>
    </div>

<div id="wrapper">
    <header id="banner" class="scrollto clearfix" data-enllax-ratio=".5">
        <div id="header" class="nav-collapse">
            <div class="row clearfix">
                <div class="col-1">
                    <!--Logo-->
                    <div id="logo">
                        <img src="{{ asset('templates/modern/images/logo.png') }}" id="banner-logo" alt="Portfolio"/>
                        <img src="{{ asset('templates/modern/images/logo-2.png') }}" id="navigation-logo" alt="Portfolio"/>
            </div>

                    <aside>
                        <!--Social Icons in Header-->
                        <ul class="social-icons">
                            @foreach($portfolio->social_links ?? [] as $social)
                                <li>
                                    <a target="_blank" title="{{ ucfirst($social['platform']) }}" href="{{ $social['url'] }}">
                                        <i class="fa fa-{{ $social['platform'] }} fa-1x"></i>
                                        <span>{{ ucfirst($social['platform']) }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </aside>

                    <!--Main Navigation-->
                    <nav id="nav-main">
                        <ul>
                            <li><a href="#banner">Home</a></li>
                            <li><a href="#about">About</a></li>
                            <li><a href="#gallery">Gallery</a></li>
                            <li><a href="#contact">Contact</a></li>
                        </ul>
                    </nav>

                    <div id="nav-trigger"><span></span></div>
                    <nav id="nav-mobile"></nav>
                </div>
            </div>
        </div>

        <!--Banner Content-->
        <div id="banner-content" class="row clearfix">
            <div class="col-38">
                <div class="section-heading">
                    <h1>{{ $portfolio->full_name }}</h1>
                    <h2>{{ $portfolio->tagline }}</h2>
                </div>
                <a href="#contact" class="button">Get in Touch</a>
            </div>
        </div>
    </header>

    <!--Main Content Area-->
    <main id="content">
        <!--About Section-->
        <section id="about" class="introduction scrollto">
            <div class="row clearfix">
                <div class="col-3">
                    <div class="section-heading">
                        <h3>ABOUT ME</h3>
                        <h2 class="section-title">{{ $portfolio->full_name }}</h2>
                        <p class="section-subtitle">{{ $portfolio->bio }}</p>
                    </div>
                </div>

                <div class="col-2-3">
                    @if($portfolio->skills)
                        @foreach(array_slice($portfolio->skills, 0, 4) as $skill)
                            <div class="col-2 icon-block icon-top wow fadeInUp" data-wow-delay="0.1s">
                                <div class="icon">
                                    <i class="fa fa-code fa-2x"></i>
                                </div>
                                <div class="icon-block-description">
                                    <h4>{{ $skill }}</h4>
                                    <p>{{ $portfolio->experience_level }}</p>
                                </div>
                            </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </section>

        <!--Work Experience Section-->
        @if($portfolio->workExperiences->count() > 0)
        <section id="experience" class="scrollto clearfix">
            <div class="row clearfix">
                <div class="col-3">
                    <div class="section-heading">
                        <h3>EXPERIENCE</h3>
                        <h2 class="section-title">Professional Background</h2>
        </div>
    </div>
                
                <div class="col-2-3">
            @foreach($portfolio->workExperiences as $experience)
                        <div class="col-2 icon-block wow fadeInUp">
                            <div class="icon-block-description">
                            <h4>{{ $experience->job_title }}</h4>
                                <h5>{{ $experience->company_name }}</h5>
                            <p class="text-muted">
                                {{ $experience->start_date->format('M Y') }} - 
                                {{ $experience->is_current ? 'Present' : $experience->end_date->format('M Y') }}
                            </p>
                            <p>{{ $experience->responsibilities }}</p>
                        </div>
                    </div>
                    @endforeach
        </div>
    </div>
</section>
@endif

        <!--Portfolio Projects Section-->
@if($portfolio->portfolioProjects->count() > 0)
        <section id="projects" class="scrollto clearfix">
            <div class="row clearfix">
                <div class="section-heading">
                    <h3>PORTFOLIO</h3>
                    <h2 class="section-title">Recent Projects</h2>
                </div>
                
            @foreach($portfolio->portfolioProjects as $project)
                    <div class="col-3 wow fadeInUp">
                        @if($project->images)
                            <div class="gallery-item">
                                <img src="{{ asset('storage/' . $project->images[0]) }}" alt="{{ $project->name }}"/>
                                <div class="gallery-item-description">
                                    <h4>{{ $project->name }}</h4>
                                    <p>{{ $project->description }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                                @endforeach
            </div>
        </section>
        @endif

        <!--Gallery Section-->
        <section id="gallery" class="scrollto clearfix">
            <div class="row clearfix">
                <div class="section-heading gallery-header">
                    <h3>GALLERY</h3>
                    <h2 class="section-title">My Work</h2>
                    
                    @if(auth()->id() == $portfolio->user_id)
                    <div class="gallery-upload-section">
                        <form action="{{ route('portfolio.gallery.upload') }}" method="POST" 
                              enctype="multipart/form-data" id="galleryUploadForm">
                            @csrf
                            <div class="upload-wrapper">
                                <label for="gallery_images" class="upload-btn">
                                    <i class="fa fa-cloud-upload"></i>
                                </label>
                                <input type="file" id="gallery_images" name="images[]" 
                                       multiple accept="image/*" style="display: none;">
                            </div>
                        </form>
                        <div class="upload-progress-container" style="display: none;">
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 0%;"></div>
                            </div>
                            <div class="progress-text">0%</div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="gallery-container">
                    <div class="gallery-grid">
                        @foreach($portfolio->galleryImages as $image)
                            <div class="gallery-item">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery Image">
                                @if(auth()->id() == $portfolio->user_id)
                                    <div class="gallery-item-overlay">
                                        <div class="gallery-actions">
                                            <button class="action-btn caption-image" data-image-id="{{ $image->id }}" title="Add Caption">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button class="action-btn move-image" data-image-id="{{ $image->id }}" title="Reorder">
                                                <i class="fa fa-arrows"></i>
                                            </button>
                                            <button class="action-btn delete-image" data-image-id="{{ $image->id }}" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                        @if($image->caption)
                                            <div class="image-caption">{{ $image->caption }}</div>
                                        @endif
                                    </div>
                                @endif
                </div>
            @endforeach
                    </div>
        </div>
    </div>
</section>

        <!-- Keep original testimonials section as is -->
        <aside id="testimonials" class="scrollto text-center" data-enllax-ratio=".2">
            <!-- Original testimonials content -->
        </aside>

        <!-- Contact Section -->
        <section id="contact" class="scrollto clearfix">
            <div class="row clearfix">
                <div class="col-3">
                    <div class="section-heading">
                        <h3>GET IN TOUCH</h3>
                        <h2 class="section-title">Let's Connect</h2>
                        
                        <!-- Contact Information -->
                        <div class="contact-info">
                            <div class="contact-item">
                                <i class="fa fa-envelope fa-2x"></i>
                                <p>{{ $portfolio->email }}</p>
                            </div>
                            
                            @if($portfolio->phone)
                            <div class="contact-item">
                                <i class="fa fa-phone fa-2x"></i>
                                <p>{{ $portfolio->phone }}</p>
                            </div>
@endif

                            @if($portfolio->website_url)
                            <div class="contact-item">
                                <i class="fa fa-globe fa-2x"></i>
                                <p><a href="{{ $portfolio->website_url }}" target="_blank">Visit Website</a></p>
                            </div>
                            @endif
                        </div>

                        <!-- Social Links -->
                        <div class="social-links">
                            @foreach($portfolio->social_links ?? [] as $social)
                                <a href="{{ $social['url'] }}" target="_blank" class="social-icon">
                                    <i class="fa fa-{{ $social['platform'] }} fa-2x"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-2-3">
                    <div class="contact-form wow fadeInUp">
                        <form action="#" method="POST" class="contact-form">
                            @csrf
                            <div class="form-row">
                                <div class="form-col">
                                    <input type="text" name="name" placeholder="Your Name" required>
                                </div>
                                <div class="form-col">
                                    <input type="email" name="email" placeholder="Your Email" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-col-full">
                                    <input type="text" name="subject" placeholder="Subject" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-col-full">
                                    <textarea name="message" placeholder="Your Message" required></textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-col-full">
                                    <button type="submit" class="button">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!--Footer-->
    <footer id="landing-footer" class="clearfix">
        <div class="row clearfix">
            <p id="copyright" class="col-2">© {{ date('Y') }} {{ $portfolio->full_name }}</p>
            
            <!--Social Icons in Footer-->
            <ul class="col-2 social-icons">
                @foreach($portfolio->social_links ?? [] as $social)
                    <li>
                        <a target="_blank" title="{{ ucfirst($social['platform']) }}" href="{{ $social['url'] }}">
                            <i class="fa fa-{{ $social['platform'] }} fa-1x"></i>
                            <span>{{ ucfirst($social['platform']) }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </footer>
    </div>

<!-- Contact Section Styles -->
<style>
.contact-info {
    margin: 20px 0;
}

.contact-item {
    display: flex;
    align-items: center;
    margin-bottom: 12px;
    padding: 5px 0;
}

.contact-item i {
    margin-right: 10px;
    color: #764ba2;
    width: 25px;
}

.contact-item p {
    margin: 0;
    line-height: 1.4;
}

.social-links {
    margin-top: 30px;
}

.social-icon {
    display: inline-block;
    margin-right: 15px;
    color: #764ba2;
    transition: transform 0.3s ease;
}

.social-icon:hover {
    transform: translateY(-3px);
}

.contact-form {
    max-width: 800px;
    margin: 0 auto;
}

.form-row {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
}

.form-col {
    flex: 1;
}

.form-col-full {
    width: 100%;
}

.contact-form input,
.contact-form textarea {
    width: 100%;
    padding: 10px;
    margin: 0;
    border: 2px solid rgba(118, 75, 162, 0.2);
    border-radius: 4px;
    transition: border-color 0.3s ease;
    box-sizing: border-box;
}

.contact-form textarea {
    height: 150px;
    resize: vertical;
}

.contact-form button {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 4px;
    cursor: pointer;
    transition: transform 0.3s ease;
    width: auto;
    display: inline-block;
}

.contact-form button:hover {
    transform: translateY(-2px);
}

/* Gallery Styles */
.gallery-header {
    position: relative;
    text-align: left;
    margin-bottom: 40px;
}

.gallery-upload-section {
    position: absolute;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.section-title:hover + .gallery-upload-section,
.gallery-upload-section:hover {
    opacity: 1;
}

.gallery-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 10px;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 10px;
    min-height: 100px;
}

.gallery-item {
    position: relative;
    display: block;
    width: 100%;
    height: fit-content;
    line-height: 0;
    break-inside: avoid;
    background: none;
    padding: 0;
    margin: 0;
}

.gallery-item img {
    width: 100%;
    height: auto;
    display: block;
    border-radius: 4px;
    object-fit: cover;
}

.gallery-item-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 4px;
    pointer-events: none;
}

.gallery-item:hover .gallery-item-overlay {
    opacity: 1;
    pointer-events: auto;
}

.gallery-actions {
    display: flex;
    gap: 10px;
    align-items: center;
    justify-content: center;
}

.action-btn {
    position: relative;
    z-index: 2;
    color: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(4px);
}

.action-btn i {
    font-size: 1.2em;
}

.caption-image {
    background: rgba(52, 152, 219, 0.9);
}

.caption-image:hover {
    transform: scale(1.1);
    background: rgba(52, 152, 219, 1);
}

.move-image {
    background: rgba(46, 204, 113, 0.9);
    cursor: move;
}

.move-image:hover {
    transform: scale(1.1);
    background: rgba(46, 204, 113, 1);
}

.delete-image {
    background: rgba(255, 68, 68, 0.9);
}

.delete-image:hover {
    transform: scale(1.1);
    background: rgba(255, 0, 0, 1);
}

/* Caption Modal Styles */
.caption-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}

.caption-modal.active {
    display: flex;
}

.caption-modal-content {
    background: white;
    padding: 20px;
    border-radius: 8px;
    width: 90%;
    max-width: 500px;
    position: relative;
}

.caption-modal-content textarea {
    width: 100%;
    height: 100px;
    margin: 10px 0;
    padding: 10px;
    border: 2px solid rgba(118, 75, 162, 0.2);
    border-radius: 4px;
    resize: vertical;
}

.caption-modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 15px;
}

.caption-modal-actions button {
    padding: 8px 16px;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.caption-modal-actions .save-caption {
    background: #4CAF50;
    color: white;
}

.caption-modal-actions .cancel-caption {
    background: #f44336;
    color: white;
}

.image-caption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 10px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    font-size: 14px;
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
}

.gallery-item.dragging {
    opacity: 0.7;
    cursor: move;
    position: fixed;
    z-index: 1000;
    pointer-events: none;
    transform: translate(-50%, -50%);
    width: 250px;
}

.gallery-item.drag-over {
    border: 2px dashed #4CAF50;
}

#banner {
    background: url('{{ $portfolio->banner_image ? asset("storage/" . $portfolio->banner_image) : asset("templates/modern/images/banner-images/banner-image-1.jpg") }}') no-repeat center top;
    background-size: cover;
}

@media (max-width: 1200px) {
    .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    }
}

@media (max-width: 768px) {
    .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    }
}

@media (max-width: 480px) {
    .gallery-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('galleryUploadForm');
    const fileInput = document.getElementById('gallery_images');
    const progressContainer = document.querySelector('.upload-progress-container');
    const progressFill = document.querySelector('.progress-fill');
    const progressText = document.querySelector('.progress-text');

    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                const formData = new FormData(form);
                progressContainer.style.display = 'block';
                progressFill.style.width = '0%';
                progressText.textContent = '0%';

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    onUploadProgress: function(progressEvent) {
                        const percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                        progressFill.style.width = percentCompleted + '%';
                        progressText.textContent = percentCompleted + '%';
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        progressFill.style.width = '100%';
                        progressText.textContent = '100%';
                        setTimeout(() => {
                            progressContainer.style.display = 'none';
                            window.location.reload();
                        }, 1000);
                    } else {
                        throw new Error(data.message || 'Upload failed');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    progressContainer.style.display = 'none';
                    alert('Upload failed: ' + error.message);
                });
            }
        });
    }

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

    const masonryLayout = () => {
        const grid = document.querySelector('.gallery-grid');
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

    // Caption functionality
    const captionButtons = document.querySelectorAll('.caption-image');
    captionButtons.forEach(button => {
        button.addEventListener('click', function() {
            const imageId = this.dataset.imageId;
            showCaptionModal(imageId);
        });
    });

    // Improved drag and drop functionality
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
});
</script>

@media screen and (max-width: 768px) {
    .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    }
}

@media screen and (max-width: 480px) {
    .gallery-grid {
        grid-template-columns: 1fr;
    }
}
@endsection