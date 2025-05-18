@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-4 mb-3">Portfolio Templates</h1>
            <p class="lead">Choose from our collection of professionally designed portfolio templates.</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Modern Template -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('images/templates/modern-template.jpg') }}" class="card-img-top" alt="Modern Template">
                <div class="card-body">
                    <h5 class="card-title">Modern Portfolio</h5>
                    <p class="card-text">A clean and modern design perfect for showcasing your work with style.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-success">Free</span>
                        @auth
                            <a href="{{ route('portfolios.create', ['template' => 'modern']) }}" class="btn btn-primary">
                                <i class="fa-solid fa-plus"></i> Use Template
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                <i class="fa-solid fa-right-to-bracket"></i> Login to Use
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Creative Template -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('images/templates/creative-template.jpg') }}" class="card-img-top" alt="Creative Template">
                <div class="card-body">
                    <h5 class="card-title">Creative Portfolio</h5>
                    <p class="card-text">An artistic and dynamic layout that makes your portfolio stand out.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Coming Soon</span>
                        <button class="btn btn-secondary" disabled>
                            <i class="fa-solid fa-clock"></i> Stay Tuned
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Professional Template -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('images/templates/professional-template.jpg') }}" class="card-img-top" alt="Professional Template">
                <div class="card-body">
                    <h5 class="card-title">Professional Portfolio</h5>
                    <p class="card-text">A sophisticated design focused on professional achievements.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Coming Soon</span>
                        <button class="btn btn-secondary" disabled>
                            <i class="fa-solid fa-clock"></i> Stay Tuned
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h2 class="text-center mb-4">Template Features</h2>
        </div>
        <div class="col-md-4">
            <div class="text-center mb-4">
                <i class="fa-solid fa-mobile-screen fa-3x mb-3 text-primary"></i>
                <h4>Responsive Design</h4>
                <p>All templates are fully responsive and work perfectly on all devices.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-center mb-4">
                <i class="fa-solid fa-pen-to-square fa-3x mb-3 text-primary"></i>
                <h4>Easy Customization</h4>
                <p>Customize colors, fonts, and layout to match your personal brand.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-center mb-4">
                <i class="fa-solid fa-gauge-high fa-3x mb-3 text-primary"></i>
                <h4>Optimized Performance</h4>
                <p>Fast loading times and optimized for search engines.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add any template-specific JavaScript here
</script>
@endpush    
