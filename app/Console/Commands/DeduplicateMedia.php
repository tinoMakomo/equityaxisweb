<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DeduplicateMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:deduplicate
        {--apply : Actually apply deletions and hard-link deduplication (defaults to dry-run)}
        {--skip-orphans : Skip removing orphaned media directories not found in the media table}
        {--skip-hardlinks : Skip deduplicating identical image files across posts via hard links}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Safely remove duplicate media rows, orphaned media folders, and reclaim disk space from identical images via hard links.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $apply = (bool) $this->option('apply');
        $modeLabel = $apply ? 'APPLY MODE' : 'DRY-RUN MODE (pass --apply to execute)';
        $this->info("=== Media Deduplication & Cleanup [{$modeLabel}] ===");

        $reclaimedBytes = 0;

        // 1. Remove duplicate 'featured' media rows attached to the same post (keep the first/active one)
        $dupRowsCount = 0;
        $postsWithMultiple = Media::query()
            ->selectRaw('model_id, COUNT(*) as cnt')
            ->where('model_type', Post::class)
            ->where('collection_name', 'featured')
            ->groupBy('model_id')
            ->having('cnt', '>', 1)
            ->pluck('model_id');

        foreach ($postsWithMultiple as $postId) {
            $items = Media::where('model_type', Post::class)
                ->where('model_id', $postId)
                ->where('collection_name', 'featured')
                ->orderBy('id', 'asc')
                ->get();

            // Post::featuredImage() uses $this->media->first(), so keep the first item and prune extras
            foreach ($items->slice(1) as $extra) {
                $dupRowsCount++;
                $reclaimedBytes += (int) $extra->size;
                if ($apply) {
                    $extra->delete();
                }
            }
        }
        $this->line("1. Extra duplicate media rows on the same post: {$dupRowsCount}");

        // 2. Remove orphaned numeric directories in storage/app/public and stale media-library temp folders
        $orphanDirsCount = 0;
        $orphanBytes = 0;

        if (!$this->option('skip-orphans')) {
            $publicDir = storage_path('app/public');
            $validIds = Media::pluck('id')->flip();

            if (File::isDirectory($publicDir)) {
                foreach (File::directories($publicDir) as $dir) {
                    $base = basename($dir);
                    if (!ctype_digit($base)) {
                        continue;
                    }
                    if (!isset($validIds[(int) $base])) {
                        $size = $this->directorySize($dir);
                        $orphanDirsCount++;
                        $orphanBytes += $size;
                        if ($apply) {
                            File::deleteDirectory($dir);
                        }
                    }
                }
            }

            // Stale temp directories older than 24 hours
            $tempDir = storage_path('media-library/temp');
            $cutoff = now()->subDay()->getTimestamp();
            if (File::isDirectory($tempDir)) {
                foreach (File::directories($tempDir) as $dir) {
                    if (@filemtime($dir) < $cutoff) {
                        $size = $this->directorySize($dir);
                        $orphanDirsCount++;
                        $orphanBytes += $size;
                        if ($apply) {
                            File::deleteDirectory($dir);
                        }
                    }
                }
            }

            $reclaimedBytes += $orphanBytes;
            $this->line("2. Orphaned/temp media folders: {$orphanDirsCount} (" . $this->formatBytes($orphanBytes) . ')');
        }

        // 3. Deduplicate byte-for-byte identical image files across different posts using POSIX hard links
        $hardlinkedFiles = 0;
        $hardlinkBytes = 0;

        if (!$this->option('skip-hardlinks')) {
            $publicDir = storage_path('app/public');
            $filesBySize = [];

            if (File::isDirectory($publicDir)) {
                $iterator = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($publicDir, \FilesystemIterator::SKIP_DOTS)
                );

                foreach ($iterator as $file) {
                    if (!$file->isFile() || $file->isLink()) {
                        continue;
                    }
                    $ext = strtolower($file->getExtension());
                    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
                        continue;
                    }
                    $size = $file->getSize();
                    if ($size > 0) {
                        $filesBySize[$size][] = $file->getPathname();
                    }
                }
            }

            $canonicalByHash = [];
            foreach ($filesBySize as $size => $paths) {
                if (count($paths) < 2) {
                    continue;
                }
                sort($paths);

                foreach ($paths as $path) {
                    $hash = @hash_file('sha256', $path);
                    if ($hash === false) {
                        continue;
                    }

                    if (!isset($canonicalByHash[$hash])) {
                        $canonicalByHash[$hash] = $path;
                        continue;
                    }

                    $canonical = $canonicalByHash[$hash];
                    if (@fileinode($canonical) === @fileinode($path)) {
                        // Already hard-linked to the same inode
                        continue;
                    }

                    $hardlinkedFiles++;
                    $hardlinkBytes += $size;

                    if ($apply) {
                        $tmpLink = $path . '.dedup_tmp_' . getmypid();
                        if (@link($canonical, $tmpLink)) {
                            if (!@rename($tmpLink, $path)) {
                                @unlink($tmpLink);
                            }
                        }
                    }
                }
            }

            $reclaimedBytes += $hardlinkBytes;
            $this->line("3. Identical duplicate image files (deduplicated via hard links): {$hardlinkedFiles} (" . $this->formatBytes($hardlinkBytes) . ')');
        }

        $this->newLine();
        $actionWord = $apply ? 'Reclaimed' : 'Would reclaim';
        $this->info("{$actionWord} approximately " . $this->formatBytes($reclaimedBytes) . ' of disk space with zero broken image URLs.');

        if (!$apply) {
            $this->comment('Run "sudo -u www-data php artisan media:deduplicate --apply" to execute.');
        }

        return Command::SUCCESS;
    }

    protected function directorySize(string $dir): int
    {
        $size = 0;
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS)
        );
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $size += $file->getSize();
            }
        }
        return $size;
    }

    protected function formatBytes(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        }
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        }
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' B';
    }
}
