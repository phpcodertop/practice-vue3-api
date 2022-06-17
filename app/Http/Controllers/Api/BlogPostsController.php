<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogFormRequest;
use App\Models\BlogPost;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class BlogPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $blogPosts = BlogPost::with('author')
            ->wherePublished(1)->latest()->paginate(10);
        return response()->json($blogPosts, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogFormRequest $request
     * @return JsonResponse
     */
    public function store(BlogFormRequest $request): JsonResponse
    {
        $slug = Str::slug($request->title);

        $blogPost = BlogPost::create($request->validated()
            + [
                'author_id' => auth()->id(),
                'slug' => $slug,
                'published' => checkboxValue($request->input('published')),
            ]);
        if ($request->hasFile('image'))
        {
            $image = $request->file('image');
            $fileName = $slug.time().'.'. $image->extension();
            $image->move(public_path('uploads/blog-posts'), $fileName);
            $fileName = 'uploads/blog-posts/'.$fileName;

            $blogPost->image = $fileName;
            $blogPost->save();
        }
        return response()->json($blogPost, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param BlogPost $blog
     * @return JsonResponse
     */
    public function show(BlogPost $blog): JsonResponse
    {
        $blog->load('author');
        return response()->json($blog, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param BlogFormRequest $request
     * @param BlogPost $blog
     * @return JsonResponse
     */
    public function update(BlogFormRequest $request, BlogPost $blog): JsonResponse
    {
        $blog->update($request->validated()+ [
                'published' => 1,
            ]);

        if ($request->hasFile('image'))
        {
            $image = $request->file('image');
            $fileName = $blog->slug.time().'.'. $image->extension();
            $image->move(public_path('uploads/blog-posts'), $fileName);
            $fileName = 'uploads/blog-posts/'.$fileName;
            @unlink($blog->image);
            $blog->image = $fileName;
            $blog->save();
        }

        return response()->json($blog, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BlogPost $blog
     * @return JsonResponse
     */
    public function destroy(BlogPost $blog): JsonResponse
    {
        $blog->delete();
        @unlink($blog->image);
        return response()->json(null, 204);
    }
}
