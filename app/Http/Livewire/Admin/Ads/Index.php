<?php

namespace App\Http\Livewire\Admin\Ads;

use App\Models\Ad;
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

        $ads = Ad::orderBy($this->orderByField, $this->orderByDirection)
            ->where('link', 'like', '%' . $this->search . '%')
            ->paginate($itemsPerPage);

        return view('livewire.admin.ads.index')->withads($ads);
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
