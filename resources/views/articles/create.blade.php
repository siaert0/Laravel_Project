@extends('layouts.app')

@section('content')
    <div>
        <h1>새포럼 글 쓰기</h1>
        <hr>
        <form action="{{route('articles.store')}}" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}
           @include('articles.partial.form')
            <div class="form-group">
                <button type="submit" class="btn btn-primary">저장하기</button>
            </div>
        </form>
    </div>
@stop

