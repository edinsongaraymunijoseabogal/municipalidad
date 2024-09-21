<?php

namespace App\Livewire\Web;

use Livewire\Component;
use App\Models\Video;
use App\Models\Category;

class Videos extends Component
{
    public $popularVideos;
    public $categories;
    public $featured;
    public $mostPopular;
    public $trending;

    public $search = '';
    public $selectedCategory = '';
    public $selectedYear = '';

    public function mount()
    {
        // Carga inicial de datos
        $this->categories = Category::where('type', 'video')->get();
        $this->popularVideos = Video::with('category')->published()->orderBy('views', 'desc')->limit(5)->get();
        $this->featured = Video::orderBy('published_at', 'desc')->published()->first();
        $this->mostPopular = Video::orderBy('views', 'desc')->published()->take(6)->get();
        $this->trending = Video::orderBy('published_at', 'desc')->published()->take(4)->get();
    }

    public function render()
    {
        // Filtro por búsqueda, categoría y año
        $videos = Video::with('category')
            ->published()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedCategory, function ($query) {
                $query->where('category_id', $this->selectedCategory);
            })
            ->when($this->selectedYear, function ($query) {
                $query->whereYear('published_at', $this->selectedYear);
            })
            ->orderBy('published_at', 'desc')
            ->get();

        // Extraer los años de los videos publicados
        $years = Video::selectRaw('YEAR(published_at) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('livewire.web.videos', [
            'videos' => $videos,
            'years' => $years,
        ]);
    }

    // Métodos para alternar la selección de año
    public function toggleYear($year)
    {
        if ($this->selectedYear == $year) {
            $this->selectedYear = null;
        } else {
            $this->selectedYear = $year;
        }
    }

    // Métodos para alternar la selección de categoría
    public function toggleCategory($categoryId)
    {
        if ($this->selectedCategory == $categoryId) {
            $this->selectedCategory = null;
        } else {
            $this->selectedCategory = $categoryId;
        }
    }

    // Método para reiniciar los filtros
    public function resetFilters()
    {
        $this->reset(['search', 'selectedCategory', 'selectedYear']);
    }
}
