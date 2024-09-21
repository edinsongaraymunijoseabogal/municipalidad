<div class="app-content pt-3 p-md-3 p-lg-4">

    @if ($isOpen)
        @include('livewire.admin.create-user')
    @endif

    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">{{ __('Users') }}</h1>
            </div>

            <div class="col-auto">
                <div class="page-utilities">
                    <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                        <div class="col-auto">
                            <form class="row gx-1 align-items-center">
                                <div class="col-auto">
                                    <input type="text" wire:model.live="query" class="form-control search-docs"
                                        placeholder="{{ __('Search...') }}">
                                </div>
                            </form>
                        </div>
                        <div class="col-auto">
                            <button wire:click="create()" class="btn btn-primary">
                                <i class="fa fa-plus"></i> {{ __('New User') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($users && $users->count() > 0)
            <div class="row g-4">

                @if (session()->has('message'))
                    <div class="alert alert-success" role="alert">
                        <i class="fa fa-check-circle"></i> {{ session('message') }}
                    </div>
                @endif

                <table class="table table-hover table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th>{{ __('Photo') }}</th>
                            <th>{{ __('User Info') }}</th>
                            <th>{{ __('Work Info') }}</th>
                            <th>{{ __('Contact Info') }}</th>
                            <th>{{ __('Role') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    @if ($user->photo)
                                        <img src="{{ asset('storage/' . $user->photo) }}" alt="User Photo"
                                            class="rounded-circle" width="50" height="50">
                                    @else
                                        <img src="{{ asset('images/default-user.png') }}" alt="Default User"
                                            class="rounded-circle" width="50" height="50">
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $user->name }}</strong><br>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </td>
                                <td>
                                    <strong>{{ $user->organizational_unit->name }}</strong><br>
                                    <small class="text-muted">{{ $user->position->name }}</small>
                                </td>
                                <td>
                                    <strong>{{ $user->central_phone }}</strong><br>
                                    <small>{{ __('Ext') }}: {{ $user->extension }}</small>
                                </td>
                                <td>{{ ucfirst($user->role) }}</td>
                                <td>
                                    <span class="badge bg-{{ $user->status ? 'success' : 'danger' }}">
                                        {{ $user->status ? __('Active') : __('Inactive') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <button wire:click="edit({{ $user->id }})" class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button wire:click="delete({{ $user->id }})"
                                            onclick="confirm('{{ __('Are you sure you want to delete this user?') }}') || event.stopImmediatePropagation()"
                                            class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $users->links('components.app-pagination') }}
                </div>
            </div>
        @else
            <div class="alert alert-info text-center" role="alert">
                <i class="fa fa-info-circle"></i> {{ __('No users found.') }}
            </div>
        @endif
    </div>

    <livewire:admin.organizational-unit-manager />
    <livewire:admin.position-manager />

</div>
