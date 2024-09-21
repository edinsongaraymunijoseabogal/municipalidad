<?php

namespace App\Livewire\Admin;

use App\Models\OrganizationalUnit;
use Livewire\Component;

class OrganizationalUnitManager extends Component
{
    public $organizationUnits;
    public $organizationUnitId, $name;
    public $isEditing = false;
    public $isOpen = false;

    protected $listeners = ['openOrganizationalUnitModal' => 'openModal'];

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
        $this->loadOrganizationUnits();
    }

    public function loadOrganizationUnits()
    {
        $this->organizationUnits = OrganizationalUnit::all();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->organizationUnitId = '';
        $this->isEditing = false;
    }

    public function store()
    {
        $this->validate(['name' => 'required|string|max:255']);

        OrganizationalUnit::create(['name' => $this->name]);

        session()->flash('message', 'Unidad Organizacional creada correctamente.');

        $this->resetInputFields();
        $this->loadOrganizationUnits();
        $this->dispatch('organizationalUnitUpdated');
        $this->closeModal();
    }

    public function edit($id)
    {
        $organizationalUnit = OrganizationalUnit::findOrFail($id);
        $this->organizationUnitId = $id;
        $this->name = $organizationalUnit->name;
        $this->isEditing = true;
        $this->openModal();
    }

    public function update()
    {
        $this->validate(['name' => 'required|string|max:255']);

        $organizationalUnit = OrganizationalUnit::findOrFail($this->organizationUnitId);
        $organizationalUnit->update(['name' => $this->name]);

        session()->flash('message', 'Unidad Organizacional actualizada correctamente.');

        $this->resetInputFields();
        $this->loadOrganizationUnits();
        $this->dispatch('organizationalUnitUpdated');
        $this->closeModal();
    }

    public function delete($id)
    {
        OrganizationalUnit::findOrFail($id)->delete();

        session()->flash('message', 'Unidad Organizacional eliminada correctamente.');
        $this->loadOrganizationUnits();
        $this->dispatch('organizationalUnitUpdated');
    }

    public function cancelEdit()
    {
        $this->resetInputFields();
    }

    public function render()
    {
        return view('livewire.admin.organizational-unit-manager', [
            'organizationUnits' => $this->organizationUnits,
        ]);
    }
}
