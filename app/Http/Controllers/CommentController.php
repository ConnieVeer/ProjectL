<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return dd(Auth::id());
        if (Auth::check()) {

            $url = str_starts_with('http', $request->input('url')) ? $request->input('url') : 'http://'.$request->input('url');

            $comment = Comment::create([
                'body' => $request->input('body'),
                'url' => $url,
                'commentable_type' => $request->input('commentable_type'),
                'commentable_id' => $request->input('commentable_id'),
                'user_id' => Auth::user()->id
            ]);

            if ($comment) {
                //return dd($comment);
               return back()->with('success', 'Comment created successfully');
            } else {
                return back()->withInput()->with('error', 'ERROR: creating comment');
            }
        }

        return view('auth.login');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
       return dd($comment);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
