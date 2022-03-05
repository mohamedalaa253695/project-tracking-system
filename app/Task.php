<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    use RecordsActivity;

    protected $fillable = [
        'body',
        'completed'
    ];

    protected $casts = [
        'completed' => 'boolean'
    ];

    protected $touches = ['project'];

    protected $guarded = [];

    protected static $recordableEvents = ['created', 'deleted'];

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
}
