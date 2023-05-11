<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBookRequest;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    /**
     * Get a list of all books.
     *
     * @return JsonResponse
     */
    public function index()
    {
//        echo json_encode([request()->header('Authorization')]); exit;
        $books = Book::when(!auth('sanctum')->check(), static function ($query) {
            return $query->where('is_public', true);
        })->orderBy('created_at', 'DESC');

        return response()->json($books->jsonPaginate());
    }

    /**
     * Get the details of a specific book by ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $book = Book::when(!auth('sanctum')->check(), static function ($query) {
            return $query->where('is_public', true);
        })->findOrFail($id);

        return response()->json($book);
    }

    public function create(CreateBookRequest $request): JsonResponse
    {
        // Create a new book
        $book = new Book;
        $book->title = $request->input('title');
        $book->author = $request->input('author');
        $book->price = $request->input('price');
        $book->is_public = $request->input('is_public');
        $book->save();

        return response()->json([
            'message' => 'Book created successfully',
            'data' => $book
        ], 201);
    }

    /**
     * Update the details of a specific book by ID.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        // Validate request data
        $this->validate($request, [
            'title' => 'required',
            'author' => 'required',
            // Add more validation rules as needed
        ]);

        // Update book
        $book = Book::findOrFail($id);
        $book->title = $request->input('title');
        $book->author = $request->input('author');
        // Update other book attributes as needed
        $book->save();

        return response()->json($book);
    }

    /**
     * Delete a book by ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $book = Book::findOrFail($id); // Find the book by ID
            $book->delete(); // Delete the book
            return response()->json(['message' => 'Book deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete book'], 500);
        }
    }
}
