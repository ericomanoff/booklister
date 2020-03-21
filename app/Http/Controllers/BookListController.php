<?php

namespace App\Http\Controllers;
use App\BookList;
use Illuminate\Http\Request;

class BookListController extends Controller
{
    public function index()
    {
      $booklists = BookList::all();

      return  response()->json($booklists);
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
      $booklist = BookList::find($id);
      $booklist->books;
      return response()->json($booklist);
    }

}
