<div>
    @if ($isOpen)
        <div class="modal fade show" tabindex="-1" role="dialog"
            style="display: block; background-color: rgba(0, 0, 0, 0.5);" aria-modal="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Manage Document Types') }}</h5>
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
                                <label for="name">{{ __('Document Type Name') }}:</label>
                                <div class="d-flex gap-2">
                                    <input type="text" wire:model="name" id="name" class="form-control">
                                    <div class="d-flex gap-2">
                                        @if ($isEditing)
                                            <button type="button" wire:click.prevent="update()"
                                                class="btn btn-warning">
                                                <i class="fa fa-save"></i>
                                            </button>
                                            <button type="button" wire:click="cancelEdit()" class="btn btn-secondary">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        @else
                                            <button type="button" wire:click.prevent="store()" class="btn btn-primary">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </form>

                        <hr>

                        <h5>{{ __('Document Types') }}</h5>
                        <ul class="list-group">
                            @foreach ($documentTypes as $type)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $type->name }}
                                    <div>
                                        <button wire:click="edit({{ $type->id }})" class="btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button wire:click="delete({{ $type->id }})" class="btn btn-sm btn-danger">
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
