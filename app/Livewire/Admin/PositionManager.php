<?php

namespace App\Livewire\Admin;

use App\Models\Position;
use App\Models\OrganizationalUnit;
use Livewire\Component;

class PositionManager extends Component
{
    public $positions;
    public $positionId, $name, $organizationalUnitId;
    public $isEditing = false;
    public $isOpen = false;

    protected $listeners = ['open-position-modal' => 'openPositionModal'];

    public function openPositionModal($parameters = [])
    {
        $this->organizationalUnitId = $parameters['organizationalUnitId'] ?? null;
        $this->isOpen = true;
        $this->loadpositions();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }

    public function mount()
    {
        
    }

    public function loadpositions()
    {
        if ($this->organizationalUnitId) {
            $this->positions = Position::where('organizational_unit_id', $this->organizationalUnitId)->get();
        } else {
            $this->positions = Position::all();
        }
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->organizationalUnitId = '';
        $this->positionId = '';
        $this->isEditing = false;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'organizationalUnitId' => 'required|exists:organizational_units,id',
        ]);

        Position::create([
            'name' => $this->name,
            'organizational_unit_id' => $this->organizationalUnitId,
        ]);

        session()->flash('message', 'Puesto creado correctamente.');

        $this->resetInputFields();
        $this->loadpositions();
        $this->dispatch('positionUpdated');
        $this->closeModal();
    }

    public function edit($id)
    {
        $position = Position::findOrFail($id);
        $this->positionId = $id;
        $this->name = $position->name;
        $this->organizationalUnitId = $position->organizational_unit_id;
        $this->isEditing = true;
        $this->openModal();
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'organizationalUnitId' => 'required|exists:organizational_units,id',
        ]);

        $position = Position::findOrFail($this->positionId);
        $position->update([
            'name' => $this->name,
            'organizational_unit_id' => $this->organizationalUnitId,
        ]);

        session()->flash('message', 'Puesto actualizado correctamente.');

        $this->resetInputFields();
        $this->loadpositions();
        $this->dispatch('positionUpdated');
        $this->closeModal();
    }

    public function delete($id)
    {
        Position::findOrFail($id)->delete();

        session()->flash('message', 'Puesto eliminado correctamente.');
        $this->loadpositions();
        $this->dispatch('positionUpdated');
    }

    public function cancelEdit()
    {
        $this->resetInputFields();
    }

    public function render()
    {
        $organizationalUnits = OrganizationalUnit::all();

        return view('livewire.admin.position-manager', [
            'positions' => $this->positions,
            'organizationalUnits' => $organizationalUnits,
        ]);
    }
}
