<div class="media item__comment {{ $isReply ? 'sub' : 'top' }}" data-id= "{{ $comment->id }}" id="comment_{{ $comment->id }}">
    @include('users.partial.avatar', ['user' => $comment->user, 'size' => 32])

    <div class="media-body">
        <h5 class="media-heading">
            <a href="{{ gravatar_profile_url($comment->user->email) }}">
                {{ $comment->user->name }}
            </a>
            <small>
                {{ $comment->created_at->diffForHumans() }}
            </small>
        </h5>


        <div class="action__comment">
            @can('update', $comment)
                <button class="btn__delete__comment">삭제</button>
                <button class="btn__edit__comment">수정</button>
            @endcan

            @if($currentUser)
                <button class="btn__reply__comment">답글 쓰기</button>
            @endif
        </div>

        @if($currentUser)
            @include('comments.partial.create', ['parentId' => $comment->id])
        @endif

       {{-- @can('update', $comment)
            @include('comments.partial.edit')
        @endcan--}}

        @forelse ($comment->replies as $reply)
            @include('comments.partial.comment', [
              'comment' => $reply,
              'isReply' => true,
            ])
        @empty
        @endforelse
    </div>
</div>