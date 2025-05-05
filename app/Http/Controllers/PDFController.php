<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{
    public function generateUserPostsPDF($userId)
    {
        $user = User::findOrFail($userId);
        $posts = Post::where('user_id', $userId)->get();

        if ($posts->isEmpty()) {
            return back()->with('error', 'Este usuario no tiene posts.');
        }

        $pdf = PDF::loadView('pdf.pdf-user-posts', compact('user', 'posts'));

        return $pdf->download('posts_usuario_'.$user->id.'.pdf');
    }

    public function generatePageAnalysisPDF()
    {

        $topUsers = User::withCount(['posts as main_posts_count' => function ($query) {
            $query->whereNull('parent_id');
        }])->orderByDesc('main_posts_count')->take(10)->get();

        $topTopics = Topic::withCount('posts')->orderByDesc('posts_count')->take(10)->get();

        $topPosts = Post::topLikedLastDay(10)->get();

        $mostCommentedPosts = Post::whereNull('parent_id')
            ->with('user')
            ->withCount(['children as comments_count'])
            ->orderByDesc('comments_count')
            ->take(10)
            ->get();

        $totalUsers = User::count();
        $totalPosts = Post::count();
        $totalTopics = Topic::count();
        $totalMainPosts = Post::whereNull('parent_id')->count();
        $totalComments = Post::whereNotNull('parent_id')->count();
        $avgCommentsPerPost = $totalMainPosts > 0 ? round($totalComments / $totalMainPosts, 2) : 0;

        $pdf = PDF::loadView('pdf.pdf-page-analysis', compact(
            'topUsers',
            'topTopics',
            'topPosts',
            'mostCommentedPosts',
            'totalUsers',
            'totalPosts',
            'totalTopics',
            'totalMainPosts',
            'totalComments',
            'avgCommentsPerPost'
        ));

        return $pdf->download('pdf.pdf-page-analysis');
    }
}
