<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    use \Conner\Tagging\Taggable;
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $fillable = [
      'title', 'link', 'bookmark_count'
    ];

    public function lessons()
    {
        return $this->hasMany('App\Models\Lesson');
    }

    public function popular_course()
    {
        return $this->hasOne('App\Models\PopularCourse');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User')->withPivot('pregress');
    }

    public function bookmark_user()
    {
        return $this->belongsToMany('App\Models\User', 'bookmarks');
    }
}
