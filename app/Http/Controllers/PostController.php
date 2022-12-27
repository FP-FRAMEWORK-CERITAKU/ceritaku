<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => 'nullable|string',
            'myposts' => 'nullable|boolean',
            'publish' => 'nullable|boolean',
        ]);

        $search = $validated['search'] ?? null;
        $myposts = $validated['myposts'] ?? false;
        $user = auth()->user() ?? request()->user() ?? null;
        $isPublish = $validated['publish'] ?? true;

        // login first if want to see my posts
        if ($myposts && !auth()->check()) {
            return redirect()->route('auth.login');
        }

        // all post with some query
        $posts = Post::when(!empty($search), function (Builder $query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            })
            ->when($myposts && $user instanceof User, function (Builder $query) use ($user) {
                $query->where('creator_id', $user->id);
            })
            ->where('is_publish', $isPublish)
            ->orderBy('created_at', 'desc')
            ->with([
                'creator'
            ])
            ->withCount('comments')
            ->paginate(6);

        // recent post
        $recentPosts = Post::orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        return view('pages.posts.index', compact([
            'posts',
            'recentPosts',
            'user'
        ]));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        $user = auth()->user() ?? request()->user() ?? null;

        return view('pages.posts.create', compact([
            'user'
        ]));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function store(Request $request)
    {
        $user = auth()->user() ?? request()->user() ?? null;
        $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'is_publish' => 'nullable|boolean',
            'photo_background' => 'required|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        $creator_id = $user->id;
        $slug = uniqid() . '-' . Str::slug(Str::limit($validated['title'], 100, '-'));

        $saved = Post::create([
            'creator_id' => $creator_id,
            'slug' => $slug,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'is_publish' => $validated['is_publish'] ?? false,
        ]);

        if (!$saved || !$saved->exists) {
            $withMessage = [
                'status' => 'danger',
                'message' => 'Cerita gagal dibuat'
            ];

            return redirect()->back()
                ->withInput()
                ->with($withMessage);
        }

        if (!empty($validated['photo_background'])) {
            $saved->savePhoto($validated['photo_background']);
        }

        return redirect()->route('cerita.show', $saved->slug);
    }

    public function storeComment(Request $request, Post $post)
    {
        $user = auth()->user() ?? request()->user() ?? null;
        $validated = $request->validate([
            'reply_to_id' => [
                'nullable',
                'exists:comments,id',
                function ($attribute, $value, $fail) use ($post) {
                    $comment = $post->comments()->where('id', $value)->first();

                    if (!$comment instanceof Comment) {
                        $fail('Komentar tidak ditemukan pada cerita ini');
                    }
                }
            ],
            'comment' => 'required|string',
        ]);

        $creator_id = $user->id;

        $saved = $post->comments()->create([
            'creator_id' => $creator_id,
            'reply_to_id' => $validated['reply_to_id'] ?? null,
            'content' => $validated['comment'],
        ]);

        if (!$saved || !$saved->exists) {
            $withMessage = [
                'status' => 'danger',
                'message' => 'Komentar gagal dibuat'
            ];

            return redirect()->back()
                ->withInput()
                ->with($withMessage);
        }

        return redirect()->route('cerita.show', $post->slug)->withFragment('comment' . $saved->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $data = $post->load([
            'creator',
            'comments.reply_to',
            'comments.replied_by',
        ])->loadCount('comments');

        // recent post
        $recentPosts = Post::orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        return view('pages.posts.show', compact([
            'data',
            'recentPosts'
        ]));
    }

    /**
     * @param Post $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Post $post)
    {
        $user = auth()->user() ?? request()->user() ?? null;
        if (
            $user->id != $post->creator_id
            && !$user->hasRoleSuperadmin()
        ) {
            abort(403);
        }

        $data = $post;

        return view('pages.posts.edit', compact([
            'data',
            'user'
        ]));
    }

    /**
     * @param Request $request
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Post $post)
    {
        $user = auth()->user() ?? request()->user() ?? null;

        if (
            $user->id != $post->creator_id
            && !$user->hasRoleSuperadmin()
        ) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'is_publish' => 'nullable|boolean',
            'photo_background' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        $slug = uniqid() . '-' . Str::slug(Str::limit($validated['title'], 100, '-'));

        $updated = $post->update([
            'slug' => $slug,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'is_publish' => $validated['is_publish'] ?? false,
        ]);

        if (!$updated) {
            $withMessage = [
                'status' => 'danger',
                'message' => 'Cerita gagal diubah'
            ];

            return redirect()->back()
                ->withInput()
                ->with($withMessage);
        }

        if (!empty($validated['photo_background'])) {
            $post->savePhoto($validated['photo_background']);
        }

        return redirect()->route('cerita.show', $post->slug);
    }

    /**
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Post $post)
    {
        $user = auth()->user() ?? request()->user() ?? null;

        if (
            $user->id != $post->creator_id
            && !$user->hasRoleSuperadmin()
        ) {
            abort(403);
        }

        $deleted = $post->delete();

        if (!$deleted) {
            $withMessage = [
                'status' => 'danger',
                'message' => 'Cerita gagal dihapus'
            ];

            return redirect()->back()
                ->withInput()
                ->with($withMessage);
        }

        return redirect()->route('cerita.index');
    }

    public function destroyComment(Post $post, Comment $comment)
    {
        $user = auth()->user() ?? request()->user() ?? null;

        if (
            $user->id != $comment->creator_id
            && !$user->hasRoleSuperadmin()
        ) {
            abort(403);
        }

        if ($comment->post_id != $post->id) {
            abort(403);
        }

        $deleted = $comment->delete();

        if (!$deleted) {
            $withMessage = [
                'status' => 'danger',
                'message' => 'Komentar gagal dihapus'
            ];

            return redirect()->back()
                ->withInput()
                ->with($withMessage);
        }

        return redirect()->route('cerita.show', $post->slug);
    }
}
