<?php

namespace App\Composer;

use Illuminate\View\View;
use App\Models\Category;

class CategoryComposer
{

    protected $category;
    public function __construct(Category $category
    ) {
        $this->category = $category;
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with('categories', $this->category->getParents());
    }
}
