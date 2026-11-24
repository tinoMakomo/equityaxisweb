<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Post;
use App\Utilities\Helper;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\ChangePostPasswordRequest;

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

        if ($request->hasFile('featured_image')) {
            $post->clearMediaCollection('featured');
            $post->addMediaFromRequest('featured_image')
                ->toMediaCollection('featured');
        }

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

        if ($request->hasFile('featured_image')) {
            $post->clearMediaCollection('featured');
            $post->addMediaFromRequest('featured_image')
                ->toMediaCollection('featured');
        }

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
}
