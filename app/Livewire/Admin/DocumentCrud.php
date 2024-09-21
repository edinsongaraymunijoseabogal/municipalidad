<?php

namespace App\Livewire\Admin;

use App\Models\Document;
use App\Models\DocumentType;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class DocumentCrud extends Component
{
    use WithFileUploads, WithPagination;

    public $title, $description, $file, $document_type_id, $documentId, $documentTypes;
    public $isOpen = false;
    public $maxFileSize = 5000;
    public $query = '';
    public $filterType = 'all';

    public function mount()
    {
        $this->documentTypes = DocumentType::all();
    }

    protected $listeners = ['documentTypeUpdated' => 'updateDocumentTypes'];

    public function updateDocumentTypes()
    {
        $this->documentTypes = DocumentType::all();
    }

    public function updatingQuery()
    {
        $this->resetPage();
    }

    public function updatingFilterType()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->query = '';
        $this->filterType = 'all';
        $this->resetPage();
    }

    public function render()
    {
        $documents = Document::query()
            ->when($this->query, function ($query) {
                return $query->where('title', 'like', '%' . $this->query . '%')
                            ->orWhere('description', 'like', '%' . $this->query . '%');
            })
            ->when($this->filterType != 'all', function ($query) {
                return $query->where('document_type_id', $this->filterType);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.document-crud', [
            'documents' => $documents,
            'documentTypes' => $this->documentTypes
        ])->layout('components.layouts.admin');
    }

    public function create()
    {
        $this->resetInputFields();
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
        $this->title = '';
        $this->description = '';
        $this->file = '';
        $this->document_type_id = '';
        $this->documentId = '';
    }

    public function store()
    {
        $this->validate([
            'title' => __('required'),
            'description' => __('required'),
            'file' => __('required|file|max:') . $this->maxFileSize,
            'document_type_id' => __('required')
        ]);

        $fileName = $this->file->getClientOriginalName();
        $filePath = $this->file->storeAs('documents', $fileName, 'public');

        Document::updateOrCreate(['id' => $this->documentId], [
            'title' => $this->title,
            'description' => $this->description,
            'file' => $filePath,
            'document_type_id' => $this->document_type_id
        ]);

        session()->flash('message', $this->documentId ? __('Document updated successfully.') : __('Document created successfully.'));

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $document = Document::findOrFail($id);
        $this->documentId = $id;
        $this->title = $document->title;
        $this->description = $document->description;
        $this->file = $document->file;
        $this->document_type_id = $document->document_type_id;
        $this->openModal();
    }

    public function delete($id)
    {
        Document::find($id)->delete();
        session()->flash('message', __('Document deleted successfully.'));
    }
}
