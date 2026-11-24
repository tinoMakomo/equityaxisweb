<div>

    <div class="card-header">
        <div class="card-tools">
            <div class="input-group input-group-sm">
                <input type="text" wire:model.debounce.500ms="search" class="form-control float-right"
                    placeholder="Search name or email">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <h3 class="card-title">
            <a class="btn btn-primary" href="{{ route('admin_users.create') }}">
                <i class="fas fa-plus">
                </i>
                Add New User
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
                    <th><a class="cursor-pointer" wire:click="changeOrderBy('email')">Email
                            @if ($orderByField == 'email' && $orderByDirection == 'asc')
                                <i class="fa fa-arrow-down"></i>
                            @elseif($orderByField == 'email' && $orderByDirection == 'desc')
                                <i class="fa fa-arrow-up"></i>
                            @endif
                    </th>
                    <th><a class="cursor-pointer" wire:click="changeOrderBy('user_type_id')">Type
                            @if ($orderByField == 'user_type_id' && $orderByDirection == 'asc')
                                <i class="fa fa-arrow-down"></i>
                            @elseif($orderByField == 'user_type_id' && $orderByDirection == 'desc')
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
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ optional($user->userType)->name ?? '—' }}</td>
                        <td>{{ $user->updated_at->diffForHumans() }}</td>
                        <td class="project-actions text-right">
                            <a class="btn btn-primary" href="{{ route('admin_users.show', $user->id) }}">
                                <i class="fas fa-folder">
                                </i>
                                View
                            </a>
                            <a class="btn btn-danger btn-sm"
                                onclick="confirmDeleteOperation('{{ route('admin_users.destroy', $user->id) }}', 'user')"
                                href="#">
                                <i class="fas fa-trash">
                                </i>
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
        {{ $users->links() }}
    </div>

</div>
