<?php

namespace halestar\DiCmsBlogger\Controllers\API;

use App\Http\Controllers\Controller;
use halestar\DiCmsBlogger\Models\Blog;
use halestar\DiCmsBlogger\Resources\BlogResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class BlogApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Gate::allows('viewAny', Blog::class))
            return response()->json([], 403);
        return BlogResource::collection(Blog::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Gate::allows('create', Blog::class))
            return response()->json([], 403);
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|max:255',
                'description' => 'nullable',
                'slug' => 'required|max:255',
            ]);
        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);
        $blog = new Blog();
        $blog->fill($validator->validated());
        //create all pages
        $blog->createIndexPage();
        $blog->createPostsPage();
        $blog->createArchivePage();
        $blog->save();
        return BlogResource::make($blog)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        if(!Gate::allows('view', $blog))
            return response()->json([], 403);
        return new BlogResource($blog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        if(!Gate::allows('update', $blog))
            return response()->json([], 403);
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|max:255',
                'description' => 'nullable',
                'slug' => 'required|max:255',
                'auto_archive' => 'nullable|boolean',
                'archive_after' => 'exclude_unless:auto_archive,1|required|numeric|min:1|max:100',

            ]);
        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);
        $blog->fill($validator->validated());
        $blog->save();
        return new BlogResource($blog);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if(!Gate::allows('delete', $blog))
            return response()->json([], 403);
        $blog->delete();
        return response()->json([], 204);
    }
}
