@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Book List</h1>
        <a href="{{ route('books.create') }}" class="btn btn-primary">Add New Book</a>
    </div>

    {{-- Success and error messages are handled by the layout --}}

    @if ($books->isEmpty())
        <p>No books found.</p>
    @else
        @foreach ($books as $book)
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-2 p-3">
                        @if ($book->cover_photo)
                            <img src="{{ asset('storage/covers/' . $book->cover_photo) }}" alt="{{ $book->title }}" class="img-fluid rounded-start" style="max-height: 150px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/100x150.png?text=No+Image" alt="No Image" class="img-fluid rounded-start">
                        @endif
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->title }}</h5>
                            <p class="card-text"><small class="text-muted">By: {{ $book->author }}</small></p>
                            <p class="card-text"><small class="text-muted">Genre: {{ $book->genre ?? 'N/A' }}</small></p>
                            <p class="card-text"><small class="text-muted">Published: {{ $book->published_year ?? 'N/A' }}</small></p>
                        </div>
                    </div>
                    <div class="col-md-3 align-self-center p-3 text-end">
                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-info btn-sm mb-1 d-block">View</a>
                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning btn-sm mb-1 d-block">Edit</a>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline-block; width:100%;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm d-block w-100" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection

@push('styles')
<style>
    /* Specific styles for index page if needed - for now, using Bootstrap and layout styles */
    .card-title {
        font-weight: 600; /* Example of a more specific style if Poppins needs a different weight here */
    }
</style>
@endpush
