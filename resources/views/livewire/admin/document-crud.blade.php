<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0">
            {{ __('Showing Documents') }}
            <small class="text-muted">
                ({{ $documents->count() }} {{ __('results found') }})
            </small>
        </h5>
        <div class="d-flex align-items-center gap-2">
            @if ($filterType !== 'all')
                <span class="badge bg-primary">{{ $documentTypes->firstWhere('id', $filterType)?->name }}</span>
            @else
                <span class="badge bg-secondary">{{ __('All Document Types') }}</span>
            @endif

            <span class="badge bg-info">{{ __('Newest First') }}</span>

            <!-- Botón para limpiar filtros -->
            <button class="btn btn-light btn-sm d-flex align-items-center" wire:click="resetFilters">
                <i class="fas fa-sync-alt me-1"></i> {{ __('Reset Filters') }}
            </button>
        </div>
    </div>

    <!-- Barra de búsqueda y filtros -->
    <div class="d-flex justify-content-between mb-3">
        <div class="d-flex">
            <input type="text" class="form-control me-2" placeholder="{{ __('Search documents...') }}"
                wire:model.live="query">
            <select class="form-select me-2" wire:model.live="filterType">
                <option value="all">{{ __('All Document Types') }}</option>
                @foreach ($documentTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn app-btn-primary" wire:click="create">
            <i class="fas fa-plus"></i> {{ __('New Document') }}
        </button>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead class="table-success">
                <tr>
                    <th>{{ __('Document Type') }}</th>
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Description') }}</th>
                    <th>{{ __('PDF') }}</th>
                    <th>{{ __('Upload Date') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($documents as $document)
                    <tr>
                        <td>{{ $document->documentType->name }}</td>
                        <td>{{ $document->title }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($document->description, 120) }}</td>
                        <td>
                            @if ($document->file)
                                <a href="{{ asset('storage/' . $document->file) }}" class="btn btn-info btn-sm d-block"
                                    target="_blank">
                                    <i class="fa fa-file-pdf"></i>
                                </a>
                                <small>{{ round(Storage::size('public/' . $document->file) / 1024) }} KB</small>
                            @endif
                        </td>
                        <td>{{ $document->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <button wire:click="edit({{ $document->id }})" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button wire:click="delete({{ $document->id }})" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="text-center my-5">
                                <i class="fas fa-exclamation-circle fa-3x text-warning mb-3"></i>
                                <h4 class="text-muted">{{ __('No documents found with the selected filters.') }}</h4>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $documents->links('components.app-pagination') }}
    </div>

    @if ($isOpen)
        @include('livewire.admin.create-document')
    @endif

    <livewire:admin.document-type-manager />
</div>
