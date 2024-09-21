<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold leading-tight text-gray-900 mb-8">{{ __('Directory') }}</h1>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="mb-6">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between space-y-4 lg:space-y-0 gap-4">
                <div class="lg:w-1/3">
                    <label for="search"
                        class="block text-sm font-medium text-gray-700">{{ __('Search by name') }}</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <input type="text" wire:model.live="search" id="search"
                            class="block w-full pl-3 pr-10 py-2 border border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md"
                            placeholder="{{ __('Search...') }}">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fa fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/3">
                    <label for="organizationalUnit"
                        class="block text-sm font-medium text-gray-700">{{ __('Organizational Unit') }}</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <select wire:model.live="selectedOrganizationalUnit" id="organizationalUnit"
                            class="block w-full pl-3 pr-10 py-2 border border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md">
                            <option value="">{{ __('All Units') }}</option>
                            @foreach ($organizationalUnits as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="lg:w-1/3">
                    <label for="position" class="block text-sm font-medium text-gray-700">{{ __('Position') }}</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <select wire:model.live="selectedPosition" id="position"
                            class="block w-full pl-3 pr-10 py-2 border border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md">
                            <option value="">{{ __('All Positions') }}</option>
                            @foreach ($positions as $position)
                                <option value="{{ $position->id }}">{{ $position->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="lg:ml-auto lg:mt-0 mt-4">
                    <button wire:click="generatePDF"
                        class="bg-green-600 text-white p-4 rounded-lg shadow hover:bg-green-700 flex items-center transition duration-300 ease-in-out">
                        <i class="fa fa-file-pdf"></i>
                    </button>
                </div>
            </div>
        </div>

        @if ($groupedUsers->isEmpty())
            <div class="text-center py-10">
                <h3 class="text-lg font-semibold text-gray-700">{{ __('No users found.') }}</h3>
                <p class="text-gray-500">{{ __('Try changing the filters or adding new users to the directory.') }}</p>
            </div>
        @else
            @foreach ($groupedUsers as $organizationalUnit => $usersInUnit)
                <div class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ $organizationalUnit }}
                        <small class="text-gray-600">({{ $usersInUnit->count() }})</small>
                    </h2>

                    @if ($usersInUnit->isEmpty())
                        <p class="text-gray-600 italic">{{ __('No users found in this unit.') }}</p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach ($usersInUnit as $user)
                                <div
                                    class="bg-white rounded-xl border border-gray-200 shadow-lg hover:shadow-2xl transition-all duration-300 ease-in-out overflow-hidden">
                                    <div class="p-6 text-center">
                                        <div class="relative w-24 h-24 mx-auto mb-4">
                                            @if ($user->photo)
                                                <img class="w-full h-full rounded-full object-cover ring-4 ring-green-200"
                                                    src="{{ asset('storage/' . $user->photo) }}"
                                                    alt="{{ $user->name }}">
                                            @else
                                                <div
                                                    class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center ring-4 ring-gray-200">
                                                    <span class="text-2xl font-bold text-gray-600">
                                                        {{ $user->name }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <h2 class="text-xl font-bold text-gray-900">
                                            {{ $user->name }}
                                        </h2>
                                        <p class="text-sm text-gray-500 mb-2 italic">
                                            {{ $user->position->name ?? __('No position') }}
                                        </p>
                                        <div class="border-t border-gray-300 my-4"></div>
                                        <div class="flex flex-col items-center space-y-2">
                                            @if ($user->central_phone || $user->extension)
                                                <div class="flex items-center space-x-2 text-sm text-gray-700">
                                                    <i class="fa fa-phone text-green-500"></i>
                                                    @if ($user->central_phone && $user->extension)
                                                        <span>{{ __('Phone') }}: {{ $user->central_phone }}
                                                            {{ __('Ext') }}: {{ $user->extension }}</span>
                                                    @elseif ($user->central_phone)
                                                        <span>{{ __('Phone') }}: {{ $user->central_phone }}</span>
                                                    @endif
                                                </div>
                                            @endif
                                            @if ($user->email)
                                                <div class="flex items-center space-x-2 text-sm text-gray-700">
                                                    <i class="fa fa-envelope text-blue-500"></i>
                                                    <a href="mailto:{{ $user->email }}"
                                                        class="text-blue-600 hover:underline">{{ $user->email }}</a>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="mt-6">
                                            <a href="mailto:{{ $user->email }}"
                                                class="inline-block bg-green-600 text-white font-semibold px-4 py-2 rounded-full text-sm shadow hover:bg-green-700 hover:shadow-lg transition-all duration-300 ease-in-out">
                                                {{ __('Contact') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>

    @if ($pdfUrl)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold">{{ __('Directory') }}</h3>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-gray-800">&times;</button>
                </div>

                <div class="mt-4">
                    <iframe src="{{ $pdfUrl }}" class="w-full h-96" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    @endif

</div>
