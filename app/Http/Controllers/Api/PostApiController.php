<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;
use App\Models\Post;
use Illuminate\Http\Request;

class PostApiController extends Controller
{
    /**
     * GET /api/posts
     * Paginated list of published posts, newest first.
     * Optional filters: ?category=2 &tag=mining &editors_pick=1
     */
    public function index(Request $request)
    {
        $query = Post::with('categories', 'media')
            ->where('status', 'published')
            ->whereNotNull('publish_at')
            ->orderBy('id', 'desc');

        // Filter by category ID
        if ($request->filled('category')) {
            $categoryId = (int) $request->category;
            $query->whereExists(function ($sub) use ($categoryId) {
                $sub->selectRaw('1')
                    ->from('category_posts')
                    ->whereColumn('category_posts.post_id', 'posts.id')
                    ->where('category_posts.category_id', $categoryId);
            });
        }

        // Filter by tag
        if ($request->filled('tag')) {
            $query->where('tags', 'like', '%' . $request->tag . '%');
        }

        // Filter editor's picks
        if ($request->filled('editors_pick')) {
            $query->where('editors_pick', true);
        }

        $perPage = min(max((int) $request->get('per_page', 20), 1), 50);
        $posts = $query->paginate($perPage);

        return new PostCollection($posts);
    }

    /**
     * GET /api/posts/{id}
     * Single post by ID.
     */
    public function show($id)
    {
        $post = Post::with('categories', 'media', 'user.media')
            ->where('status', 'published')
            ->whereNotNull('publish_at')
            ->findOrFail($id);

        return new PostResource($post);
    }

    /**
     * GET /api/posts/slug/{slug}
     * Single post by slug (useful for Next.js dynamic routes).
     */
    public function showBySlug($slug)
    {
        $post = Post::with('categories', 'media', 'user.media')
            ->where('status', 'published')
            ->whereNotNull('publish_at')
            ->where('slug', $slug)
            ->firstOrFail();

        return new PostResource($post);
    }

    /**
     * GET /api/posts/search?q=query
     * Basic title search.
     */
    public function search(Request $request)
    {
        $request->validate(['q' => 'required|min:2']);

        $posts = Post::with('categories', 'media')
            ->where('status', 'published')
            ->whereNotNull('publish_at')
            ->where('title', 'like', '%' . $request->q . '%')
            ->orderBy('id', 'desc')
            ->paginate(20);

        return new PostCollection($posts);
    }

    /**
     * GET /api/posts/latest?limit=6
     * Convenience endpoint for homepage hero/feed.
     */
    public function latest(Request $request)
    {
        $limit = min($request->get('limit', 6), 50); // cap at 50

        $posts = Post::with('categories', 'media')
            ->where('status', 'published')
            ->whereNotNull('publish_at')
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get();

        return PostResource::collection($posts);
    }

    /**
     * GET /api/posts/trending
     * Editors picks from the last 7 days, fallback to recent if none
     */
    public function trending(Request $request)
    {
        $limit = min($request->get('limit', 10), 50);

        $posts = Post::with('categories', 'media')
            ->where('status', 'published')
            ->whereNotNull('publish_at')
            ->where('publish_at', '>=', now()->subDays(7))
            ->orderByRaw('editors_pick DESC, publish_at DESC')
            ->limit($limit)
            ->get();

        // Fallback — if last 7 days yields nothing, return latest 
        if ($posts->isEmpty()) {
            $posts = Post::with('categories', 'media')
            ->where('status', 'published')
            ->whereNotNull('publish_at')
            ->orderByRaw('editors_pick DESC, publish_at DESC')
            ->limit($limit)
            ->get();
    }

    return PostResource::collection($posts);
}

/**
 * GET /api/posts/top
 * Editors picks from the last 30 days, fallback to recent if none
 */
public function top(Request $request)
{
    $limit = min($request->get('limit', 10), 50);

    $posts = Post::with('categories', 'media')
        ->where('status', 'published')
        ->whereNotNull('publish_at')
        ->where('publish_at', '>=', now()->subDays(30))
        ->orderByRaw('editors_pick DESC, publish_at DESC')
        ->limit($limit)
        ->get();

    // Fallback — if last 30 days yields nothing, return latest
    if ($posts->isEmpty()) {
        $posts = Post::with('categories', 'media')
            ->where('status', 'published')
            ->whereNotNull('publish_at')
            ->orderByRaw('editors_pick DESC, publish_at DESC')
            ->limit($limit)
            ->get();
         }

         return PostResource::collection($posts);
    }

