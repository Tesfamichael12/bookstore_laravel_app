<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; padding-top: 20px; background-color: #f4f4f9; }
        .container { max-width: 600px; }
        .card { background-color: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); padding: 30px; }
        .form-label { font-weight: 500; }
        .current-cover-photo img { max-width: 100px; height: auto; border: 1px solid #ddd; padding: 5px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1 class="mb-4 text-center">Edit Book: {{ $book->title }}</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') {{-- Method spoofing for PUT request --}}

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $book->title) }}" required>
                </div>

                <div class="mb-3">
                    <label for="author" class="form-label">Author</label>
                    <input type="text" class="form-control" id="author" name="author" value="{{ old('author', $book->author) }}" required>
                </div>

                <div class="mb-3">
                    <label for="genre" class="form-label">Genre</label>
                    <input type="text" class="form-control" id="genre" name="genre" value="{{ old('genre', $book->genre) }}">
                </div>

                <div class="mb-3">
                    <label for="published_year" class="form-label">Published Year</label>
                    <input type="number" class="form-control" id="published_year" name="published_year" value="{{ old('published_year', $book->published_year) }}" min="0" max="{{ date('Y') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Current Cover Photo</label>
                    <div class="current-cover-photo">
                        @if ($book->cover_photo)
                            <img src="{{ asset('storage/covers/' . $book->cover_photo) }}" alt="Current Cover Photo">
                        @else
                            <p>No cover photo available.</p>
                        @endif
                    </div>
                    <label for="cover_photo" class="form-label">Upload New Cover Photo (optional)</label>
                    <input type="file" class="form-control" id="cover_photo" name="cover_photo" accept="image/jpeg, image/png, image/gif">
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Update Book</button>
                    <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
