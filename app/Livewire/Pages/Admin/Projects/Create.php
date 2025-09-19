<?php

namespace App\Livewire\Pages\Admin\Projects;

use App\Models\Project;
use App\Models\User;
use App\Models\Client;
use App\Models\Setting;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Create Project')]
class Create extends Component
{
    public $title = '';
    public $description = '';
    public $estimated_start_date = '';
    public $estimated_days = '';
    public $project_lead_id = '';
    public $client_id = '';
    public $team_members = [];
    public $project_budget = '';
    public $currency = 'USD';
    public $priority = 'medium';
    public $status = 'planned';

    protected function rules()
    {
        $priorities = array_map('strtolower', array_map('str_replace', [' ', ' '], ['_', '_'], Setting::getEnumValues('task_priority')));
        $statuses = array_map('strtolower', array_map('str_replace', [' ', ' '], ['_', '_'], Setting::getEnumValues('project_status')));
        
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'estimated_start_date' => 'required|date|after_or_equal:today',
            'estimated_days' => 'required|integer|min:1',
            'project_lead_id' => 'required|exists:users,id',
            'client_id' => 'nullable|exists:clients,id',
            'team_members' => 'nullable|array',
            'team_members.*' => 'exists:users,id',
            'project_budget' => 'nullable|numeric|min:0',
            'currency' => 'required|string|in:USD,EUR,GBP,INR,JPY',
            'priority' => 'required|in:' . implode(',', $priorities),
            'status' => 'required|in:' . implode(',', $statuses),
        ];
    }

    protected $messages = [
        'title.required' => 'Project title is required.',
        'estimated_start_date.required' => 'Estimated start date is required.',
        'estimated_start_date.after_or_equal' => 'Start date must be today or later.',
        'estimated_days.required' => 'Estimated days is required.',
        'estimated_days.min' => 'Estimated days must be at least 1.',
        'project_lead_id.required' => 'Project lead is required.',
        'project_lead_id.exists' => 'Selected project lead does not exist.',
        'team_members.array' => 'Team members must be an array.',
        'project_budget.numeric' => 'Project budget must be a number.',
        'project_budget.min' => 'Project budget cannot be negative.',
    ];

    public function mount()
    {
        $this->estimated_start_date = now()->format('Y-m-d');
    }

    public function updatedProjectBudget($value)
    {
        // Remove any non-numeric characters except decimal point
        $value = preg_replace('/[^0-9.]/', '', $value);
        
        // Ensure only one decimal point
        $parts = explode('.', $value);
        if (count($parts) > 2) {
            $value = $parts[0] . '.' . implode('', array_slice($parts, 1));
        }
        
        // Limit to 2 decimal places
        if (count($parts) === 2 && strlen($parts[1]) > 2) {
            $value = $parts[0] . '.' . substr($parts[1], 0, 2);
        }
        
        $this->project_budget = $value;
    }

    public function save()
    {
        if (!auth()->user()->can('add project')) {
            session()->flash('error', 'You do not have permission to create projects.');
            return;
        }

        $this->validate();

        // Ensure project lead is not in team members
        $teamMembers = array_filter($this->team_members, function($memberId) {
            return $memberId != $this->project_lead_id;
        });

        Project::create([
            'title' => $this->title,
            'description' => $this->description,
            'estimated_start_date' => $this->estimated_start_date,
            'estimated_days' => $this->estimated_days,
            'project_lead_id' => $this->project_lead_id,
            'client_id' => $this->client_id ?: null,
            'team_members' => array_values($teamMembers),
            'project_budget' => $this->project_budget ?: null,
            'currency' => $this->currency,
            'priority' => $this->priority,
            'status' => $this->status,
        ]);

        session()->flash('success', 'Project created successfully!');
        return $this->redirect(route('admin.projects.index'));
    }

    public function render()
    {
        $users = User::orderBy('first_name')->get();
        $clients = Client::orderBy('client_name')->get();
        
        $currencies = [
            'USD' => 'US Dollar ($)',
            'EUR' => 'Euro (€)',
            'GBP' => 'British Pound (£)',
            'INR' => 'Indian Rupee (₹)',
            'JPY' => 'Japanese Yen (¥)',
        ];

        $priorities = array_combine(
            array_map('strtolower', array_map('str_replace', [' ', ' '], ['_', '_'], Setting::getEnumValues('task_priority'))),
            Setting::getEnumValues('task_priority')
        );

        $statuses = array_combine(
            array_map('strtolower', array_map('str_replace', [' ', ' '], ['_', '_'], Setting::getEnumValues('project_status'))),
            Setting::getEnumValues('project_status')
        );

        return view('livewire.pages.admin.projects.create', [
            'users' => $users,
            'clients' => $clients,
            'currencies' => $currencies,
            'priorities' => $priorities,
            'statuses' => $statuses,
        ]);
    }
}