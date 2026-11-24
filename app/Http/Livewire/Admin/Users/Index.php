<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
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

        $users = User::orderBy($this->orderByField, $this->orderByDirection)
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->paginate($itemsPerPage);

        return view('livewire.admin.users.index')->withusers($users);
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
