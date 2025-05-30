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

    <div style="text-align: center; padding: 100px 20px;">
        <h1 style="font-size: 32px; margin-bottom: 10px;"> {{ __('Blog General Analysis Report') }}</h1>
        <p style="font-size: 18px; margin-bottom: 40px;">{{ __('A comprehensive overview of user activity, posts and topics') }}</p>

        <p style="font-size: 16px;"><strong>{{ __('Generated on') }}:</strong> {{ now()->format('F j, Y') }}</p>
        <p style="font-size: 16px;"><strong>{{ __('Generated by') }}:</strong> {{ config('app.name') }}</p>
    </div>

    <div style="page-break-after: always;"></div>

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
        <thead>
        <tr>
            <th>{{ __('Profile') }}</th>
            <th>{{ __('Username') }}</th>
            <th>{{ __('Email') }}</th>
            <th>{{ __('Main Posts') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($topUsers as $user)
            <tr>
                <td>
                    <img src="{{ $user->profile_photo ? public_path('storage/profile-photos/' . basename($user->profile_photo)) : public_path($user->profile_photo) }}" alt="Profile photo" style="width: 50px; height: 50px; border-radius: 50%;">
                </td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td style="text-align: center;">{{ $user->main_posts_count }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2>{{ __('Most used topics') }}</h2>
    <table style="width: 60%; margin: 0 auto;">
        <thead>
        <tr>
            <th style="text-align: center;">{{ __('Topic') }}</th>
            <th style="text-align: center;">{{ __('Number of Posts') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($topTopics as $topic)
            <tr>
                <td style="text-align: center;">{{ $topic->name }}</td>
                <td style="text-align: center;">{{ $topic->posts_count }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2>{{ __('Most liked posts') }}</h2>
    <table>
        <thead>
        <tr>
            <th>{{ __('Body') }}</th>
            <th>{{ __('Author') }}</th>
            <th>{{ __('Likes') }}</th>
            <th>{{ __('Published At') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($topPosts as $index => $post)
            <tr style="background-color: {{ $index % 2 == 0 ? '#f9f9f9' : '#ffffff' }};">
                <td>{{ \Illuminate\Support\Str::limit($post->body, 60) }}</td>
                <td>{{ $post->user->username }}</td>
                <td style="text-align: center;">{{ $post->likes_count }}</td>
                <td>{{ $post->created_at->format('Y-m-d') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2>{{ __('Posts with most comments') }}</h2>
    <table>
        <thead>
        <tr>
            <th>{{ __('Author & Post') }}</th>
            <th>{{ __('Comments') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($mostCommentedPosts as $post)
            <tr>
                <td>
                    <strong>{{ $post->user->username }}</strong><br>
                    <em>{{ \Illuminate\Support\Str::limit($post->body, 70) }}</em>
                </td>
                <td style="text-align: center;">{{ $post->comments_count }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<!-- Final del reporte -->
<div style="page-break-before: always; padding: 40px;">
    <h2 style="text-align: center;"> {{ __('Final Summary') }}</h2>

    <p style="font-size: 14px; margin-top: 20px;">
        {{ __('This report provides insights into the current usage trends of the blog platform. The data shows steady participation from the user base, with an average of') }}
        <strong>{{ $avgCommentsPerPost }}</strong> {{ __('comments per main post.') }}
    </p>

    <p style="font-size: 14px;">
        {{ __('Topics like') }}
        <strong>{{ $topTopics->first()?->name ?? __('N/A') }}</strong>
        {{ __('are currently the most discussed, and users like') }}
        <strong>{{ $topUsers->first()?->username ?? __('N/A') }}</strong>
        {{ __('are leading the contribution efforts.') }}
    </p>

    <p style="font-size: 14px; margin-top: 20px;">
        {{ __('We recommend continuing to monitor engagement levels and encourage user participation through targeted content or community initiatives.') }}
    </p>

    <p style="font-size: 14px; margin-top: 40px;">
        {{ __('Report generated automatically by') }} {{ config('app.name') }}.
    </p>
</div>

</body>
</html>
