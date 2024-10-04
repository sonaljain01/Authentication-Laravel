@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Gallery</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('gallery.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="file" name="images[]" multiple class="form-control">
            </div>
            <button type="submit" class="btn btn-success" style="margin-top: 10px;">Upload Images</button>
        </form>

        <hr>

        <div class="gallery-grid">
            @foreach ($images as $image)
                <div class="gallery-item">
                    <img src="{{ asset('storage/gallery/' . $image->file_name) }}" alt="Image" class="img-thumbnail">
                    <div class="dot-container">
                        <span class="cross" onclick="deleteImage('{{ $image->id }}')"></span>
                        <script>
                            function deleteImage(imageId) {
                                if (confirm("Are you sure you want to delete this image?")) {
                                    const form = document.createElement('form');
                                    form.method = 'POST';
                                    form.action = `/gallery/${imageId}`;
                                    form.innerHTML = `@csrf @method('DELETE')`;
                                    document.body.appendChild(form);
                                    form.submit();
                                }
                            }
                        </script>
                    </div>
                </div>
            @endforeach

        </div>
    </div>


    <style>
        .container {
            max-width: 500px;
            margin-top: 2%
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            grid-gap: 10px;
            margin-top: 20px;
        }

        .gallery-item {
            margin: 10px;
            position: relative;
            overflow: hidden;
            border: 2px solid #ddd;
            padding: 5px;
            border-radius: 8px;
            background-color: #f8f8f8;
        }

        .gallery-item img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius: 8px;
        }

        .dot-container {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .cross {
            font-size: 15px;
            color: white;
            background-color: rgb(239, 142, 142);
            border-radius: 50%;
            padding: 1px;
            display: inline-block;
            width: 15px;
            height: 15px;
            text-align: center;
            line-height: 25px;
        }
    </style>
@endsection
