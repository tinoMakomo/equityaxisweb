<nav class="sidebar">
    <div class="sidebar-header">
        <h1>
            EQUITY AXIS
            <a href="#" class="side-bar-toggle close"></a>
        </h1>
        <small>Financial Insights at your Finger Tips</small>
    </div>
    <div class="sidebar-sub-header">
        <h5>Top Sections</h5>
    </div>
    <ul class="main_side">
        <li class="active"><a class="parent-link" href="/">Home</a></li>
        @foreach ($parentCategories as $parent)
            @if ($parent->hasChildren())
                <li>
                    <a class="parent-link" href="{{ route('category', [$parent->id, $parent->slug]) }}">
                        {{ $parent->name }}</a>
                    <a data-bs-toggle="collapse" href="#sb-{{ $parent->slug }}" role="button" aria-expanded="false"
                        aria-controls="{{ $parent->slug }}" class="fa fa-angle-down side-bar-category-toggle"
                        aria-hidden="true"></a>
                    <ul class="collapse" id="sb-{{ $parent->slug }}">
                        @foreach ($parent->children as $child)
                            <li>
                                <a href="{{ route('category', [$child->id, $child->slug]) }}">{{ $child->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @else
                <li>
                    <a class="parent-link {{ Str::contains(Request::url(), 'category/' . $parent->id) ? 'active' : '' }}"
                        href="{{ route('category', [$parent->id, $parent->slug]) }}">{{ $parent->name }}</a>
                </li>
            @endif
        @endforeach
    </ul>
    <div class="sidebar-sub-header">
        <h5>Tools & Resources</h5>
    </div>
    <ul class="main_side">
        <li><a class="parent-link" href="#">Stock Street</a></li>
        <li><a class="parent-link" href="#">The Axis</a></li>
    </ul>
</nav>
