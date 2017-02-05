<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'subtitle', 'slug', 'content', 'user_id', 'active', 'seo_tags', 'seo_description'
    ];

    public function author() {
        return $this->belongsTo('\App\User',  'user_id');
    }

    public function allActive() {
        return $this->where('active', true)->get();
    }
}
