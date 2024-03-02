<?php

namespace App\Http\Controllers\Api\Novels;

use App\Http\Controllers\CloudinaryStorage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Novels\NovelRequest;
use App\Models\Novels\Novel;
use App\Models\Novels\NovelGenre;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NovelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $novels = Novel::with('genre')->get();
        $novelCollections = collect();

        foreach ($novels as $novel) {
            $genreCollections = collect();

            foreach ($novel->genre as $novelGenre) {
                $genreCollections->push([
                    'name' => $novelGenre->name,
                ]);
            }

            $novelCollections->push([
                'uuid' => $novel->uuid,
                'name' => $novel->name,
                'description' => $novel->description,
                'cover' => $novel->cover,
                'is_publish' => $novel->is_publish,
                'is_private' => $novel->is_private,
                'genre' => $genreCollections,
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Successfully Get Novels',
            'data' => $novelCollections,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NovelRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $coverNovel = CloudinaryStorage::upload($request->file('image')->getRealPath(), $request->file('image')->getClientOriginalName());

            $request->merge([
                'cover' => $coverNovel,
            ]);

            $novel = Novel::create($request->except(['genre', 'image']));
            $novel->genre()->attach($request->input('genre'));
        } catch (\Exception $exception) {
            DB::rollBack();

            return response()->json([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'request' => $request->all(),
            ]);
        }

        DB::commit();

        return response()->json([
            'code' => 201,
            'message' => 'Successfully Create',
            'data' => $novel,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Novel $novel)
    {
        $novel->with('genre');
        $genreCollections = collect();

        foreach ($novel->genre as $novelGenre) {
            $genreCollections->push([
                'name' => $novelGenre->name,
            ]);
        }

        $novel = [
            'uuid' => $novel->uuid,
            'name' => $novel->name,
            'description' => $novel->description,
            'cover' => $novel->cover,
            'is_publish' => $novel->is_publish,
            'is_private' => $novel->is_private,
            'genre' => $genreCollections,
        ];

        return response()->json([
            'status' => 200,
            'message' => 'Successfully Get Novels',
            'data' => $novel,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NovelRequest $request, Novel $novel): JsonResponse
    {
        DB::beginTransaction();

        try {
            $novel->update($request->except(['genre', 'image']));
            $genreRequest = $request->genre;
            $genreId = $novel->genre->pluck('id')->all();

            $deletedGenre = array_diff($genreId, $genreRequest);

            if (isset($deletedGenre)) {
                $novel->novelGenre()->whereIn('genre_id', $deletedGenre)->delete();
            }

            $newGenre = array_diff($genreRequest, $genreId);

            if (isset($newGenre)) {
                foreach ($newGenre as $genre) {
                    NovelGenre::create([
                        'novel_uuid' => $novel->uuid,
                        'genre_id' => $genre,
                    ]);
                }
            }

        } catch (\Exception $exception) {
            DB::rollBack();

            return response()->json([
                'message' => $exception->getMessage(),
            ]);
        }

        DB::commit();

        return response()->json([
            'status' => 201,
            'message' => 'Successfully Update',
            'data' => $novel,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Novel $novel)
    {
        //
    }
}
