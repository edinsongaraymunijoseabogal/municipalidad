<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Post;
use App\Models\Video;
use App\Models\User;
use App\Models\Document;

class Dashboard extends Component
{
    public $totalNoticias;
    public $totalVideos;
    public $totalUsuarios;
    public $totalDocumentos;

    public function mount()
    {
        $this->totalNoticias = Post::count();
        $this->totalVideos = Video::count();
        $this->totalUsuarios = User::count();
        $this->totalDocumentos = Document::count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard')
            ->layout('components.layouts.admin');
    }
}
