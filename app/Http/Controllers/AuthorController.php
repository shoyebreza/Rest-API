<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors  = Author::with('book')->paginate(10);

        /* $authors  = Author::paginate(10); */

        return AuthorResource::collection($authors);


        /* return response()->json([
            'authors' =>$authors,
            'message' =>'author fached success'
        ],200); */



    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request)
    {
        $author = Author::create($request->validated());

        /* $author = Author::create([
            'name'=>$request->name,
            'bio'=>$request->bio,
            'nationality'=>$request->nationality
        ]); */

        return response()->json([
            'author' =>$author,
            'status' =>'Author created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        /* $author = Author::find($id); */

        return new AuthorResource($author);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAuthorRequest $request, Author $author)
    {
        $author->update($request->validated());

        return new AuthorResource($author);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();

        return response()->json([
            'message'=>'Data deleted successfully!'
        ]);
    }
}
