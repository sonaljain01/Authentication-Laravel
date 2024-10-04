@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 500px;">
        <h1 style="font-size: 36px; color: #333; margin-top: 100px">{{ Auth::user()->name }}</h1>

        <div style="display: flex; align-items:center; gap: 20px; margin-top: 20px">
            <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile Image"
                style="border-radius: 150%; width: 100px; height: 150px; object-fit: ; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <div class="col-md-8">
                <p>Welcome, {{ Auth::user()->name }}!</p>
                <p>{{ Auth::user()->email }}</p>
                <a href="{{ route('profile.view') }}"
                    style="background-color: #007bff; color: white; padding: 5px 20px; border-radius: 50px; text-decoration: none;">
                    Your Profile
                </a>
            </div>
        </div>
        <div class="gallery-section" style="margin-top: 20px ">
            <h3>Gallery</h3>
            <a href="{{ route('gallery.view') }}" class="btn btn-primary">Access Gallery</a>
        </div>
        

    </div>
@endsection
