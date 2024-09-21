<div class="modal fade @if ($isOpen) show @endif" tabindex="-1" role="dialog"
    style="display: @if ($isOpen) block @else none @endif; background: #0000006a;" aria-modal="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{ $userId ? __('Edit User') : __('Create User') }}
                </h5>
                <button type="button" class="btn-close" wire:click="closeModal"
                    aria-label="{{ __('Close') }}"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="name">{{ __('Name') }}:</label>
                                <input type="text" wire:model="name" id="name" class="form-control">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="email">{{ __('Email') }}:</label>
                                <input type="email" wire:model="email" id="email" class="form-control">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="photo">{{ __('Photo') }}:</label>

                                @if ($photo && !is_string($photo))
                                    <div class="mb-3 text-center">
                                        <img src="{{ $photo->temporaryUrl() }}" alt="Preview" width="100">
                                    </div>
                                @elseif($userId && $photo)
                                    <div class="mb-3 text-center">
                                        <img src="{{ asset('storage/' . $photo) }}" alt="User Photo" width="100">
                                    </div>
                                @endif
                                <input type="file" wire:model="photo" id="photo" class="form-control"
                                    accept=".jpg, .jpeg, .png">
                                @error('photo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="central_phone">{{ __('Central Phone') }}:</label>
                                <input type="text" wire:model="central_phone" id="central_phone"
                                    class="form-control">
                                @error('central_phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="role">{{ __('Role') }}:</label>
                                <select wire:model="role" id="role" class="form-control">
                                    <option value="">{{ __('Select Role') }}</option>
                                    <option value="admin">{{ __('Admin') }}</option>
                                    <option value="user">{{ __('User') }}</option>
                                </select>
                                @error('role')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="status">{{ __('Status') }}:</label>
                                <select wire:model="status" id="status" class="form-control">
                                    <option value="">{{ __('Select Status') }}</option>
                                    <option value="1">{{ __('Active') }}</option>
                                    <option value="0">{{ __('Inactive') }}</option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="extension">{{ __('Extension') }}:</label>
                                <input type="text" wire:model="extension" id="extension" class="form-control">
                                @error('extension')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="organizational_unit_id">{{ __('Organizational Unit') }}:</label>
                                <div class="d-flex gap-2">
                                    <select wire:model.live="organizational_unit_id" id="organizational_unit_id"
                                        class="form-control">
                                        <option value="">{{ __('Select Organizational Unit') }}</option>
                                        @foreach ($organizationalUnits as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-secondary"
                                        wire:click="$dispatch('openOrganizationalUnitModal')">
                                        <i class="fa fa-cog"></i>
                                    </button>
                                </div>
                                @error('organizational_unit_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        @if (!empty($organizational_unit_id))
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="position_id">{{ __('Position') }}:</label>
                                    <div class="d-flex gap-2">
                                        <select wire:model="position_id" id="position_id" class="form-control">
                                            <option value="">{{ __('Select Position') }}</option>
                                            @foreach ($positions as $position)
                                                <option value="{{ $position->id }}">{{ $position->name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-secondary"
                                            wire:click="openPositionModal">
                                            <i class="fa fa-cog"></i>
                                        </button>
                                    </div>
                                    @error('position_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endif
                    </div>

                    @if (!empty($generatedPassword))
                        <div class="alert alert-info">
                            {{ __('Generated Password') }}: <strong>{{ $generatedPassword }}</strong>
                        </div>
                    @endif
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" wire:click.prevent="store()"
                    class="btn btn-primary">{{ __('Save') }}</button>
                <button type="button" wire:click="closeModal()"
                    class="btn btn-secondary">{{ __('Cancel') }}</button>
            </div>
        </div>
    </div>
</div>
