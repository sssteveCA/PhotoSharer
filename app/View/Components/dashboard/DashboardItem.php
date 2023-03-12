<?php

namespace App\View\Components\dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DashboardItem extends Component
{

    public array $viewData = [];
    public bool $empty = true;
    public string $message;

    /**
     * Create a new component instance.
     */
    public function __construct(public array $data, public string $listname, public string $title)
    {
        //
    }

    public function setData(){
        switch($this->listname){
            case 'users_subscribed':
                break;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.dashboard-item');
    }
}
