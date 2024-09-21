<?php

function generateEmbedLink($url)
{
    $parsedUrl = parse_url($url);
    $host = $parsedUrl['host'] ?? '';
    parse_str($parsedUrl['query'] ?? '', $queryParams);

    switch ($host) {
        case 'www.youtube.com':
        case 'youtube.com':
            if (isset($queryParams['v'])) {
                $videoId = $queryParams['v'];
                return "https://www.youtube.com/embed/{$videoId}";
            }
            break;

        case 'youtu.be':
            $videoId = ltrim($parsedUrl['path'], '/');
            return "https://www.youtube.com/embed/{$videoId}";

        case 'www.facebook.com':
        case 'facebook.com':
            return "https://www.facebook.com/plugins/video.php?href=" . urlencode($url) . "&show_text=false&width=560&t=0";

        default:
            return null;
    }
}
