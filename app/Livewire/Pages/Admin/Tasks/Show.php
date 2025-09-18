<?php

namespace App\Livewire\Pages\Admin\Tasks;

use App\Models\Task;
use App\Models\TaskComment;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Show extends Component
{
    public Task $task;
    public $comment = '';

    public function mount(Task $task)
    {
        $this->task = $task->load(['assignedTo', 'createdBy', 'project', 'comments.user']);
    }

    public function markAsCompleted()
    {
        $this->task->markAsCompleted();
        session()->flash('status', 'Task marked as completed.');
        $this->task->refresh();
    }

    public function addComment()
    {
        if (!auth()->user()->can('add task comment')) {
            session()->flash('error', 'You do not have permission to add task comments.');
            return;
        }

        $this->validate([
            'comment' => 'required|string|min:3',
        ]);

        TaskComment::create([
            'task_id' => $this->task->id,
            'user_id' => auth()->id(),
            'comment' => $this->comment,
        ]);

        $this->comment = '';
        $this->task->load('comments.user');
        session()->flash('status', 'Comment added successfully.');
    }

    public function deleteComment(TaskComment $comment)
    {
        $comment->delete();
        $this->task->load('comments.user');
        session()->flash('status', 'Comment deleted successfully.');
    }

    public function delete()
    {
        $this->task->delete();
        session()->flash('status', 'Task deleted successfully.');
        return redirect()->route('admin.tasks.index');
    }

    public function render()
    {
        return view('livewire.pages.admin.tasks.show');
    }
}