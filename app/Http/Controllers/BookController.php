<?php

namespace App\Http\Controllers;
use App\Book;
use App\BookList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function store(Request $request, $id)
      {

        $validatedData = $request->validate([
          'title' => 'required',
          'author' => 'required'
        ]);

        $booklist = BookList::find($id);
        $listSize = $booklist->books->count();

        //maybe here hit good reads api to check for rating
        $rating = null;

        $book = Book::create([
          'book_list_id' => $id,
          'title' => $validatedData['title'],
          'author' => $validatedData['author'],
          'num_pages' => $request->input('num_pages', null),
          'rating' => $rating,
          'order' => $listSize
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

      public function delete(Request $request, $id, $bookId)
      {
        Book::destroy($bookId);
        $response = "deleted resource: " . $bookId;
        return response()->json($response);
      }

      public function reorder(Request $request, $id )
      {
        
        DB::transaction(function () {
        
          global $request;
          $data = $request->json()->all();
          
          foreach ($data as $key => $value) {
              $book = Book::find($key);
              $book->order = $value;
              $book->save();
            }
          
        });
        
        return response()->json('Redorder Complete!');
      }
}
