<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CommentsController extends Controller
{
    //

    /**
     * CommentsController constructor.
     */
    public function __construct()
    {

    }


    public function store(\App\Http\Requests\CommentsRequest $request, \App\Article $article)
    {
        $comment = $article->comments()->create(array_merge(
            $request->all(),
            ['user_id' => $request->user()->id]
        ));
        flash()->success(
            '댓글이 저장되었습니다.'
        );
        return $this->respondCreated($article, $comment);
    }


    public function update(\App\Http\Requests\CommentsRequest $request, \App\Comment $comment)
    {
        $comment->update($request->all());
        return redirect(route('articles.show', $comment->commentable()->id). '#comment_'
        .$comment->id);
    }



    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json([], 204);
    }





    protected function respondCreated(\App\Article $article, \App\Comment $comment)
    {
        return redirect(
            route('articles.show', $article->id) . '#comment_' . $comment->id
        );
    }
}
