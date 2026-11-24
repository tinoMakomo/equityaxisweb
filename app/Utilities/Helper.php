<?php

namespace App\Utilities;

use App\Models\Ad;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class Helper
{
    protected static ?array $adsMap = null;
    protected static ?int $cacheVersion = null;

    public static function getCacheVersion(): int
    {
        if (static::$cacheVersion === null) {
            static::$cacheVersion = (int) Cache::get('site:cache_version', 1);
        }

        return static::$cacheVersion;
    }

    public static function clearSiteCache(): void
    {
        static::$adsMap = null;
        $nextVersion = static::getCacheVersion() + 1;
        static::$cacheVersion = $nextVersion;
        Cache::forever('site:cache_version', $nextVersion);
    }

    public static function isArchive(): bool
    {
        return Str::contains(Request::root(), 'archive.equityaxis.net');
    }

    public static function isNotArchive(): bool
    {
        return static::isArchive() == false;
    }

    public static function getIsArchivedValue(): int
    {
        return static::isArchive() ? 1 : 0;
    }

    protected static function getAdsMap(): array
    {
        if (static::$adsMap !== null) {
            return static::$adsMap;
        }

        $version = static::getCacheVersion();

        static::$adsMap = Cache::remember("site:v{$version}:ads", 300, function () {
            $map = [];
            foreach (Ad::with('media')->get() as $ad) {
                if (!isset($map[$ad->preset])) {
                    $map[$ad->preset] = [
                        'link' => $ad->link,
                        'image' => $ad->featured(),
                    ];
                }
            }
            return $map;
        });

        return static::$adsMap;
    }

    public static function hasAd(string $preset): bool
    {
        return isset(static::getAdsMap()[$preset]);
    }

    public static function getAd(string $preset)
    {
        $ads = static::getAdsMap();
        if (isset($ads[$preset])) {
            return $ads[$preset]['image'];
        }
        return asset("images/ads/" . $preset . ".jpg");
    }

    public static function getAdUrl(string $preset)
    {
        $ads = static::getAdsMap();
        if (isset($ads[$preset])) {
            return $ads[$preset]['link'];
        }
        return "/";
    }

    public static function getParentCategories()
    {
        $version = static::getCacheVersion();

        return Cache::remember("site:v{$version}:parent_categories", 300, function () {
            return Category::where('parent', 0)
                ->with('children')
                ->orderBy('position', 'asc')
                ->get();
        });
    }

    public static function getRecentPosts()
    {
        $isArchived = static::getIsArchivedValue();
        $version = static::getCacheVersion();

        return Cache::remember("site:v{$version}:recent_posts:{$isArchived}", 300, function () use ($isArchived) {
            return Post::select('id', 'title', 'slug', 'created_at')
                ->where('status', 'published')
                ->where('is_archived', $isArchived)
                ->orderBy('id', 'desc')
                ->limit(5)
                ->get();
        });
    }


    public static function getRouteForPost($post)
    {
        return route('post', [$post->id, $post->created_at->year, $post->created_at->month, $post->slug]);
    }

    public static function getRouteForCategory($category)
    {
        return route('category', [$category->id, $category->slug]);
    }

    public static function getCategoryRouteForPost($post)
    {
        if ($post->categories->count() == 0) {
            return "#";
        }
        return route('category', [$post->categories->first()->id, $post->categories->first()->slug]);
    }

    public static function getViewsForPost($post)
    {
        try {
            $url = static::getRouteForPost($post);
            $data = App::make('piwik')->getActions()->getPageUrl($pageUrl = $url);

            if ($data != null && count($data)) {
                return [
                    "hits" => $data[0]->nb_hits,
                    "unique_hits" => $data[0]->nb_uniq_visitors,
                ];
            }
        } catch (\Throwable $e) {
            // Fall back gracefully if analytics service is unreachable
        }

        return [
            "hits" => 0,
            "unique_hits" => 0,
        ];
    }

    public static function getFormattedPostDate($post){
        return $post->created_at->diffInHours(now()->subDays(1)) > 24 ? $post->created_at->format('M d, Y') : $post->created_at->diffForHumans();
    }

    /**
     * Inject an AdSense in-article ad unit after the Nth paragraph of an article body
     * when ADSENSE_IN_ARTICLE_SLOT is configured.
     */
    public static function injectInArticleAd(?string $html, int $afterParagraph = 3): string
    {
        $html = (string) $html;
        $client = config('services.adsense.client');
        $slot = config('services.adsense.in_article_slot');

        if (empty($client) || empty($slot) || stripos($html, '</p>') === false) {
            return $html;
        }

        $adMarkup = view('includes.adsense-unit', [
            'type' => 'in-article',
            'slot' => $slot,
        ])->render();

        $parts = preg_split('/(<\/p>)/i', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
        if (!$parts || count($parts) <= ($afterParagraph * 2)) {
            return $html . $adMarkup;
        }

        $output = '';
        $paragraphCount = 0;
        $inserted = false;

        foreach ($parts as $part) {
            $output .= $part;
            if (!$inserted && strcasecmp($part, '</p>') === 0) {
                $paragraphCount++;
                if ($paragraphCount === $afterParagraph) {
                    $output .= $adMarkup;
                    $inserted = true;
                }
            }
        }

        return $output;
    }
}
