@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-4">
            @if($portfolio->profile_image)
                <img src="{{ asset('storage/' . $portfolio->profile_image) }}" 
                     class="img-fluid rounded-circle mb-3" 
                     alt="{{ $portfolio->full_name }}">
            @endif
            <h1>{{ $portfolio->full_name }}</h1>
            <p class="lead">{{ $portfolio->tagline }}</p>
            <div class="mb-4">
                <h5>Contact Information</h5>
                <p><i class="fas fa-envelope"></i> {{ $portfolio->email }}</p>
                @if($portfolio->phone)
                    <p><i class="fas fa-phone"></i> {{ $portfolio->phone }}</p>
                @endif
                @if($portfolio->website_url)
                    <p><i class="fas fa-globe"></i> <a href="{{ $portfolio->website_url }}" target="_blank">Website</a></p>
                @endif
            </div>

            @if($portfolio->social_links)
                <div class="mb-4">
                    <h5>Social Links</h5>
                    @foreach($portfolio->social_links as $social)
                        <a href="{{ $social['url'] }}" target="_blank" class="btn btn-outline-primary btn-sm me-2 mb-2">
                            <i class="fab fa-{{ $social['platform'] }}"></i> {{ ucfirst($social['platform']) }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">About Me</h5>
                    <p class="card-text">{{ $portfolio->bio }}</p>
                </div>
            </div>

            @if($portfolio->skills)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Skills</h5>
                        @foreach($portfolio->skills as $skill)
                            <span class="badge bg-primary me-2">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($portfolio->tools)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Tools & Software</h5>
                        @foreach($portfolio->tools as $tool)
                            <span class="badge bg-secondary me-2">{{ $tool }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Experience Level</h5>
                    <p class="card-text text-capitalize">{{ $portfolio->experience_level }}</p>
                </div>
            </div>

            @if($portfolio->workExperiences->count() > 0)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Work Experience</h5>
                        @foreach($portfolio->workExperiences as $experience)
                            <div class="mb-3">
                                <h6>{{ $experience->job_title }} at {{ $experience->company_name }}</h6>
                                <p class="text-muted">
                                    {{ $experience->start_date->format('M Y') }} - 
                                    {{ $experience->is_current ? 'Present' : $experience->end_date->format('M Y') }}
                                </p>
                                <p>{{ $experience->responsibilities }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($portfolio->portfolioProjects->count() > 0)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Portfolio Projects</h5>
                        @foreach($portfolio->portfolioProjects as $project)
                            <div class="mb-3">
                                <h6>{{ $project->name }}</h6>
                                <p>{{ $project->description }}</p>
                                @if($project->skills_used)
                                    <div class="mb-2">
                                        @foreach($project->skills_used as $skill)
                                            <span class="badge bg-info me-1">{{ $skill }}</span>
                                        @endforeach
                                    </div>
                                @endif
                                @if($project->images)
                                    <div class="row">
                                        @foreach($project->images as $image)
                                            <div class="col-md-4 mb-2">
                                                <img src="{{ asset('storage/' . $image) }}" 
                                                     class="img-fluid rounded" 
                                                     alt="Project image">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
