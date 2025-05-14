@extends('layouts.app') {{-- Assuming you have a layout file, adjust if not --}}

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>{{ $book->title }}</h2>
                </div>
                <div class="card-body">
                    @if($book->cover_photo)
                        <div class="mb-3 text-center">
                            <img src="{{ asset('storage/covers/' . $book->cover_photo) }}" alt="Cover photo for {{ $book->title }}" class="img-fluid" style="max-height: 400px; border: 1px solid #ddd; padding: 5px;">
                        </div>
                    @else
                        <div class="mb-3 text-center">
                            <p>No cover photo available.</p>
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 20%;">Author</th>
                                <td>{{ $book->author }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Genre</th>
                                <td>{{ $book->genre ?: 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Published Year</th>
                                <td>{{ $book->published_year ?: 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Added On</th>
                                <td>{{ $book->created_at->format('M d, Y') }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Last Updated</th>
                                <td>{{ $book->updated_at->format('M d, Y') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-4">
                        <a href="{{ route('books.index') }}" class="btn btn-secondary">Back to List</a>
                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary">Edit Book</a>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this book?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete Book</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
