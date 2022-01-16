<?php

namespace App;
use App\Project;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //

    protected $fillable = [
        'body',
        'completed'
    ];

    protected $touches = ['project'];

    protected $guarded = [];

    public function project(){
        return $this->belongsTo(Project::class);
    }


    public function path()
    {
        return "/project/{$this->project->id}/tasks/{$this->id}";
    }


}
