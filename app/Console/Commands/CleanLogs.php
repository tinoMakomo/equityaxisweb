<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CleanLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:clean {--days= : Delete log files older than this many days (defaults to LOG_DAILY_DAYS or 3)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete application and queue log files older than the configured retention period.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $days = (int) ($this->option('days') ?: config('logging.channels.daily.days', 3));
        $days = max($days, 1);
        $cutoff = now()->subDays($days)->getTimestamp();
        $deleted = 0;

        // Clean storage/logs/*.log
        $storageLogsDir = storage_path('logs');
        if (File::isDirectory($storageLogsDir)) {
            foreach (File::files($storageLogsDir) as $file) {
                if ($file->getFilename() === '.gitignore') {
                    continue;
                }
                if (str_ends_with($file->getFilename(), '.log') && $file->getMTime() < $cutoff) {
                    if (@unlink($file->getPathname())) {
                        $deleted++;
                    }
                }
            }
        }

        // Clean root queue.log* files (including rotated copies)
        foreach (glob(base_path('queue.log*')) ?: [] as $path) {
            if (is_file($path) && filemtime($path) < $cutoff) {
                if (@unlink($path)) {
                    $deleted++;
                }
            }
        }

        $this->info("Deleted {$deleted} log file(s) older than {$days} day(s).");

        return Command::SUCCESS;
    }
}
