<?php

namespace App\Listeners;

//use App\Events\article.created;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ArticlesEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  article.created  $event
     * @return void
     */
    public function handle(\App\Events\ArticleCreated $event)
    {
        //
        dump('이벤트를 수신하였습니다. 상태는 다음과 같습니다.');
        dump($event->article->toArray());
    }
}
