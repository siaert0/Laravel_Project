<h1>{{$greeting or ''}} . {{$name or ''}}</h1>
<!-- {{$name}}은 php문법인 <?= $name; ?>과 같다! -->

<hr>

@if( $itemCount = count($items))
    <p>{{ $itemCount }} 종류의 과일이 존재합니다.</p>
@else
    <p>아무것도 없습니다.</p>
@endif

<hr>


<ul>
    @forelse($items as $item)
        <li>{{ $item }}</li>
    @empty
        <p>아무것도 없습니다.</p>
    @endforelse
</ul>

<hr>

@extends('layouts.master')

@section('style')
    <style>
        body{
            background: wheat;
        }
    </style>
    @stop
@section('content')
    <p>저는 자식뷰의 content입니다.</p>
    @include('partial.footer')
@endsection

@section('script')
    <script>
        alert('저는 자식뷰의 script 섹션입니다.');
    </script>
@stop
