@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Choose a Template</h3>
                </div>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        @foreach($templates as $template)
                            <div class="col">
                                <div class="card h-100">
                                    @if($template->thumbnail)
                                        <div class="position-relative" style="height: 180px; overflow: hidden;">
                                            <img src="{{ asset('images/templates/' . $template->thumbnail) }}" 
                                                 class="card-img-top" 
                                                 alt="{{ $template->name }}"
                                                 style="object-fit: cover; height: 100%; width: 100%;">
                                        </div>
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                                            <i class="fa-solid fa-image fa-3x text-muted"></i>
                                        </div>
                                    @endif  
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $template->name }}</h5>
                                        <p class="card-text flex-grow-1">{{ $template->description }}</p>
                                        <a href="{{ route('portfolios.setup', ['template_id' => $template->id]) }}" 
                                           class="btn btn-primary mt-auto">
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

<input type="hidden" name="template_id" value="{{ request('template_id') }}">

@endsection
