<?php

namespace App\View\Components\photo;

use App\Models\Photo;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Component;

class PhotoDetailsComponent extends Component
{

    public string $author;
    public array $comments;
    public string $name;
    public array $tags_list;
    public Photo $photo;

    /**
     * Create a new component instance.
     */
    public function __construct(string $author, array $comments, Photo $photo)
    {
        $this->setValues($author,$comments,$photo);
    }

    private function setValues(string $author, array $comments, Photo $photo){
        $this->author = $author;
        $this->comments = $comments;
        $this->photo = $photo;
        Log::info("PhotoDetailsComponent photo details => ".var_export($this->photo,true));
        Log::info("PhotoDetailsComponent comments => ".var_export($this->comments,true));
        $this->tags_list = json_decode($this->photo->tags_list,true);
        Log::info("PhotoDetailsComponent tags list => ".var_export($this->tags_list,true));
        $last_dot = strrpos($this->photo->name,".");
        $this->name = substr($this->photo->name,0,$last_dot);
        Log::info("PhotoDetailsComponent name => ".var_export($this->name,true));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.photo.photo-details-component');
    }
}
