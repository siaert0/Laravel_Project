@if ($tags->count())
        @foreach ($tags as $tag)
                <a href="{{ route('tags.articles.index', $tag->slug) }}">
                    <{{ $tag->name}}>
                </a>
        @endforeach
@endif