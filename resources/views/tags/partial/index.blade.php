<p class="lead">태그</p>

<ul class="list">
    @foreach($allTags as $tag)
        <li {!! str_contains(request()->path(), $tag->slug) ? 'class="active"' : '' !!}>
            <a href="{{ route('tags.articles.index', $tag->slug) }}">
                {{ $tag->name }}
                @if ($count = $tag->articles->count())
                    <span class="badge badge-default">{{ $count }}</span>
                @endif
            </a>
        </li>
    @endforeach
</ul>

@section('script')
    @parent
    <script>
        // 댓글 삭제 요청을 처리한다.
        $('.btn__delete__comment').on('click', function (e) {
            var commentId = $(this).closest('.item__comment').data('id'),
                articleId = $('#item__article').data('id');
            if (confirm('댓글을 삭제합니까?')) {
                $.ajax({
                    type: 'DELETE',
                    url: "/comments/" + commentId,
                    data: {
                        _method: "DELETE",
                    }
                }).then(function () {
                    $('#comment_' + commentId).fadeOut(1000, function () {
                        $(this).remove();
                    });
                });
            }
        });
    </script>
@stop