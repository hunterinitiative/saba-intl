<?php

namespace App\Nova\Actions;

use App\Exceptions\AdminAlreadyExistsException;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Nova\Actions\DestructiveAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\Boolean;

class MakeAdmin extends DestructiveAction
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        try {
            $models->each(function($model) use ($fields) {
                $model->MakeAdmin($fields->is_super_admin);
            });
        } catch (AdminAlreadyExistsException $e) {
            return Action::danger($e->getMessage());
        } catch (Exception $e) {
            return Action::danger($e->getMessage());
        } 
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Boolean::make('Is Super Admin'),
        ];
    }
}
