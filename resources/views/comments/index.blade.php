
<div class="page-header">
    <h4>댓글</h4>
</div>

<div class="form__new__comment">
    @if($currentUser)
        @include('comments.partial.create')
  {{--  @else
        @include('comments.partial.login')--}}
    @endif
</div>

<div class="list__comment">
    @forelse($comments as $comment)
        @include('comments.partial.comment', [
            'parentId' => $comment->id,
            'isReply' => false,
        ])
        @empty
    @endforelse
</div>


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