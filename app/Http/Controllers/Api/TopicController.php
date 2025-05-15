<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TopicResource;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopicController extends Controller
{
    /**
     * @group Temas (Topics)
     * APIs para gestionar los temas del blog
     */

    /**
     * Obtener todos los temas.
     *
     * Retorna la lista completa de temas.
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "Laravel",
     *       "created_at": "2024-01-01T00:00:00.000000Z",
     *       "updated_at": "2024-01-01T00:00:00.000000Z"
     *     }
     *   ]
     * }
     */
    public function index()
    {
        $topics = Topic::all();
        return TopicResource::collection($topics);
    }

    /**
     * Obtener los 10 temas más usados.
     *
     * Retorna los 10 temas con mayor cantidad de posts asociados.
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 3,
     *       "name": "PHP",
     *       "usage_count": 25,
     *       ...
     *     }
     *   ]
     * }
     *
     * @response 404 {
     *   "message": "No topics found"
     * }
     */
    public function mostUsedTopic()
    {
        $topics = DB::table('post_topic')
            ->select('topic_id', DB::raw('COUNT(*) as usage_count'))
            ->groupBy('topic_id')
            ->orderByDesc('usage_count')
            ->take(10)
            ->get();

        if ($topics->isEmpty()) {
            return response()->json(['message' => 'No topics found'], 404);
        }

        $fullTopics = $topics->map(function ($row) {
            $topic = Topic::find($row->topic_id);
            $topic->usage_count = $row->usage_count;
            return $topic;
        });

        return TopicResource::collection($fullTopics);
    }

    /**
     * Crear un nuevo tema.
     *
     * @bodyParam name string required Nombre del tema. Example: "JavaScript"
     *
     * @response 201 {
     *   "data": {
     *     "id": 5,
     *     "name": "JavaScript",
     *     ...
     *   },
     *   "message": "Topic created successfully"
     * }
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $topic = Topic::create([
            'name' => $request->name,
        ]);

        return (new TopicResource($topic))
            ->additional(['message' => 'Topic created successfully'])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Obtener un tema específico.
     *
     * @urlParam id integer required ID del tema. Example: 1
     *
     * @response 200 {
     *   "data": {
     *     "id": 1,
     *     "name": "Laravel",
     *     ...
     *   }
     * }
     *
     * @response 404 {
     *   "message": "No query results for model [App\\Models\\Topic] 1"
     * }
     */
    public function show($id)
    {
        $topic = Topic::findOrFail($id);
        return new TopicResource($topic);
    }

    /**
     * Actualizar un tema existente.
     *
     * @urlParam id integer required ID del tema. Example: 1
     * @bodyParam name string required Nuevo nombre del tema. Example: "VueJS"
     *
     * @response 200 {
     *   "data": {
     *     "id": 1,
     *     "name": "VueJS",
     *     ...
     *   },
     *   "message": "Topic updated successfully"
     * }
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

        return (new TopicResource($topic))
            ->additional(['message' => 'Topic updated successfully']);
    }

    /**
     * Eliminar un tema.
     *
     * @urlParam id integer required ID del tema. Example: 1
     *
     * @response 200 {
     *   "message": "Topic deleted successfully"
     * }
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
     * Obtener posts relacionados a un tema.
     *
     * @urlParam id integer required ID del tema. Example: 1
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 10,
     *       "body": "Contenido del post",
     *       ...
     *     }
     *   ]
     * }
     */
    public function posts($id)
    {
        $topic = Topic::findOrFail($id);
        $posts = $topic->posts; // Podrías usar PostResource si quieres formato uniforme

        return response()->json([
            'data' => $posts
        ]);
    }
}
