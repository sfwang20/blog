<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'category_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function comments()
    {
      return $this->hasMany('App\Comment');
    }

    public function tagsString()
    {
        $tagsname = [];
        foreach ($this->tags as $key=> $tag) {
          $tagsname[] = $tag->name;
        }
        $tagString = implode(', ', $tagsname);
        return $tagString;
    }

}
