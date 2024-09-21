<?php

namespace App\Livewire\Admin;

use App\Models\DocumentType;
use Livewire\Component;

class DocumentTypeManager extends Component
{
    public $documentTypes;
    public $documentTypeId, $name;
    public $isEditing = false;
    public $isOpen = false;

    protected $listeners = ['openDocumentTypeModal' => 'openModal'];

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
        $this->loadDocumentTypes();
    }
    
    public function loadDocumentTypes()
    {
        $this->documentTypes = DocumentType::all();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->documentTypeId = '';
        $this->isEditing = false;
    }

    public function store()
    {
        $this->validate(['name' => 'required|string|max:255']);
        DocumentType::create(['name' => $this->name]);
        session()->flash('message', 'Tipo de documento creado correctamente.');
        $this->resetInputFields();
        $this->loadDocumentTypes();
        $this->dispatch('documentTypeUpdated');
    }

    public function edit($id)
    {
        $documentType = DocumentType::findOrFail($id);
        $this->documentTypeId = $id;
        $this->name = $documentType->name;
        $this->isEditing = true;
        $this->openModal();
    }

    public function update()
    {
        $this->validate(['name' => 'required|string|max:255']);
        $documentType = DocumentType::findOrFail($this->documentTypeId);
        $documentType->update(['name' => $this->name]);
        session()->flash('message', 'Tipo de documento actualizado correctamente.');
        $this->resetInputFields();
        $this->loadDocumentTypes();
        $this->dispatch('documentTypeUpdated');
    }

    public function delete($id)
    {
        DocumentType::findOrFail($id)->delete();
        session()->flash('message', 'Tipo de documento eliminado correctamente.');
        $this->loadDocumentTypes();
        $this->dispatch('documentTypeUpdated');
    }

    public function cancelEdit()
    {
        $this->resetInputFields();
    }

    public function render()
    {
        return view('livewire.admin.document-type-manager', [
            'documentTypes' => $this->documentTypes,
        ]);
    }
}
