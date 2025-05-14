<?php

namespace App\Http\Controllers;

use App\Models\Book; // Import the Book model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Import Storage facade
use Illuminate\Support\Facades\Log; // Import Log facade

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Log::info('Book list viewed.');
        $books = Book::all(); // Fetch all books from the database
        return view('books.index', ['books' => $books]); // Pass books to the view
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Log::info('Create book form viewed.');
        return view('books.create'); // Return the view for the create form
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'nullable|string|max:100',
            'published_year' => 'nullable|integer|min:0|max:' . date('Y'),
            'cover_photo' => 'nullable|image|mimes:jpeg,png,gif|max:2048', // Max 2MB
        ]);

        if ($request->hasFile('cover_photo')) {
            $coverPhotoFile = $request->file('cover_photo');
            $imageName = time() . '_' . $coverPhotoFile->getClientOriginalName();
            $imagePath = storage_path('app/public/covers/' . $imageName);

            // Load the image using GD
            $imageType = exif_imagetype($coverPhotoFile->getRealPath());
            switch ($imageType) {
                case IMAGETYPE_JPEG:
                    $src = imagecreatefromjpeg($coverPhotoFile->getRealPath());
                    break;
                case IMAGETYPE_PNG:
                    $src = imagecreatefrompng($coverPhotoFile->getRealPath());
                    break;
                case IMAGETYPE_GIF:
                    $src = imagecreatefromgif($coverPhotoFile->getRealPath());
                    break;
                default:
                    $src = false;
            }

            if ($src) {
                // Resize and crop to 300x400
                $dstWidth = 300;
                $dstHeight = 400;
                $dst = imagecreatetruecolor($dstWidth, $dstHeight);
                // Fill with white background for PNG/GIF transparency
                $white = imagecolorallocate($dst, 255, 255, 255);
                imagefill($dst, 0, 0, $white);
                imagecopyresampled($dst, $src, 0, 0, 0, 0, $dstWidth, $dstHeight, imagesx($src), imagesy($src));

                // Add watermark text
                $text = 'Do not copy';
                $font = public_path('fonts/arial.ttf'); // Make sure this font exists
                $fontSize = 20;
                $color = imagecolorallocatealpha($dst, 0, 0, 0, 60); // Black, semi-transparent
                $bbox = imagettfbbox($fontSize, 0, $font, $text);
                $x = $dstWidth - ($bbox[2] - $bbox[0]) - 10;
                $y = $dstHeight - 10;
                imagettftext($dst, $fontSize, 0, $x, $y, $color, $font, $text);

                // Save the image as PNG
                imagepng($dst, $imagePath);
                imagedestroy($src);
                imagedestroy($dst);

                // Store just the filename
                $validatedData['cover_photo'] = $imageName;
                Log::info('Cover photo uploaded and processed (GD): ' . $validatedData['cover_photo']);
            } else {
                $validatedData['cover_photo'] = null;
            }
        } else {
            $validatedData['cover_photo'] = null;
        }

        $book = Book::create($validatedData);
        Log::info('Book created: ' . $book->title . ' (ID: ' . $book->id . ')');

        return redirect()->route('books.index')->with('success', 'Book added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        Log::info('Book viewed: ' . $book->title . ' (ID: ' . $book->id . ')');
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        Log::info('Edit book form viewed for: ' . $book->title . ' (ID: ' . $book->id . ')');
        return view('books.edit', compact('book')); // Pass the book to the edit view
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'nullable|string|max:100',
            'published_year' => 'nullable|integer|min:0|max:' . date('Y'),
            'cover_photo' => 'nullable|image|mimes:jpeg,png,gif|max:2048', // Max 2MB
        ]);

        if ($request->hasFile('cover_photo')) {
            // Delete old cover photo if it exists
            if ($book->cover_photo) {
                Storage::disk('public')->delete('covers/' . $book->cover_photo);
                Log::info('Old cover photo deleted: ' . $book->cover_photo . ' for Book ID: ' . $book->id);
            }

            $coverPhotoFile = $request->file('cover_photo');
            $imageName = time() . '_' . $coverPhotoFile->getClientOriginalName();
            $imagePath = storage_path('app/public/covers/' . $imageName);

            // Load the image using GD
            $imageType = exif_imagetype($coverPhotoFile->getRealPath());
            switch ($imageType) {
                case IMAGETYPE_JPEG:
                    $src = imagecreatefromjpeg($coverPhotoFile->getRealPath());
                    break;
                case IMAGETYPE_PNG:
                    $src = imagecreatefrompng($coverPhotoFile->getRealPath());
                    break;
                case IMAGETYPE_GIF:
                    $src = imagecreatefromgif($coverPhotoFile->getRealPath());
                    break;
                default:
                    $src = false;
            }

            if ($src) {
                // Resize and crop to 300x400
                $dstWidth = 300;
                $dstHeight = 400;
                $dst = imagecreatetruecolor($dstWidth, $dstHeight);
                // Fill with white background for PNG/GIF transparency
                $white = imagecolorallocate($dst, 255, 255, 255);
                imagefill($dst, 0, 0, $white);
                imagecopyresampled($dst, $src, 0, 0, 0, 0, $dstWidth, $dstHeight, imagesx($src), imagesy($src));

                // Add watermark text
                $text = 'Do not copy';
                $font = public_path('fonts/arial.ttf'); // Make sure this font exists
                $fontSize = 20;
                $color = imagecolorallocatealpha($dst, 0, 0, 0, 60); // Black, semi-transparent
                $bbox = imagettfbbox($fontSize, 0, $font, $text);
                $x = $dstWidth - ($bbox[2] - $bbox[0]) - 10;
                $y = $dstHeight - 10;
                imagettftext($dst, $fontSize, 0, $x, $y, $color, $font, $text);

                // Save the image as PNG
                imagepng($dst, $imagePath);
                imagedestroy($src);
                imagedestroy($dst);

                // Store just the filename
                $validatedData['cover_photo'] = $imageName;
                Log::info('New cover photo uploaded and processed (GD): ' . $validatedData['cover_photo'] . ' for Book ID: ' . $book->id);
            } else {
                $validatedData['cover_photo'] = null;
            }
        } else {
            // Keep the existing cover photo if no new one is uploaded
            $validatedData['cover_photo'] = $book->cover_photo;
        }

        $book->update($validatedData);
        Log::info('Book updated: ' . $book->title . ' (ID: ' . $book->id . ')');

        return redirect()->route('books.index')->with('success', 'Book updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $bookTitle = $book->title; // Store title before deletion for logging
        $bookId = $book->id;

        if ($book->cover_photo) {
            Storage::disk('public')->delete('covers/' . $book->cover_photo);
            Log::info('Cover photo deleted: ' . $book->cover_photo . ' for Book ID: ' . $bookId);
        }

        $book->delete();
        Log::info('Book deleted: ' . $bookTitle . ' (ID: ' . $bookId . ')');

        return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
    }
}
