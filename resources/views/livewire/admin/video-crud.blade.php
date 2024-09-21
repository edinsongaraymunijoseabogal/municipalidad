<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0">
            {{ __('Showing videos') }}
            <small class="text-muted">
                ({{ $videos->count() }} {{ __('results found') }})
            </small>
        </h5>
        <div class="d-flex align-items-center gap-2">
            @if ($filterCategory !== 'all')
                <span class="badge bg-primary">{{ $categories->firstWhere('id', $filterCategory)?->name }}</span>
            @else
                <span class="badge bg-secondary">{{ __('All Categories') }}</span>
            @endif

            <span
                class="badge bg-info">{{ ucfirst($filterStatus === 'all' ? __('All Statuses') : __(ucfirst($filterStatus))) }}</span>
            <span
                class="badge bg-warning">{{ ucfirst($sortOrder === 'date_desc' ? __('Newest First') : __('Oldest First')) }}</span>

            <!-- Botón para limpiar filtros -->
            <button class="btn btn-light btn-sm d-flex align-items-center" wire:click="resetFilters">
                <i class="fas fa-sync-alt me-1"></i> {{ __('Reset Filters') }}
            </button>
        </div>
    </div>

    <!-- Barra de búsqueda y filtros -->
    <div class="d-flex justify-content-between mb-3">
        <div class="d-flex">
            <input type="text" class="form-control me-2" placeholder="{{ __('Search videos...') }}"
                wire:model.live="search">
            <select class="form-select me-2" wire:model.live="filterCategory">
                <option value="all">{{ __('All Categories') }}</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <select class="form-select me-2" wire:model.live="filterStatus">
                <option value="all">{{ __('All Statuses') }}</option>
                <option value="published">{{ __('Published') }}</option>
                <option value="draft">{{ __('Draft') }}</option>
            </select>
            <select class="form-select" wire:model.live="sortOrder">
                <option value="date_desc">{{ __('Newest First') }}</option>
                <option value="date_asc">{{ __('Oldest First') }}</option>
            </select>
        </div>
        <button class="btn app-btn-primary" wire:click="openModal">
            <i class="fas fa-plus"></i> {{ __('New Video') }}
        </button>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="row g-4">
        @forelse ($videos as $video)
            <div class="col-6 col-md-4 col-xl-3">
                <div class="app-card app-card-doc shadow-sm h-100" role="button"
                    wire:click="edit({{ $video->id }})">
                    <div class="app-card-thumb-holder p-3">
                        @if ($video->featured_image)
                            <div class="app-card-thumb">
                                <img class="thumb-image" src="{{ Storage::url($video->featured_image) }}"
                                    alt="{{ $video->title }}">
                            </div>
                        @else
                            <i class="fas fa-video text-file"></i>
                        @endif
                        <span class="badge {{ $video->status === 'published' ? 'bg-success' : 'bg-warning' }}">
                            {{ $video->status === 'published' ? __('Published') : __('Draft') }}
                        </span>
                    </div>
                    <div class="app-card-body p-3 has-card-actions">
                        <h4 class="app-doc-title truncate mb-0">{{ $video->title }}</h4>
                        <div class="app-doc-meta">
                            <ul class="list-unstyled mb-0">
                                <li><span class="text-muted">{{ __('Category') }}:</span> {{ $video->category->name }}
                                </li>
                                <li><span class="text-muted">{{ __('Published') }}:</span>
                                    {{ \Carbon\Carbon::parse($video->published_at)->diffForHumans() }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center my-5">
                <i class="fas fa-exclamation-circle fa-3x text-warning mb-3"></i>
                <h4 class="text-muted">{{ __('No videos found with the selected filters.') }}</h4>
            </div>
        @endforelse
    </div>

    @if ($showModal)
        @include('livewire.admin.manage-video')
    @endif

    <livewire:admin.category-manager />
</div>
