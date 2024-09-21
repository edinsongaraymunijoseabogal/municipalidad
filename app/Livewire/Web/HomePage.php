<?php

namespace App\Livewire\Web;

use Livewire\Component;
use App\Models\Post;
use App\Models\Video;
use App\Models\Setting;

class HomePage extends Component
{
    public $title = "";
    public $description = "";

    public $featuredNews;
    public $news;
    public $videos;
    public $articles;

    public $site_title;
    public $site_logo;
    public $site_description;


    public function mount()
    {

        $settings = Setting::whereIn('key', ['site_title','sote_logo'])->pluck('value', 'key');
        $this->site_title = $settings['site_title'] ?? null;
        $this->site_description = $settings['description'] ?? null;
        $this->site_logo = $settings['site_logo'] ?? null;

        $this->title = 'Inicio | '. $this->site_title;
        $this->description = $this->site_description;

        $this->featuredNews = Post::latest()->take(3)->get();
        
        $this->news = Post::latest()->published()->take(3)->get();
        
        $this->videos = Video::latest()->published()->take(6)->get();
        
    }

    public function render()
    {
        return view('livewire.web.home-page')
            ->layoutData([
                'title' => $this->title,
                'description' => $this->description,
            ]);
    }
}
