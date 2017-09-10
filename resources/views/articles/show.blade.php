@extends('layouts.app')

@section('content')
    @php $viewName = 'articles.show'; @endphp

    <div class="page-header">
        <h4>포럼<small> / {{ $article->title }}</small></h4>
    </div>

    <div class="row">
        <div class="col-md-3">
            <aside>
                @include('tags.partial.index')
            </aside>
        </div>
    <article data-id="{{ $article->id }}">
        @include('articles.partial.article', compact('article'))
        @include('tags.partial.list', ['tags' => $article->tags])
    </article>
    </div>
    <div class="text-center action__article">
        @can('update', $article)
        <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-info">
            <i class="fa phpdebugbar-fa-pencil"></i>글 수정
        </a>
        @endcan
        @can('delete', $article)
        <button class="btn btn-danger button__delete">
            <i class="fa phpdebugbar-fa-trash-o"></i>글 삭제
        </button>
        @endcan
        <a href="{{ route('articles.index') }}" class="btn btn-default">
            <i class="fa phpdebugbar-fa-list"></i>글 목록
        </a>
    </div>

@stop

@section('script')
    <script>
        $.ajaxSetup({
            header: {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.button__delete').on('click',function (e) {
            var articleId = $('article').data('id');
            if(confirm("글을 삭제하시겠습니까?")){
                $.ajax({
                    type: 'DELETE',
                    url : '/articles/'+ articleId
                }).then(function () {
                    window.location.href = '/articles';
                });
            }
        });
    </script>
@stop