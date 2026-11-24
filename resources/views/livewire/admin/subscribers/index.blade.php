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
                    <th><a class="cursor-pointer" wire:click="changeOrderBy('full_name')">Name
                            @if ($orderByField == 'full_name' && $orderByDirection == 'asc')
                                <i class="fa fa-arrow-down"></i>
                            @elseif($orderByField == 'full_name' && $orderByDirection == 'desc')
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
                    <th><a class="cursor-pointer" wire:click="changeOrderBy('company')">Company Name
                            @if ($orderByField == 'company' && $orderByDirection == 'asc')
                                <i class="fa fa-arrow-down"></i>
                            @elseif($orderByField == 'company' && $orderByDirection == 'desc')
                                <i class="fa fa-arrow-up"></i>
                            @endif
                    </th>
                    <th><a class="cursor-pointer">Services</th>
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
                @forelse ($subscribers as $subscriber)
                    <tr>
                        <td>{{ $subscriber->id }}</td>
                        <td>{{ $subscriber->full_name }}</td>
                        <td>{{ $subscriber->email }}</td>
                        <td>{{ $subscriber->company }}</td>
                        <td>
                            @foreach ($subscriber->getServices() as $service)
                            <span class="badge  bg-primary">{{ $service }}</span>
                            @endforeach
                            </td>
                        <td>{{ $subscriber->updated_at->diffForHumans() }}</td>
                        <td class="project-actions text-right">
                            <a class="btn btn-danger btn-sm"
                                onclick="confirmDeleteOperation('{{ route('admin_subscribers.destroy', $subscriber->id) }}', 'subscriber')"
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
        {{ $subscribers->links() }}
    </div>

</div>
