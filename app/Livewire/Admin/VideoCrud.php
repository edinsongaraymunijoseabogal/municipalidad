<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Video;
use App\Models\Category;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class VideoCrud extends Component
{
    use WithFileUploads;

    public $videos, $title, $content, $video_url, $featured_image, $category_id, $status = 'draft', $published_at, $video_id;
    public $isEdit = false;
    public $categories;
    public $showModal = false;
    public $confirmingDelete = false;
    public $videoIdBeingDeleted = null;
    public $search = '';
    public $filterCategory = 'all';
    public $filterStatus = 'all';
    public $sortOrder = 'date_desc';
    public $type = 'video';
    public $tempImageUrl = null;

    protected $rules = [
        'title' => 'required|min:6',
        'content' => 'required',
        'video_url' => 'required|url',
        'category_id' => 'required|exists:categories,id',
        'status' => 'required|in:draft,published',
        'published_at' => 'required|date',
    ];

    public function getYoutubeVideoId($url)
    {
        preg_match('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|embed|watch)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $matches);
        return $matches[1] ?? null;
    }

    public function fetchYoutubeThumbnail()
    {
        $videoId = $this->getYoutubeVideoId($this->video_url);
        
        if ($videoId) {
            $highResUrl = "https://i.ytimg.com/vi/{$videoId}/maxresdefault.jpg";
            $standardResUrl = "https://i.ytimg.com/vi/{$videoId}/hqdefault.jpg";

            $headers = get_headers($highResUrl, 1);

            if (strpos($headers[0], '200') !== false) {
                $this->tempImageUrl = $highResUrl;
            } else {
                $headers = get_headers($standardResUrl, 1);
                if (strpos($headers[0], '200') !== false) {
                    $this->tempImageUrl = $standardResUrl;
                } else {
                    session()->flash('error', __('Unable to fetch thumbnail from YouTube.'));
                }
            }
        } else {
            session()->flash('error', __('Invalid YouTube URL'));
        }
    }

    protected $listeners = ['categoryUpdated' => 'updateCategories'];

    public function updateCategories()
    {
        $this->categories = Category::where('type', $this->type)->get();
    }

    public function changeImage()
    {
        $this->tempImageUrl = null;
    }

    public function mount()
    {
        $this->categories = Category::where('type', $this->type)->get();
        $this->getVideos();
    }

    public function getVideos()
    {
        $query = Video::query();

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

        $this->videos = $query->get();
    }

    public function updated($field)
    {
        $this->validateOnly($field);
        $this->getVideos();
    }

    public function resetFields()
    {
        $this->title = '';
        $this->content = '';
        $this->video_url = '';
        $this->featured_image = '';
        $this->category_id = '';
        $this->status = 'draft';
        $this->published_at = now();
        $this->isEdit = false;
        $this->video_id = null;
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->filterCategory = 'all';
        $this->filterStatus = 'all';
        $this->sortOrder = 'date_desc';
        $this->getVideos(); 
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

        if (!is_string($this->featured_image) && $this->featured_image) {
            $this->validate([
                'featured_image' => 'image|mimes:jpg,jpeg,png|max:1024',
            ]);
        }

        $video = new Video();
        $video->title = $this->title;
        $video->content = $this->content;
        $video->video_url = $this->video_url;
        $video->category_id = $this->category_id;
        $video->status = $this->status;
        $video->published_at = $this->published_at;

        if (!is_string($this->featured_image) && $this->featured_image) {
            $video->featured_image = $this->featured_image->store('videos', 'public');
        } elseif ($this->tempImageUrl) {
            try {
                $headers = get_headers($this->tempImageUrl, 1);
                
                if (strpos($headers[0], '200') !== false) {
                    $imageContents = file_get_contents($this->tempImageUrl);
                    $imageName = 'videos/' . uniqid() . '.jpg';
                    Storage::put('public/' . $imageName, $imageContents);
                    $video->featured_image = $imageName;
                } else {
                    session()->flash('error', __('Failed to download image from URL.'));
                }
            } catch (\Exception $e) {
                session()->flash('error', __('Error downloading the image: ') . $e->getMessage());
            }
        }

        $video->save();
        session()->flash('message', __('Video created successfully.'));
        $this->resetFields();
        $this->getVideos();
        $this->closeModal();
    }

    public function openCategoryModal()
    {
        $this->dispatch('open-category-modal', ['type' => $this->type]);
    }

    public function edit($id)
    {
        $video = Video::findOrFail($id);
        $this->video_id = $video->id;
        $this->title = $video->title;
        $this->content = $video->content;
        $this->video_url = $video->video_url;
        $this->featured_image = $video->featured_image;
        $this->category_id = $video->category_id;
        $this->status = $video->status;
        $this->published_at = $video->published_at;
        $this->tempImageUrl = null;
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function confirmDelete($videoId)
    {
        $this->confirmingDelete = true;
        $this->videoIdBeingDeleted = $videoId;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = false;
        $this->videoIdBeingDeleted = null;
    }

    public function deleteVideo()
    {
        $video = Video::findOrFail($this->videoIdBeingDeleted);

        if ($video->featured_image && Storage::exists('public/' . $video->featured_image)) {
            Storage::delete('public/' . $video->featured_image);
        }

        $video->delete();

        $this->confirmingDelete = false;
        $this->videoIdBeingDeleted = null;

        $this->closeModal();

        session()->flash('message', __('Video deleted successfully.'));
        $this->getVideos();
    }

    public function update()
    {
        $this->validate();

        if (!is_string($this->featured_image) && $this->featured_image) {
            $this->validate([
                'featured_image' => 'image|mimes:jpg,jpeg,png|max:1024',
            ]);
        }

        $video = Video::findOrFail($this->video_id);
        $video->title = $this->title;
        $video->content = $this->content;
        $video->video_url = $this->video_url;
        $video->category_id = $this->category_id;
        $video->status = $this->status;
        $video->published_at = $this->published_at;

        if (!is_string($this->featured_image) && $this->featured_image) {
            $video->featured_image = $this->featured_image->store('videos', 'public');
        } elseif ($this->tempImageUrl) {
            try {
                $headers = get_headers($this->tempImageUrl, 1);
                
                if (strpos($headers[0], '200') !== false) {
                    $imageContents = file_get_contents($this->tempImageUrl);
                    $imageName = 'videos/' . uniqid() . '.jpg';
                    Storage::put('public/' . $imageName, $imageContents);
                    $video->featured_image = $imageName;
                } else {
                    session()->flash('error', __('Failed to download image from URL.'));
                }
            } catch (\Exception $e) {
                session()->flash('error', __('Error downloading the image: ') . $e->getMessage());
            }
        }

        $video->save();
        session()->flash('message', __('Video updated successfully.'));
        $this->resetFields();
        $this->getVideos();
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.video-crud')->layout('components.layouts.admin');
    }
}
