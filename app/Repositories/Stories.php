<?php
namespace App\Repositories;

use App\Story;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class Stories {

    /**
     * Retrieve the latest published updates
     *
     * @return LengthAwarePaginator
     */
    public function published() : LengthAwarePaginator
    {
        return Story::published()
                     ->latest()
                     ->paginate(7);
    }
}