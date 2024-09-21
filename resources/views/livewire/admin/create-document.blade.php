<div class="modal fade @if ($isOpen) show @endif" tabindex="-1" role="dialog"
    style="display: @if ($isOpen) block @else none @endif;  background: #0000006a;" aria-modal="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{ $documentId ? __('Edit Document') : __('Create Document') }}
                </h5>
                <button type="button" class="btn-close" wire:click="closeModal"
                    aria-label="{{ __('Close') }}"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group mb-3">
                        <label for="title">{{ __('Title') }}:</label>
                        <input type="text" wire:model="title" id="title" class="form-control">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">{{ __('Description') }}:</label>
                        <textarea wire:model="description" id="description" class="form-control"></textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="file">{{ __('File') }}:</label>
                        @if ($documentId && $file)
                            <div class="mb-2">
                                <a href="{{ asset('storage/' . $file) }}" target="_blank">{{ __('Current File') }}</a>
                            </div>
                        @endif
                        <input type="file" wire:model="file" id="file" class="form-control"
                            accept="application/pdf">
                        @error('file')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="d-block">
                            <small class="form-text text-muted">
                                {{ __('Maximum file size:') }} {{ $maxFileSize }} KB
                            </small>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="document_type_id">{{ __('Document Type') }}:</label>
                        <div class="d-flex gap-2">
                            <select wire:model="document_type_id" id="document_type_id" class="form-control">
                                <option value="">{{ __('Select a type') }}</option>
                                @foreach ($documentTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-secondary"
                                wire:click="$dispatch('openDocumentTypeModal')">
                                <i class="fa fa-cog"></i>
                            </button>
                        </div>
                        @error('document_type_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="store()"
                    class="btn btn-primary">{{ __('Save') }}</button>
                <button type="button" wire:click="closeModal()" class="btn btn-secondary">{{ __('Cancel') }}</button>
            </div>
        </div>
    </div>

</div>
