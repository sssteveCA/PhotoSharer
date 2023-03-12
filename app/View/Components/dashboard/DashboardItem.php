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
        $this->setData();
    }

    public function setData(){
        if(count($this->data) > 0) $this->empty = false;
        switch($this->listname){
            case 'users_subscribed':
                if(!$this->empty){
                    $this->viewData = array_map(function($user_subscribed){
                        return $user_subscribed->name;
                    },$this->data);
                }
                else{
                    $this->message = "Nessun utente registrato";
                }
                break;
            case 'comments':
                if(!$this->empty){
                    $this->viewData = array_map(function($comment){
                        return <<<HTML
L'utente {$comment['author_name']} ha commentato "{$comment['comment_text']}" la foto <a href="/photos/{$comment['photo_id']}">
HTML;
                    },$this->data);
                }
                else{
                    $this->message = "Nessun commento";
                }
                break;
            case 'photos': 
                if(!$this->empty){
                    $this->viewData = array_map(function($photo){
                        return <<<HTML
<a href="/photos/{$photo['id']}">{$photo['name']}</a>
HTML;
                    },$this->data);
                }
                else{
                    $this->message = "Nessuna foto caricata";
                }
                break;
            case 'reported_photos':
                if(!$this->empty){
                    $this->viewData = array_map(function($reported_photo){
                        return <<<HTML
La foto <a href="/photos/{$reported_photo['id']}">{$reported_photo['name']}</a> ha ricevuto una segnalazione
HTML;
                    },$this->data);
                }
                else{
                    $this->message = "Nessuna foto segnalata";
                }
                break;
            case 'reported_comments':
                if(!$this->empty){
                    $this->viewData = array_map(function($reported_comment){
                        return <<<HTML
Il commento "{$reported_comment['comment_text']}" nella foto <a href="/photos/{$reported_comment['photo_id']}">{$reported_comment['photo_name']}</a> ha ricevuto una segnalazione
HTML;
                    },$this->data);
                }
                else{
                    $this->message = "Nessun commento segnalato";
                }
                break;
            case 'tags':
                if(!$this->empty){
                    $this->viewData = array_map(function($tag){
                        return <<<HTML
HTML;
                    },$this->data);
                }
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
