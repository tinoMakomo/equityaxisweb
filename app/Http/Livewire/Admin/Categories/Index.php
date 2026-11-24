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
        $itemsPerPage = optional(auth()->user()->preferences)->items_per_page ?? 15;
        $allowedOrderFields = ['id', 'name', 'description', 'parent', 'display_in_navbar', 'updated_at'];
        $orderByField = in_array($this->orderByField, $allowedOrderFields, true) ? $this->orderByField : 'id';
        $orderByDirection = strtolower($this->orderByDirection) === 'asc' ? 'asc' : 'desc';
        $search = trim((string) $this->search);

        $categories = Category::with('parentModel:id,name')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');
                });
            })
            ->orderBy($orderByField, $orderByDirection)
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
