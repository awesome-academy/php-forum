<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    /**
     * Specify Model class name
     */
    public function getModel()
    {
        return Category::class;
    }
}
