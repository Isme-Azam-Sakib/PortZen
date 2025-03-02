@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Banner -->
    <section class="hero d-flex align-items-center">
        <div class="container text-center">
            <h2 class="text-white">Create Your Stunning Portfolio in Minutes</h2>
            <p class="text-light">Choose a template, enter your details, and get a personalized portfolio instantly.</p>
            <a href="{{ route('dashboard') }}" class="btn btn-lg btn-primary"><i class="fa-solid fa-rocket"></i> Get Started</a>
        </div>
    </section>
@endsection