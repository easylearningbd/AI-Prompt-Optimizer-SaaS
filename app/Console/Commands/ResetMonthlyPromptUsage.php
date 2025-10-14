<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ResetMonthlyPromptUsage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prompts:reset-monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset monthly prompt usage for the all users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = User::where('role', '!=', 'admin')
            ->update([
                'prompts_used_this_month' => 0,
                'subscription_renewed_at' => now(),
            ]);
            $this->info("Reset prompt usage for {$count} users.");
    }
}
