<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold leading-tight text-gray-900 mb-8">{{ $title }}</h1>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 border p-6 bg-white shadow-lg rounded-lg">
        <!-- Filtros por Tipo de Documento -->
        <ul class="space-y-4">
            <li>
                <a href="#" wire:click.prevent="$set('selectedDocumentType', null)"
                    class="block px-4 py-2 rounded-lg text-left transition duration-300 ease-in-out
                    @if (is_null($selectedDocumentType)) bg-green-600 text-white 
                    @else bg-gray-200 text-gray-600 hover:bg-gray-300 hover:shadow-md @endif">
                    <i class="fas fa-folder-open mr-2"></i>{{ __('All Documents') }}
                </a>
            </li>
            @foreach ($documentTypes as $documentType)
                <li>
                    <a href="#" wire:click.prevent="$set('selectedDocumentType', {{ $documentType->id }})"
                        class="block px-4 py-2 rounded-lg text-left transition duration-300 ease-in-out
                        @if ($selectedDocumentType == $documentType->id) bg-green-600 text-white 
                        @else bg-gray-200 text-gray-600 hover:bg-gray-300 hover:shadow-md @endif">
                        <i class="fas fa-file-alt mr-2"></i>{{ $documentType->name }}
                    </a>
                </li>
            @endforeach
        </ul>

        <!-- Lista de Documentos -->
        <div class="lg:col-span-3">
            <div class="mb-4 flex space-x-4">
                <select wire:model.live="year"
                    class="block w-1/3 bg-white border border-gray-300 text-gray-900 py-2 px-4 rounded-lg shadow-sm focus:outline-none transition duration-300 ease-in-out">
                    <option value="">{{ __('All Years') }}</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>

                <input type="text" wire:model.live="search"
                    class="block w-full bg-white border border-gray-300 text-gray-900 py-2 px-4 rounded-lg shadow-sm focus:outline-none transition duration-300 ease-in-out"
                    placeholder="{{ __('Search by title or description...') }}">
            </div>

            @if ($documents->isEmpty())
                <div
                    class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg transition duration-300 ease-in-out">
                    <p class="font-bold"><i
                            class="fas fa-exclamation-circle mr-2"></i>{{ __('No documents available') }}</p>
                    <p>{{ __('There appear to be no documents that match your search criteria.') }}</p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6">
                    @foreach ($documents as $document)
                        <div
                            class="bg-white border border-gray-300 rounded-lg p-6 shadow-sm hover:shadow-lg transition duration-300 ease-in-out">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl font-semibold text-green-600"><i
                                        class="fas fa-file mr-2"></i>{{ $document->title }}</h2>
                                <div class="text-sm text-gray-400 flex items-center">
                                    <i class="fas fa-clock mr-1"></i>
                                    <span>{{ $document->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                            <p class="mt-2 text-gray-700">{{ Str::limit($document->description, 150) }}</p>
                            <div class="mt-4 flex justify-between items-center">
                                <button wire:click="selectDocument({{ $document->id }})"
                                    class="text-green-600 hover:text-green-800 font-medium transition duration-300 ease-in-out">
                                    <i class="fas fa-eye mr-2"></i>{{ __('View Document') }}
                                </button>
                                <div class="text-sm text-gray-500 flex items-center space-x-2">
                                    <span class="bg-gray-200 px-2 py-1 rounded"><i
                                            class="fas fa-file-alt mr-1"></i>{{ pathinfo($document->file)['extension'] }}</span>
                                    <span class="bg-gray-200 px-2 py-1 rounded"><i
                                            class="fas fa-database mr-1"></i>{{ number_format(Storage::size('public/' . $document->file) / (1024 * 1024), 1) }}
                                        MB</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    {{ $documents->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal para ver el Documento PDF -->
    @if ($selectedDocument)
        <div class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full transition duration-300 ease-in-out">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold"><i class="fas fa-file-pdf mr-2"></i>{{ $selectedDocument->title }}
                    </h3>
                    <button wire:click="closeModal"
                        class="text-gray-500 hover:text-gray-800 text-xl transition duration-300 ease-in-out">&times;</button>
                </div>
                <div class="h-96 overflow-auto">
                    <embed src="{{ Storage::url($selectedDocument->file) }}{{ $documentCacheBuster }}"
                        type="application/pdf" class="w-full h-full" />
                </div>
            </div>
        </div>
    @endif
</div>
