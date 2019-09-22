<?php
namespace App\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

trait Publishable {

    /**
     * Scope a query to only include resources that are published.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', 1)
                     ->where('published_at', '<=', Carbon::now());
    }

    /**
     * Scope a query to only include resources that are drafts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDrafts($query)
    {
        return $query->whereNull('published_at')->orWhere('is_published', 0);
    }

    public function publish($publishDate = null)
    { 
        if (Auth::user()->can('update', $this)) {

            return $this->update([
                'is_published' => 1,
                'published_at' => $publishDate ?? Carbon::now()
            ]);
            
        } else {

            throw new AuthorizationException('You are not authorized to modify this update.');

        }
    }

    public function unpublish()
    { 
        if (Auth::user()->can('update', $this)) {

            return $this->update([
                'is_published' => 0,
                'published_at' => null
            ]);
            
        } else {

            throw new AuthorizationException('You are not authorized to modify this update.');

        }
    }
}