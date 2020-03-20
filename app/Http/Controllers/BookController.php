<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function store(Request $request)
      {
        $validatedData = $request->validate(['title' => 'required']);

        $book = Book::create([
          'title' => $validatedData['title'],
          'project_id' => $request->project_id,
        ]);

        return $book->toJson();
      }

      public function markAsRead(Book $book)
      {
        $book->is_read = true;
        $book->update();

        return response()->json('Book updated!');
      }
}
