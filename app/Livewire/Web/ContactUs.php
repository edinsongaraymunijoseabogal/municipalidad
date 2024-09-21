<?php

namespace App\Livewire\Web;

use Livewire\Component;
use App\Models\Setting;

class ContactUs extends Component
{
    public $latitude;
    public $longitude;
    public $site_title;
    public $site_logo;
    public $contact_address;
    public $contact_phone;
    public $contact_email;

    public function mount()
    {
        $settings = Setting::whereIn('key', ['latitude', 'longitude', 'site_title', 'site_logo', 'contact_address', 'contact_phone', 'contact_email'])
                    ->pluck('value', 'key');
        $this->latitude = $settings['latitude'] ?? '';
        $this->longitude = $settings['longitude'] ?? '';
        $this->site_title = $settings['site_title'] ?? '';
        $this->site_logo = $settings['site_logo'] ?? '';
        $this->contact_address = $settings['contact_address'] ?? '';
        $this->contact_phone = $settings['contact_phone'] ?? '';
        $this->contact_email = $settings['contact_email'] ?? '';
    }

    public function render()
    {
        return view('livewire.web.contact-us');
    }
}
