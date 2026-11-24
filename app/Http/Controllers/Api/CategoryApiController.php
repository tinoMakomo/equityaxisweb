<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\PostCollection;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    /**
     * GET /api/categories
     * All categories, with children eager loaded.
     */
    public function index()
    {
        $categories = Category::with('children')
            ->where('parent', 0)
            ->orWhereNull('parent')
            ->orderBy('position')
            ->get();

        return new CategoryCollection($categories);
    }

    /**
     * GET /api/categories/{id}
     * Single category with its children.
     */
    public function show($id)
    {
        $category = Category::with('children')
            ->findOrFail($id);

        return new CategoryResource($category);
    }

    /**
     * GET /api/categories/{id}/posts
     * Paginated posts belonging to a category (includes child categories).
     */
    public function posts(Request $request, $id)
    {
        $category = Category::with('children')->findOrFail($id);

        $categoryIds = $category->getSelfAndChildCategoryIds();

        $limit = min(max((int) $request->get('limit', 20), 1), 50);

        $posts = Post::with('categories', 'media')
            ->whereExists(function ($query) use ($categoryIds) {
                $query->selectRaw('1')
                    ->from('category_posts')
                    ->whereColumn('category_posts.post_id', 'posts.id')
                    ->whereIn('category_posts.category_id', $categoryIds);
            })
            ->where('posts.status', 'published')
            ->whereNotNull('posts.publish_at')
            ->orderBy('posts.id', 'desc')
            ->paginate($limit);

        return new PostCollection($posts);
    }
}
