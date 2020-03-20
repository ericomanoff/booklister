<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookListController extends Controller
{
    public function index()
    {
      $booklists = BookList::where('is_read', false)
                          ->orderBy('created_at', 'desc')
                          ->withCount(['books' => function ($query) {
                            $query->where('is_read', false);
                          }])
                          ->get();

      return $booklists->toJson();
    }

    public function store(Request $request)
    {
      $validatedData = $request->validate([
        'name' => 'required',
        'description' => 'required',
      ]);

      $booklist = BookList::create([
        'name' => $validatedData['name'],
        'description' => $validatedData['description'],
      ]);

      return response()->json('BookList created!');
    }

    public function show($id)
    {
      $booklist = BookList::with(['books' => function ($query) {
        $query->where('is_read', false);
      }])->find($id);

      return $booklist->toJson();
    }

    public function markAsRead(BookList $booklist)
    {
      $booklist->is_read = true;
      $booklist->update();

      return response()->json('BookList updated!');
    }
}
