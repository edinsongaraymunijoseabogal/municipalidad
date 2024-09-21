<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Post;
use App\Models\Category;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostCrud extends Component
{
    use WithFileUploads;

    public $posts, $title, $content, $featured_image, $category_id, $status = 'draft', $published_at, $post_id;
    public $isEdit = false;
    public $categories;
    public $showModal = false;
    public $confirmingDelete = false;
    public $postIdBeingDeleted = null;
    public $search = '';
    public $filterCategory = 'all';
    public $filterStatus = 'all';
    public $sortOrder = 'date_desc';
    public $type = 'post';

    protected $rules = [
        'title' => 'required|min:6',
        'content' => 'required',
        'category_id' => 'required|exists:categories,id',
        'status' => 'required|in:draft,published',
        'published_at' => 'required|date',
    ];

    public function fileSelected($image)
    {
        $this->featured_image = $image;
    }

    public function openCategoryModal()
    {
        $this->dispatch('open-category-modal', ['type' => $this->type]);
    }

    public function mount()
    {
        $this->categories = Category::where('type', $this->type)->get();
        $this->getPosts();
    }

    public function getPosts()
    {
        $query = Post::query();

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->filterCategory !== 'all') {
            $query->where('category_id', $this->filterCategory);
        }

        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        if ($this->sortOrder === 'date_asc') {
            $query->orderBy('published_at', 'asc');
        } else {
            $query->orderBy('published_at', 'desc');
        }

        $this->posts = $query->get();
    }

    public function updated($field)
    {
        $this->validateOnly($field);
        $this->getPosts();
    }

    public function resetFields()
    {
        $this->title = '';
        $this->content = '';
        $this->featured_image = '';
        $this->category_id = '';
        $this->status = 'draft';
        $this->published_at = now();
        $this->isEdit = false;
        $this->post_id = null;
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->filterCategory = 'all';
        $this->filterStatus = 'all';
        $this->sortOrder = 'date_desc';
        $this->getPosts();
    }

    public function openModal()
    {
        $this->resetFields();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function store()
    {
        $this->validate();

        if (!is_string($this->featured_image)) {
            $this->validate([
                'featured_image' => 'image|mimes:jpg,jpeg,png|max:1024',
            ]);
        }

        $post = new Post();
        $post->title = $this->title;
        $post->content = $this->content;
        $post->category_id = $this->category_id;
        $post->status = $this->status;
        $post->published_at = $this->published_at;
        $post->slug = Str::slug($this->title);

        if (!is_string($this->featured_image)) {
            $post->featured_image = $this->featured_image->store('post', 'public');
        }

        $post->save();
        session()->flash('message', 'Post creado exitosamente.');
        $this->resetFields();
        $this->getPosts();
        $this->closeModal();
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->post_id = $post->id;
        $this->title = $post->title;
        $this->content = $post->content;
        $this->featured_image = $post->featured_image;
        $this->category_id = $post->category_id;
        $this->status = $post->status;
        $this->published_at = $post->published_at;
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function confirmDelete($postId)
    {
        $this->confirmingDelete = true;
        $this->postIdBeingDeleted = $postId;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = false;
        $this->postIdBeingDeleted = null;
    }

    public function deletePost()
    {
        $post = Post::findOrFail($this->postIdBeingDeleted);

        if ($post->featured_image && Storage::exists('public/' . $post->featured_image)) {
            Storage::delete('public/' . $post->featured_image);
        }

        $post->delete();

        $this->confirmingDelete = false;
        $this->postIdBeingDeleted = null;

        $this->closeModal();

        session()->flash('message', 'Post eliminado exitosamente.');
        $this->getPosts();
    }

    public function update()
    {
        $this->validate();

        if (!is_string($this->featured_image)) {
            $this->validate([
                'featured_image' => 'image|mimes:jpg,jpeg,png|max:1024',
            ]);
        }

        $post = Post::findOrFail($this->post_id);
        $post->title = $this->title;
        $post->content = $this->content;
        $post->category_id = $this->category_id;
        $post->status = $this->status;
        $post->published_at = $this->published_at;
        $post->slug = Str::slug($this->title);

        if (!is_string($this->featured_image)) {
            $post->featured_image = $this->featured_image->store('post', 'public');
        }

        $post->save();
        session()->flash('message', 'Post actualizado exitosamente.');
        $this->resetFields();
        $this->getPosts();
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.post-crud')->layout('components.layouts.admin');
    }
}
