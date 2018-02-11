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
        'title',
        'subtitle',
        'slug',
        'content',
        'user_id',
        'active',
        'seo_tags',
        'seo_description',
    ];

    /**
     * Create a belongsTo relation between an page and its author.
     * We use this on the page detail page.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('\App\User', 'user_id');
    }

    /**
     * Return an array of alle active pages on the system.
     * This will be used in AppServiceProvider::boot method
     * to make it a global available variable for creating the
     * menu's.
     *
     * @return mixed
     */
    public function allActive()
    {
        return $this->where('active', true)->get();
    }
}
