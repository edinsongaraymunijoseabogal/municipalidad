<?php

namespace App\Livewire\Web;

use Livewire\Component;
use App\Models\User;
use App\Models\OrganizationalUnit;
use App\Models\Position;
use PDF;
use Storage;

class Directory extends Component
{
    public $title = "";
    public $description = "";

    public $search = '';
    public $selectedOrganizationalUnit = null;
    public $selectedPosition = null;

    public $organizationalUnits = [];
    public $positions = [];

    public $pdfUrl = null;

    public function mount()
    {
        $this->title = "Directorio de Personal | ". app('configService')->get('site_title');
        
        $this->organizationalUnits = OrganizationalUnit::all();
        $this->positions = Position::all();
    }

    public function render()
    {
        $users = User::with(['position', 'organizational_unit'])
            ->where('status', 1)
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhereHas('organizational_unit', function ($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
            })
            ->when($this->selectedOrganizationalUnit, function ($query) {
                $query->where('organizational_unit_id', $this->selectedOrganizationalUnit);
            })
            ->when($this->selectedPosition, function ($query) {
                $query->where('position_id', $this->selectedPosition);
            })
            ->orderBy('organizational_unit_id')
            ->get();

        $groupedUsers = $users->groupBy('organizational_unit.name');

        return view('livewire.web.directory', [
            'groupedUsers' => $groupedUsers,
        ])->layoutData([
            'title' => $this->title
        ]);
    }

    public function generatePDF()
    {
        $users = User::with(['position', 'organizational_unit'])
            ->where('status', 1)
            ->orderBy('organizational_unit_id')
            ->get();

        $groupedUsers = $users->groupBy('organizational_unit.name');

        $pdf = PDF::loadView('pdf.directory', ['groupedUsers' => $groupedUsers]);

        $fileName = 'directory_' . time() . '.pdf';
        Storage::put('public/temp/' . $fileName, $pdf->output());

        $this->pdfUrl = Storage::url('public/temp/' . $fileName);
    }

    public function closeModal()
    {
        $this->pdfUrl = null;
    }

}
