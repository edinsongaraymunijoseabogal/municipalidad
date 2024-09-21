<?php

namespace App\Livewire\Web;

use Livewire\Component;

use App\Models\Setting;

class AboutUs extends Component
{

    public $title = "";
    public $description = "";

    public $about_us_text;
    public $about_us_image;
    public $mission;
    public $mission_image;
    public $vision;
    public $vision_image;
    public $values;

    public function mount()
    {

        $settings = Setting::whereIn('key', ['about_us_text', 'about_us_image','mission', 'mission_image', 'vision', 'vision_image', 'values'])->pluck('value', 'key');

        $this->title = 'Sobre Nosotros | '  . app('configService')->get('site_title');

        $this->about_us_text = $settings['about_us_text'] ?? null;
        $this->about_us_image = $settings['about_us_image'] ?? null;
        $this->mission = $settings['mission'] ?? null;
        $this->vision = $settings['vision'] ?? null;
        $this->mission_image = $settings['mission_image'] ?? null;
        $this->vision_image = $settings['vision_image'] ?? null;
        
        $this->values = json_decode($settings['values'] ?? '{}', true);
    }

    public function render()
    {
        return view('livewire.web.about-us')
            ->layoutData([
                'title' => $this->title,
            ]);
    }
}
