<?php

namespace App\Http\Livewire\Admin\Subscribers;

use App\Models\Subscriber;
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
        $allowedOrderFields = ['id', 'full_name', 'email', 'company', 'updated_at', 'created_at'];
        $orderByField = in_array($this->orderByField, $allowedOrderFields, true) ? $this->orderByField : 'id';
        $orderByDirection = strtolower($this->orderByDirection) === 'asc' ? 'asc' : 'desc';
        $search = trim((string) $this->search);

        $subscribers = Subscriber::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('full_name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('company', 'like', '%' . $search . '%');
                });
            })
            ->orderBy($orderByField, $orderByDirection)
            ->paginate($itemsPerPage);

        return view('livewire.admin.subscribers.index')->withsubscribers($subscribers);
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
