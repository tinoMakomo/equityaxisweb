<nav class="navbar navbar-expand-lg header-categories">
    <div class="container-fluid">
        <div class="d-flex justify-content-between w-100">
            <div class="d-flex">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <a href="{{ route('category', [$category->parentModel->id, $category->parentModel->slug]) }}"
                        class="nav-link">{{ Str::upper($category->parentModel->name) }}</a>
                    <a href="{{ route('category', [$category->id, $category->slug]) }}"
                        class="nav-link active">{{ Str::upper($category->name) }}</a>
                </div>
            </div>
        </div>
    </div>
</nav>
