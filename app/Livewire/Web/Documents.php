<?php

namespace App\Livewire\Web;

use Livewire\Component;
use App\Models\Document;
use App\Models\DocumentType;

class Documents extends Component
{
    public $title = "Documentos";
    public $description = "Listado de documentos y portal de transparencia del sitio web.";
    
    public $selectedDocumentType = null;
    public $documentTypes = [];
    public $search = '';
    public $years = [];
    public $selectedDocument = null;
    public $year = null;
    public $documentCacheBuster = '';

    public function mount()
    {
        $this->documentTypes = DocumentType::all();
        $this->years = Document::selectRaw('YEAR(created_at) as year')->distinct()->pluck('year');
    }

    public function selectDocument($documentId)
    {
        $this->selectedDocument = Document::find($documentId);
        $this->documentCacheBuster = '?v=' . time();
    }

    public function closeModal()
    {
        $this->selectedDocument = null;
    }

    public function updatedSelectedDocumentType()
    {
        $this->resetDocumentSelection();
    }

    public function updatedYear()
    {
        $this->resetDocumentSelection();
    }

    public function updatedSearch()
    {
        $this->resetDocumentSelection();
    }

    protected function resetDocumentSelection()
    {
        $this->selectedDocument = null;
        $this->documentCacheBuster = '';
    }

    public function render()
    {
        $documents = Document::query()
            ->when($this->selectedDocumentType, function ($query) {
                return $query->where('document_type_id', $this->selectedDocumentType);
            })
            ->when($this->search, function ($query) {
                return $query->where('title', 'like', '%' . $this->search . '%')
                            ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->year, function ($query) {
                return $query->whereYear('created_at', $this->year);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.web.documents', [
            'documents' => $documents,
        ])->layoutData([
            'title' => $this->title . ' | ' . app('configService')->get('site_title'),
            'description' => $this->description,
        ]);
    }
}
