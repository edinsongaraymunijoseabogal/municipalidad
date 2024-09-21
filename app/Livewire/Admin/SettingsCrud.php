<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingsCrud extends Component
{
    use WithFileUploads;

    public $activeTab = 'general-settings';

    public $site_logo, $new_site_logo, $site_favicon, $new_site_favicon;
    public $site_title, $description, $keywords, $meta_description;

    public $about_us_text, $about_us_image, $new_about_us_image;

    public $mission, $vision, $values = [];
    public $mission_image, $existing_mission_image;
    public $vision_image, $existing_vision_image;
    public $organigram_pdf, $existing_organigram_pdf;

    public $facebook, $twitter, $instagram, $linkedin, $youtube, $tiktok;

    public $contact_address, $contact_phone, $contact_email;

    public $latitude = "", $longitude = "";

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function mount()
    {
        $settings = Setting::all()->pluck('value', 'key');

        $this->site_logo = $settings['site_logo'] ?? null;
        $this->site_favicon = $settings['site_favicon'] ?? null;
        $this->site_title = $settings['site_title'] ?? '';
        $this->description = $settings['description'] ?? '';
        $this->keywords = $settings['keywords'] ?? '';
        $this->meta_description = $settings['meta_description'] ?? '';

        $this->about_us_text = $settings['about_us_text'] ?? '';
        $this->about_us_image = $settings['about_us_image'] ?? null;

        $this->mission = $settings['mission'] ?? '';
        $this->vision = $settings['vision'] ?? '';
        $this->values = json_decode($settings['values'] ?? '[]', true);

        $this->existing_mission_image = $settings['mission_image'] ?? null;
        $this->existing_vision_image = $settings['vision_image'] ?? null;
        $this->existing_organigram_pdf = $settings['organigram_pdf'] ?? null;

        $this->facebook = $settings['facebook'] ?? '';
        $this->twitter = $settings['twitter'] ?? '';
        $this->instagram = $settings['instagram'] ?? '';
        $this->linkedin = $settings['linkedin'] ?? '';
        $this->youtube = $settings['youtube'] ?? '';
        $this->tiktok = $settings['tiktok'] ?? '';

        $this->contact_phone = $settings['contact_phone'] ?? '';
        $this->contact_email = $settings['contact_email'] ?? '';

        $this->contact_address = $settings['contact_address'] ?? '';
        
        $this->latitude = $settings['latitude'] ?? null;
        $this->longitude = $settings['longitude'] ?? null;


    }

    private function updateSetting($key, $value)
    {
        Setting::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public function saveGeneralSettings()
    {
        $this->validate([
            'site_title' => 'required|string',
            'new_site_logo' => 'nullable|image|max:1024',
            'new_site_favicon' => 'nullable|image|max:1024',
        ]);

        if ($this->new_site_logo) {
            $this->site_logo = $this->new_site_logo->store('logos', 'public');
            $this->updateSetting('site_logo', $this->site_logo);
        }
        if ($this->new_site_favicon) {
            $this->site_favicon = $this->new_site_favicon->store('favicons', 'public');
            $this->updateSetting('site_favicon', $this->site_favicon);
        }

        $this->updateSetting('site_title', $this->site_title);
        $this->updateSetting('description', $this->description);
        $this->updateSetting('keywords', $this->keywords);
        $this->updateSetting('meta_description', $this->meta_description);

        session()->flash('generalMessage', __('Settings updated successfully!'));
    }

    public function addValue()
    {
        $this->values[] = '';
    }

    public function removeValue($index)
    {
        unset($this->values[$index]);
        $this->values = array_values($this->values);
    }

    public function saveAboutUsSettings()
    {
        $this->validate([
            'about_us_text' => 'nullable|string',
            'mission' => 'nullable|string',
            'vision' => 'nullable|string',
            'values' => 'nullable|array',
            'values.*' => 'string|max:255',
            'new_about_us_image' => 'nullable|image|max:2048',
            'organigram_pdf' => 'nullable|file|max:4096',
            'mission_image' => 'nullable|image|max:2048',
            'vision_image' => 'nullable|image|max:2048',
        ]);

        if ($this->new_about_us_image) {
            $this->about_us_image = $this->new_about_us_image->store('about_us_images', 'public');
            $this->updateSetting('about_us_image', $this->about_us_image);
        }

        if ($this->mission_image) {
            if ($this->existing_mission_image) {
                Storage::disk('public')->delete($this->existing_mission_image);
            }
            $mission_image_path = $this->mission_image->store('mission_images', 'public');
            $this->updateSetting('mission_image', $mission_image_path);
            $this->existing_mission_image = $mission_image_path;
        }

        if ($this->vision_image) {
            if ($this->existing_vision_image) {
                Storage::disk('public')->delete($this->existing_vision_image);
            }
            $vision_image_path = $this->vision_image->store('vision_images', 'public');
            $this->updateSetting('vision_image', $vision_image_path);
            $this->existing_vision_image = $vision_image_path;
        }

        if ($this->organigram_pdf) {
            if ($this->existing_organigram_pdf) {
                Storage::disk('public')->delete($this->existing_organigram_pdf);
            }
            $organigram_pdf_path  = $this->organigram_pdf->store('organigram_pdfs', 'public');
            $this->updateSetting('organigram_pdf', $organigram_pdf_path);
            $this->existing_organigram_pdf = $organigram_pdf_path;
        }

        $this->updateSetting('about_us_text', $this->about_us_text);
        $this->updateSetting('mission', $this->mission);
        $this->updateSetting('vision', $this->vision);
        $this->updateSetting('values', json_encode($this->values));

        session()->flash('aboutUsMessage', __('About Us settings updated successfully!'));
    }

    public function saveSocialMediaSettings()
    {
        $this->validate([
            'facebook' => 'nullable|string',
            'twitter' => 'nullable|string',
            'instagram' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'youtube' => 'nullable|string',
            'tiktok' => 'nullable|string',
        ]);
        $this->updateSetting('facebook', $this->facebook);
        $this->updateSetting('twitter', $this->twitter);
        $this->updateSetting('instagram', $this->instagram);
        $this->updateSetting('linkedin', $this->linkedin);
        $this->updateSetting('youtube', $this->youtube);
        $this->updateSetting('tiktok', $this->tiktok);

        session()->flash('socialMediaMessage', __('Social media settings updated successfully!'));
    }

    public function saveContactSettings()
    {
        $this->validate([
            'contact_phone' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'contact_address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);
        $this->updateSetting('contact_phone', $this->contact_phone);
        $this->updateSetting('contact_email', $this->contact_email);
        $this->updateSetting('contact_address', $this->contact_address);
        $this->updateSetting('latitude', $this->latitude);
        $this->updateSetting('longitude', $this->longitude);

        session()->flash('contactMessage', __('Contact settings updated successfully!'));
    }


    public function render()
    {
        return view('livewire.admin.settings-crud')->layout('components.layouts.admin');
    }
}
