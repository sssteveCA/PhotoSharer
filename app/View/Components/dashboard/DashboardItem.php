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
        if(count($this->data) > 0) $this->empty = false;
        switch($this->listname){
            case 'users_subscribed':
                if(!$this->empty){}
                else{
                    $this->message = "Nessun utente registrato";
                }
                break;
            case 'comments':
                if(!$this->empty){}
                else{
                    $this->message = "Nessun commento";
                }
                break;
            case 'photos': 
                if(!$this->empty){}
                else{
                    $this->message = "Nessuna foto caricata";
                }
                break;
            case 'reported_photos':
                if(!$this->empty){}
                else{
                    $this->message = "Nessuna foto segnalata";
                }
                break;
            case 'reported_comments':
                if(!$this->empty){}
                else{
                    $this->message = "Nessun commento segnalato";
                }
                break;
            case 'tags':
                if(!$this->empty){}
                else{
                    $this->message = "Nessun tag esistente";
                }
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
