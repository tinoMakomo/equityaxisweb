<?php

namespace App\View\Components\Posts;

use App\Models\Post;
use Illuminate\View\Component;

class PostTypeOne extends Component
{
    public $post;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.posts.post-type-one');
    }
}
