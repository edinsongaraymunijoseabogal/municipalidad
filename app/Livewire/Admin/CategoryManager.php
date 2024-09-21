<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;

class CategoryManager extends Component
{
    public $categories;
    public $categoryId, $name;
    public $isEditing = false;
    public $isOpen = false;
    public $type;

    protected $listeners = ['open-category-modal' => 'openModal'];

    public function openModal($parameters = [])
    {
        $this->type = $parameters['type'] ?? '';
        $this->isOpen = true;
        $this->loadCategories();
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }

    public function mount()
    {
        $this->loadCategories();
    }
    
    public function loadCategories()
    {
        $this->categories = Category::where('type', $this->type)->get();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->categoryId = '';
        $this->isEditing = false;
    }

    public function store()
    {
        $this->validate(['name' => 'required']);
        Category::create(['name' => $this->name, 'type' => $this->type]);
        session()->flash('message', 'Categoría creada correctamente.');
        $this->resetInputFields();
        $this->loadCategories();
        $this->dispatch('categoryUpdated');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $id;
        $this->name = $category->name;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate(['name' => 'required']);
        $category = Category::findOrFail($this->categoryId);
        $category->update(['name' => $this->name, 'type' => $this->type]);
        session()->flash('message', 'Categoría actualizada correctamente.');
        $this->resetInputFields();
        $this->loadCategories();
        $this->dispatch('categoryUpdated');
    }

    public function delete($id)
    {
        Category::find($id)->delete();
        session()->flash('message', 'Categoría eliminada correctamente.');
        $this->loadCategories();
        $this->dispatch('categoryUpdated');
    }

    public function render()
    {
        return view('livewire.admin.category-manager', [
            'categories' => $this->categories,
        ]);
    }
}
