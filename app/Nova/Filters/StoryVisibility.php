<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Laravel\Nova\Filters\Filter;

class StoryVisibility extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @var string
     */
    public $name = 'Visibility';

    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {        
        switch ($value) {
            case 'published':
                return $query->where('is_published', 1)
                             ->where('published_at', '<=', Carbon::now());
                break;
            case 'pending':
                return $query->where('is_published', 1)
                             ->where('published_at', '>', Carbon::now());
                break;
            case 'draft':
                return $query->where('is_published', $value);
                break;
        }
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            'Published' => 'published',
            'Pending (Future Dated)' => 'pending',
            'Draft' => 'draft'
        ];
    }
}
