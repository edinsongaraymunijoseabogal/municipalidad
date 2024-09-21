<div>
    @if ($isOpen)
        <!-- Modal para CRUD de categorías -->
        <div class="modal fade show" tabindex="-1" role="dialog" style="display: block; background: #0000008a;"
            aria-modal="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Manage Categories') }}</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"
                            aria-label="{{ __('Close') }}"></button>
                    </div>
                    <div class="modal-body">
                        @if (session()->has('message'))
                            <div class="alert alert-success" role="alert">
                                <i class="fa fa-check-circle"></i> {{ session('message') }}
                            </div>
                        @endif

                        <form>
                            <div class="form-group mb-3">
                                <label for="name">{{ __('Category Name') }}:</label>
                                <input type="text" wire:model="name" id="name" class="form-control">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-flex gap-2">
                                @if ($isEditing)
                                    <button type="button" wire:click.prevent="update()"
                                        class="btn btn-warning">{{ __('Update Category') }}</button>
                                    <button type="button" wire:click="resetInputFields()"
                                        class="btn btn-secondary">{{ __('Cancel') }}</button>
                                @else
                                    <button type="button" wire:click.prevent="store()"
                                        class="btn btn-primary">{{ __('Add Category') }}</button>
                                @endif
                            </div>
                        </form>

                        <hr>

                        <h5>{{ __('Categories') }}</h5>
                        <ul class="list-group">
                            @foreach ($categories as $category)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $category->name }}
                                    <div>
                                        <button wire:click="edit({{ $category->id }})" class="btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button wire:click="delete({{ $category->id }})" class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>
