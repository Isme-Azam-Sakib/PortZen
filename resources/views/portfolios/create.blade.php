@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col">
            <h2 class="font-semibold">Create Your Portfolio</h2>
            <p class="text-muted">Choose a template to get started</p>
        </div>
    </div>

    <div class="row">
        @foreach($templates as $template)
        <div class="col-md-4 mb-4">
            <div class="card template-card">
                <img src="{{ asset($template->thumbnail) }}" 
                     class="card-img-top" 
                     alt="{{ $template->name }}"
                     style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $template->name }}</h5>
                    <p class="card-text">{{ $template->description }}</p>
                    <form action="{{ route('portfolios.setup') }}" method="POST">
                        @csrf
                        <input type="hidden" name="template_id" value="{{ $template->id }}">
                        <button type="submit" class="btn btn-primary w-100">
                            Select Template
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
