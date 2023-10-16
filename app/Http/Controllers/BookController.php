<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\BookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\BookResource;
class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::paginate(10);
        return response()->json($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
$validated=$request->validated();
        $book=new Book();
        $book->name=$validated['name'];
        $book->author=$validated['author'];
        $book->genre=$validated['genre'];
        $book->publish_year=$validated['publish_year'];
        $book->save();
        return response()->json([
            'data'=>new BookResource($book),
            'message'=>'Created succesfully',
            'success'=>true

    ],201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return response()->json([
            'success' => true,
            'data' => $book,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, Book $book)
    {
        $book->update($request->validated());
        return response()->json(
            [
                'data' => $book,
            ],

        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        if ($book->delete()) {
            return response()->json(['message' => 'Succesfully deleted'], 200);
        } else {
            return response()->json(['message' => 'Failed to delete'], 500);
        }
    }
}
