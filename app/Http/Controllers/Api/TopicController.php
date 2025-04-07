<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * Mostrar todos los topics.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $topics = Topic::all();
        return response()->json([
            'data' => $topics
        ]);
    }

    /**
     * Crear un nuevo topic.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $topic = Topic::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Topic created successfully',
            'data' => $topic
        ], 201);
    }

    /**
     * Mostrar un topic específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $topic = Topic::findOrFail($id);

        return response()->json([
            'data' => $topic
        ]);
    }

    /**
     * Actualizar un topic.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $topic = Topic::findOrFail($id);
        $topic->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Topic updated successfully',
            'data' => $topic
        ]);
    }

    /**
     * Eliminar un topic.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();

        return response()->json([
            'message' => 'Topic deleted successfully'
        ]);
    }

    /**
     * Obtener los posts asociados a un topic.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function posts($id)
    {
        $topic = Topic::findOrFail($id);
        $posts = $topic->posts;

        return response()->json([
            'data' => $posts
        ]);
    }
}
