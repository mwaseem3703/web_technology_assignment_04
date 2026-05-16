<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $sampleTasks = [
            'Refactor Laravel Middleware', 'Fix SQL Injection vulnerability', 
            'Optimizing React Components', 'API Integration for Broadband',
            'Deploy to Vercel Staging', 'Setup Redis Caching',
            'Update Assembly registers', 'Design New Landing Page',
            'Check Cloudflare DNS', 'Update Laravel Dependencies',
            'Review OS Lab Reports', 'Create Database Migrations',
            'Setup Github Actions', 'Configure Tailwind Colors',
            'Testing Riverpod State'
        ];

        foreach ($sampleTasks as $title) {
            Task::create([
                'title' => $title,
                'description' => 'Automatic generated task for pagination testing purposes.',
                'start_date' => now(),
                'due_date' => now()->addDays(rand(1, 15)),
                'priority' => ['Low', 'Medium', 'High'][array_rand(['Low', 'Medium', 'High'])],
                'status' => 'Pending'
            ]);
        }
    }
}