    /**
 * GET /api/posts/more?exclude=1,2,3,4&limit=10
 * Recent posts excluding already displayed IDs
 */
public function more(Request $request)
{
    $limit   = min($request->get('limit', 10), 50);
    $exclude = $request->get('exclude', '');

    // Convert comma-separated string to array of integers
    $excludeIds = collect(explode(',', $exclude))
        ->map(fn($id) => (int) trim($id))
        ->filter()
        ->values()
        ->toArray();

    $posts = Post::with('categories', 'media')
        ->where('status', 'published')
        ->whereNotNull('publish_at')
        ->when(!empty($excludeIds), fn($q) => $q->whereNotIn('id', $excludeIds))
        ->orderBy('publish_at', 'desc')
        ->paginate($limit);

    return new PostCollection($posts);
}

    /**
     * GET /api/posts/tag/{tag}
     * Paginated posts filtered by tag.
     * Tags are stored as double-semicolon separated strings e.g. "mining;;zimbabwe;;gold"
     */
    public function byTag(Request $request, string $tag)
    {
        $perPage = min(max((int) $request->get('per_page', 20), 1), 50);

        $posts = Post::with('categories', 'media')
            ->where('status', 'published')
            ->whereNotNull('publish_at')
            ->where('tags', 'like', '%' . $tag . '%')
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return new PostCollection($posts);
    }

    /**
     * GET /api/posts/{id}/related
     * Related posts based on shared categories and tags
     */
    public function related(Request $request, $id)
    {
        $limit = min(max((int) $request->get('limit', 5), 1), 20);

        $post = Post::with('categories')
            ->where('status', 'published')
            ->whereNotNull('publish_at')
            ->findOrFail($id);

        $categoryIds = $post->categories->pluck('id')->toArray();
        $tags        = array_values(array_filter(array_map('trim', $post->tags())));

        $query = collect();

        if (!empty($categoryIds) || !empty($tags)) {
            $query = Post::with('categories', 'media')
                ->where('status', 'published')
                ->whereNotNull('publish_at')
                ->where('id', '!=', $id)
                ->where(function ($q) use ($categoryIds, $tags) {
                    if (!empty($categoryIds)) {
                        $q->whereExists(function ($sub) use ($categoryIds) {
                            $sub->selectRaw('1')
                                ->from('category_posts')
                                ->whereColumn('category_posts.post_id', 'posts.id')
                                ->whereIn('category_posts.category_id', $categoryIds);
                        });
                    }

                    foreach ($tags as $tag) {
                        $q->orWhere('tags', 'like', '%' . $tag . '%');
                    }
                })
                ->orderByRaw('editors_pick DESC, publish_at DESC')
                ->limit($limit)
                ->get();
        }

        // Fallback — if no related posts found, return latest from same category
        if ($query->isEmpty() && !empty($categoryIds)) {
            $query = Post::with('categories', 'media')
                ->where('status', 'published')
                ->whereNotNull('publish_at')
                ->where('id', '!=', $id)
                ->whereExists(function ($sub) use ($categoryIds) {
                    $sub->selectRaw('1')
                        ->from('category_posts')
                        ->whereColumn('category_posts.post_id', 'posts.id')
                        ->whereIn('category_posts.category_id', $categoryIds);
                })
                ->orderBy('publish_at', 'desc')
                ->limit($limit)
                ->get();
        }

        return PostResource::collection($query);
    }
}
