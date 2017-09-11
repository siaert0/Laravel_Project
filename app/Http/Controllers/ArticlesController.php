<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    /**
     * ArticlesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug = null)
    {
        //
        $query = $slug
            ? \App\Tag::whereSlug($slug)->firstOrFail()->articles()
            : new \App\Article;
        $articles = $query->latest()->paginate(3);
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $article = new \App\Article;
        return view('articles.create', compact('article'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\ArticlesRequest $request)
    {

        $article = $request->user()->articles()->create($request->all());

        if(! $article){
            return back()->with('flash_message', '글이 저장되지 않았습니다.');
        }
        //
        $article->tags()->sync($request->input('tags'));

        if($request->hasFile('files')){
            $files = $request->file('files');

            foreach ($files as $file){
                $fileName = str_random().filter_var($file->getClientOriginalName(),FILTER_SANITIZE_URL);
                $article->attachments()->create([
                    'filename' => $fileName,
                    'bytes' => $file->getSize(),
                    'mime' => $file->getClientMimeType(),
                ]);
                $file->move(attachments_path(),$fileName);
            }


            Event(new \App\Events\ArticleCreated($article));
             return redirect(route('articles.index'))->with('flash_message','글이 저장되었습니다.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Article $article)
    {
        //
        $comments = $article->comments()->with('replies')->whereNull('parent_id')
            ->latest()->get();
        return view('articles.show', compact('article','comments'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(\App\Article $article)
    {
        //
        $this->authorize('update',$article);
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\ArticlesRequest $request, \App\Article $article)
    {
        //
        $article->update($request->all());
        $article->tags()->sync($request->input('tags'));
        flash()->success('수정된 내용을 저장했습니다.');

        return redirect(route('articles.show',$article->id)); // compact는 전달개념이고
                                                                    // url의 paramiter 값이다.
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(\App\Article $article)
    {
        //
        $this->authorize('delete',$article);
        $article->delete();
        return response()->json([],204);
    }
}
