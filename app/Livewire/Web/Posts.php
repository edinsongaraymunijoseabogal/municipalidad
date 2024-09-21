<?php

namespace App\Livewire\Web;

use Livewire\Component;
use App\Models\Post;
use App\Models\Category;
use Carbon\Carbon;

class Posts extends Component
{
    public $title = "";
    public $description = "";

    public $popularPosts;
    public $categories;
    public $featured;
    public $mostPopular;
    public $trending;

    public $search = '';
    public $selectedCategory = '';
    public $selectedYear = '';

    public function mount()
    {
        $this->title = "Listado de noticias | ". app('configService')->get('site_title');
        $this->description = "Ven y descubre las últimas noticias de la institución y los eventos más recientes.";
        $this->categories = Category::where('type', 'post')->get();
        $this->popularPosts = Post::with('category')->published()->orderBy('views', 'desc')->limit(5)->get();
        $this->featured = Post::orderBy('published_at', 'desc')->published()->first();
        $this->mostPopular = Post::orderBy('views', 'desc')->published()->take(2)->get();
        $this->trending = Post::orderBy('published_at', 'desc')->published()->take(4)->get();
    }

    public function render()
    {
        $posts = Post::with('category')
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

        $years = Post::selectRaw('YEAR(published_at) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        if ($posts->isNotEmpty()) {

            $titleParts = [];

            if (!empty($this->search)) {
                $titleParts[] = 'sobre ' . $this->search;
            }

            if (!empty($this->selectedCategory)) {
                $category = Category::find($this->selectedCategory);
                if ($category) {
                    $titleParts[] = 'de ' . $category->name;
                }
            }

            if (!empty($this->selectedYear)) {
                $titleParts[] = 'del año ' . $this->selectedYear;
            }

            $titleText = implode(' ', $titleParts);

            $this->title = 'Listado de noticias ' . $titleText . ' | ' . app('configService')->get('site_title');
        }

        return view('livewire.web.posts', [
            'posts' => $posts,
            'years' => $years,
        ])->layoutData([
            'title' => $this->title,
            'description' => $this->description,
        ]);
    }


    public function toggleYear($year)
    {
        if ($this->selectedYear == $year) {
            $this->selectedYear = null;
        } else {
            $this->selectedYear = $year; 
        }
    }

    public function toggleCategory($categoryId)
    {
        if ($this->selectedCategory == $categoryId) {
            $this->selectedCategory = null;
        } else {
            $this->selectedCategory = $categoryId;
        }
    }

    public function resetFilters()
    {
        $this->reset(['search', 'selectedCategory', 'selectedYear']);
    }


}
