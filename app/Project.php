<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    use RecordsActivity;

    protected $fillable = [
        'title',
        'description',
        'owner_id',
        'notes'
    ];

    protected $guarded = [];

    public function path()
    {
        return "/project/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function addTask($body)
    {
        return $this->tasks()->create(compact('body'));
    }

    public function addTasks($tasks)
    {
        return $this->tasks()->createMany($tasks);
    }

    public function invite(User $user)
    {
        $this->members()->attach($user);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members')->withTimestamps();
    }
}
