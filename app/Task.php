<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //

    protected $fillable = [
        'body',
        'completed'
    ];

    protected $casts = [
        'completed' => 'boolean'
    ];

    protected $touches = ['project'];

    protected $guarded = [];

    // for future me that is for the sake of having fun but you should be consistent and us
    //observer task as with the project observer

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::created(function ($task) {
    //         $task->project->recordActivity('created_task');
    //     });
    // }

    public function complete()
    {
        $this->update(['completed' => true]);
        $this->recordActivity('completed_task');
    }

    public function incomplete()
    {
        $this->update(['completed' => false]);
        $this->recordActivity('incompleted-task');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function path()
    {
        return "/project/{$this->project->id}/tasks/{$this->id}";
    }

    public function recordActivity($description)
    {
        $this->activity()->create([
            'project_id' => $this->project_id,
            'description' => $description
        ]);
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }
}
