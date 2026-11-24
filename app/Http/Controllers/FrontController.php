<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Utilities\Helper;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\UpdateSubscriberRequest;
use App\Http\Middleware\AttachParentCategoriesToRequest;
use App\Http\Requests\StoreFeedbackRequest;
use App\Models\Feedback;

class FrontController extends Controller
{

    public function __construct()
    {
        $this->middleware(AttachParentCategoriesToRequest::class);
    }

    public function index()
    {
        $isArchived = Helper::getIsArchivedValue();
        $editorsPick = Post::where('status', 'published')
            ->where('is_archived', $isArchived)
            ->where('editors_pick', true)
            ->with(['categories', 'media'])
            ->orderBy('created_at', 'desc')
            ->first();

        $posts = Post::where('status', 'published')
            ->where('is_archived', $isArchived)
            ->when($editorsPick, function (Builder $query) use ($editorsPick) {
                $query->where('id', '!=', $editorsPick->id);
            })
            ->with(['categories', 'media'])
            ->orderBy('created_at', 'desc')
            ->paginate(35);

        return view('front.index')->withPosts($posts)->withEditorsPick($editorsPick);
    }

    public function search(Request $request)
    {
        $search = trim((string) $request->input('q', ''));
        $isArchived = Helper::getIsArchivedValue();

        if ($search === '') {
            $posts = $this->paginate(collect(), 20, null, ['path' => $request->url(), 'query' => $request->query()]);
        } else {
            try {
                $posts = Post::search($search)
                    ->query(function (Builder $query) use ($isArchived) {
                        $query->where('status', 'published')
                            ->where('is_archived', $isArchived)
                            ->with(['categories', 'media']);
                    })
                    ->get();
                $posts = $this->paginate($posts, 20, null, ['path' => $request->url(), 'query' => $request->query()]);
            } catch (\Throwable $e) {
                $posts = Post::where('status', 'published')
                    ->where('is_archived', $isArchived)
                    ->where(function (Builder $query) use ($search) {
                        $query->where('title', 'LIKE', "%{$search}%")
                            ->orWhere('tags', 'LIKE', "%{$search}%");
                    })
                    ->with(['categories', 'media'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(20)
                    ->appends(['q' => $search]);
            }
        }

        $topPosts = Post::where('status', 'published')
            ->where('is_archived', $isArchived)
            ->orderBy('created_at', 'desc')
            ->with(['categories', 'media'])
            ->limit(8)
            ->get();

        return view('front.search')->withPosts($posts)->withSearch($search)->withTopPosts($topPosts);
    }

    public function terms()
    {
        return view('front.terms');
    }

    public function contact()
    {
        return view('front.contact');
    }

    public function privacy()
    {
        return view('front.privacy');
    }

    public function cookies()
    {
        return view('front.cookies');
    }

    public function disclaimer()
    {
        return view('front.disclaimer');
    }



    public function subscribe(Request $request)
    {
        $email = $request->input('email');
        return view('front.subscribe.add')->withEmail($email);
    }

    public function subscribeAdd(UpdateSubscriberRequest $request)
    {
        if ($request->hasAny([
            'news_updates',
            'e_newspaper',
            'email_services'
        ]) == false) {
            return back()->withMessage('Please, select at least one services below.')->withInput();
        }
        Subscriber::create([
            'full_name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'company' => $request->input('company'),
            'mobile_number' => $request->input('mobile_number'),
            'news_updates' => $request->input('news_updates') == 'on' ? true : false,
            'e_newspaper' => $request->input('e_newspaper') == 'on' ? true : false,
            'email_services' => $request->input('email_services') == 'on' ? true : false,
        ]);

        return redirect()->route('subscribe.success');
    }

    public function contactSubmit(StoreFeedbackRequest $request)
    {
        Feedback::create([
            'full_name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
        ]);

        return redirect()->route('contact.success');
    }

    public function subscribeSuccess()
    {
        return view('front.subscribe.added');
    }

    public function contactSuccess()
    {
        return view('front.contact-success');
    }

    public function aboutUs()
    {
        return view('front.about-us');
    }

    public function careers()
    {
        return view('front.careers');
    }

    public function helpCentre()
    {
        return view('front.help-centre');
    }

    public function services()
    {
        return view('front.services');
    }

    public function unsubscribe(String $email)
    {
        Subscriber::where(['email' => $email])->delete();
        return view('front.subscribe.removed');
    }

    public function category($id)
    {
        $category = Category::with('children')->findOrFail($id);
        $categoryIds = $category->getSelfAndChildCategoryIds();

        $posts = Post::whereExists(function ($query) use ($categoryIds) {
                $query->selectRaw('1')
                    ->from('category_posts')
                    ->whereColumn('category_posts.post_id', 'posts.id')
                    ->whereIn('category_posts.category_id', $categoryIds);
            })
            ->where('status', 'published')
            ->where('is_archived', Helper::getIsArchivedValue())
            ->with(['categories', 'media'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        if (count($categoryIds) > 1) {
            return view('front.category')->withPosts($posts)->withShowSubCategories(true)->withCategory($category);
        }

        return view('front.category')->withPosts($posts)->withShowBreadcrump($category->hasParent())->withCategory($category);
    }

    public function author($id)
    {
        $user = User::findOrFail($id);
        $isArchived = Helper::getIsArchivedValue();

        $posts = Post::where('user_id', $id)
            ->where('status', 'published')
            ->where('is_archived', $isArchived)
            ->with(['categories', 'media'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        $topPosts = Post::where('status', 'published')
            ->where('is_archived', $isArchived)
            ->orderBy('created_at', 'desc')
            ->with(['categories', 'media'])
            ->limit(8)
            ->get();

        return view('front.author')->withPosts($posts)->withUser($user)->withTopPosts($topPosts);
    }

    public function tag(String $tag)
    {
        $isArchived = Helper::getIsArchivedValue();

        $posts = Post::where('tags', 'LIKE', "%{$tag}%")
            ->where('status', 'published')
            ->where('is_archived', $isArchived)
            ->with(['categories', 'media'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        $topPosts = Post::where('status', 'published')
            ->where('is_archived', $isArchived)
            ->orderBy('created_at', 'desc')
            ->with(['categories', 'media'])
            ->limit(8)
            ->get();

        return view('front.search')->withPosts($posts)->withSearch($tag)->withTopPosts($topPosts);
    }

    public function post($id)
    {
        $post = Post::with(['user', 'categories', 'media'])->findOrFail($id);
        $topPosts = Post::where('status', 'published')
            ->where('is_archived', Helper::getIsArchivedValue())
            ->orderBy('created_at', 'desc')
            ->with(['categories', 'media'])
            ->limit(8)
            ->get();

        return view('front.post')
            ->withPost($post)
            ->withtopPosts($topPosts);
    }
}
