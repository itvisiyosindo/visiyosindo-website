<?php

namespace App\Console\Commands;

use App\Models\JobVacancy;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class RegenerateJobVacancySlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job-vacancies:regenerate-slugs {--force : Force regenerate all slugs}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate slugs for job vacancies that have empty or invalid slugs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting slug regeneration for job vacancies...');
        
        $force = $this->option('force');
        
        // Get vacancies with empty slugs or all if force
        $query = JobVacancy::query();
        
        if (!$force) {
            $query->where(function ($q) {
                $q->whereNull('slug')
                  ->orWhere('slug', '')
                  ->orWhere('slug', 'LIKE', '% %'); // Contains spaces (invalid slug)
            });
        }
        
        $vacancies = $query->get();
        
        if ($vacancies->isEmpty()) {
            $this->info('No vacancies need slug regeneration.');
            return 0;
        }
        
        $this->info("Found {$vacancies->count()} vacancies to process.");
        $bar = $this->output->createProgressBar($vacancies->count());
        $bar->start();
        
        $updated = 0;
        $skipped = 0;
        $errors = 0;
        
        foreach ($vacancies as $vacancy) {
            try {
                $oldSlug = $vacancy->slug;
                $newSlug = Str::slug($vacancy->title);
                
                // Check if slug already exists (for other records)
                $slugExists = JobVacancy::where('slug', $newSlug)
                    ->where('id', '!=', $vacancy->id)
                    ->exists();
                
                if ($slugExists) {
                    // Append ID to make it unique
                    $newSlug = $newSlug . '-' . $vacancy->id;
                }
                
                if ($oldSlug !== $newSlug) {
                    $vacancy->update(['slug' => $newSlug]);
                    $updated++;
                    $this->newLine();
                    $this->line("  Updated: '{$vacancy->title}' → slug: '{$newSlug}'");
                } else {
                    $skipped++;
                }
                
                $bar->advance();
            } catch (\Exception $e) {
                $errors++;
                $this->newLine();
                $this->error("  Error processing vacancy ID {$vacancy->id}: {$e->getMessage()}");
                $bar->advance();
            }
        }
        
        $bar->finish();
        $this->newLine(2);
        
        // Summary
        $this->info('Slug regeneration completed!');
        $this->table(
            ['Status', 'Count'],
            [
                ['Updated', $updated],
                ['Skipped (no change)', $skipped],
                ['Errors', $errors],
                ['Total Processed', $vacancies->count()],
            ]
        );
        
        return 0;
    }
}
