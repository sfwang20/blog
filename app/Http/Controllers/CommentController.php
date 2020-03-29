<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreComment;

class CommentController extends Controller
{
    public function store(StoreComment $request)
    {
        $comment = new Comment;
        $comment->fill($request->all());

        if (Auth::check())
          $comment->user_id = Auth::id();

        $comment->save();

        return redirect('/posts/'.$request->post_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */

    public function update(StoreComment $request, Comment $comment)
    {
        $comment->fill($request->all());
        $comment->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
    }
}
