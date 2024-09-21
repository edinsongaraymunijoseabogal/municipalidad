<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\OrganizationalUnit;
use App\Models\Position;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class UserCrud extends Component
{
    use WithPagination, WithFileUploads;

    public $name, $email, $password, $generatedPassword, $organizational_unit_id, $position_id, $role = 'user', $status = true, $userId;
    public $central_phone, $extension, $photo;
    public $isOpen = false;
    public $positions = [];
    public $organizationalUnits;
    public $query = '';

    protected $listeners = ['organizationalUnitUpdated' => 'updateOrganizationalUnits', 'positionUpdated' => 'updatePositions'];

    public function updateOrganizationalUnits()
    {
        $this->organizationalUnits = OrganizationalUnit::all();
    }

    public function updatePositions()
    {
        $this->positions = Position::where('organizational_unit_id', $this->organizational_unit_id)->get();
    }

    public function mount()
    {
        $this->organizationalUnits = OrganizationalUnit::all();
    }

    public function updatedOrganizationalUnitId()
    {
        $this->positions = Position::where('organizational_unit_id', $this->organizational_unit_id)->get();
        $this->position_id = null;
    }

    public function render()
    {
        $users = User::query()
            ->when($this->query, function ($query) {
                return $query->where('name', 'like', '%' . $this->query . '%')
                            ->orWhere('email', 'like', '%' . $this->query . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.user-crud', [
            'users' => $users,
            'organizationalUnits' => $this->organizationalUnits,
            'positions' => $this->positions
        ])->layout('components.layouts.admin');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->generatedPassword = Str::random(8);
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->generatedPassword = '';
        $this->organizational_unit_id = '';
        $this->position_id = '';
        $this->role = 'user';
        $this->status = true;
        $this->userId = '';
        $this->central_phone = '';
        $this->extension = '';
        $this->photo = null;
        $this->positions = [];
    }

    public function store()
    {

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'password' => $this->userId ? 'nullable|min:6' : '',
            'organizational_unit_id' => 'required|exists:organizational_units,id',
            'position_id' => 'required|exists:positions,id',
            'role' => 'required|in:user,admin',
            'status' => 'required|boolean',
            'central_phone' => 'nullable|string|max:20',
            'extension' => 'nullable|string|max:10',
            'photo' => !is_string($this->photo) ? 'image|mimes:jpg,jpeg,png|max:1024' : ''
        ]);


        $userData = [
            'name' => $this->name,
            'email' => $this->email,
            'organizational_unit_id' => $this->organizational_unit_id,
            'position_id' => $this->position_id,
            'role' => $this->role,
            'status' => $this->status,
            'central_phone' => $this->central_phone,
            'extension' => $this->extension,
        ];

        if (!is_string($this->photo)) {
            $photoPath = $this->photo->store('photos', 'public');
            $userData['photo'] = $photoPath;
        }

        if (!$this->userId && $this->generatedPassword) {
            $userData['password'] = Hash::make($this->generatedPassword);
        }
        
        User::updateOrCreate(['id' => $this->userId], $userData);


        session()->flash('message', $this->userId ? 'Usuario actualizado correctamente.' : 'Usuario creado correctamente.');

        $this->closeModal();
        $this->resetInputFields();
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->organizational_unit_id = $user->organizational_unit_id;
        $this->position_id = $user->position_id;
        $this->role = $user->role;
        $this->status = $user->status;
        $this->central_phone = $user->central_phone;
        $this->extension = $user->extension;
        $this->photo = $user->photo;

        if ($this->organizational_unit_id) {
            $this->positions = Position::where('organizational_unit_id', $this->organizational_unit_id)->get();
        }
        
        $this->generatedPassword = null;

        $this->openModal();
    }

    public function delete($id)
    {
        User::find($id)->delete();
        session()->flash('message', 'Usuario eliminado correctamente.');
    }

    public function openPositionModal()
    {
        $this->dispatch('open-position-modal', ['organizationalUnitId' => $this->organizational_unit_id]);
    }
}
