<?php

namespace App\Nova;

use App\Nova\Actions\PublishStory;
use App\Nova\Actions\UnpublishStory;
use App\Nova\Filters\StoryVisibility;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Story extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Story';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title', 'content',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Boolean::make('Published', 'is_published')->exceptOnForms(),
            Text::make('Title'),
            Image::make('Cover Image', 'cover')->hideFromIndex(),
            Trix::make('Content')->alwaysShow(),
            Boolean::make('Published', 'is_published')->onlyOnForms(),
            new Panel('Additional Information', $this->moreInformationFields()),
        ];
    }

    /**
     * Get additional fields for the resource.
     *
     * @return array
     */
    protected function moreInformationFields()
    {
        return [
            ID::make()->sortable()->onlyOnDetail(),
            Date::make('Date Published', 'published_at')->exceptOnForms(),
            DateTime::make('Created On', 'created_at')->onlyOnDetail(),
            DateTime::make('Last Updated', 'updated_at')->onlyOnDetail(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new StoryVisibility()
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            new PublishStory(),
            new UnpublishStory(),
        ];
    }
}
