<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users and projects for assignment
        $users = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['admin', 'employee']);
        })->get();

        $projects = Project::all();

        $tasks = [
            [
                'title' => 'Design new homepage layout',
                'description' => 'Create a modern, responsive homepage layout with improved user experience and mobile optimization.',
                'status' => Task::STATUS_IN_PROGRESS,
                'priority' => Task::PRIORITY_HIGH,
                'start_date' => now()->addDays(1),
                'end_date' => now()->addDays(5),
            ],
            [
                'title' => 'Implement user authentication',
                'description' => 'Set up secure user authentication system with login, registration, and password reset functionality.',
                'status' => Task::STATUS_PENDING,
                'priority' => Task::PRIORITY_URGENT,
                'start_date' => now()->addDays(1),
                'end_date' => now()->addDays(3),
            ],
            [
                'title' => 'Database optimization',
                'description' => 'Optimize database queries and add proper indexing for better performance.',
                'status' => Task::STATUS_PENDING,
                'priority' => Task::PRIORITY_MEDIUM,
                'start_date' => now()->addDays(2),
                'end_date' => now()->addDays(7),
            ],
            [
                'title' => 'API documentation',
                'description' => 'Create comprehensive API documentation for all endpoints with examples and usage guidelines.',
                'status' => Task::STATUS_COMPLETED,
                'priority' => Task::PRIORITY_LOW,
                'start_date' => now()->subDays(5),
                'end_date' => now()->subDays(2),
                'completed_at' => now()->subDays(1),
            ],
            [
                'title' => 'Mobile app testing',
                'description' => 'Conduct thorough testing of the mobile application across different devices and platforms.',
                'status' => Task::STATUS_IN_PROGRESS,
                'priority' => Task::PRIORITY_HIGH,
                'start_date' => now()->subDays(1),
                'end_date' => now()->addDays(4),
            ],
            [
                'title' => 'Security audit',
                'description' => 'Perform comprehensive security audit and implement necessary security measures.',
                'status' => Task::STATUS_PENDING,
                'priority' => Task::PRIORITY_URGENT,
                'start_date' => now()->addDays(1),
                'end_date' => now()->addDays(2),
            ],
            [
                'title' => 'Performance monitoring setup',
                'description' => 'Set up monitoring tools to track application performance and user analytics.',
                'status' => Task::STATUS_PENDING,
                'priority' => Task::PRIORITY_MEDIUM,
                'start_date' => now()->addDays(5),
                'end_date' => now()->addDays(10),
            ],
            [
                'title' => 'Code review and refactoring',
                'description' => 'Review existing codebase and refactor legacy code for better maintainability.',
                'status' => Task::STATUS_CANCELLED,
                'priority' => Task::PRIORITY_LOW,
                'start_date' => now()->addDays(7),
                'end_date' => now()->addDays(14),
            ],
            [
                'title' => 'Client presentation preparation',
                'description' => 'Prepare presentation materials and demo for upcoming client meeting.',
                'status' => Task::STATUS_IN_PROGRESS,
                'priority' => Task::PRIORITY_HIGH,
                'start_date' => now()->subDays(1),
                'end_date' => now()->addDays(1),
            ],
            [
                'title' => 'Backup system implementation',
                'description' => 'Implement automated backup system for data protection and disaster recovery.',
                'status' => Task::STATUS_PENDING,
                'priority' => Task::PRIORITY_MEDIUM,
                'start_date' => now()->addDays(3),
                'end_date' => now()->addDays(6),
            ],
        ];

        foreach ($tasks as $taskData) {
            Task::create([
                'title' => $taskData['title'],
                'description' => $taskData['description'],
                'status' => $taskData['status'],
                'priority' => $taskData['priority'],
                'assigned_to' => $users->random()->id,
                'created_by' => $users->random()->id,
                'project_id' => $projects->isNotEmpty() ? $projects->random()->id : null,
                'start_date' => $taskData['start_date'],
                'end_date' => $taskData['end_date'],
                'completed_at' => $taskData['completed_at'] ?? null,
            ]);
        }
    }
}