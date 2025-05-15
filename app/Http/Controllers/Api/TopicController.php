<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TopicResource;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::all();
        return TopicResource::collection($topics);
    }

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

        // Para cada topic_id, obtenemos el modelo Topic con su uso
        $fullTopics = $topics->map(function ($row) {
            $topic = Topic::find($row->topic_id);
            $topic->usage_count = $row->usage_count;
            return $topic;
        });

        return TopicResource::collection($fullTopics);
    }

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

    public function show($id)
    {
        $topic = Topic::findOrFail($id);
        return new TopicResource($topic);
    }

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

    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();

        return response()->json([
            'message' => 'Topic deleted successfully'
        ]);
    }

    public function posts($id)
    {
        $topic = Topic::findOrFail($id);
        $posts = $topic->posts; // Si quieres, puedes hacer también un PostResource aquí

        return response()->json([
            'data' => $posts
        ]);
    }
}
