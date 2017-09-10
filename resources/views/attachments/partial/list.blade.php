@if ($attachments->count())
        @foreach ($attachments as $attachment)
               * <a href="{{ $attachment->url }}">
                    {{ $attachment->filename }} ({{ $attachment->bytes }})
                </a>
        @endforeach
@endif