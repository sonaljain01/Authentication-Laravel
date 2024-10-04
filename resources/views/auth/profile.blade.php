@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="name">{{ Auth::user()->name }}</h1>
        <p class="email">email: {{ Auth::user()->email }}</p>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="profile_image" class="form-label">Upload Profile Image</label>
                <input type="file" class="form-control" name="profile_image" id="profile_image" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>

        @if (Auth::user()->profile_image)
            <div class="mt-3">
                <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile Image" width="150">
            </div>
        @endif
    </div>

    <style>
        .container {
            max-width: 500px;
            margin-top: 50px;
        }

        .form-label {
            font-weight: bold;
        }

        .name{
            font-size: 36px;
            color: #333;
            margin-top: 20px;
        }

        .email{
            font-size: 18px;
            color: black;
            margin-top: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
            margin-top: 10px;
        }
    </style>
@endsection
