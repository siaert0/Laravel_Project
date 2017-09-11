
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