<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Post;
use App\Utilities\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.posts.index');
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        return view('admin.posts.trash');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $post = Post::create([
            'user_id' => $request->input('author'),
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'excerpt' => $request->input('excerpt'),
            'publish_at' => Carbon::make($request->input('publish_at')),
            'tags' => $request->input('tags') == null ? "" : implode(";;", $request->input('tags')),
            'status' => $request->input('status'),
        ]);

        if($request->input('editors_pick') != null){
            $post->update([
                'editors_pick' => $request->input('editors_pick'),
            ]);
        }
        if($request->input('is_archived') != null){
            $post->update([
                'is_archived' => $request->input('is_archived'),
            ]);
        }

        $this->attachFeaturedImage($post, $request);

        $post->categories()->sync($request->input('categories'));
        Helper::clearSiteCache();

        return redirect()->route('admin_posts.index')->with(['success-message' => "Post created successfully."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $post = Post::findOrFail($id);
        if (auth()->user()->isAuthor()) {
            if ($post->user_id != auth()->user()->id) {
                abort(404);
            }
        }

        $meta = Helper::getViewsForPost($post);

        return view('admin.posts.show')->withPost($post)->withMeta($meta);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, int $id)
    {
        $post = Post::findOrFail($id);
        if (auth()->user()->isAuthor()) {
            if ($post->user_id != auth()->user()->id) {
                abort(404);
            }
        }

        $post->update([
            'user_id' => $request->input('author'),
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'publish_at' => Carbon::make($request->input('publish_at')),
            'excerpt' => $request->input('excerpt'),
            'tags' => $request->input('tags') == null ? "" : implode(";;", $request->input('tags')),
            'status' => $request->input('status'),
        ]);

        if($request->input('editors_pick') != null){
            $post->update([
                'editors_pick' => $request->input('editors_pick'),
            ]);
        }
        if($request->input('is_archived') != null){
            $post->update([
                'is_archived' => $request->input('is_archived'),
            ]);
        }

        $post->categories()->sync($request->input('categories'));

        $this->attachFeaturedImage($post, $request);

        Helper::clearSiteCache();

        return redirect()->route('admin_posts.index')->with(['success-message' => "Post updated successfully."]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        Post::destroy($id);
        Helper::clearSiteCache();
        return redirect()->route('admin_posts.index')->with(['success-message' => "Post deleted successfully."]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(int $id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->clearMediaCollection();
        $post->where('id', $id)->forceDelete();
        Helper::clearSiteCache();
        return redirect()->route('admin_posts.index')->with(['success-message' => "Post permanently deleted successfully."]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function restore(int $id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();
        Helper::clearSiteCache();
        return redirect()->route('admin_posts.index')->with(['success-message' => "Post restored successfully."]);
    }

    /**
     * Return paginated, deduplicated previously uploaded post images for the admin picker modal.
     */
    public function mediaLibrary(Request $request)
    {
        $search = trim((string) $request->input('q', ''));
        $perPage = min(max((int) $request->input('per_page', 24), 6), 48);

        $latestIdsQuery = Media::query()
            ->selectRaw('MAX(media.id) as id')
            ->leftJoin('posts', function ($join) {
                $join->on('posts.id', '=', 'media.model_id')
                    ->where('media.model_type', '=', Post::class);
            })
            ->where('media.model_type', Post::class)
            ->where('media.collection_name', 'featured')
            ->where('media.mime_type', 'like', 'image/%')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('media.name', 'like', "%{$search}%")
                        ->orWhere('media.file_name', 'like', "%{$search}%")
                        ->orWhere('posts.title', 'like', "%{$search}%");
                });
            })
            ->groupBy('media.file_name', 'media.size');

        $paginator = Media::query()
            ->whereIn('media.id', $latestIdsQuery)
            ->orderBy('media.id', 'desc')
            ->paginate($perPage);

        $postIds = $paginator->getCollection()->pluck('model_id')->unique()->filter()->values();
        $postTitles = Post::withTrashed()->whereIn('id', $postIds)->pluck('title', 'id');

        $items = $paginator->getCollection()->map(function (Media $media) use ($postTitles) {
            $thumbUrl = $media->hasGeneratedConversion('thumb-sm')
                ? $media->getFullUrl('thumb-sm')
                : $media->getFullUrl();

            return [
                'id' => $media->id,
                'name' => $media->name,
                'file_name' => $media->file_name,
                'post_title' => $postTitles[$media->model_id] ?? '',
                'thumb_url' => $thumbUrl,
                'full_url' => $media->getFullUrl(),
                'created_at' => optional($media->created_at)->format('M d, Y'),
            ];
        })->values();

        return response()->json([
            'data' => $items,
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'total' => $paginator->total(),
        ]);
    }

    /**
     * Attach either a newly uploaded featured image or a copy of an already-uploaded media item.
     */
    protected function attachFeaturedImage(Post $post, Request $request): void
    {
        if ($request->hasFile('featured_image')) {
            $post->clearMediaCollection('featured');
            $post->addMediaFromRequest('featured_image')
                ->toMediaCollection('featured');
            return;
        }

        if ($request->filled('existing_media_id')) {
            $sourceMedia = Media::where('id', (int) $request->input('existing_media_id'))
                ->where('model_type', Post::class)
                ->first();

            if (!$sourceMedia) {
                return;
            }

            // Already attached to this post in the featured collection
            if ((int) $sourceMedia->model_id === (int) $post->id && $sourceMedia->collection_name === 'featured') {
                return;
            }

            $oldMediaIds = $post->getMedia('featured')->pluck('id')->all();
            $copied = $sourceMedia->copy($post, 'featured');

            if ($copied && !empty($oldMediaIds)) {
                Media::whereIn('id', $oldMediaIds)->get()->each->delete();
            }
        }
    }
}
