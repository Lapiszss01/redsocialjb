<!DOCTYPE html>
<html>
<head>
    <title>{{ __('Blog General Analysis') }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .container { width: 100%; padding: 20px; }
        h1, h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; font-size: 12px; text-align: left; }
        th { background-color: #f2f2f2; }
        .stats { margin-bottom: 20px; font-size: 14px; }
        img {width: 100px; height: 100px;}
    </style>
</head>
<body>
<div class="container">
    <h1>{{ __('Blog General Analysis') }}</h1>

    <div class="stats">
        <p><strong>{{ __('Total users') }}:</strong> {{ $totalUsers }}</p>
        <p><strong>{{ __('Total posts (including comments)') }}:</strong> {{ $totalPosts }}</p>
        <p><strong>{{ __('Total main posts') }}:</strong> {{ $totalMainPosts }}</p>
        <p><strong>{{ __('Total comments') }}:</strong> {{ $totalComments }}</p>
        <p><strong>{{ __('Average comments per post') }}:</strong> {{ $avgCommentsPerPost }}</p>
        <p><strong>{{ __('Total topics') }}:</strong> {{ $totalTopics }}</p>
    </div>

    <h2>{{ __('Top users by post count') }}</h2>
    <table>
        <thead><tr><th>{{ __('User') }}</th><th>{{ __('Posts') }}</th></tr></thead>
        <tbody>
        @foreach($topUsers as $user)
            <tr>
                <td>
                    <div class="w-8 h-8 rounded-full overflow-hidden border border-gray-300 dark:border-gray-600">
                        <img src="{{ $user->profile_photo ? public_path('storage/profile-photos/' . basename($user->profile_photo)) : public_path($user->profile_photo) }}" alt="Profile photo">
                    </div>
                    {{ $user->username }}
                </td>
                <td>{{ $user->posts->count() }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2>{{ __('Most used topics') }}</h2>
    <table>
        <thead><tr><th>{{ __('Topic') }}</th><th>{{ __('Posts') }}</th></tr></thead>
        <tbody>
        @foreach($topTopics as $topic)
            <tr><td>{{ $topic->name }}</td><td>{{ $topic->posts->count() }}</td></tr>
        @endforeach
        </tbody>
    </table>

    <h2>{{ __('Most liked posts') }}</h2>
    <table>
        <thead><tr><th>{{ __('Post') }}</th><th>{{ __('Author') }}</th><th>{{ __('Likes') }}</th></tr></thead>
        <tbody>
        @foreach($topPosts as $post)
            <tr>
                <td>{{ \Illuminate\Support\Str::limit($post->body, 50) }}</td>
                <td>{{ $post->user->username }}</td>
                <td>{{ $post->likes_count }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2>{{ __('Posts with most comments') }}</h2>
    <table>
        <thead><tr><th>{{ __('Post') }}</th><th>{{ __('Author') }}</th><th>{{ __('Comments') }}</th></tr></thead>
        <tbody>
        @foreach($mostCommentedPosts as $post)
            <tr>
                <td>{{ \Illuminate\Support\Str::limit($post->body, 50) }}</td>
                <td>{{ $post->user->username }}</td>
                <td>{{ $post->comments_count }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
