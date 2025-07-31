<?php

namespace App\Livewire\Modals\Components;


use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

class  InputselectBedsForChangeResident extends Component
{
    public $selected = '';
    public $search = '';
    public $options = [];
    public $isOpen = false;
    public $placeholder = 'انتخاب کنید...';
    public $model;
    public $labelField = 'name';
    public $valueField = 'id';
    public $searchFields = ['name'];
    public $limit = 10;

    protected $listeners = ['closeAllSelects' => 'close'];

    public function mount($model = null, $labelField = 'name', $valueField = 'id', $searchFields = ['name'], $placeholder = 'انتخاب کنید...', $limit = 10)
    {
        $this->model = $model;
        $this->labelField = $labelField;
        $this->valueField = $valueField;
        $this->searchFields = $searchFields;
        $this->placeholder = $placeholder;
        $this->limit = $limit;

        $this->loadOptions();
    }

    public function updatedSearch()
    {
        $this->loadOptions();
        $this->open();
    }

    public function loadOptions()
    {
        if (!$this->model) {
            return;
        }

        $query = $this->model::query();

        if (!empty($this->search)) {
            $query->where(function (Builder $q) {
                foreach ($this->searchFields as $field) {
                    if (str_contains($field, '.')) {
                        // Handle nested relationships like 'user.name'
                        $relations = explode('.', $field);
                        $column = array_pop($relations);
                        $relation = implode('.', $relations);

                        $q->orWhereHas($relation, function ($subQuery) use ($column) {
                            $subQuery->where($column, 'like', '%' . $this->search . '%');
                        });
                    } else {
                        $q->orWhere($field, 'like', '%' . $this->search . '%');
                    }
                }
            });
        }

        $this->options = $query->limit($this->limit)->get()->map(function ($item) {
            return [
                'value' => data_get($item, $this->valueField),
                'label' => data_get($item, $this->labelField),
            ];
        })->toArray();
    }

    public function selectOption($value, $label)
    {
        $this->selected = $value;
        $this->search = $label;
        $this->close();

        // Emit event for parent component
        $this->dispatch('optionSelected', $value, $label);
    }

    public function open()
    {
        $this->dispatch('closeAllSelects');
        $this->isOpen = true;
    }

    public function close()
    {
        $this->isOpen = false;
    }

    public function clearSelection()
    {
        $this->selected = '';
        $this->search = '';
        $this->loadOptions();
        $this->dispatch('optionSelected', '', '');
    }

    public function render()
    {
        return view('livewire.modals.components.inputselect-beds-for-change-resident');
    }
}
