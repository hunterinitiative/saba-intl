<?php

namespace App\Traits;

Trait AppendsModelAndPath {
    /**
     * Get a string path for the model.
     *
     * @return string
     */
    public function path() : string
    {
        return "/". $this->getModelAttribute() ."/{$this->slug}";
    }

    /**
     * Get a string path for the model.
     *
     * @return string
     */
    public function getPathAttribute() : string
    {
        return $this->path();
    }

    /**
     * Get the name of the model.
     *
     * @return string
     */
    public function getModelAttribute() : string
    {
        return Str::plural(strtolower(class_basename((get_class($this)))));
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['model', 'path'];
}