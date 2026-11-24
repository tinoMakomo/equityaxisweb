<div>

    <div class="card-header">
        <div class="card-tools">
            <div class="input-group input-group-sm">
                <input type="text" wire:model.debounce.500ms="search" class="form-control float-right"
                    placeholder="Search title or author">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <h3 class="card-title">
            <a class="btn btn-primary" href="{{ route('admin_posts.create') }}">
                <i class="fas fa-plus">
                </i>
                Create New Post
            </a>
            <a class="btn btn-primary" href="{{ route('admin_posts.index') }}">
                <i class="fas fa-trash">
                </i>
                View Posts List
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
                        </a></th>
                    <th><a class="cursor-pointer" wire:click="changeOrderBy('title')">Title
                            @if ($orderByField == 'title' && $orderByDirection == 'asc')
                                <i class="fa fa-arrow-down"></i>
                            @elseif($orderByField == 'title' && $orderByDirection == 'desc')
                                <i class="fa fa-arrow-up"></i>
                            @endif
                        </a></th>
                    <th><a class="cursor-pointer" wire:click="changeOrderBy('user_id')">Author
                            @if ($orderByField == 'user_id' && $orderByDirection == 'asc')
                                <i class="fa fa-arrow-down"></i>
                            @elseif($orderByField == 'user_id' && $orderByDirection == 'desc')
                                <i class="fa fa-arrow-up"></i>
                            @endif
                        </a></th>
                    <th><a class="cursor-pointer" wire:click="changeOrderBy('status')">Status
                            @if ($orderByField == 'status' && $orderByDirection == 'asc')
                                <i class="fa fa-arrow-down"></i>
                            @elseif($orderByField == 'status' && $orderByDirection == 'desc')
                                <i class="fa fa-arrow-up"></i>
                            @endif
                        </a></th>
                    <th><a class="cursor-pointer" wire:click="changeOrderBy('updated_at')">Last Updated
                            @if ($orderByField == 'updated_at' && $orderByDirection == 'asc')
                                <i class="fa fa-arrow-down"></i>
                            @elseif($orderByField == 'updated_at' && $orderByDirection == 'desc')
                                <i class="fa fa-arrow-up"></i>
                            @endif
                        </a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ Str::limit($post->title, 50) }}</td>
                        <td>{{ optional($post->user)->name ?? 'Unknown' }}</td>
                        <td>{{ $post->getStatus() }}</td>
                        <td>{{ $post->updated_at->diffForHumans() }}</td>
                        <td class="project-actions text-right">
                            <a class="btn btn-primary" href="{{ route('admin_posts.show', $post->id) }}">
                                <i class="fas fa-folder">
                                </i>
                                View
                            </a>
                            <a class="btn btn-success btn-sm"
                                onclick="confirmRestoreOperation('{{ route('admin_posts.restore', $post->id) }}', 'post')"
                                href="#">
                                <i class="fas fa-recycle">
                                </i>
                                Restore
                            </a>
                            <a class="btn btn-danger btn-sm"
                                onclick="confirmForceDeleteOperation('{{ route('admin_posts.force_delete', $post->id) }}', 'post')"
                                href="#">
                                <i class="fas fa-trash">
                                </i>
                                Delete Permanently
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
        {{ $posts->links() }}
    </div>

</div>
