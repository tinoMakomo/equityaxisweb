<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Post;
use App\Models\Category;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a site map for the entire website.';

    /**
     * Execute the console command.
     *
     * @return int
     */

public function handle()
{
    $this->info('Generating sitemap...');

    $baseUrl = config('app.url');

    // Ensure output directory exists
    $sitemapDir = storage_path('app/public/sitemaps');
    if (!file_exists($sitemapDir)) {
        mkdir($sitemapDir, 0755, true);
    }

    // 1. Static pages
    $this->info('Building static pages sitemap...');
    Sitemap::create()
        ->add(Url::create('/')->setPriority(1.0)->setChangeFrequency('daily'))
        ->add(Url::create('/about-us')->setPriority(0.5)->setChangeFrequency('monthly'))
        ->add(Url::create('/services')->setPriority(0.5)->setChangeFrequency('monthly'))
        ->add(Url::create('/contact')->setPriority(0.4)->setChangeFrequency('monthly'))
        ->add(Url::create('/subscribe')->setPriority(0.6)->setChangeFrequency('monthly'))
        ->writeToFile($sitemapDir . '/sitemap-static.xml');

    // 2. Categories (top-level only — parent == 0 or null)
    $this->info('Building categories sitemap...');
    $categorySitemap = Sitemap::create();
    Category::all()->each(function ($category) use ($categorySitemap) {
        $categorySitemap->add(
            Url::create("/category/{$category->id}/{$category->slug}")
                ->setPriority($category->parent == 0 ? 0.8 : 0.6)
                ->setChangeFrequency('daily')
        );
    });
    $categorySitemap->writeToFile($sitemapDir . '/sitemap-categories.xml');

    // 3. Posts — published only, exclude soft-deleted (chunk for memory efficiency)
    $this->info('Building posts sitemap...');
    $postSitemap = Sitemap::create();
    Post::select('id', 'slug', 'publish_at', 'updated_at')
        ->where('status', 'published')       // published only
        ->whereNotNull('publish_at')          // must have a publish date
        ->whereNull('deleted_at')             // exclude soft-deleted
        ->orderBy('id', 'desc')
        ->chunk(500, function ($posts) use ($postSitemap) {
            foreach ($posts as $post) {
                $year  = date('Y', strtotime($post->publish_at));
                $month = date('n', strtotime($post->publish_at));
                $postSitemap->add(
                    Url::create("/post/{$post->id}/{$year}/{$month}/{$post->slug}")
                        ->setLastModificationDate($post->updated_at)
                        ->setPriority(0.7)
                        ->setChangeFrequency('weekly')
                );
            }
        });
    $postSitemap->writeToFile($sitemapDir . '/sitemap-posts.xml');

    // 4. Sitemap index
    $this->info('Building sitemap index...');
    SitemapIndex::create()
        ->add($baseUrl . '/storage/sitemaps/sitemap-static.xml')
        ->add($baseUrl . '/storage/sitemaps/sitemap-categories.xml')
        ->add($baseUrl . '/storage/sitemaps/sitemap-posts.xml')
        ->writeToFile(public_path('sitemap.xml'));

    $this->info('Done. Sitemap live at ' . $baseUrl . '/sitemap.xml');
}
}
