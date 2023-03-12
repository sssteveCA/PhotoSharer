<?php

namespace App\View\Components\photo;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CommentsListComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public array $comments)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.photo.comments-list-component');
    }
}
