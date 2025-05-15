<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * @group Posts
     * APIs para gestión de publicaciones (posts)
     */

    /**
     * Obtener todos los posts.
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "user_id": 2,
     *       "body": "Contenido del post",
     *       "image_url": null,
     *       "parent_id": null,
     *       "published_at": "2024-05-01T12:00:00.000000Z"
     *     }
     *   ]
     * }
     */
    public function index()
    {
        return PostResource::collection(Post::all());
    }

    /**
     * Obtener posts publicados de un usuario específico.
     *
     * @urlParam userId integer required ID del usuario. Example: 2
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 3,
     *       "user_id": 2,
     *       "body": "Post del usuario",
     *       ...
     *     }
     *   ]
     * }
     *
     * @response 404 {
     *   "message": "No posts found for this user"
     * }
     */
    public function getByUser($userId)
    {
        $posts = Post::publishedMainPostsByUser($userId)->get();

        if ($posts->isEmpty()) {
            return response()->json(['message' => 'No posts found for this user'], 404);
        }
        return PostResource::collection($posts);
    }

    /**
     * Crear un nuevo post.
     *
     * @bodyParam user_id integer required ID del usuario que crea el post. Example: 1
     * @bodyParam body string required Contenido del post. Example: "Este es un post de ejemplo"
     * @bodyParam image_url string URL opcional de imagen. Example: "https://example.com/image.jpg"
     * @bodyParam parent_id integer ID opcional de post padre (para respuestas). Example: 5
     * @bodyParam published_at date Fecha y hora de publicación. Example: "2024-05-01 15:00:00"
     *
     * @response 201 {
     *   "data": {
     *     "id": 10,
     *     "user_id": 1,
     *     "body": "Este es un post de ejemplo",
     *     ...
     *   }
     * }
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'body' => 'required|string',
            'image_url' => 'nullable|url',
            'parent_id' => 'nullable|exists:posts,id',
            'published_at' => 'nullable|date',
        ]);

        $post = Post::create($validated);

        return new PostResource($post);
    }

    /**
     * Mostrar un post específico.
     *
     * @urlParam post integer required ID del post. Example: 10
     *
     * @response 200 {
     *   "data": {
     *     "id": 10,
     *     "user_id": 1,
     *     "body": "Contenido del post",
     *     ...
     *   }
     * }
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Actualizar un post.
     *
     * @urlParam post integer required ID del post. Example: 10
     * @bodyParam body string Contenido actualizado. Example: "Nuevo contenido"
     * @bodyParam image_url string URL de imagen. Example: "https://example.com/nueva-imagen.jpg"
     * @bodyParam parent_id integer ID de post padre. Example: 5
     * @bodyParam published_at date Fecha de publicación. Example: "2024-06-01 12:00:00"
     *
     * @response 200 {
     *   "data": {
     *     "id": 10,
     *     "body": "Nuevo contenido",
     *     ...
     *   }
     * }
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'body' => 'sometimes|required|string',
            'image_url' => 'nullable|url',
            'parent_id' => 'nullable|exists:posts,id',
            'published_at' => 'nullable|date',
        ]);

        $post->update($validated);

        return new PostResource($post);
    }

    /**
     * Eliminar un post.
     *
     * @urlParam post integer required ID del post. Example: 10
     *
     * @response 200 {
     *   "message": "Post deleted successfully."
     * }
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully.']);
    }
}
