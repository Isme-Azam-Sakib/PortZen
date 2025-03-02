@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Welcome, {{ Auth::user()->name }}!</h5>
                    <p class="text-muted">Member since {{ Auth::user()->created_at->format('M Y') }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Quick Actions</h5>
                    <div class="d-grid gap-2 d-md-flex">
                        <a href="{{ route('portfolios.create') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i> Create New Portfolio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Your Portfolios</h5>
                </div>
                <div class="card-body">
                    @if(auth()->user()->portfolios->count() > 0)
                        <div class="row">
                            @foreach(auth()->user()->portfolios as $portfolio)
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $portfolio->title }}</h5>
                                            <p class="text-muted">Created: {{ $portfolio->created_at->format('M d, Y') }}</p>
                                            <div class="d-grid gap-2">
                                                <a href="{{ route('portfolios.show', $portfolio) }}" class="btn btn-outline-primary btn-sm">
                                                    <i class="fa-solid fa-eye"></i> View
                                                </a>
                                                <a href="{{ route('portfolios.edit', $portfolio) }}" class="btn btn-outline-secondary btn-sm">
                                                    <i class="fa-solid fa-pen"></i> Edit
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fa-solid fa-folder-open fa-3x text-muted mb-3"></i>
                            <h5>No Portfolios Yet</h5>
                            <p class="text-muted">Create your first portfolio to get started!</p>
                            <a href="{{ route('portfolios.create') }}" class="btn btn-primary">
                                <i class="fa-solid fa-plus"></i> Create Portfolio
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
