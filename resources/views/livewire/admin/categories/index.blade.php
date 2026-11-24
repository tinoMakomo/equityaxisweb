<div>

    <div class="card-header">
        <div class="card-tools">
            <div class="input-group input-group-sm">
                <input type="text" wire:model.debounce.500ms="search" class="form-control float-right"
                    placeholder="Search name or description">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <h3 class="card-title">
            <a class="btn btn-primary" href="{{ route('admin_categories.create') }}">
                <i class="fas fa-plus">
                </i>
                Add New Category
            </a>
        </h3>
    </div>
    <div class="card-body table-responsive p-0 ">
        <div class="loading-table" wire:loading>
            <div class="inner"><i class="fa fa-spinner fa-spin"></i></div>
        </div>
        <table class="table table-striped table-head-fixed text-nowrap">
            <thead>
                <tr>
                    <th><a class="cursor-pointer" wire:click="changeOrderBy('id')">ID
                            @if ($orderByField == 'id' && $orderByDirection == 'asc')
                                <i class="fa fa-arrow-down"></i>
                            @elseif($orderByField == 'id' && $orderByDirection == 'desc')
                                <i class="fa fa-arrow-up"></i>
                            @endif
                        </a> </th>
                    <th><a class="cursor-pointer" wire:click="changeOrderBy('name')">Name
                            @if ($orderByField == 'name' && $orderByDirection == 'asc')
                                <i class="fa fa-arrow-down"></i>
                            @elseif($orderByField == 'name' && $orderByDirection == 'desc')
                                <i class="fa fa-arrow-up"></i>
                            @endif
                    </th>
                    <th><a class="cursor-pointer" wire:click="changeOrderBy('description')">Description
                            @if ($orderByField == 'description' && $orderByDirection == 'asc')
                                <i class="fa fa-arrow-down"></i>
                            @elseif($orderByField == 'description' && $orderByDirection == 'desc')
                                <i class="fa fa-arrow-up"></i>
                            @endif
                    </th>
                    <th><a class="cursor-pointer" wire:click="changeOrderBy('parent')">Parent
                            @if ($orderByField == 'parent' && $orderByDirection == 'asc')
                                <i class="fa fa-arrow-down"></i>
                            @elseif($orderByField == 'parent' && $orderByDirection == 'desc')
                                <i class="fa fa-arrow-up"></i>
                            @endif
                    </th>
                    <th><a class="cursor-pointer" wire:click="changeOrderBy('display_in_navbar')">
                            Display In Navbar
                            @if ($orderByField == 'display_in_navbar' && $orderByDirection == 'asc')
                                <i class="fa fa-arrow-down"></i>
                            @elseif($orderByField == 'display_in_navbar' && $orderByDirection == 'desc')
                                <i class="fa fa-arrow-up"></i>
                            @endif
                    </th>
                    <th><a class="cursor-pointer" wire:click="changeOrderBy('updated_at')">Last Updated
                            @if ($orderByField == 'updated_at' && $orderByDirection == 'asc')
                                <i class="fa fa-arrow-down"></i>
                            @elseif($orderByField == 'updated_at' && $orderByDirection == 'desc')
                                <i class="fa fa-arrow-up"></i>
                            @endif
                        </a> </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td>{{ $category->getParentName() }}</td>
                        <td>{{ $category->display_in_navbar ? "Yes" : "No" }}</td>
                        <td>{{ $category->updated_at->diffForHumans() }}</td>
                        <td class="project-actions text-right">
                            <a class="btn btn-primary" href="{{ route('admin_categories.show', $category->id) }}">
                                <i class="fas fa-folder">
                                </i>
                                View
                            </a>
                            <a class="btn btn-danger btn-sm"
                                onclick="confirmDeleteOperation('{{ route('admin_categories.destroy', $category->id) }}', 'category')"
                                href="#">
                                <i class="fas fa-trash"></i>
                                Delete
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">No results found.</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $categories->links() }}
    </div>

</div>
