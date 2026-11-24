<?php

namespace App\Http\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;


class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $orderByField = 'id';
    public $orderByDirection = 'desc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $itemsPerPage = auth()->user()->preferences->items_per_page;

        $categories = Category::orderBy($this->orderByField, $this->orderByDirection)
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->paginate($itemsPerPage);

        return view('livewire.admin.categories.index')->withcategories($categories);
    }

    public function changeOrderBy($field)
    {
        if ($this->orderByField == $field) {
            if ($this->orderByDirection == "desc") {
                $this->orderByDirection = "asc";
            } else {
                $this->orderByDirection = "desc";
            }
        } else {
            $this->orderByField = $field;
            $this->orderByDirection = "desc";
        }
    }
}
