<?php

namespace halestar\DiCmsBlogger\Controllers\API;

use App\Http\Controllers\Controller;
use halestar\DiCmsBlogger\Models\Blog;
use halestar\DiCmsBlogger\Models\BlogPost;
use halestar\DiCmsBlogger\Models\Scopes\OrderRevChronoScope;
use halestar\DiCmsBlogger\Resources\BlogPostResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BlogPostApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Blog $blog)
    {
        if(!Gate::allows('viewAny', BlogPost::class))
            return response()->json([], 403);
        return BlogPostResource::collection($blog->blogPosts()->withoutGlobalScope(OrderRevChronoScope::class)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Blog $blog)
    {
        if(!Gate::allows('create', BlogPost::class))
            return response()->json([], 403);
        $validator = Validator::make($request->all(),
            [
                'title' => 'required',
                'subtitle' => 'nullable',
                'slug' => 'required|max:255|unique:' . config('dicms.table_prefix') . 'blog_posts,slug',
                'posted_by' => 'required',
            ]);
        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);
        $blogPost = new BlogPost();
        $blogPost->fill($validator->validated());
        $blog->blogPosts()->save($blogPost);
        return BlogPostResource::make($blogPost)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $post)
    {
        if(!Gate::allows('view', $post))
            return response()->json([], 403);
        return new BlogPostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogPost $post)
    {
        if(!Gate::allows('update', $post))
            return response()->json([], 403);
        $validator = Validator::make($request->all(),
            [
                'title' => 'required',
                'subtitle' => 'nullable',
                'slug' => ['required', 'max:255', Rule::unique(config('dicms.table_prefix') . 'blog_posts')->ignore($post)],
                'posted_by' => 'required',
                'published' => 'nullable|boolean',
                'body' => 'nullable',
            ]);
        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);
        $post->fill($validator->validated());
        $post->save();
        return new BlogPostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $post)
    {
        if(!Gate::allows('delete', $post))
            return response()->json([], 403);
        $post->delete();
        return response()->json([], 204);
    }
}
