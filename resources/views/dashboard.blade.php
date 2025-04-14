@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Add SweetAlert2 CSS and JS in the header -->
    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        .portfolio-actions {
            display: flex;
            gap: 8px;
            justify-content: center;
        }
        .portfolio-actions .btn {
            flex: 1;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(portfolioId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This portfolio will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + portfolioId).submit();
                }
            });
        }
    </script>
    @endpush

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
                                            @if($portfolio->template_id)
                                                <img src="{{ asset('images/templates/ellesi' . $portfolio->template_id . '.png') }}" 
                                                     alt="{{ $portfolio->title }}" 
                                                     class="img-fluid mb-3">
                                            @else
                                                <img src="{{ asset('storage/' . $portfolio->image) }}" 
                                                     alt="{{ $portfolio->title }}" 
                                                     class="img-fluid mb-3">
                                            @endif
                                            <h5 class="card-title">{{ $portfolio->title }}</h5>
                                            <p class="text-muted">Created: {{ $portfolio->created_at->format('M d, Y') }}</p>
                                            <div class="portfolio-actions">
                                                <a href="{{ route('portfolios.show', $portfolio) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                                                    <i class="fa-solid fa-eye"></i> Preview
                                                </a>
                                                <a href="{{ route('portfolios.edit', $portfolio) }}" class="btn btn-outline-secondary btn-sm">
                                                    <i class="fa-solid fa-pen"></i> Edit
                                                </a>
                                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDelete({{ $portfolio->id }})">
                                                    <i class="fa-solid fa-trash"></i> Delete
                                                </button>
                                                <form id="delete-form-{{ $portfolio->id }}" action="{{ route('portfolios.destroy', $portfolio) }}" method="POST" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
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
