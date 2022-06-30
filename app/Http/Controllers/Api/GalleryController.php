<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Gallery::latest()->get(), 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate(['file' => 'required|image']);

        $image = $request->file('file');

        $imageName = time().'.'. $image->extension();
        $image->move(public_path('uploads/gallery'), $imageName);
        $path = 'uploads/gallery/'.$imageName;

        $gallery = Gallery::create([
            'title' => $request->input('title'),
            'path' => $path,
        ]);

        return response()->json([ 'gallery' => $gallery, 'success' => 'true'],201);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Gallery $gallery
     * @return JsonResponse
     */
    public function destroy(Gallery $gallery): JsonResponse
    {
        @unlink($gallery->path);

        $gallery->delete();

        return response()->json([], 200);
    }
}
