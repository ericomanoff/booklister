<?php

namespace App\Http\Controllers;
use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function store(Request $request, $id)
      {

        $validatedData = $request->validate([
          'title' => 'required',
          'author' => 'required'
        ]);

        //maybe here hit good reads api to check for rating
        $rating = null;

        $book = Book::create([
          'book_list_id' => $id,
          'title' => $validatedData['title'],
          'author' => $validatedData['author'],
          'num_pages' => $request->input('num_pages', null),
          'rating' => $rating,
        ]);

        return response()->json($book);
      }

      public function markAsRead(Book $book)
      {
        $book->is_read = true;
        $book->update();

        return response()->json('Book updated!');
      }

      public function show($bookId)
      {
        $book = Book::find($bookId);
        return response()->json($book);
      }
}
