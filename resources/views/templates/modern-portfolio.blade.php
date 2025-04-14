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
                <div class="col-3">
                    <div class="section-heading">
                        <h3>GALLERY</h3>
                        <h2 class="section-title">My Work</h2>
                        
                        @if(auth()->id() == $portfolio->user_id)
                        <div class="gallery-upload-section">
                            <form action="{{ route('portfolio.gallery.upload') }}" method="POST" 
                                  enctype="multipart/form-data" id="galleryUploadForm">
                                @csrf
                                <div class="upload-wrapper">
                                    <label for="gallery_images" class="upload-btn">
                                        <i class="fa fa-cloud-upload"></i> Add Images
                                    </label>
                                    <input type="file" id="gallery_images" name="images[]" 
                                           multiple accept="image/*" style="display: none;">
                                    <small class="text-muted">Max 30 images allowed</small>
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
                </div>

                <div class="col-2-3">
                    <div class="gallery-grid" id="galleryGrid">
                        @foreach($portfolio->galleryImages as $image)
                            <div class="gallery-item wow fadeInUp" data-wow-delay="{{ $loop->index * 0.1 }}s">
                                <div class="gallery-item-inner">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery Image">
                                    @if(auth()->id() == $portfolio->user_id)
                                        <div class="gallery-item-overlay">
                                            <button class="delete-image" data-image-id="{{ $image->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    @endif
                                </div>
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
    margin: 30px 0;
}

.contact-item {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.contact-item i {
    margin-right: 15px;
    color: #764ba2;
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
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    padding: 20px 0;
}

.gallery-item {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.gallery-item:hover {
    transform: translateY(-5px);
}

.gallery-item-inner {
    position: relative;
    padding-bottom: 100%;
}

.gallery-item img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.gallery-item-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-item:hover .gallery-item-overlay {
    opacity: 1;
}

.delete-image {
    background: #ff4444;
    color: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.delete-image:hover {
    transform: scale(1.1);
}

.gallery-upload-section {
    margin-top: 20px;
}

.upload-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.upload-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.upload-btn i {
    font-size: 1.2em;
}

.upload-progress-container {
    margin-top: 15px;
    width: 100%;
}

.progress-bar {
    width: 100%;
    height: 10px;
    background-color: #f0f0f0;
    border-radius: 5px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background-color: #4CAF50;
    transition: width 0.3s ease;
}

.progress-text {
    margin-top: 5px;
    text-align: center;
    font-size: 14px;
    color: #666;
}

.upload-wrapper {
    margin-bottom: 15px;
}

.text-muted {
    display: block;
    margin-top: 5px;
    color: #666;
}

.gallery-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 25px;
    border-radius: 4px;
    background: white;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    display: none;
    animation: slideIn 0.3s ease;
}

.gallery-notification.success {
    background: #4CAF50;
    color: white;
}

.gallery-notification.error {
    background: #f44336;
    color: white;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
</style>

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
});
</script>
@endsection