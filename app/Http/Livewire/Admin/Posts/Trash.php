<?php

namespace App\Http\Livewire\Admin\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;


class Trash extends Component
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
        $allowedOrderFields = ['id', 'title', 'status', 'updated_at', 'created_at'];
        $orderByField = in_array($this->orderByField, $allowedOrderFields, true) ? $this->orderByField : 'id';
        $orderByDirection = strtolower($this->orderByDirection) === 'asc' ? 'asc' : 'desc';
        $search = trim((string) $this->search);

        $query = Post::onlyTrashed()->with('user')->orderBy($orderByField, $orderByDirection);

        if (auth()->user()->isAuthor()) {
            $query->where('user_id', auth()->user()->id)
                ->when($search !== '', function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%');
                });
        } else {
            $query->when($search !== '', function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('title', 'like', '%' . $search . '%')
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', '%' . $search . '%');
                        });
                });
            });
        }

        $posts = $query->paginate($itemsPerPage);

        return view('livewire.admin.posts.trash')->withposts($posts);
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
