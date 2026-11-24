<nav class="navbar navbar-expand-lg header-categories">
    <div class="container-fluid">
        <div class="d-flex justify-content-between w-100">
            <div class="d-flex">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <a href="{{ route('category', [$category->id, $category->slug]) }}"
                        class="nav-link active">{{ Str::upper($category->name) }}</a>
                    @foreach ($category->children as $child)
                        <a href="{{ route('category', [$child->id, $child->slug]) }}"
                            class="nav-link">{{ $child->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</nav>
