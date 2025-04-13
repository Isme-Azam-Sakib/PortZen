@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Choose a Template</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($templates as $template)
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    @if($template->thumbnail)
                                        <div class="position-relative" style="height: 200px; overflow: hidden;">
                                            <img src="{{ asset('images/templates/' . $template->thumbnail) }}" 
                                                 class="card-img-top" 
                                                 alt="{{ $template->name }}"
                                                 style="object-fit: cover; height: 100%; width: 100%;">
                                        </div>
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                            <i class="fa-solid fa-image fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $template->name }}</h5>
                                        <p class="card-text">{{ $template->description }}</p>
                                        <a href="{{ route('portfolios.setup', ['template_id' => $template->id]) }}" 
                                           class="btn btn-primary">
                                            <i class="fa-solid fa-check"></i> Select Template
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
