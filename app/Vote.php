<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ['user_id', 'comment_id', 'up', 'down', 'voted_id'];

    protected $dates = ['voted_id'];

    public function comment(){
        return $this->belongsTo(Comment::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
