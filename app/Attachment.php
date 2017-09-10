<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    //
    protected $fillable = ['filename','bytes','mime'];

    public function getBytesAttribute($value){
        return format_fileSize($value);
    }

    public function getUrlAttribute(){
        return url('files/'.$this->filename);
    }

    public function article(){
        return $this->belongsTo(Article::class);
    }
}
