<div class="modal d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5)">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $isEdit ? __('Edit Video') : __('Create Video') }}</h5>
                <button type="button" class="btn-close" wire:click="closeModal"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label">{{ __('Title') }}</label>
                                <input type="text" wire:model.defer="title" class="form-control" id="title"
                                    required>
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="editor" class="form-label">{{ __('Content') }}</label>
                                <div class="border rounded" style="min-height: 200px;" wire:ignore>
                                    <livewire:quill-text-editor wire:model.live="content" theme="bubble" />
                                </div>
                                @error('content')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="video_url" class="form-label">{{ __('Video URL') }}</label>
                                <div class="d-flex gap-2">
                                    <input type="url" wire:model.defer="video_url" class="form-control"
                                        id="video_url" required>
                                    <button type="button" class="btn btn-primary" wire:click="fetchYoutubeThumbnail">
                                        <i class="fa fa-image"></i>
                                    </button>
                                </div>
                                @error('video_url')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="featured_image" class="form-label">{{ __('Featured Image') }}</label>
                                <div class="dropzone overflow-hidden"
                                    style="border: 2px dashed #ccc; padding: 20px; text-align: center; cursor: pointer;"
                                    onclick="document.getElementById('fileInput').click();">
                                    @if ($tempImageUrl)
                                        <img class="w-100" src="{{ $tempImageUrl }}" alt="Preview"
                                            style="max-height: 200px;">
                                    @elseif ($featured_image && !is_string($featured_image))
                                        <img class="w-100" src="{{ $featured_image->temporaryUrl() }}" alt="Preview"
                                            style="max-height: 200px;">
                                    @elseif($isEdit && $featured_image)
                                        <img class="w-100" src="{{ Storage::url($featured_image) }}"
                                            alt="Existing Image" class="img-fluid rounded" style="max-height: 200px;">
                                    @else
                                        <p>{{ __('Drag & Drop an image, click to upload') }}</p>
                                    @endif
                                    <input type="file" id="fileInput" wire:model="featured_image"
                                        wire:change="changeImage" style="display: none;" accept="image/*" />
                                </div>
                                @error('featured_image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">{{ __('Category') }}</label>
                                <div class="d-flex gap-2">
                                    <select wire:model.defer="category_id" class="form-select" id="category">
                                        <option value="">{{ __('Select Category') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-secondary" wire:click="openCategoryModal">
                                        <i class="fa fa-cog"></i>
                                    </button>
                                </div>
                                @error('category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">{{ __('Status') }}</label>
                                <select wire:model.defer="status" class="form-select" id="status">
                                    <option value="draft">{{ __('Draft') }}</option>
                                    <option value="published">{{ __('Published') }}</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="published_at" class="form-label">{{ __('Published At') }}</label>
                                <input type="datetime-local" wire:model.defer="published_at" class="form-control"
                                    id="published_at">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        @if ($isEdit)
                            <button type="button" class="btn btn-danger"
                                wire:click="confirmDelete({{ $video_id }})">{{ __('Delete') }}</button>
                        @endif
                        <button type="button" class="btn btn-secondary"
                            wire:click="closeModal">{{ __('Cancel') }}</button>
                        <button type="submit"
                            class="btn btn-primary">{{ $isEdit ? __('Update') : __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@if ($confirmingDelete)
    <div class="modal d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5)">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">{{ __('Confirm Deletion') }}</h5>
                    <button type="button" class="btn-close" wire:click="cancelDelete"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Are you sure you want to delete this video? This action cannot be undone.') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-danger"
                        wire:click="deleteVideo">{{ __('Yes, Delete') }}</button>
                </div>
            </div>
        </div>
    </div>
@endif
